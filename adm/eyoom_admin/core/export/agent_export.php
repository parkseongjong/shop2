<?php
require_once __DIR__ . '/_common.php';
!function_exists('getDistrictState') && include_once(G5_EXTEND_PATH . '/agent.extend.php');


$sub_menu = "600100";
/** @type $auth array */
$err_message = auth_check_menu($auth, $sub_menu, 'r', true);

empty($err_message) !== true && export_message($err_message, 'error', null, true);
/*
 | ---------------------------------------------------------------
 |  기본 변수, 파라미터
 | ---------------------------------------------------------------
 */
// -- 파라미터
$param = array_merge($_GET, $_POST);
empty($param['fromDate']) === true && ($param['fromDate'] = (new DateTime('-3 month'))->format('Y-m-01'));
empty($param['toDate']) === true && ($param['toDate'] = (new DateTime())->format('Y-m-t')); //

$param['fromDate'] = (new DateTime($param['fromDate']))->format('Y-m-d');
$param['toDate'] = (new DateTime($param['toDate']))->format('Y-m-d');
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

// COUNT
$totals = fn_sql_row("SELECT COUNT(0) FROM {$g5['tb_agent_point']} WHERE {$where}");
!$totals && export_message('가져올 데이터가 없습니다.', 'error', null, true);
// 1048576
$totals > _EXPORT_ROW_MAX_ && export_message('출력할 수 있는 데이터 갯수(' . number_format(_EXPORT_ROW_MAX_) . ')가 초과했습니다.', 'error', null, true);

//
//

$rows = [];
$page = 1;
$config['cf_page_rows'] = 200; // 강제 제한

$entry = [
     'A' => "대리점명"
    , 'B' => "분류"
    , 'C' => "코드"
    , 'D' => '지급율'
    , 'E' => "연락처"
    , 'F' => "이메일"
    , 'G' => "상태"
    , 'H' => "회원수"
    , 'I' => "포인트적립일"
    , 'J' => "적립포인트"
    , 'K' => "정산여부"
    , 'L' => "내용"
];
$Widths = [
    'A' => 40
    , 'B' => 8
    , 'C' => 8
    , 'D' => 7
//    , 'E' => 32
    , 'E' => 12
    , 'F' => 24
    , 'G' => 6
    , 'H' => 8
    , 'I' => 20
    , 'J' => 12
    , 'K' => 8
    , 'L' => 86
];

[, $pages] = fn_sql_build_limit($page, $totals);

export_message(number_format($totals) . "건의 대리점 적립 포인트 내역 추출 중 ...", 'log', ['total' => $totals, 'pages' => $pages, 'progress' => 0]);

/**
 * @param PHPExcel_Worksheet $sheet
 * @param $row_index
 * @param $subtotal
 * @param $debt
 * @param $bank_account
 * @throws
 */
function __set_sheet(&$sheet, $row_index, $subtotal, $debt, $bank_account)
{
    $di = $row_index + 1;
    $ti = $row_index + 2;


    $sheet->mergeCells("L{$di}:L{$ti}");
    // 미정산
    $sheet->getStyle("I{$di}:J{$di}")->applyFromArray(['fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => 'F8CBAD']]]);

    // 합계
    $sheet->getStyle("I{$ti}:J{$ti}")->applyFromArray(['fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => '9BC2E6']]]);

    //
    $sheet->getStyle("J{$di}:L{$di}")->getFont()->setBold(true);
    $sheet->getStyle("J{$ti}")->getFont()->setBold(true);
    $sheet->getStyle("A{$ti}:H{$ti}")->applyFromArray(['borders' => ['bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]]);

    $sheet->setCellValue("I{$di}", '미정산');
    $sheet->setCellValue("I{$ti}", '소  계');

    $sheet->setCellValue("J{$di}", $debt);
    $sheet->setCellValue("J{$ti}", $subtotal);
    $sheet->setCellValue("L{$di}", $bank_account);
}


try {
    /*
      | ---------------------------------------------------------------
      |  엑셀 및 쉬트 초기화
      | ---------------------------------------------------------------
      */
    $Excel = new PHPExcel();
    $Excel->setActiveSheetIndex(0);
    $Sheet = &$Excel->getActiveSheet();
    $Sheet->setTitle(date('Y년 m월 d일 대리점 포인트 내역'));
    $Sheet->fromArray(array_values($entry), 'A1');

    // 첫열 높이, 전체 각 행 너비
    $Sheet->getRowDimension(1)->setRowHeight(21);
    foreach ($Widths as $col => $value) {
        $Sheet->getColumnDimension($col)->setWidth($value);
    }


    // Agent COUNT
    $agentCount = fn_sql_row("SELECT COUNT(DISTINCT(ap_agent)) FROM {$g5['tb_agent_point']} WHERE {$where}");

    // https://bm.devper.dev4.kr/adm/?dir=export&pid=agent_export&scope=point&debug=X
    $lastedRowIndex = $totals + 1 + ($agentCount * 2);


    // 첫열 고정
    $Sheet->freezePane('B2');

    // 첫열 스타일
    $Sheet->getStyle("A1:M1")->applyFromArray([
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ]

        , 'borders' => [
            'allborders' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN
            ]
        ]

        , 'fill' => [
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => 'E0E0E0'],
        ]
    ]);

    // 공통
    $Sheet->getStyle("A1:M{$lastedRowIndex}")->applyFromArray([
        'alignment' => ['vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER],
        'font' => ['size' => 9, 'name' => 'Malgun Gothic Semilight']
    ]);

    // Alignment center
    $Sheet->getStyle("B1:B{$lastedRowIndex}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $Sheet->getStyle("G1:G{$lastedRowIndex}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $Sheet->getStyle("K1:K{$lastedRowIndex}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    // Number format
    $Sheet->getStyle("H2:H{$lastedRowIndex}")->getNumberFormat()->setFormatCode('#,##0');
    $Sheet->getStyle("J2:J{$lastedRowIndex}")->getNumberFormat()->setFormatCode('#,##0');

    $Sheet->getStyle("I2:L{$lastedRowIndex}")->applyFromArray(['borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]]);
    $Sheet->getStyle("A2:H{$lastedRowIndex}")->applyFromArray([
        'borders' => [
            'vertical' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
            , 'outline' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
        ]
    ]);
    /*
     | ---------------------------------------------------------------
     |  페이징 당 데이터 가져오기
     | ---------------------------------------------------------------
     */
    $rowIndex = 1;
    $rowTotal = 0;

    //
    $prev = null;
    $States = getDistrictState();
    for ($page = 1; $page <= $pages; $page++) {
        $offset = ($page - 1) * $config['cf_page_rows'];
        $percent = floor(($page / $pages) * 100);

        $sql = "SELECT * FROM {$g5['tb_agent_point']} TA LEFT OUTER JOIN {$g5['tb_agents']} TB ON TA.ap_agent=TB.ag_code WHERE {$where} ORDER BY ap_agent ASC, ap_idx ASC  LIMIT {$offset}, {$config['cf_page_rows']}";
        $rows = fn_sql_fetch_all($sql);

        $rowTotal += count($rows);
        $rowTotal = min($rowTotal, $totals);
        $subtotals = null;

        export_message(number_format($rowTotal) . "/" . number_format($totals) . " 데이터 추출 및 쓰기 중 ...", 'log', ['total' => $totals, 'pages' => $pages, 'progress' => $percent]);

        foreach ($rows as $i => $row) {

            $entry = ['I' => $row['ap_created_at'], 'J' => $row['ap_point'], 'K' => $row['ap_withdraw'], 'L' => $row['ap_note']];


            if ($prev != $row['ap_agent']) {
                $entry['A'] = $States[substr($row['ap_agent'], 0, 2)] . ' / ' . $row['ag_name'];
                $entry['B'] = $row['ag_type'] == 'S' ? '총판' : '대리점';
                $entry['C'] = $row['ap_agent'];
                $entry['D'] = $row['ag_margin_rate'] > 0.00 ? "{$row['ag_margin_rate']}%" : '';
                $entry['E'] = $row['ag_phone'];
                $entry['F'] = $row['ag_email'];
                $entry['G'] = $row['ag_status'] == 'active' ? '노출' : '숨김';
                $entry['H'] = $row['ag_mentee'];

                /*
                 *
                 */
                if ($prev) {
                    __set_sheet($Sheet, $rowIndex, $subtotals['subtotal'], $subtotals['debt'], trim("{$row['ag_bank_name']} {$row['ag_bank_account']} {$row['ag_bank_owner']}"));
                    $rowIndex += 2;
                }
                unset($subtotals);

                $subtotals['subtotal'] = $row['ap_point'];
                $row['ap_withdraw'] != 'Y' && $row['ap_point'] > 0 && ($subtotals['debt'] = $row['ap_point']);
                $prev = $row['ap_agent'];
            }
            else {
                $subtotals['subtotal'] += $row['ap_point'];
                $row['ap_withdraw'] != 'Y' && $row['ap_point'] > 0 && ($subtotals['debt'] += $row['ap_point']);
            }


            $rowIndex++;
            foreach ($entry as $col => $value) {
                if (in_array($col, ['C']) === true) {
                    $Sheet->setCellValueExplicit("{$col}{$rowIndex}", $value, PHPExcel_Cell_DataType::TYPE_STRING);
                }
                else {
                    $Sheet->setCellValue("{$col}{$rowIndex}", $value);
                }

                // 주문상태일때
                $col == 'G' && $Sheet->getStyle("{$col}{$rowIndex}")->getFont()->getColor()->setRGB(['노출' => '000000', '숨김' => 'C00000'][$value]);
                $col == 'J' && $entry['K'] == 'N' && $value > 0 && $Sheet->getStyle("{$col}{$rowIndex}")->getFont()->getColor()->setRGB('FF3300');


            }

        }
    }


    __set_sheet($Sheet, $rowIndex, $subtotals['subtotal'], $subtotals['debt'], trim("{$row['ag_bank_name']} {$row['ag_bank_account']} {$row['ag_bank_owner']}"));


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

        $file_name = 'agents.' . md5(microtime(true));
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