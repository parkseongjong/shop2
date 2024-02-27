<?php
require_once __DIR__ . '/_common.php';

$sub_menu = "400400";
/** @type $auth array */
$err_message = auth_check_menu($auth, $sub_menu, 'r', true);

empty($err_message) !== true && export_message($err_message, 'error', null, true);

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
];

// -- 파라미터
$param = array_merge($_GET, $_POST);
empty($param['sort']) === true && ($param['sort'] = 'A'); // 정렬 대상
empty($param['order']) === true && ($param['order'] = 'D'); // 정렬 순서

empty($param['term']) === true && ($param['term'] = 'A'); //
empty($param['fromDate']) === true && ($param['fromDate'] = (new DateTime('-3 month'))->format('Y-m-01'));
empty($param['toDate']) === true && ($param['toDate'] = (new DateTime())->format('Y-m-t')); //

$param['fromDate'] = (new DateTime($param['fromDate']))->format('Y-m-d');
$param['toDate'] = (new DateTime($param['toDate']))->format('Y-m-d');

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
//
// Get totals
$totals = fn_sql_row("SELECT COUNT(0) FROM {$g5['g5_shop_order_table']} T_ORD LEFT JOIN {$g5['g5_shop_cart_table']} T_CART ON T_CART.od_id=T_ORD.od_id WHERE $where");
!$totals && export_message('가져올 데이터가 없습니다.', 'error', null, true);
// 1048576
$totals > _EXPORT_ROW_MAX_ && export_message('출력할 수 있는 데이터 갯수(' . number_format(_EXPORT_ROW_MAX_) . ')가 초과했습니다.', 'error', null, true);

//
//

$rows = [];
$page = 1;
$config['cf_page_rows'] = 200; // 강제 제한

$entry = [
    'A' => "주문번호"
    , 'B' => "상품명"
    , 'C' => "주문날짜"

    , 'D' => '판매자'   // 판매자
    , 'E' => '판매자ID'   // 판매자 ID

    , 'F' => "우편번호"
    , 'G' => "주문자 주소"
    , 'H' => "주문자 이름"
    , 'I' => "주문자 ID"
    , 'J' => "주문자 휴대전화"

    , 'K' => "판매단가"
    , 'L' => "주문단가"
    , 'M' => "수량"

    , 'N' => "결제금액"

    , 'O' => "우편번호"
    , 'P' => "배송지"

    , 'Q' => "주문상태"
    , 'R' => "수령인"
    , 'S' => "연락처"
    , 'T' => '관리자 확인' // 관리자 체크
    , 'U' => '메모' // 관리자 메모
    , 'V' => "주문메모"

    , 'W' => "결제상태"
    , 'X' => "결제수단"
    , 'Y' => "선택옵션"
    , 'Z' => "선택옵션 추가금액"
    , 'AA' => "배송업체"
    , 'AB' => "송장번호"
    , 'AC' => "배송일자"
];
$Merges = [
    'A'
    , 'C'
    , 'D'
    , 'E'
    , 'F'
    , 'G'
    , 'H'
    , 'I'
    , 'J'
    , 'N'
    , 'O'
    , 'P'
    , 'Q'
    , 'R'
    , 'S'
    #, 'T'
    #, 'U'
    , 'V'
    , 'W'
    , 'X'
    , 'AA'
    , 'AB'
    , 'AC'
];
$Widths = [
    'A' => 20
    , 'B' => 60
    , 'C' => 20
    , 'D' => 10
    , 'E' => 10
    , 'F' => 10
    , 'G' => 100

    , 'H' => 18
    , 'I' => 18
    , 'J' => 18

    , 'K' => 10
    , 'L' => 10
    , 'N' => 10

    , 'O' => 10
    , 'P' => 100

    , 'Q' => 10
    , 'R' => 10
    , 'S' => 18

    , 'T' => 15
    , 'V' => 30
    , 'W' => 18
    , 'X' => 12
    , 'AA' => 12
    , 'AB' => 16
    , 'AC' => 20
];

[$limit, $pages] = fn_sql_build_limit($page, $totals);

export_message(number_format($totals) . "건의 주문 상품 추출 중 ...", 'log', ['total' => $totals, 'pages' => $pages, 'progress' => 0]);
try {
    /*
     | ---------------------------------------------------------------
     |  엑셀 및 쉬트 초기화
     | ---------------------------------------------------------------
     */
    $Excel = new PHPExcel();
    $Excel->setActiveSheetIndex(0);
    $Sheet = &$Excel->getActiveSheet();
    $Sheet->setTitle(date('Y년 m월 d일 주문'));
    $Sheet->fromArray(array_values($entry), 'A1');

    // 첫열 높이, 전체 각 행 너비
    $Sheet->getRowDimension(1)->setRowHeight(21);
    foreach ($Widths as $col => $value) {
        $Sheet->getColumnDimension($col)->setWidth($value);
    }

    $lastedRowIndex = ($totals + 1);

    // 첫열 고정
    $Sheet->freezePane('B2');

    // 첫열 스타일
    $Sheet->getStyle("A1:AC1")->applyFromArray([
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ], 'fill' => [
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => 'E0E0E0'],
            ##'name'  => '맑은 고딕'
        ]
    ]);
    // 주문상태, 결제 상태등은 가운데 정렬
    $Sheet->getStyle("Q1:Q{$lastedRowIndex}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $Sheet->getStyle("W1:X{$lastedRowIndex}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $Sheet->getStyle("A1:AC{$lastedRowIndex}")->applyFromArray([
        'alignment' => [
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allborders' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN
            ]
        ],
        'font' => [
            'color' => ['rgb' => '333333'],
            'size' => 9,
            //'name' => 'Verdana'
        ]
    ]);
    $Sheet->getStyle("AA2:AC{$lastedRowIndex}")->applyFromArray([
        'fill' => [
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => 'F0F0F0']
        ]
    ]);

    /*
     | ---------------------------------------------------------------
     |  페이징 당 데이터 가져오기
     | ---------------------------------------------------------------
     */
    $rowIndex = 1;
    $groupIndex = null;
    $ord_id = null;
    $rowTotal = 0;

    for (; $page <= $pages; $page++) {
        $offset = ($page - 1) * $config['cf_page_rows'];
        $percent = floor(($page / $pages) * 100);

        $sql = "
        SELECT
            T_ORD.*
            , T_CART.it_id
            , T_CART.it_name
            , T_CART.ct_status
            , T_CART.ct_price
            , T_CART.ct_qty
            , T_CART.ct_send_cost
            , T_MB.mb_name
            , T_MB.mb_hp
            , T_MB.mb_email
        FROM
            {$g5['g5_shop_order_table']} T_ORD
            LEFT JOIN {$g5['g5_shop_cart_table']} T_CART ON T_CART.od_id=T_ORD.od_id
            LEFT OUTER JOIN  {$g5['member_table']} T_MB ON T_ORD.mb_id = T_MB.mb_id
        WHERE 
            $where
        ORDER BY 
            $order_by, od_id
        LIMIT
            {$offset}, {$config['cf_page_rows']}
    ";
        $rows = fn_sql_fetch_all($sql);
        $rowTotal += count($rows);
        $rowTotal = min($rowTotal, $totals);
        export_message(number_format($totals) . "건 중 " . number_format($rowTotal) . "의 주문 상품 정보 추출 및 쓰기 중 ...", 'log', ['total' => $totals, 'pages' => $pages, 'progress' => $percent]);
        //
        foreach ($rows as $i => $row) {
            $rowIndex++;
            $is_group = $ord_id == $row['od_id'];

            $row['od_receipt_time'] = trim(str_replace(['0000-00-00', '00:00:00'], '', $row['od_receipt_time']));
            $row['od_invoice_time'] = trim(str_replace(['0000-00-00', '00:00:00'], '', $row['od_invoice_time']));

            // 주문 번호, 상품명, 주문 일시, 판매자, 판매자 ID, 주문자 주소 우편 번호, 주문자 주소,
            // 주문자, 주문자 ID, 주문자 연락처,
            // 판매가, 반영 판매가, 수량, 결제 금액,
            // 수령자 주소 우편 번호, 수령자 주소, 진행상태, 받으실분, 받으실분 전화번호, 관리자 체크 상태, 메모, 주문메모,
            // 결제상태, 결제수단, 선택옵션, 선택 옵션 추가 금액
            $entry = [
                'A' => "{$row['od_id']}"
                , 'B' => $row['it_name']
                , 'C' => (new DateTime($row['od_time']))->format('Y-m-d H:i:s')

                , 'D' => ''   // 판매자
                , 'E' => ''   // 판매자 ID

                , 'F' => "{$row['od_zip1']}{$row['od_zip2']}"
                , 'G' => "{$row['od_addr1']} {$row['od_addr2']}"
                , 'H' => "{$row['od_name']}"
                , 'I' => "{$row['mb_id']}"
                , 'J' => conv_telno($row['od_hp'])

                , 'K' => "{$row['ct_price']}"
                , 'L' => "{$row['ct_price']}"
                , 'M' => "{$row['ct_qty']}"

                , 'N' => $row['od_misu'] > 0 ? $row['od_misu'] : $row['od_receipt_price']

                , 'O' => "{$row['od_b_zip1']}{$row['od_b_zip2']}"
                , 'P' => "{$row['od_b_addr1']} {$row['od_b_addr2']}"

                , 'Q' => $row['od_status']
                , 'R' => $row['od_b_name']
                , 'S' => conv_telno($row['od_b_hp'])
                , 'T' => '' // 관리자 체크
                , 'U' => '' // 관리자 메모
                , 'V' => preg_replace("/\"/", "&#034;", $row['od_shop_memo']) // 주문메모

                , 'W' => $row['od_receipt_time'] ? '결제완료' : ($row['od_status'] == '주문' ? '미입금' : '미확인')  // 결제상태
                , 'X' => $row['od_settle_case']
                , 'Y' => $row['ct_option'] // 선택옵션
                , 'Z' => $row['io_price'] // 선택옵션 추가금액
                , 'AA' => $row['od_delivery_company']
                , 'AB' => $row['od_invoice']
                , 'AC' => $row['od_invoice_time']
            ];


            /*if ($is_group) { unset(
                $entry['A']/*, $entry['B']* /, $entry['C'], $entry['D'], $entry['E'], $entry['F'], $entry['G'], $entry['H'], $entry['I'],
                $entry['J']/*, $entry['K']* //*, $entry['L']* //*, $entry['M']* /, $entry['N'], $entry['O'], $entry['P'], $entry['Q'], $entry['R'],
                $entry['S'], $entry['T'], $entry['U']/*, $entry['V']* /, $entry['W'], $entry['X']/*, $entry['Y']* //*, $entry['Z']* /, $entry['AA'],
                $entry['AB'], $entry['AC']
            ); "*/


            foreach ($entry as $col => $value) {
                if ($is_group && in_array($col, $Merges) === true) {
                    $Sheet->mergeCells("{$col}{$groupIndex}:{$col}{$rowIndex}");
                    //$Sheet->getStyle("{$col}{$groupIndex}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $Sheet->getStyle("A{$groupIndex}:AC{$rowIndex}")->applyFromArray([
                        'fill' => [
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => ['rgb' => 'FFF2CC']
                        ]
                    ]);
                }
                else if (in_array($col, ['A', 'F', 'O', 'AB']) === true) {
                    $Sheet->setCellValueExplicit("{$col}{$rowIndex}", $value, PHPExcel_Cell_DataType::TYPE_STRING);
                }
                else if (in_array($col, ['K', 'L', 'M', 'N']) === true) {
                    $Sheet->setCellValueExplicit("{$col}{$rowIndex}", $value, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $Sheet->getStyle("{$col}{$rowIndex}")->getNumberFormat()->setFormatCode('#,##0');
                }
                else {
                    $Sheet->setCellValue("{$col}{$rowIndex}", $value);
                }


                // 주문상태일때
                if ($col == 'Q') {
                    $Sheet->getStyle("{$col}{$rowIndex}")->getFont()->getColor()->setRGB([
                        '주문' => 'FF4848',
                        '입금' => '53A5FA', '준비' => 'FDAB29', '배송' => '73B852', '완료' => '000000'
                        , '취소' => '8C6E63', '반품' => '6284F3', '품절' => '676769',
                    ][$value]);
                }
            }

            // --
            if (!$is_group) {
                $ord_id = $row['od_id'];
                $groupIndex = $rowIndex;
            }
        }
        usleep(60);

    }

    /*
     | 임시파일 생성 후 삭제
     |
     */
    if ($_GET['debug'] == 'Y') {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"test.xlsx\"");
        header("Cache-Control: max-age=0");
        (PHPExcel_IOFactory::createWriter($Excel, 'Excel2007'))->save('php://output');
    }
    else {

        $file_name = 'orderlist.'.md5(microtime(true));
        file_exists(_EXPORT_PATH_) !== true && mkdir(_EXPORT_PATH_, 0755);

        $export_file = _EXPORT_PATH_ . "/{$file_name}";

        (PHPExcel_IOFactory::createWriter($Excel, 'Excel5'))->save($export_file);
        export_message('completed', 'close', ['mode' => 'export', 'fileName' => $file_name], true);
    }
}

catch (Exception $e) {
    export_message('ERROR: ' . $e->getMessage(), 'error', null, true);
}

die;