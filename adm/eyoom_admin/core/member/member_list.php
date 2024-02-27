<?php
/**
 * @file    /adm/eyoom_admin/core/member/member_list.php
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;

$sub_menu = "200100";

$action_url1 = G5_ADMIN_URL . '/?dir=member&amp;pid=member_list_update&amp;smode=1';

auth_check_menu($auth, $sub_menu, 'r');

/*
 | ---------------------------------------------------------------
 |  기본 변수, 파라미터
 | ---------------------------------------------------------------
 */
$PageConfig = [
    'order' => ['A' => 'ASC', 'D' => 'DESC']
    // 주문일, 주문자, 결제금액,
    , 'sort' => [
        'A' => 'mb_no'
        , 'B' => 'mb_id'
        , 'C' => 'mb_name'
    ]

    , 'search' => [
        'A' => 'mb_id',       // 아이디
        'B' => 'mb_name',     // 이름
        'C' => 'mb_email',       // 휴대전화
        'D' => 'mb_hp',       // 휴대전화
    ]

    , 'searchLabel' => [
        'A' => '아이디',       // 주문번호
        'B' => '이름',       // 주문자명
        'C' => '이메일', // 주문자 휴대전화
        'D' => '휴대전화',       // 수취인명
    ]
    , 'cert' => [
        'Y' => '인증'
        , 'N' => '미인증'
    ]
    , 'term' => [
        'A' => 'mb_datetime'
        , 'B' => 'mb_today_login'

    ]
    , 'termLabel' => [
        'A' => '가입일'
        , 'B' => '접속일'
    ]
    , 'statusLabel' => [
        'A' => '정상'
        , 'B' => '탈퇴'
        , 'C' => '차단'
    ] 
    
];


// -- 파라미터
$param = array_merge($_GET, $_POST);
empty($param['sort']) === true && ($param['sort'] = 'A'); // 정렬 대상
empty($param['order']) === true && ($param['order'] = 'D'); // 정렬 순서

empty($param['term']) === true && ($param['term'] = 'A');

$page = $param['page'] ?? 1;
unset($param['page']);
$query = http_build_query($param);
/*
 | ---------------------------------------------------------------
 | 조건절
 | ---------------------------------------------------------------
 */
$conditional = [];
// 날짜검색
if (empty($param['fromDate']) !== true) {
    $param['fromDate'] = (new DateTime($param['fromDate']))->format('Y-m-d');
    $param['toDate'] = (new DateTime($param['toDate']))->format('Y-m-d');

    $conditional[] = "{$PageConfig['term'][$param['term']]} BETWEEN '{$param['fromDate']}' AND {$param['toDate']}";
}

// 레벨 검색
$param['level'] > 0 && ($conditional[] = "mb_level = {$param['level']}");
// 인증 또는 미 인징
empty($param['cert']) !== true && ($conditional[] = 'mb_certify ' . ($param['cert'] == 'Y' ? ' != \'\'' : '= \'\''));


// 정상, 탈퇴, 차단
if ($param['status'] == 'A') {
    $conditional[] = 'mb_leave_date = \'\' AND mb_intercept_date = \'\'';
}
else if ($param['status'] == 'B') {
    $conditional[] = 'mb_leave_date != \'\'';
}
else if ($param['status'] == 'C') {
    $conditional[] = 'mb_leave_date = \'\' AND mb_intercept_date != \'\'';
}

// 키워드 검색 : SQL 구문 생성
##$param['keyword'] = 'test naver.com';
if (empty($param['keyword']) !== true && empty($param['search']) !== true) {
    $keyfield = $PageConfig['search'][$param['search']];
    $syntax = [];

    foreach (explode(' ', trim($param['keyword'])) as $word) {
        $syntax[] = $keyfield . ' LIKE ' . fn_sql_quote('%' . $word . '%');
    }
    $conditional[] = '(' . implode(' AND ', $syntax) . ')';
    unset($syntax, $keyfield);
}


$where = '';
empty($conditional) !== true && ($where = " WHERE ".implode(' AND ', $conditional));
$order_by = $PageConfig['sort'][$param['sort']] . ' ' . $PageConfig['order'][$param['order']];

$sql = "SELECT COUNT(0) FROM {$g5['member_table']} {$where} ORDER BY {$order_by}";
$totals = fn_sql_row($sql);
$rows = [];
if ($totals > 0) :
    [$limit, $total_page, $max_no] = fn_sql_build_limit($page, $totals);
    $sql = "SELECT * FROM {$g5['member_table']} {$where} ORDER BY {$order_by} {$limit}";
    $rows = fn_sql_fetch_all($sql);
endif;
/**
 * 페이징
 */
$paging = $eb->set_paging('admin', $dir, $pid, $query);
