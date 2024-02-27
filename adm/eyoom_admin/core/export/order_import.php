<?php
require_once __DIR__ . '/_common.php';

$sub_menu = "400400";
/** @type $auth array */
$err_message = auth_check_menu($auth, $sub_menu, 'r', true);
empty($err_message) !== true && export_message($err_message, 'error', null, true);
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
    , 'AA' => "배송업체" // 26
    , 'AB' => "송장번호" // 27
    , 'AC' => "배송일자" // 28
];
/*
 | ---------------------------------------------------------------
 | 파일 업로드 및
 | ---------------------------------------------------------------
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $param['mode'] == 'upload') {
    $file = &$_FILES['source'];
    ($file['error'] > 0 || !$file['size']) && export_message('File upload failed.', 400);

    // -- 정상적인 엑셀 파일인지 검사
    try {
        $tmp_file = $file['tmp_name'];
        $reader = PHPExcel_IOFactory::createReader(PHPExcel_IOFactory::identify($tmp_file));

        $PHPExcel = $reader->load($tmp_file);
        $row = reset($PHPExcel->getSheet(0)->rangeToArray('A1:AC1', null, true, false));
        $diff= array_diff(array_values($entry), $row);

        empty($diff) !== true && export_message('엑셀 데이터가 일치하지 않습니다.', 400);

        $file_name = 'orderimport.' . md5(microtime(true));

        file_exists(_EXPORT_PATH_) !== true && mkdir(_EXPORT_PATH_, 0755);
        $export_file = _EXPORT_PATH_ . "/{$file_name}";

        @copy($tmp_file, $export_file) ? export_message($file_name, 200) : export_message('업로드된 파일의 임시 보관에 실패하였습니다.', 400);
    }
    catch (Exception $err) {
        export_message("Error loading file {$file['name']}." . $err->getMessage(), 400);
    }
}
else if ($param['mode'] != 'import') {
    export_message('Method not allowed.', 'error');
}
// &mode=import&id=

empty($param['id']) === true && export_message('Missing the ID.', 'error');

file_exists($export_file = _EXPORT_PATH_ . "/{$param['id']}") === false && export_message('삭제되었거나 잘 못된 파일 ID 입니다.', 'error');

try {
    $PHPExcel = (PHPExcel_IOFactory::createReader(PHPExcel_IOFactory::identify($export_file)))->load($export_file);
    $Sheet = $PHPExcel->setActiveSheetIndex(0);
    $totals = $Sheet->getHighestRow();
    export_message(number_format($totals) . "건의 데이터 처리중 ...", 'log', ['total' => $totals, 'progress' => 0]);

    $apply = 0;

    for ($index = 2; $index <= $totals; ++$index) {
        usleep(1000);
        $row = reset($Sheet->rangeToArray('A' . $index . ':AC' . $index, null, true, false));
        $percent = floor((($index - 1) / $totals) * 100);

        if (empty($row['27']) === true) {
            export_message("#{$row[0]} - Not change(" . number_format($index - 1) . '/' . number_format($totals) . ")", 'log', ['total' => $totals, 'progress' => $percent]);
            continue;
        }

        ++$apply;
        $orderId = trim($row[0]);
        $courier = trim($row[26]);
        $invoiceNo = trim($row[27]);
        $shippingDate = trim($row[28]);

        $invoiceNo = preg_replace('/[^0-9]+/', '', $invoiceNo);

        empty($courier) === true && ($courier = 'CJ대한통운');
        empty($shippingDate) === true && ($shippingDate = date('Y-m-d H:i:s'));

        export_message("#{$row[0]} - 갱신 중 ... (" . number_format($index - 1) . '/' . number_format($totals) . ")", 'log', ['total' => $totals, 'progress' => $percent]);

        $sql = "UPDATE {$g5['g5_shop_order_table']} SET od_delivery_company=" . fn_sql_quote($courier) . ', od_invoice=' . fn_sql_quote($invoiceNo) . ', od_invoice_time=' . fn_sql_quote($shippingDate);
        $sql .= " WHERE od_id=" . fn_sql_quote($orderId) . ' AND od_status IN(\'입금\', \'준비\', \'배송\')';
    }
    export_message($apply > 0 ? number_format($totals) . '건 중 ' . number_format($apply) . '건 주문에 대한 배송정보가 변경되었습니다.' : '변경된 주문 정보가 없습니다.', 'close', ['mode' => 'import', 'apply' => $apply], true);
}
catch (Exception $err) {
    export_message('ERROR: ' . $err->getMessage(), 'error', null, true);
}


die;