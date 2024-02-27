<?php
/**
 * 결제 승인 완료 요청하기
 */
include_once __DIR__ . '/_common.php';
$token = $_POST['RETURNPARAMS'];
$payUrl = get_session('ss_order_payup_payurl');
set_session('ss_order_payup_payurl', '');

// 사용자 결제 취소
if (empty($token) === true) {
    include_once(G5_PATH . '/head.sub.php');
    ?>
    <script type="text/javascript">
        if (!window.parent || !window.parent.closePayUp) {
            !window.opener && (window.opener = self);
            window.close();
        }
        else {
            window.parent.closePayUp();
        }
    </script>

    <noscript>
        <div id="validation_check">
            <h1>결제 취소</h1>
            <p class="cbg">
                결제 진행을 중단하셨습니다.<br />
                창을 닫으신 후 다시 시도하세요.
            </p>
        </div>
    </noscript>
    <?php
    include_once(G5_PATH . '/tail.sub.php');
    die;
}
/*
Array
(
    [payMethod] => CHECKOUT
    [payUrl] => https://api.testpayup.co.kr/ap/api/payment/20220705004201ST0034/pay
    [starturl] => https://checkout.teledit.com/creditcard_std/web
    [startparams] => GcEZSizCa4OVSXL6G/Ybd1YI2W2zFQa82ULylA8k8LElLekExKZKd7klutnbR249KQ0fx9bYbBLUP+mQN2sP+4aIwypFEK9vggTRMZAhrl6/qAoE3Udl4YqrqoT64NY0TkvjmUu98j1nLrMfUl/TkEE3/puk17Dsnvmxo3If/YvNTqXXzuLwY1GdR2F5DOkNr72QAMcRMX869lZWwLYqOqBiKugVaX0KYGnjKURYyBvy5h2DQftfuje4Tkb9xjmdaxTs2taXY962hYfupbPIycaXOvPUZsEh5iFG+K8b3qj0uKdeiESlDfZ2r8W1ZIA0b4CqkNWPRPo9GwQrdOCxtGG54RPxl8X/1xu4+0FlmSEkebdXbpGYY59DPLo0cMTjXhHoTwz+V+cO/SXP5guU6vD4vrDKB0GnSEKVnBiOiik=
    [transactionId] => 20220705004201ST0034
    [orderNumber] => 2022070500415857
    [amount] => 1000
)

$result=[
    'responseCode' => '0000'
    , 'responseMsg' => '성공'
    , 'amount' => '1000'
    , 'noinf' => 'N'
    , 'orderNumber' => '2022070513253826'
    , 'cardName' => '카카오뱅크체크'
    , 'cardNo' => '123450******0123'
    , 'transactionId' => '20220705132542020311'
    , 'bypassValue' => ''
    , 'quota' => '0'
    , 'authNumber' => '26133103'
    , 'returnUrl' => '/shop/payup/payup_payout.php'
    , 'authDateTime' => '20220705132636'
];
*/
include_once __DIR__ . '/../settle_payup.inc.php';
$result = $PayUp->Authorize($payUrl, $token);
// 결제 오류
###$result['responseCode'] != '0000' && alert_close("[결제오류] {$result['responseMsg']}");
include_once(G5_PATH . '/head.sub.php');
?>
    <script type="text/javascript">
        $(function () {
            var hWnd, data ={};
            data = <?=json_encode($result)?>;
            function fnl_dismiss(parent) {
                if(parent && parent.closePayUp) {
                    parent.closePayUp();
                }
                else {
                    !window.opener && (window.opener = self);
                    self.close();
                }
            }
            function fnl_success(parent) {
                var $form = parent.$('FORM[name="forderform"]');
                parent.$('#display_pay_button').hide();
                parent.$('#display_pay_process').show();

                for (var col in data) {
                    if (!data.hasOwnProperty(col)) continue;
                    $form.find('INPUT[name="' + col + '"]').val(data[col]);
                }
                $form.submit();
                fnl_dismiss(parent);
            }

            window.parent && (hWnd = window.parent);
            !hWnd && window.opener && (hWnd = window.opener);

            if (data.responseCode != '0000') {
                alert('[결제 승인 실패] ' + data.responseMsg);
                fnl_dismiss(hWnd);
            }
            else if (!hWnd) {
                alert('결제가 정상적으로 승인되었으나, 오류로 인하여 주문처리를 할 수 없습니다.\n관리자에게 문의하세요.');
                fnl_dismiss(hWnd);
            }
            else {
                fnl_success(hWnd);
            }

        });
    </script>
<?php
include_once(G5_PATH . '/tail.sub.php');