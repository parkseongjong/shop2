<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
$param = $_POST;
array_walk($param, function (&$value, &$key) {
    $value = clean_xss_tags($value);
});

// 실패
($param['responseCode'] != '0000') && alert($param['responseMsg'] . ' 코드 : ' . $param['responseCode']);

if ($od_settle_case == '신용카드') {
    if ($default['de_payup_way'] == 'manual') {
        $signature = hash('sha256', "{$default['de_payup_mid']}|{$param['transactionId']}|{$param['authDateTime']}|{$default['de_payup_secret']}");
        ($signature != $param['sig']) && alert('유효하지 않은 검증 코드입니다.');
    }

    $tno = $param['transactionId']; // 페이업 거래번호
    $app_no = $param['authNumber']; // 카드사승인번호
    $card_name = $param['cardName']; // 결제 카드사명
    $app_time = $param['authDateTime']; // 결제승인일시
    // ----
    /*
        responseCode:   응답 코드 : 0000
        responseMsg:    응답 메세지: 성공
        transactionId:  거래번호 (페이업에서 생성)
        authDateTime:   승인일시 결제승인 일시(YYYYMMDDHH24MISS) Y
        authNumber:     승인번호 카드사승인번호 Y
        cardName:       카드사명 승인된 카드사 명 Y
        orderNumber:    주문번호 승인요청시의 가맹점 주문번호 Y
        amount:         결제금액 총 결제금액 Y
        kakaoResultCode:카카오(알림결과코드“” : 미발송 , “0000” : 발송성공, 그외코드 오류.)

        payupType:      타입 keyin Y
        sig:            검증값 결제 위변조 방지를 위한 응답 검증 값
    */
}
else if ($od_settle_case == '가상계좌') {

    $tno = $param['transactionId']; // 페이업 거래번호
    $bankname = $param['bankName']; // 입금은행
    $account = $param['account'];   // 계좌번호
    $depositor = $param['accountHolder']; // 입금자명
    $amount = $param['amount'];
}
