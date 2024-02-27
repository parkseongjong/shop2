<?php
include_once('./_common.php');
include_once(G5_SHOP_PATH . '/settle_payup.inc.php');

$transaction_id = clean_xss_tags($_POST['transactionId']);
$cancel_reason = clean_xss_tags($_POST['reason']);
if (empty($transaction_id) !== true) {
    $response = $PayUp->Cancel($transaction_id);
    /*
      "cancelDateTime": "20180205152745", "transactionId": "20180205152504ST0009", "responseCode": "0000", "responseMsg": "성공" }
     */
    if ($response['responseCode'] == '0000') {
        function_exists('add_order_post_log') && add_order_post_log('PayUp 결제 취소', "Success: {$response['cancelDateTime']}");
    }
    else {
        function_exists('add_order_post_log') && add_order_post_log('PayUp 결제 취소', "Failure: {$response['responseMsg']}");
    }

}