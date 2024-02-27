<?php
/**
 *
 * User: Lee, Namdu
 * Date: 2022-05-16
 * Time: 오후 1:30
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;

$sub_menu = "600100";
$g5['title'] = "대리점목록";

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
    , 'sort' => ['A' => 'ag_id', 'B' => 'ag_name', 'C' => 'ag_code', 'D' => 'ag_mentee', 'E' => 'ag_accrue']
    # , 'search' => ['A' => 'mb_name', 'B' => 'mb_id', 'C' => 'mb_nick', 'E' => 'mb_hp']
];
$BankList = [
    '기업은행'
    , '국민은행'
    , '신한은행'
    , '우리은행'
    , 'KEB하나은행'
    , 'SC제일은행'
    , '우체국'
    , '농협'
    , '수협'
    , '신협'
    , '광주은행'
    , '부산은행'
    , '제주은행'
    , '전북은행'
    , '경남은행'
    , '대구은행'
    , '새마을금고'
    , '케이뱅크'
    , '카카오뱅크'
    , '토스뱅크'
];


// -- 파라미터
$param = array_merge($_GET, $_POST);
empty($param['sort']) === true && ($param['sort'] = 'C'); // 정렬 대상
empty($param['order']) === true && ($param['order'] = 'A'); // 정렬 순서

$page = $param['page'] ?? 1;
unset($param['page']);
$query = http_build_query($param);
/*
 | ---------------------------------------------------------------
 |  DB 쿼리
 | ---------------------------------------------------------------
 */
$conditional = [];

// 지역 검색
if (empty($param['district']) !== true) {
    $search = '';
    foreach ($param['district'] as $d_code) {
        if (empty($d_code) === true) continue;
        $search = $d_code;
    }

    if (empty($search) !== true) {
        $conditional[] = 'ag_code LIKE ' . fn_sql_quote("{$search}%");
    }
}

if (empty($param['type']) !== true) {
    $conditional[] = 'ag_type = ' . fn_sql_quote($param['type']);
}

// 키워드 검색 : SQL 구문 생성
##$param['keyword'] = 'test naver.com';
if (empty($param['keyword']) !== true) {
    $syntax = [];
    $search = [];
    foreach (explode(' ', trim($param['keyword'])) as $word) {
        $syntax[] = '{__COLUMN__} LIKE ' . fn_sql_quote('%' . $word . '%');
    }

    foreach (['ag_name'] as $col) {
        $search[] = str_replace('{__COLUMN__}', $col, implode(' AND ', $syntax));
    }

    $conditional[] = '(' . implode(') OR (', $search) . ')';

    unset($syntax, $search);
}

$where = empty($conditional) === true ? '1' : implode(' AND ', $conditional);
$order_by = $PageConfig['sort'][$param['sort']] . ' ' . $PageConfig['order'][$param['order']];


$_SQL = "
SELECT
    {__COLUMNS__}
FROM
    {$g5['tb_agents']} T_A
WHERE
    {$where} 
ORDER BY 
  {$order_by}    
";

// count
$sql = str_replace('{__COLUMNS__}', 'COUNT(0)', $_SQL);
$totals = fn_sql_row($sql);

//
// @global $total_page 총 페이지 수
$list = [];
if ($totals > 0) {
    [$limit, $total_page, $max_no] = fn_sql_build_limit($page, $totals);
    $sql = str_replace('{__COLUMNS__}', implode(', ', [
            '*'

            , "(SELECT SUM(ap_point) FROM {$g5['tb_agent_point']} WHERE ap_agent =  T_A.ag_code AND ap_withdraw='Y') settlement" // 대리점 정산누적
            , "(SELECT SUM(ap_point) FROM {$g5['tb_agent_point']} WHERE ap_agent =  T_A.ag_code AND ap_withdraw='N') not_settlement" // 대리점 미정산누적
            , "(SELECT COUNT(0) FROM {$g5['member_table']} WHERE mb_1 = T_A.ag_code) mentee"

            , "(SELECT SUM(ap_point) FROM {$g5['tb_agent_point']} WHERE ap_agent IN(SELECT ag_code FROM {$g5['tb_agents']} TS1 WHERE TS1.ag_parent = T_A.ag_code AND ag_bank_account !='') AND ap_withdraw='Y') sub_settlement" // 하위 대리점 정산된 내역
            , "(SELECT SUM(ap_point) FROM {$g5['tb_agent_point']} WHERE ap_agent IN(SELECT ag_code FROM {$g5['tb_agents']} TS1 WHERE TS1.ag_parent = T_A.ag_code AND ag_bank_account !='') AND ap_withdraw='N') sub_not_settlement" // 하위 대리점 미정산된 내역
            , "(SELECT ag_name FROM {$g5['tb_agents']} T_B WHERE T_B.ag_code = T_A.ag_parent) parent_name"

            ##, "(SELECT SUM(ap_point) FROM {$g5['tb_agent_point']} WHERE ap_agent=T_A.ag_code) subtotal"
        ]), $_SQL) . $limit;

    $list = fn_sql_fetch_all($sql);
}
unset($_SQL, $limit, $sql, $where);

$SoleDistributor = fn_sql_fetch_all("
SELECT
    ag_code, ag_name
FROM
    {$g5['tb_agents']} T_A
WHERE
    ag_type = 'S'
ORDER BY 
  ag_name, ag_code
");
/*
 | ---------------------------------------------------------------
 |
 | ---------------------------------------------------------------
 */

$paging = $eb->set_paging('admin', $dir, $pid, $query);