<?php
/**
 *
 */
include_once __DIR__ . '/_common.php';
include_once __DIR__ . '/../settle_payup.inc.php';

function fnl_alert_close($message = '')
{
    print '<script type="text/javascript">' . PHP_EOL;
    if (empty($message) !== true) {
        print 'var msg=' . json_encode($message) . '; alert(msg);';
    }
    print PHP_EOL . 'closePayout();</script></body></html>';
    die;
}


$param = $_POST;
array_walk($param, function (&$value, &$key) {
    $value = clean_xss_tags($value);
});

/**
 * @type array $bizinfo
 */
$brand = '';
if (file_exists(($brand_file = G5_DATA_PATH . "/common/{$bizinfo['bi_top_mobile_shoplogo']}")) && !is_dir($brand_file)) {
    $brand = str_replace(G5_PATH, G5_URL, $brand_file);
}
else if (file_exists(($brand_file = G5_DATA_PATH . "/common/{$bizinfo['bi_top_shoplogo']}")) && !is_dir($brand_file)) {
    $brand = str_replace(G5_PATH, G5_URL, $brand_file);
}

$ordNo = get_session('ss_order_payup_id');
$amount = (int)preg_replace('#[^0-9]#', '', $_POST['amount']);

$payUpHostName = $PayUp->getHostName();
?>
<!doctype html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="utf-8" />

    <title>페이업 결제</title>
    <meta name="HandheldFriendly" content="true" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="color-scheme" content="light only">
    <meta http-equiv="imagetoolbar" content="no" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <script type="text/javascript" charset="UTF-8" src="<?= G5_JS_URL ?>/jquery-1.12.4.min.js?ver=<?= G5_JS_VER ?>"></script>
    <script type="text/javascript" charset="UTF-8" src="<?= G5_JS_URL ?>/jquery-migrate-1.4.1.min.js?ver=<?= G5_JS_VER ?>"></script>
    <script type="text/javascript" charset="UTF-8" src="<?= EYOOM_THEME_URL; ?>/plugins/sweetalert/sweetalert.min.js?ver=<?= G5_JS_VER ?>"></script>
    <script type="text/javascript" charset="UTF-8" src="<?= G5_SHOP_URL; ?>/payup/assets/payup.js?ver=<?= G5_JS_VER ?>"></script>

    <link rel="stylesheet" href="<?= EYOOM_THEME_URL ?>/plugins/bootstrap/css/bootstrap.min.css?ver=<?= G5_CSS_VER ?>">
    <link rel="stylesheet" href="<?= EYOOM_THEME_URL ?>/plugins/sweetalert/sweetalert.min.css?ver=<?= G5_CSS_VER ?>">
    <link rel="stylesheet" href="<?= G5_SHOP_URL ?>/payup/assets/payup.css?ver=<?= G5_CSS_VER ?>">
    <script type="text/javascript">
        !window.g5_shop_url && (window.g5_shop_url = '<?=G5_SHOP_URL?>');
        !window.payupHostName && (window.payupHostName = '<?=$payUpHostName?>');
        !window.payupAccountName && (window.payupAccountName = '<?=$PayUp->getMerchantId()?>');
        <?php if (G5_ENV != 'development' || !$member['mb_id'] || is_admin($member['mb_id']) != 'super'): ?>
        document.onmousedown = disableClick;
        document.oncontextmenu = new Function('return false');
        $(document).on('keydown', function (event) {
            if (event.keyCode == 123 /* F12 */) {
                event.preventDefault();
                event.returnValue = false;
                fn_alert_focus('Function 키를 사용 할 수 없습니다.');
            }
        });
        <?php endif ?>
    </script>

</head>
<body>
<?php
/*
 |
 |
 |
 */


($amount <= 1) && fnl_alert_close('가격이 올바르지 않습니다.');
($param['orderNumber'] != $ordNo) && fnl_alert_close('주문 정보가 일치하지 않습니다.');
?>

<div class="pay-container">
    <form name="frmPayout" method="POST" action="<?= G5_SHOP_URL ?>/payup/payup_payout.php">
        <input type="hidden" name="orderNumber" value="<?= $param['orderNumber'] ?>" />
        <input type="hidden" name="amount" value="<?= $param['amount'] ?>" />
        <input type="hidden" name="itemName" value="<?= $param['itemName'] ?>" />
        <input type="hidden" name="userName" value="<?= $param['buyerName'] ?>" />

        <div class="payup-brand">
            <a><img src="<?= $payUpHostName ?>/resources/plugin2/mb/img/plogo.png" /></a>
            <aside>
                <button class="btn-dismiss" data-dismiss="modal" type="button">&times;</button>
            </aside>
        </div>
        <h4 class="brand" data-env="<?= G5_ENV ?>">
            <?php if ($brand): ?>
                <img src="<?= $brand ?>" alt="<?= $bizinfo['bi_company_name'] ?>" />
            <?php else: ?>
                <strong><?= $bizinfo['bi_company_name'] ?></strong>
            <?php endif; ?>
        </h4>
        <div class="intro">
            <h2 class="subtitle"><strong><?= $param['buyerName'] ?></strong>님의 카드결제 정보입니다.</h2>
            <section class="summary">
                <dl>
                    <dt>상품명</dt>
                    <dd>
                        <small class="text-ellipsis"><?= $param['itemName'] ?></small>
                    </dd>
                </dl>
                <dl>
                    <dt>결제금액</dt>
                    <dd><span class="pay-amount"><?= number_format($param['amount']) ?></span>원</dd>
                </dl>
            </section>

            <section class="terms p-section" id="terms-container">
                <h3>약관동의</h3>
                <article>
                    <label class="checklist">
                        <input type="checkbox" id="ck01" name="ck01" class="term-check" data-role="control" value="Y" /><i class="checkmark"></i>
                        <strong>전체 약관 동의</strong>
                    </label>
                </article>

                <article>
                    <label class="checklist">
                        <input type="checkbox" id="ck02" name="ck02" class="term-check" value="Y" /><i class="checkmark"></i>
                        전자금융거래 이용약관 동의<sub>(필수)</sub>
                    </label>
                    <div class="buttons">
                        <a href="" class="btn btn-s btn-default btn-popup" aria-haspopup="true" data-label="term">
                            확인하기
                        </a>
                    </div>
                </article>

                <article>
                    <label class="checklist">
                        <input type="checkbox" id="ck03" name="ck03" class="term-check" value="Y" /><i class="checkmark"></i>
                        개인정보 처리방침 동의<sub>(필수)</sub>
                    </label>
                    <div class="buttons">
                        <a href="" class="btn btn-s btn-default btn-popup" aria-haspopup="true" data-label="privacy">
                            확인하기
                        </a>
                    </div>
                </article>
            </section>
            <section class="notify p-section">
                <h3>결제알림</h3>

                <article>
                    <label class="control-label" for="PU_p">휴대폰번호<sub>(선택)</sub></label>
                    <input type="tel" name="mobileNo" id="PU_p" class="form-control" autocomplete="off" maxlength="13" value="<?= $param['buyerMobileNo'] ?>" />
                </article>
                <article>
                    <label class="control-label" for="PU_e">이메일 <sub>(선택)</sub></label>
                    <input type="email" name="email" id="PU_e" class="form-control" autocomplete="off" maxlength="100" value="<?= $param['buyerEmail'] ?>" />
                </article>
            </section>
        </div>

        <div class="credit-card">

            <section class="form-write">
                <h3>카드정보 입력</h3>
                <article>
                    <label class="control-label" for="PU_cardNo">카드번호</label>
                    <input type="tel" name="cardNo" id="PU_cardNo" class="form-control next-focus" maxlength="19" placeholder="____ ____ ____ ____" autocomplete="off" data-labelledby="#PU_expiry" data-focus-size="16" />
                    <div class="help-block" id="card-info-desc"></div>
                </article>

                <dl>
                    <dd>
                        <label class="control-label" for="PU_expiry">유효기간<sub>(MM/YY)</sub></label>
                        <input type="tel" name="expiry" id="PU_expiry" class="form-control next-focus" maxlength="7" placeholder="MM / YY" autocomplete="off" data-labelledby="#PU_pw" data-focus-size="4" />
                    </dd>
                    <dd>
                        <label class="control-label" for="PU_pw">비밀번호<sub>(앞2자리)</sub></label>
                        <input type="password" name="pass" id="PU_pw" class="form-control next-focus" maxlength="2" placeholder="**" autocomplete="off" data-labelledby="#PU_identify" />
                    </dd>
                </dl>

                <dl>
                    <dd>
                        <label class="control-label" for="PU_identify">생년월일/사업자번호</label>
                        <input type="tel" name="identify" id="PU_identify" class="form-control" maxlength="10" placeholder="예) <?= (new DateTime('-24 year'))->format('ym15') ?>" autocomplete="off" />
                    </dd>
                    <dd class="control-help-text">
                        <p class="help-block">* 생년월일 : 6자리</p>
                        <p class="help-block">* 사업자번호 : 10자리</p>
                    </dd>
                </dl>
                <dl>
                    <dd>
                        <label class="control-label" for="PU_quota">할부개월</label>
                        <select name="quota" id="PU_quota" class="form-control">
                            <option value="0">일시불</option>
                            <?php if ($amount >= 50000): ?>
                                <option value="2">2개월</option>
                                <option value="3">3개월</option>
                                <option value="4">4개월</option>
                                <option value="5">5개월</option>
                                <option value="6">6개월</option>
                                <option value="7">7개월</option>
                                <option value="8">8개월</option>
                                <option value="9">9개월</option>
                                <option value="10">11개월</option>
                                <option value="12">12개월</option>
                            <?php endif; ?>
                        </select>

                    </dd>
                    <dd class="control-help-button">
                        <a href="" class="btn btn-s btn-default btn-popup" aria-haspopup="true" data-label="quota">
                            무이자 할부 안내
                        </a>
                        <p class="help-block">*5만원 이상 무이자 가능</p>
                    </dd>
                </dl>
            </section>
        </div>
        <section class="p-foot">
            <button type="submit" class="btn btn-active btn-block">다음</button>
        </section>

        <div id="pay-load" class="pay-loading">
            <div class="pay-load-content"><img src="<?= G5_SHOP_URL ?>/img/pay_loading.gif" /></div>
        </div>

        <div id="pay-complete" class="pay-loading">
            <div class="pay-load-content"><img src="<?= G5_SHOP_URL ?>/img/pay_0000_2.gif" /></div>
        </div>
    </form>
</div>
</body>
</html>


