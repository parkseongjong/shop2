<?php
/**
 *
 * User: Lee, Namdu
 * Date: 2022-05-16
 * Time: 오후 1:30
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;
$sub_menu = "600200";
$g5['title'] = "포인트내역";

/** @type $auth array */
auth_check_menu($auth, $sub_menu, 'r');
/*
 | ---------------------------------------------------------------
 |  기본 변수, 파라미터
 | ---------------------------------------------------------------
 */
$PageConfig = [
    'order' => ['A' => 'ASC', 'D' => 'DESC']
    // 날짜, 이름
    , 'sort' => ['A' => 'ap_agent', 'B' => 'ag_name']
    # , 'search' => ['A' => 'mb_name', 'B' => 'mb_id', 'C' => 'mb_nick', 'E' => 'mb_hp']
];

// -- 파라미터
$param = array_merge($_GET, $_POST);
empty($param['sort']) === true && ($param['sort'] = 'A'); // 정렬 대상
empty($param['order']) === true && ($param['order'] = 'A'); // 정렬 순서
empty($param['fromDate']) === true && ($param['fromDate'] = (new DateTime('-3 month'))->format('Y-m-01'));
empty($param['toDate']) === true && ($param['toDate'] = (new DateTime())->format('Y-m-t')); //

$param['fromDate'] = (new DateTime($param['fromDate']))->format('Y-m-d');
$param['toDate'] = (new DateTime($param['toDate']))->format('Y-m-d');

unset($param['page']);
$query = http_build_query($param);
/*
 | ---------------------------------------------------------------
 |  DB 쿼리
 | ---------------------------------------------------------------
 */
$conditional = [
    "ap_created_at BETWEEN '{$param['fromDate']} 00:00:00' AND '{$param['toDate']} 23:59:59'"
];
// 지역 검색
empty($param['state']) !== true && ($conditional[] = "ap_agent LIKE " . fn_sql_quote("{$param['state']}%"));

$where = implode(' AND ', $conditional);
$order_by = $PageConfig['sort'][$param['sort']] . ' ' . $PageConfig['order'][$param['order']];

// COUNT
$totals = fn_sql_row("SELECT COUNT(DISTINCT(ap_agent)) FROM {$g5['tb_agent_point']} WHERE {$where}");
// @global $total_page 총 페이지 수
$list = [];
if ($totals > 0) {
    [$limit, $total_page, $max_no] = fn_sql_build_limit($page, $totals);
    $sql = "SELECT DISTINCT(ap_agent) FROM {$g5['tb_agent_point']} TBA LEFT OUTER JOIN {$g5['tb_agents']} TBB ON TBA.ap_agent=TBB.ag_code WHERE {$where} ORDER BY {$order_by} {$limit}";
    $codes = implode(',', fn_sql_quote(fn_sql_fetch_all($sql, MYSQLI_NUM)));

    $sql = "
SELECT
	ap_agent    AS agent,
	ap_withdraw AS withdraw, 
	ag_name	    AS `name`,
	volume		AS `volume`,
	subtotal,
	seq,
	lasted
FROM
    (SELECT
        ap_agent, 
        ap_withdraw,
        SUM(ap_point) subtotal, 
        COUNT(0) volume, 
        MAX(ap_idx) seq, 
        MAX(ap_created_at) lasted 
    FROM
        {$g5['tb_agent_point']}
    WHERE
        ap_created_at BETWEEN '{$param['fromDate']} 00:00:00' AND '{$param['toDate']} 23:59:59'
        AND ap_agent IN({$codes})
    GROUP BY 
        ap_agent, ap_withdraw) TBA
    LEFT OUTER JOIN {$g5['tb_agents']} TBB ON TBA.ap_agent=TBB.ag_code 
ORDER BY {$order_by}
";
    $rows = fn_sql_fetch_all($sql);
    foreach ($rows as $row) {
        $line = &$list[$row['agent']];
        (isset($line) !== true) && ($line = [
            'agent' => $row['agent']
            , 'name' => $row['name']
            , 'lasted' => 0
            , 'withdrawAmount' => 0
            , 'withdrawVolume' => 0
            , 'debtAmount' => 0
            , 'debtVolume' => 0
        ]);

        // 정산
        if ($row['withdraw'] != 'N') {
            $line['withdrawAmount'] = $row['subtotal'];
            $line['withdrawVolume'] = $row['volume'];
        }
        else {
            $line['debtAmount'] = $row['subtotal'];
            $line['debtVolume'] = $row['volume'];
        }

        $line['subtotal'] += $row['subtotal'];
        $line['volume'] += $row['volume'];
        $line['lasted'] = max($line['lasted'], $row['lasted']);
    }
}
unset($_SQL, $limit, $sql, $where);
/*
 | ---------------------------------------------------------------
 |
 | ---------------------------------------------------------------
 */

$paging = $eb->set_paging('admin', $dir, $pid, $query);