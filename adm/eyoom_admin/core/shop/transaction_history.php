<?php

if (!defined('_EYOOM_IS_ADMIN_')) exit;

$sub_menu = "400420";
$g5['title'] = "카드 결제내역";

/** @type $auth array */
auth_check_menu($auth, $sub_menu, 'r');
/*
 | ---------------------------------------------------------------
 |  기본 변수, 파라미터
 | ---------------------------------------------------------------
 */
$PageConfig = [
    'order' => ['A' => 'ASC', 'D' => 'DESC']
    // 날짜, 이름, 지녁명,
    , 'sort' => ['A' => 'idx', 'B' => 'ord_id', 'C' => 'mb_id', 'D' => 'code']
    , 'search' => ['A' => 'ord_id', 'B' => 'mb_id']
];
// -- 파라미터
$param = array_merge($_GET, $_POST);
empty($param['sort']) === true && ($param['sort'] = 'A'); // 정렬 대상
empty($param['order']) === true && ($param['order'] = 'D'); // 정렬 순서
empty($param['fromDate']) === true && ($param['fromDate'] = (new DateTime())->format('Y-m-01'));
empty($param['toDate']) === true && ($param['toDate'] = (new DateTime())->format('Y-m-t')); //

$param['fromDate'] = (new DateTime($param['fromDate']))->format('Y-m-d');
$param['toDate'] = (new DateTime($param['toDate']))->format('Y-m-d');

$page = $param['page'] ?? 1;
unset($param['page']);
$query = http_build_query($param);

/*
 | ---------------------------------------------------------------
 |  DB 쿼리
 | ---------------------------------------------------------------
 */
$condition = ["created_at BETWEEN '{$param['fromDate']} 00:00:00' AND '{$param['toDate']} 23:59:59'"];
// 검색어 입력
if (empty($param['keyword']) !== true && empty($field = $PageConfig['search'][$param['keyfield']]) !== true) {
    $condition[] = "`{$field}` LIKE " . fn_sql_quote(trim($param['keyword']));
}
//
if ($param['status'] == 'F') {
    $condition[] = "`code` != '0000' ";
}
else if ($param['status'] == 'N') {
    $condition[] = "`code` = '0000' AND (SELECT COUNT(0) FROM `{$g5['g5_shop_order_table']}` TS WHERE TS.od_id = TM.ord_id) = 0 ";
}

$where = implode(' AND ', $condition);
$order_by = $PageConfig['sort'][$param['sort']] . ' ' . $PageConfig['order'][$param['order']];

$sql = "SELECT COUNT(0) FROM `{$g5['tb_payout']}` TM WHERE {$where} LIMIT 1";

$totals = fn_sql_row($sql);
$paging = $eb->set_paging('admin', $dir, $pid, $query);
$list = [];
if ($totals > 0) {
    [$limit, $total_page, $max_no] = fn_sql_build_limit($page, $totals);
    $sql = "
SELECT
    *
    , (SELECT mb_name FROM `{$g5['member_table']}` TS WHERE TS.mb_id = TM.mb_id) member_name
    , (SELECT od_status FROM `{$g5['g5_shop_order_table']}` TS WHERE TS.od_id = TM.ord_id) order_status
    
FROM 
    `{$g5['tb_payout']}` TM
WHERE 
    {$where}
ORDER BY
    {$order_by}
{$limit}
";
    $rows = fn_sql_fetch_all($sql);
    foreach ($rows as $row) {
        $row['request'] = json_decode($row['request'], true);
        $row['response'] = json_decode($row['response'], true);
        $list[] = $row;
    }
}


unset($_SQL, $limit, $sql, $where);
/*
 | ---------------------------------------------------------------
 |
 | ---------------------------------------------------------------
 */

$paging = $eb->set_paging('admin', $dir, $pid, $query);