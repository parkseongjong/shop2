<?php
include_once('./_common.php');
include_once __DIR__.'/../settle_payup.inc.php';

!function_exists('json_encode') && include_once(G5_LIB_PATH . '/json.lib.php');

// 결제대행사 체크
$default['de_pg_service'] != 'payup' && fn_ajax_output(['code' => 400, 'message' => '올바른 방법으로 이용해 주십시오.']);
empty($PayUp->getMerchantId()) === true && fn_ajax_output(['code' => 400, 'message' => 'PG사 정보가 유효하지 않습니다.']);
empty($PayUp->getSecret()) === true && fn_ajax_output(['code' => 401, 'message' => 'PG사 인증키 정보가 유효하지 않습니다.']);

$orderNumber = get_session('ss_order_payup_id');
$amount = (int)preg_replace('#[^0-9]#', '', $_POST['amount']);
($amount <= 1) && fn_ajax_output(['code' => 412, 'message' => '가격이 올바르지 않습니다.']);

$timestamp = $PayUp->getTimestamp(true);
$sign = $PayUp->makeSignature($orderNumber, $amount);
fn_ajax_output(['code' => 200, 'timestamp' => $timestamp, 'sign' => $sign, 'secret' => hash('sha256', $timestamp)]);
