<?php
require_once __DIR__ . '/_common.php';
require_once __DIR__ . '/../settle_payup.inc.php';

// 결제대행사 체크
$default['de_pg_service'] != 'payup' && fn_ajax_output(['code' => 400, 'message' => '올바른 방법으로 이용해 주십시오.']);
empty($PayUp->getMerchantId()) === true && fn_ajax_output(['code' => 400, 'message' => 'PG사 정보가 유효하지 않습니다.']);
empty($PayUp->getSecret()) === true && fn_ajax_output(['code' => 401, 'message' => 'PG사 인증키 정보가 유효하지 않습니다.']);

$param = $_POST;
array_walk($param, function (&$value, &$key) {
    $value = clean_xss_tags($value);
});

$orderNumber = get_session('ss_order_payup_id');
$amount = (int)preg_replace('#[^0-9]#', '', $_POST['amount']);
($amount <= 1) && fn_ajax_output(['code' => 412, 'message' => '가격이 올바르지 않습니다.']);

switch ($param['payMethod']) {
    // 인앱 결제 요청서 생성(CARD)
    default:
        {
            $response = $PayUp->Checkout($orderNumber, $amount, $param['itemName'], $param['userName'], $param['userEmail'], $param['type']);
            break;
        }
    // 인앱결제 창 요청
    case 'PAYOUT':
        {
            set_session('ss_order_payup_payurl', $param['payUrl']);
            ##include_once(G5_PATH . '/head.sub.php');
            ?>
            <!doctype html>
            <html lang="ko">
            <head>
                <meta charset="utf-8">
                <?php
                if (G5_IS_MOBILE) {
                    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10">' . PHP_EOL;
                    echo '<meta name="HandheldFriendly" content="true">' . PHP_EOL;
                    echo '<meta name="format-detection" content="telephone=no">' . PHP_EOL;
                }
                else {
                    echo '<meta http-equiv="imagetoolbar" content="no">' . PHP_EOL;
                    echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge">' . PHP_EOL;
                }

                if ($config['cf_add_meta']) {
                    echo $config['cf_add_meta'] . PHP_EOL;
                }
                ?>
                <title><?php echo $g5_head_title; ?></title>
            </head>
            <body>
            <form name="form1" method="POST" action="<?= $param['starturl'] ?>">
                <input type="hidden" name="startparams" value="<?= $param['startparams'] ?>" />
                <!-- button>전송</button -->
            </form>
            <script type="text/javascript">document.forms['form1'].submit();</script>
            </body>
            </html>
            <?php
            ##include_once(G5_PATH . '/tail.sub.php');
            die;
            break;
        }
    // 가상계좌
    case 'VBANK':
        {
            if (!$param['cashUseFlag']) {
                unset($param['cashType'], $param['cashNo']);
            }


            $response = $PayUp->VBank(new \PayUp\Type\OfferBankType([
                'orderNumber' => "{$orderNumber}"
                , 'amount' => "{$amount}"
                , 'itemName' => $param['itemName']
                , 'userName' => $param['userName']
                , 'userEmail' => $param['userEmail']
                , 'mobileNumber' => "{$param['mobileNumber']}"
                , 'bankCode' => "{$param['bankCode']}"
                , 'depositName' => $param['depositor']
                , 'cashType' => "{$param['cashType']}"
                , 'cashNo' => "{$param['cashNo']}"
            ]));
            break;
        }

}
fn_ajax_output($response);
/*

curl -X POST \
-H "Content-Type: application/json; charset=utf-8" \
-d '{"signature":"d75a7854c42348db1e0be7dc346a69bc50515a5ec335371bd0bc26e249001a8c", "orderNumber":"ORDER01100000", "amount":"1004", "itemName":"테스트상품", "userName":"테스터", "depositName":"입금자", "bankCode":"BK04", "expireDate":"20200305235959", "cashUseFlag":"0", "timestamp":"20200101265656"}' \
https://api.testpayup.co.kr/ap/api/payment/free/order

*/