<?php

!function_exists('json_encode') && include_once(G5_LIB_PATH . '/json.lib.php');
!function_exists('empty_mb_id') && include_once(G5_LIB_PATH . '/register.lib.php');

ob_end_clean();
/** @type $auth array */
$sub_menu = "600200";
auth_check_menu($auth, $sub_menu, 'r');
/*
 | ---------------------------------------------------------------
 |  기본 변수, 파라미터
 | ---------------------------------------------------------------
 */
$PageConfig = [
    'order' => ['A' => 'ASC', 'D' => 'DESC']
    // 날짜, 이름
    , 'sort' => ['A' => 'ap_idx', 'B' => 'ap_src_type']
    # , 'search' => ['A' => 'mb_name', 'B' => 'mb_id', 'C' => 'mb_nick', 'E' => 'mb_hp']
];

// -- 파라미터
$param = array_merge($_GET, $_POST);
empty($param['sort']) === true && ($param['sort'] = 'A'); // 정렬 대상
empty($param['order']) === true && ($param['order'] = 'D'); // 정렬 순서
if ($param['period'] != 'all') {
    empty($param['fromDate']) === true && ($param['fromDate'] = (new DateTime('-1 month'))->format('Y-m-01'));
    empty($param['toDate']) === true && ($param['toDate'] = (new DateTime('-1 month'))->format('Y-m-t')); //

    $param['fromDate'] = (new DateTime($param['fromDate']))->format('Y-m-d');
    $param['toDate'] = (new DateTime($param['toDate']))->format('Y-m-d');
}

unset($param['page']);

$query = http_build_query($param);
$order_by = $PageConfig['sort'][$param['sort']] . ' ' . $PageConfig['order'][$param['order']];
$config['cf_page_rows'] = 10;

$returnValue = ['code' => 200, 'message' => 'OK'];
/*
 | ---------------------------------------------------------------
 |  DB 쿼리
 | ---------------------------------------------------------------
 */
$agent_code = fn_sql_quote($param['agent']);
if($param['own'] == 'parent') {
    $condition = ["ap_agent IN(SELECT ag_code FROM {$g5['tb_agents']} WHERE ag_parent={$agent_code} AND ag_bank_account !='')"];
}
else {
    $condition = ["ap_agent = {$agent_code}"];
}

$param['period'] != 'all' && ($condition[] = "ap_created_at BETWEEN '{$param['fromDate']} 00:00:00' AND '{$param['toDate']} 23:59:59'");
$where = implode(' AND ', $condition);

$subs = [];
$rows = fn_sql_fetch_all("SELECT ap_withdraw, SUM(ap_point) point FROM {$g5['tb_agent_point']} WHERE {$where} GROUP BY ap_withdraw");
foreach ($rows as $row) {
    $subs[$row['ap_withdraw']] += $row['point'];
}


$sql = "SELECT COUNT(0) FROM {$g5['tb_agent_point']} WHERE {$where}";
$totals = fn_sql_row($sql);

$config['cf_page_rows'] = 25;
$paging = $eb->set_paging('admin', $dir, $pid, $query);


print '
<ul class="list-group">
    <li class="list-group-item">
        <em data-role="no">No.</em>
        <em data-role="source">대리점</em>
        <em data-role="point">포인트</em>
        <em data-role="note">비고</em>
        <em data-role="dateTime">날짜</em>
        <em data-role="isWithdraw">정산</em>        
    </li>
';

if ($totals > 0) {
    [$limit, $total_page, $max_no] = fn_sql_build_limit($page, $totals);
    $total_point = fn_sql_row("SELECT SUM(ap_point) FROM {$g5['tb_agent_point']} WHERE {$where} ");
    $subtotal_point = 0;

    $sql = "
SELECT
    ap_idx          AS id 
    , ap_agent      AS `code`
    , ap_src_type   AS `source`
    , ap_src_id     AS `sid`
    , ap_point      AS `point`
    , ap_note       AS `note`
    , ap_withdraw   AS `isWithdraw`
    , ap_created_at AS `dateTime`
    , ap_stamper    AS  `stamper`
    , ap_invoice_at    AS  `invoiceDateTime`
    , (SELECT ag_name FROM {$g5['tb_agents']} WHERE ag_code=ap_agent)    AS  `label`
FROM 
    {$g5['tb_agent_point']}
WHERE 
    {$where} 
ORDER BY {$order_by}
{$limit}";
    $rows = fn_sql_fetch_all($sql);
    foreach ($rows as $row) {
        $subtotal_point += $row['point'];

        print '
            <li class="list-group-item">
            <em data-role="no">' . ($max_no--) . '</em>
            <em data-role="source">' . $row['label'] . '</em>
            <em data-role="point"' . ($row['point'] > 0 ? ' class="text-info"' : ' class="text-danger"') . '><span class="point-suffix">' . number_format($row['point']) . '</em>
            <em data-role="note">' . gettext($row['note']) . '</em>
            <em data-role="dateTime" class="' . ($row['isWithdraw'] == 'Y' ? ' withdraw' : '') . '">' . (new DateTime($row['dateTime']))->format('y.m.d H:i') . '</em>
            <em data-role="isWithdraw" data-value="' . $row['isWithdraw'] . '">' . ($row['isWithdraw'] == 'Y' ? '<button class="btn btn-e-indigo withdrawal-cancel" data-value="'.$row['id'].'">취소</button>' : 'N') . '</em>            
        </li>';
    }

}
print '</ul>';

$help = ' 소계: <strong class="color-indigo">'.number_format($subtotal_point).'</strong> / 합계: <strong class="color-green">'.number_format($total_point).'</strong>';
$help .=' (정산:<strong>'.number_format($subs['Y']).'</strong>, 미정산:<strong>'.number_format($subs['N']).'</strong>)';
print "<div style=\"padding:.25rem 1.25rem;text-align: center\">{$help}</div>";

print '<div class="page-nav">' . eb_paging($eyoom['paging_skin']) . '</div>';
die;