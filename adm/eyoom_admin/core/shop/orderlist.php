<?php
/**
 * @file    /adm/eyoom_admin/core/shop/orderlist.php
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;

$sub_menu = "400400";
/** @type $auth array */
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
        'A' => 'od_id'
        , 'B' => 'od_name'
        , 'C' => 'od_cart_price'
        , 'D' => 'od_receipt_time'
        , 'E' => 'od_invoice_time'
    ]

    , 'search' => [
        'A' => 'od_id',       // 주문번호
        'B' => 'od_name',     // 주문자명
        'C' => 'od_hp',       // 주문자 휴대전화
        'D' => 'od_b_name',   // 수취인명
        'E' => 'od_b_hp',     // 수취인 휴대전화
        'F' => 'od_app_no',   // 결제 승인번호
        'G' => 'od_invoice',  // 송장번호
    ]

    , 'searchLabel' => [
        'A' => '주문번호',       // 주문번호
        'B' => '주문자명',       // 주문자명
        'C' => '주문자 휴대전화', // 주문자 휴대전화
        'D' => '수령인명',       // 수취인명
        'E' => '수령인 휴대전화', // 수취인 휴대전화
        'F' => '승인번호',       // 송장번호
        'G' => '운송장번호',     // 송장번호
    ]
    , 'status' => [
        'A' => '주문'
        , 'B' => '입금'
        , 'C' => '준비'
        , 'D' => '배송'
        , 'E' => '완료'
        , 'F' => '취소'
        , 'G' => '부분취소'
    ]
    , 'term' => [
        'A' => 'od_time'
        , 'B' => 'od_receipt_time'
        , 'C' => 'od_invoice_time'
    ]
    , 'termLabel' => [
        'A' => '주문일'
        , 'B' => '입금일'
        , 'C' => '배송등록일'
    ]
];


// -- 파라미터
$param = array_merge($_GET, $_POST);
empty($param['sort']) === true && ($param['sort'] = 'A'); // 정렬 대상
empty($param['order']) === true && ($param['order'] = 'D'); // 정렬 순서

empty($param['term']) === true && ($param['term'] = 'A'); // 정렬 대상
empty($param['fromDate']) === true && ($param['fromDate'] = (new DateTime('-3 month'))->format('Y-m-01'));
empty($param['toDate']) === true && ($param['toDate'] = (new DateTime())->format('Y-m-t')); //

$param['fromDate'] = (new DateTime($param['fromDate']))->format('Y-m-d');
$param['toDate'] = (new DateTime($param['toDate']))->format('Y-m-d');

$page = $param['page'] ?? 1;
unset($param['page']);
$query = http_build_query($param);

if ($param['scope'] == 'status' && $param['od_status']) {
    $sub_menu = ['주문' => '400470', '입금' => '400480', '준비' => '400490'][$param['od_status']];
    $param['status'] = array_search($param['od_status'], $PageConfig['status']);
}
empty($param['status']) !== true && !is_array($param['status']) && is_scalar($param['status']) && ($param['status'] = [$param['status']]);
/*
 | ---------------------------------------------------------------
 |  DB 쿼리
 | ---------------------------------------------------------------
 */
$conditional = [
    $PageConfig['term'][$param['term']] . " BETWEEN '{$param['fromDate']} 00:00:00' AND '{$param['toDate']} 23:59:59'"
];

// 주문상태
if (empty($param['status']) !== true && array_keys($PageConfig['status']) != $param['status']) {

    $syntax = [];
    $parts = [];
    foreach ($param['status'] as $code) {
        if ($code == 'G') continue;
        $syntax[] = $PageConfig['status'][$code];
    }
    empty($syntax) !== true && ($parts[] = 'od_status IN(' . implode(', ', fn_sql_quote($syntax)) . ')');
    in_array('G', $param['status']) && ($parts[] = '(od_status IN(\'주문\', \'입금\', \'준비\', \'배송\', \'완료\') AND od_cancel_price > 0)');
    $conditional[] = '(' . implode(' OR ', $parts) . ')';
    unset($syntax, $parts);
}
else {
    $param['status'] = '';
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

$where = empty($conditional) === true ? '1' : implode(' AND ', $conditional);
$order_by = $PageConfig['sort'][$param['sort']] . ' ' . $PageConfig['order'][$param['order']];

$totals = fn_sql_row("SELECT COUNT(0) FROM {$g5['g5_shop_order_table']} WHERE $where");
$rows = [];
if ($totals > 0) {
    [$limit, $total_page, $max_no] = fn_sql_build_limit($page, $totals);
    $subtotals = fn_sql_row("SELECT COUNT(0) FROM {$g5['g5_shop_cart_table']} WHERE od_id IN(SELECT od_id FROM {$g5['g5_shop_order_table']} WHERE $where)");

    $sql = "
        SELECT
            T_ORD.*
            , (
                SELECT
                    CONCAT(it_id, '|', it_name)
                FROM
                    {$g5['g5_shop_cart_table']} T_CART
                WHERE
                    T_CART.od_id=T_ORD.od_id
                ORDER BY 
                    ct_id
                LIMIT 1
            ) item
            , (
                SELECT
                    COUNT(0) - 1
                FROM
                    {$g5['g5_shop_cart_table']} T_CART
                WHERE
                    T_CART.od_id=T_ORD.od_id
                ORDER BY 
                    ct_id
                LIMIT 1
            ) item_volume
            , (
                SELECT 
                    COUNT(0) 
                FROM 
                    {$g5['g5_shop_order_table']} TS_ORD 
                WHERE 
                    TS_ORD.mb_id=T_ORD.mb_id AND TS_ORD.od_id != T_ORD.od_id AND od_status IN('입금', '준비', '배송', '완료')
             ) order_times
            , T_MB.mb_name
            , T_MB.mb_hp
            , T_MB.mb_email
        FROM
            {$g5['g5_shop_order_table']} T_ORD
            LEFT OUTER JOIN  {$g5['member_table']} T_MB
            ON T_ORD.mb_id = T_MB.mb_id
        WHERE 
            $where
        ORDER BY 
            $order_by    
        {$limit}    
    ";
    $rows = fn_sql_fetch_all($sql);
}

$qstr = trim(preg_replace('/((token=[^&]*)|(page=[^&]*))/', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)), '&');




/*

$where = [];

$doc = isset($_GET['doc']) ? clean_xss_tags($_GET['doc'], 1, 1) : '';
$sort1 = (isset($_GET['sort1']) && in_array($_GET['sort1'], ['od_id', 'od_cart_price', 'od_receipt_price', 'od_cancel_price', 'od_misu', 'od_cash'])) ? $_GET['sort1'] : '';
$sort2 = (isset($_GET['sort2']) && in_array($_GET['sort2'], ['desc', 'asc'])) ? $_GET['sort2'] : 'desc';
$sel_field = (isset($_GET['sel_field']) && in_array($_GET['sel_field'], ['od_id', 'mb_id', 'od_name', 'od_tel', 'od_hp', 'od_b_name', 'od_b_tel', 'od_b_hp', 'od_deposit_name', 'od_invoice'])) ? $_GET['sel_field'] : '';
$od_status = isset($_GET['od_status']) ? get_search_string($_GET['od_status']) : '';
$search = isset($_GET['search']) ? get_search_string($_GET['search']) : '';

$fr_date = (isset($_GET['fr_date']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET['fr_date'])) ? $_GET['fr_date'] : '';
$to_date = (isset($_GET['to_date']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET['to_date'])) ? $_GET['to_date'] : '';

$od_misu = isset($_GET['od_misu']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_misu']) : '';
$od_cancel_price = isset($_GET['od_cancel_price']) ? preg_replace('/[^0-9a-z]/', '', $_GET['od_cancel_price']) : '';
$od_refund_price = isset($_GET['od_refund_price']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_refund_price']) : '';
$od_receipt_point = isset($_GET['od_receipt_point']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_receipt_point']) : '';
$od_coupon = isset($_GET['od_coupon']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_coupon']) : '';
$od_settle_case = isset($_GET['od_settle_case']) ? clean_xss_tags($_GET['od_settle_case'], 1, 1) : '';
$od_escrow = isset($_GET['od_escrow']) ? clean_xss_tags($_GET['od_escrow'], 1, 1) : '';

$tot_itemcount = $tot_orderprice = $tot_receiptprice = $tot_ordercancel = $tot_misu = $tot_couponprice = 0;
$sql_search = "";

if ($sel_field != "") {
    // 상품명 검색
    if ($sel_field == 'it_name') {
        $sql = "select od_id from {$g5['g5_shop_cart_table']} where it_name like '%$search%' ";
        $res = sql_query($sql);
        for ($i = 0; $row = sql_fetch_array($res); $i++) {
            $s_od_id[$row['od_id']] = $row['od_id'];
        }

        if (isset($s_od_id) && is_array($s_od_id)) {
            $where[] = " find_in_set(od_id, '" . implode(',', $s_od_id) . "') > 0 ";
        }
    }
    else if ($sel_field == 'mb_nick') {
        $sql = "select mb_id from {$g5['member_table']} where mb_nick like '%$search%' ";
        $res = sql_query($sql);
        for ($i = 0; $row = sql_fetch_array($res); $i++) {
            $s_mb_id[$row['mb_id']] = $row['mb_id'];
        }

        if (isset($s_mb_id) && is_array($s_mb_id)) {
            $where[] = " find_in_set(mb_id, '" . implode(',', $s_mb_id) . "') > 0 ";
        }
    }
    else {
        $where[] = " $sel_field like '%$search%' ";
    }

    if ($save_search != $search) {
        $page = 1;
    }
}

if ($od_status) {
    switch ($od_status) {
        case '전체취소':
            $where[] = " od_status = '취소' ";
            break;
        case '부분취소':
            $where[] = " od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0 ";
            break;
        default:
            $where[] = " od_status = '$od_status' ";
            break;
    }

    switch ($od_status) {
        case '주문' :
            $sort1 = "od_id";
            $sort2 = "desc";
            break;
        case '입금' :   // 결제완료
            $sort1 = "od_receipt_time";
            $sort2 = "desc";
            break;
        case '배송' :   // 배송중
            $sort1 = "od_invoice_time";
            $sort2 = "desc";
            break;
    }
}

if ($od_settle_case) {
    if ($od_settle_case === '간편결제') {
        $where[] = " od_settle_case in ('간편결제', '삼성페이', 'lpay', 'inicis_kakaopay') ";
    }
    else {
        $where[] = " od_settle_case = '$od_settle_case' ";
    }
}

if ($od_misu) {
    $where[] = " od_misu != 0 ";
}

if ($od_cancel_price) {
    $where[] = " od_cancel_price != 0 ";
}

if ($od_refund_price) {
    $where[] = " od_refund_price != 0 ";
}

if ($od_receipt_point) {
    $where[] = " od_receipt_point != 0 ";
}

if ($od_coupon) {
    $where[] = " ( od_cart_coupon > 0 or od_coupon > 0 or od_send_coupon > 0 ) ";
}

if ($od_escrow) {
    $where[] = " od_escrow = 1 ";
}

if ($fr_date && $to_date) {
    $where[] = " od_time between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
}

if ($where) {
    $sql_search = ' where ' . implode(' and ', $where);
}

if ($sel_field == "") $sel_field = "od_id";
if ($sort1 == "") $sort1 = "od_time";
if ($sort2 == "") $sort2 = "desc";

$sql_common = " from {$g5['g5_shop_order_table']} $sql_search ";

$sql = " select count(od_id) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *,
            (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           $sql_common
           order by $sort1 $sort2
           limit $from_record, $rows ";
$result = sql_query($sql);


$qstr1 = "od_status=" . urlencode($od_status) . "&amp;od_settle_case=" . urlencode($od_settle_case) . "&amp;od_misu=$od_misu&amp;od_cancel_price=$od_cancel_price&amp;od_refund_price=$od_refund_price&amp;od_receipt_point=$od_receipt_point&amp;od_coupon=$od_coupon&amp;fr_date=$fr_date&amp;to_date=$to_date&amp;sel_field=$sel_field&amp;search=$search&amp;save_search=$search";
if ($default['de_escrow_use']) {
    $qstr1 .= "&amp;od_escrow=$od_escrow";
}
$qstr = "$qstr1&amp;sort1=$sort1&amp;sort2=$sort2&amp;page=$page";

// 주문삭제 히스토리 테이블 필드 추가
if (!sql_query(" select mb_id from {$g5['g5_shop_order_delete_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_order_delete_table']}`
                    ADD `mb_id` varchar(20) NOT NULL DEFAULT '' AFTER `de_data`,
                    ADD `de_ip` varchar(255) NOT NULL DEFAULT '' AFTER `mb_id`,
                    ADD `de_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `de_ip` ", true);
}

if (function_exists('pg_setting_check')) {
    pg_setting_check(true);
}

$k = 0;
$list = [];
for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $cnt = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_cart_table']} where od_id = '{$row['od_id']}' ");
    $info = sql_fetch(" select it_id, it_name from {$g5['g5_shop_cart_table']} where od_id = '{$row['od_id']}' ");
    $row['it_id'] = $info['it_id'];
    $row['it_name'] = $info['it_name'];
    if ($cnt['cnt'] > 1) $row['it_name'] .= " 외 (" . ($cnt['cnt'] - 1) . ")건";
    $row['image'] = str_replace('"', "'", get_it_image($row['it_id'], 160, 160));
    $row['href'] = shop_item_url($row['it_id']);

    // 결제 수단
    $s_receipt_way = $s_br = "";
    if ($row['od_settle_case']) {
        $s_receipt_way = $row['od_settle_case'];
        $s_br = '<br />';
    }
    else {
        $s_receipt_way = '결제수단없음';
        $s_br = '<br />';
    }

    if ($row['od_receipt_point'] > 0) {
        $s_receipt_way .= $s_br . "포인트";
    }

    $row['s_receipt_way'] = $s_receipt_way;

    $row['mbinfo'] = sql_fetch("select mb_name, mb_nick, mb_tel, mb_hp, mb_email from {$g5['member_table']} where mb_id='{$row['mb_id']}'");

    $od_cnt = 0;
    if ($row['mb_id']) {
        $sql2 = " select count(*) as cnt from {$g5['g5_shop_order_table']} where mb_id = '{$row['mb_id']}' ";
        $row2 = sql_fetch($sql2);
        $od_cnt = $row2['cnt'];
    }

    // 주문 번호에 device 표시
    $od_mobile = '';
    if ($row['od_mobile']) {
        $od_mobile = '(M)';
    }

    // 주문번호에 - 추가
    switch (strlen($row['od_id'])) {
        case 16:
            $disp_od_id = substr($row['od_id'], 0, 8) . '-' . substr($row['od_id'], 8);
            break;
        default:
            $disp_od_id = substr($row['od_id'], 0, 6) . '-' . substr($row['od_id'], 6);
            break;
    }

    // 주문 번호에 에스크로 표시
    $od_paytype = '';
    if ($row['od_test']) {
        $od_paytype .= '<span class="list_test">테스트</span>';
    }

    if ($default['de_escrow_use'] && $row['od_escrow']) {
        $od_paytype .= '<span class="list_escrow">에스크로</span>';
    }

    $uid = md5($row['od_id'] . $row['od_time'] . $row['od_ip']);

    $invoice_time = is_null_time($row['od_invoice_time']) ? G5_TIME_YMDHIS : $row['od_invoice_time'];
    $delivery_company = $row['od_delivery_company'] ? $row['od_delivery_company'] : $default['de_delivery_company'];

    $bg = 'bg' . ($i % 2);
    $td_color = 0;
    if ($row['od_cancel_price'] > 0) {
        $bg .= 'cancel';
        $td_color = 1;
    }

    // 주문상태에 따라 색상 다르게 표시
    switch ($row['od_status']) {
        case '주문':
            $row['od_color'] = 'red';
            break;
        case '입금':
            $row['od_color'] = 'blue';
            break;
        case '준비':
            $row['od_color'] = 'yellow';
            break;
        case '배송':
            $row['od_color'] = 'green';
            break;
        case '완료':
            $row['od_color'] = 'default';
            break;
        case '취소':
            $row['od_color'] = 'brown';
            break;
        case '반품':
            $row['od_color'] = 'indigo';
            break;
        case '품절':
            $row['od_color'] = 'dark';
            break;
        default:
            $row['od_color'] = 'dark';
            break;
    }

    $list[$i] = $row;
    $list[$i]['it_name'] = preg_replace('/\r\n|\r|\n/', '', $row['it_name']);
    $list[$i]['disp_od_id'] = $disp_od_id;
    $list[$i]['uid'] = $uid;
    $list[$i]['od_cnt'] = $od_cnt;
    $list[$i]['invoice_time'] = $invoice_time;
    $list[$i]['dlcomp'] = $delivery_company;

    $tot_itemcount += $row['od_cart_count'];
    $tot_orderprice += ($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']);
    $tot_ordercancel += $row['od_cancel_price'];
    $tot_receiptprice += $row['od_receipt_price'];
    $tot_couponprice += $row['couponprice'];
    $tot_misu += $row['od_misu'];
}
sql_free_result($result);

if (($od_status == '' || $od_status == '완료' || $od_status == '전체취소' || $od_status == '부분취소') == false) {
    $change_status = "";
    if ($od_status == '주문') $change_status = "입금";
    if ($od_status == '입금') $change_status = "준비";
    if ($od_status == '준비') $change_status = "배송";
    if ($od_status == '배송') $change_status = "완료";
}

$dlcomp = explode(")", str_replace("(", "", G5_DELIVERY_COMPANY));
$delivery_comp = [];
for ($i = 0; $i < count($dlcomp); $i++) {
    if (trim($dlcomp[$i]) == "") continue;
    list($value, $url, $tel) = explode("^", $dlcomp[$i]);
    $delivery_comp[$i] = $value;
}*/

/**
 * 페이징
 */
$paging = $eb->set_paging('admin', $dir, $pid, $qstr);

