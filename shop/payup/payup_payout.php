<?php
/**
 * 결제 승인 완료 요청하기
 */
include_once __DIR__ . '/_common.php';
include_once __DIR__ . '/../settle_payup.inc.php';

/*$_POST = [
    'orderNumber' => '2022071416331742'
    , 'amount' => '145000'
    , 'itemName' => '비바스킨 하이드로 멀티 에너지 스킨케어'
    , 'userName' => '이남두'
    , 'ck01' => 'Y'
    , 'ck02' => 'Y'
    , 'ck03' => 'Y'
    , 'mobileNo' => '010-8568-5836'
    , 'email' => 'devper@onefamilymall.com'
    , 'cardNo' => '5365100326350333'
    , 'expiry' => '10 / 22'
    , 'pass' => '11'
    , 'identify' => '761207'
    , 'quota' => '0'
];*/
$param = $_POST;
array_walk($param, function (&$value, &$key) {
    $value = clean_xss_tags($value);
});
$cardNo = preg_replace('/[^\d]+/', '', $param['cardNo']);
$expiry = preg_replace('/[^\d]+/', '', $param['expiry']);

empty($param['ck02']) === true && fn_ajax_output(['responseCode' => 400, 'responseMsg' => '전자 금융거래 이용약관에 동의 해주세요.']);
empty($param['ck03']) === true && fn_ajax_output(['responseCode' => 400, 'responseMsg' => '개인정보 처리방침에 동의 해주세요.']);
empty($cardNo) === true && fn_ajax_output(['responseCode' => 400, 'responseMsg' => '카드번호를 입력해주세요.']);
empty($expiry) === true && fn_ajax_output(['responseCode' => 400, 'responseMsg' => '유효기간을 입력해주세요.']);
empty($param['pass']) === true && fn_ajax_output(['responseCode' => 400, 'responseMsg' => '비밀번호 앞2자리를 입력해주세요.']);
empty($param['identify']) === true && fn_ajax_output(['responseCode' => 400, 'responseMsg' => '생년월일/사업자번호를 입력해주세요.']);

$expireMonth = substr($expiry, 0, 2);
$expireYear = substr($expiry, 2, 2);
$offerType = new \PayUp\Type\OfferCardType([
    'orderNumber' => "{$param['orderNumber']}"
    , 'amount' => "{$param['amount']}"
    , 'itemName' => "{$param['itemName']}"
    , 'userName' => "{$param['userName']}"
    , 'userEmail' => $param['email']
    , 'mobileNumber' => "{$param['mobileNo']}"
    , 'cardNo' => "{$cardNo}"
    , 'expireMonth' => "{$expireMonth}"
    , 'expireYear' => "{$expireYear}"
    , 'cardPw' => "{$param['pass']}"
    , 'birthday' => "{$param['identify']}"
    , 'quota' => "{$param['quota']}"
]);

$response = $PayUp->Payout($offerType);
 /*
  | --------------------------------------------------------------------------
  | 로그 남기기
  | --------------------------------------------------------------------------
  */
$request = $offerType->toArray();
$chunk = str_split($request['cardNo'], 4);
$request['cardNo'] = $chunk[0] . '-' . substr($chunk[1], 2) . '**-****-' . $chunk[3];
$request['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
$request['clientIp'] = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
unset($request['cardPw'], $request['expireYear'], $request['expireMonth'], $request['birthday']);

$data = [
    'ord_id' => fn_sql_quote($request['orderNumber'])
    , 'mb_id' => $member && $member['mb_id'] ? fn_sql_quote($member['mb_id']) : ''
    , 'code' => fn_sql_quote($response['responseCode'])
    , 'request' => fn_sql_quote(json_encode($request, JSON_UNESCAPED_UNICODE))
    , 'response' => fn_sql_quote(json_encode($response, JSON_UNESCAPED_UNICODE))
];

$col = implode(',', array_keys($data));
$val = implode(',', array_values($data));

sql_query("INSERT INTO {$g5['tb_payout']} ({$col}) VALUES({$val})");
set_session('ss_order_payup_id', '');
fn_ajax_output($response);