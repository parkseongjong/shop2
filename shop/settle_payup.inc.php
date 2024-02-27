<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
require_once __DIR__ . '/payup/lib/class.PayUp.php';
require_once __DIR__ . '/payup/lib/class.OfferBankType.php';
require_once __DIR__ . '/payup/lib/class.OfferCardType.php';

/*
 * 가상계좌용 계정정보가 없는 경우 카드와 동일하게 설정함
 */
if (empty($default['de_payup_mid2']) == true) {
    $bank_mid = $default['de_payup_mid'];
    $bank_secret = $default['de_payup_secret'];
}
else {
    $bank_mid = $default['de_payup_mid2'];
    $bank_secret = $default['de_payup_secret2'];
}

$PayUp = new \PayUp\PayUp($default['de_payup_mid'], $default['de_payup_secret'], $default['de_payup_apikey']);
$PayUp->setVirtualAccountMerchant($bank_mid, $bank_secret);

$PayUp->setReturnUrl(G5_HTTPS_SHOP_URL . '/payup/payup_notify.php');      // 통지
$PayUp->setAuthReturn(G5_HTTPS_SHOP_URL . '/payup/payup_authorize.php');  // 실제 결제

// 테스트 버전인 경우
$default['de_card_test'] && $PayUp->isTest(true);

$PayUpBankList = [
    'BK03' => '기업은행'
    , 'BK04' => '국민은행'
    , 'BK26' => '신한은행'
    , 'BK20' => '우리은행'
    , 'BK81' => 'KEB하나은행'
    , 'BK23' => 'SC제일은행'
    , 'BK71' => '우체국'
    , 'BK11' => '농협'
    , 'BK07' => '수협'
    , 'BK34' => '광주은행'
    , 'BK32' => '부산은행'
    , 'BK31' => '대구은행'
    , 'BK39' => '경남은행'
];

/**
 * 하이브리드 앱에서 인앱 결제 오류 발생
 * - 모바일인 경우 수기결제 방식으로 변경
 *  - api, manual, (None) (API 결제 방식, 수기 결제 방식, 다날 결제 방식)
 *  - 마켓   수기 결제(api)      : 결제창(payup_capture.php) -> 지불 승인 요청(payup_payout.php) -> 주문서 작성
 *  - 페이업 수기 결제(manual)   : 페이업 팝업 결제 창 -> 주문서 작성
 *  - 페이업 다날 결제           : 결제요청서 생성(payup_checkout.php) -> 다날 결제 창 요청(payup_checkout.php) -> 결제 진행 -> 지불 승인 요청(payup_authorize.php) -> 주문서
 */


$default['de_payup_way'] = '';
G5_IS_MOBILE && ($default['de_payup_way'] = 'api');
##(G5_IS_MOBILE && in_array($member['mb_id'], ['payup2', 'kakao_a79809ee'])) && ($default['de_payup_way'] = 'manual');