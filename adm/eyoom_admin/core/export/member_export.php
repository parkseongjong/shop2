<?php
require_once __DIR__ . '/_common.php';
!function_exists('getDistrictNameByCode') && include G5_EXTEND_PATH . '/helper.extend.php';

$sub_menu = "200100";
/** @type $auth array */
$err_message = auth_check_menu($auth, $sub_menu, 'r', true);

empty($err_message) !== true && export_message($err_message, 'error', null, true);
empty($param['sort']) === true && ($param['sort'] = 'A'); // 정렬 대상
empty($param['order']) === true && ($param['order'] = 'D'); // 정렬 순서

empty($param['term']) === true && ($param['term'] = 'A');
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
    , 'term' => [
        'A' => 'mb_datetime'
        , 'B' => 'mb_today_login'

    ]
];

/*
 | ---------------------------------------------------------------
 | 조건절
 | ---------------------------------------------------------------
 */
$conditional = ['mb_no > 10'];
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
empty($conditional) !== true && ($where = " WHERE " . implode(' AND ', $conditional));
$order_by = $PageConfig['sort'][$param['sort']] . ' ' . $PageConfig['order'][$param['order']];

$sql = "SELECT COUNT(0) FROM {$g5['member_table']} {$where} ORDER BY {$order_by}";
//
// Get totals
$totals = fn_sql_row($sql);
!$totals && export_message('가져올 데이터가 없습니다.', 'error', null, true);

// 1048576
$totals > _EXPORT_ROW_MAX_ && export_message('출력할 수 있는 데이터 갯수(' . number_format(_EXPORT_ROW_MAX_) . ')가 초과했습니다.', 'error', null, true);

//
//

$rows = [];
$page = 1;
$config['cf_page_rows'] = 200; // 강제 제한

$entry = [
    'A' => "아이디"
    , 'B' => "이름"
    , 'C' => "휴대전화"
    , 'D' => '이메일'
    , 'E' => '상태'
    , 'F' => "추천인"
    , 'G' => "대리점"
    , 'H' => "가입일"
    , 'I' => "최근로그인"
    , 'J' => "포인트"
    , 'K' => "누적주문건수"
    , 'L' => "누적주문금액"
];
$Widths = [
    'A' => 20
    , 'B' => 20
    , 'C' => 20
    , 'D' => 35
    , 'E' => 8
    , 'F' => 20
    , 'G' => 30
    , 'H' => 22
    , 'I' => 22
    , 'J' => 12
    , 'K' => 12
    , 'L' => 20
];
[, $pages] = fn_sql_build_limit($page, $totals);

export_message(number_format($totals) . "건의 주문 상품 추출 중 ...", 'log', ['total' => $totals, 'pages' => $pages, 'progress' => 0]);

/*
 |
 */
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

    // 공통
    $Sheet->getStyle("A1:L{$lastedRowIndex}")->applyFromArray([
        'alignment' => ['vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,],
        'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]],
        'font' => ['size' => 9, 'name' => 'Malgun Gothic Semilight']
    ]);

    // 첫열 스타일
    $Sheet->getStyle("A1:L1")->applyFromArray([
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ], 'fill' => [
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => 'E0E0E0'],
        ]
    ]);

    // 상태 등은 가운데 정렬
    $Sheet->getStyle("E1:E{$lastedRowIndex}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $Sheet->getStyle("J2:L{$lastedRowIndex}")->getNumberFormat()->setFormatCode('#,##0');
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

        $sql = "SELECT 
            *
            , (SELECT COUNT(0) FROM {$g5['g5_shop_order_table']} T2 WHERE T2.mb_id=T1.mb_id AND od_status IN('입금', '준비', '배송', '완료')) order_count
            , (SELECT SUM(od_receipt_price) FROM {$g5['g5_shop_order_table']} T2 WHERE T2.mb_id=T1.mb_id AND od_status IN('입금', '준비', '배송', '완료')) order_subtotal
            FROM {$g5['member_table']} T1 {$where} 
            ORDER BY {$order_by}
            LIMIT {$offset}, {$config['cf_page_rows']}
            ";
        $rows = fn_sql_fetch_all($sql);
        $rowTotal += count($rows);
        $rowTotal = min($rowTotal, $totals);
        export_message(number_format($totals) . "명 중 " . number_format($rowTotal) . "명의 회원 정보 추출 및 쓰기 중 ...", 'log', ['total' => $totals, 'pages' => $pages, 'progress' => $percent]);
        //
        foreach ($rows as $i => $row) {
            $rowIndex++;


            $status = '정상';
            if ($row['mb_leave_date']) {
                $status = '탈퇴';
            }
            else if ($row['mb_intercept_date']) {
                $status = '차단';
            }

            $agent = $row['mb_1'] ? implode(getDistrictNameByCode($row['mb_1']), ' /') : '';
            $entry = [
                'A' => $row['mb_id']
                , 'B' => $row['mb_name']
                , 'C' => hyphen_hp_number($row['mb_hp'])
                , 'D' => $row['mb_email']
                , 'E' => $status
                , 'F' => $row['mb_recommend']
                , 'G' => $agent
                , 'H' => (new DateTime($row['mb_datetime']))->format('Y-m-d H:i:s')
                , 'I' => (new DateTime($row['mb_today_login']))->format('Y-m-d H:i:s')
                , 'J' => $row['mb_point']
                , 'K' => $row['order_count']
                , 'L' => $row['order_subtotal']
            ];

            foreach ($entry as $col => $value) {
                if (in_array($col, ['A', 'B', 'D', 'F', 'G']) === true) {
                    $Sheet->setCellValueExplicit("{$col}{$rowIndex}", $value, PHPExcel_Cell_DataType::TYPE_STRING);
                }
                else {
                    $Sheet->setCellValue("{$col}{$rowIndex}", $value);
                }
                // 주문상태일때
                if ($col == 'E') {
                    $Sheet->getStyle("{$col}{$rowIndex}")->getFont()->getColor()->setRGB([
                        '정상' => '000000', '탈퇴' => 'C00000', '차단' => 'FF3300'
                    ][$value]);
                }
            }
        }
        usleep(60);
    }
    /*
     | 임시파일 생성 후 삭제
     |
     */
    if ($_GET['debug'] == 'Y') {

    }
    else if ($_GET['debug'] == 'X') {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"test.xlsx\"");
        header("Cache-Control: max-age=0");
        (PHPExcel_IOFactory::createWriter($Excel, 'Excel2007'))->save('php://output');
    }
    else {

        $file_name = 'memberlist.' . md5(microtime(true));
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