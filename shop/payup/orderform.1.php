<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
// 전자결제를 사용할 때만 실행
if (!($default['de_vbank_use'] || $default['de_card_use'])) return;

isset($PayUp) !== true && include_once __DIR__ . '/../settle_payup.inc.php'; ?>
    <style type="text/css">
        .checkout-backdrop, .payup-backdrop {position: fixed;background-color: rgba(0, 0, 0, .4275);left: 0; top: 0; width: 100vw; height: 100vh;z-index: 100;}
        .payup-card {position: absolute;left: calc(50% - 180px);top: 20%;z-index: 101;background-color: #fff; width: 480px; padding: 15px; border: 1px solid #a8a8a8; box-shadow: 0 0 5px rgba(0, 0, 0, .4)}
        .payup-card article {display: flex; margin-bottom: 15px; line-height: 1.5; flex-wrap: wrap}
        .payup-card label {font-weight: normal}
        .payup-card hr {margin: 0 0 15px 0;border-top: 1px solid #888;}
        .payup-card article > label {display: block;height: 34px; padding: 6px 12px; font-size: 14px; line-height: 1.42857143; color: #555;}
        .payup-card article > label:first-child:not(.required-control) { min-width: 100px; width: 33.33333%;}
        .payup-card article > label.required-control {margin: 0 12px;padding: 0;}
        .payup-card article .required-control {position: relative;}
        .payup-card article .required-control::after {content: '';position: absolute;top: 0;right: 0;border-top: 8px solid #FF4848;border-left: 8px solid transparent;width: 0;height: 0;z-index: 1;}
        .payup-card-head {display: flex;margin-bottom: 10px;border-bottom: 1px solid #888;padding-bottom: 10px;}
        .payup-card-head .payup-btn-dismiss {border: 1px solid #888;padding: .175rem;margin: 0;opacity: .475;outline: 0; background-color: transparent;font-size: 1rem;border-radius: 50% !important;transition: opacity .3s;}
        .payup-card-head .payup-btn-dismiss:hover {opacity: 1}
        .payup-card-head .payup-btn-dismiss:after {content: "\0274c";display: inline-block}
        .flex-grow-1, .payup-card-title {flex-grow: 1}
        .payup-card-title {margin: 0;}
        .payup-card article INPUT[type="radio"] { vertical-align: middle; margin: 0 .25rem;}
        .payup-card article INPUT[type="checkbox"] { vertical-align: middle; margin: 0;}
        .form-control.help-place::placeholder, .form-control.help-place::-webkit-input-placeholder {font-weight: normal; color: #0f70be;font-size: 1rem}
        .payup-card-foot {padding: 0 15px; text-align: right}
        .payup-card label.disabled {color: #999;}
        .payup-frame {position: absolute; z-index: 101;width: <?=$default['de_payup_way'] == 'api' ? 460: 680?>px; height: <?=$default['de_payup_way'] == 'api' ? 680: 490?>px;left: calc(50% - <?=$default['de_payup_way'] == 'api' ? 230: 340?>px); background-color: #fff;box-shadow: 0 0 10px rgba(0, 0, 0, .375)}
        .payup-popup {display: none;position: absolute; z-index: 201;width: 450px; height: 740px; left: calc(50% - 225px);}
        .payup-popup[data-size="fluid"] {width: 600px; height: 740px; left: calc(50% - 300px);}
        .payup-popup DL, .payup-popup DT, .payup-popup DD {margin: 0;padding: 0}
        .payup-popup DL {display: flex; flex-direction: column;height: 100%;width: 100%;background-color: #7a7a7a;color: #f2f2f2}
        .payup-popup DT {text-align: right;padding: .25rem .75rem;border-bottom: #555 1px solid;}
        .payup-popup DD {flex-grow: 1;}
        .popup-close {background-color: transparent; border: 0;outline: 0; font-size: 1.325rem;font-weight: normal}
        .allow-checkout {display: none;}
        .allow-checkout * {box-sizing: content-box;}
        .allow-checkout .checkout-wait {position: fixed;left: calc(50% - 320px);top: 15%;width: 640px;background: #fff;z-index: 201;padding: 3.25rem .75rem;box-shadow: 0 0 10px rgba(0, 0, 0, .375);text-align: left;}
        .allow-checkout .checkout-wait IMG {margin-right: 3.75rem;display: inline-block}
        .allow-checkout .checkout-wait H4 {display: inline-block;margin: 0;}
        @media (max-width: 500px) {
            .payup-card {left: 0;width: 100vw;}
            .payup-card article > label.sm-block {min-width: 100vw; width: 100vw !important; }
        }
        @media (max-width: 767px) {
            .payup-frame {position: fixed; width: 100vw; height: 100vh;left: 0; top: 0;box-shadow: none;}
            .payup-popup, .payup-popup[data-size="fluid"] {position: fixed; width: 100vw; height: 100vh;left: 0; top: 0;box-shadow: none;}
            .allow-checkout .checkout-wait {left: 0; width: 100vw;box-shadow: none;background-color: transparent;padding: 0;}
            .allow-checkout .checkout-wait article {display: block;background-color: #fff;padding: 3.75rem 1.25rem;margin: 0 1.25rem;box-shadow: 0 0 5px rgba(0, 0, 0, .41375);}
            .allow-checkout .checkout-wait IMG {margin-right: 1.75rem;vertical-align: top;}
            .allow-checkout .checkout-wait H4 {line-height: 1.5}
        }
    </style>

<?php
/*
 | --------------------------------------------------------------------
 | 가상계좌인 경우 예금주, 입금은행, 현금영수증 신청 폼
 | --------------------------------------------------------------------
 */
if ($default['de_vbank_use']) : ?>
    <section id="payup-vbank-container" class="hide">
        <div class="payup-backdrop"></div>
        <form name="frmPayUpVbank">
            <input type="hidden" name="orderNumber" value="<?= $od_id ?>" />
            <input type="hidden" name="amount" />
            <input type="hidden" name="itemName" />
            <input type="hidden" name="mobileNumber" />
            <input type="hidden" name="userEmail" />
            <input type="hidden" name="userName" value="<?php echo get_text($member['mb_name']); ?>" />

            <input type="hidden" name="payMethod" value="VBANK" />


            <div class="payup-card">
                <div class="payup-card-head">
                    <h4 class="payup-card-title">가상계좌 입금</h4>
                    <div>
                        <button type="button" class="payup-btn-dismiss" data-dismiss="modal">
                            <strong class="sound_only">닫기</strong>
                        </button>
                    </div>
                </div>

                <article>
                    <label for="vbank-sender">입금자명<strong class="sound_only">필수</strong></label>
                    <div class="required-control flex-grow-1">
                        <input type="text" name="depositor" id="vbank-sender" class="form-control" maxlength="20" placeholder="입금자명" value="<?php echo get_text($member['mb_name']); ?>" required />
                    </div>
                </article>
                <article>
                    <label for="vbank-bank-name">입금은행<strong class="sound_only">필수</strong></label>
                    <div class="required-control flex-grow-1">
                        <select name="bankCode" id="vbank-bank-name" class="form-control" required>
                            <option value="">선택
                            </option><?php foreach ($PayUpBankList as $bank_code => $bank_name) print "<option value=\"{$bank_code}\">{$bank_name}</option>"; ?>
                        </select></div>
                </article>
                <hr />
                <article class="margin-bottom-0">
                    <label class="sm-block"><input type="checkbox" name="cashUseFlag" value="1" /> 현금영수증 발행</label>
                    <label class="disabled"><input type="radio" name="cashType" value="0" disabled checked />
                        소득공제</label>
                    <label class="disabled"><input type="radio" name="cashType" value="1" disabled /> 지출증빙(사업자) </label>
                </article>

                <article>
                    <label class="required-control flex-grow-1">
                        <input type="text" name="cashNo" class="form-control help-place" maxlength="20" placeholder="현금영수증 식별번호(휴대폰, 사업자번호, 주민번호)" value="" disabled />
                    </label>
                </article>
                <hr />
                <div class="payup-card-foot">
                    <button type="submit" class="btn btn-primary">주문하기</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </form>
    </section>
    <script type="text/javascript">
        function doVirtualBankAccount(source) {
            var $dialog = $('#payup-vbank-container'), form = $('form[name="frmPayUpVbank"]');

            $('HTML').css('overflow-y', 'hidden');
            $dialog.removeClass('hide').find('.payup-card').css('top', $(window).scrollTop() + 100).hide(0).slideDown(200);

            form.find('INPUT[name="amount"]').val($(source).find('INPUT[name="good_mny"]').val());
            form.find('INPUT[name="itemName"]').val($(source).find('INPUT[name="od_goods_name"]').val() || '<?php echo $goods; ?>');
            form.find('INPUT[name="userEmail"]').val($(source).find('INPUT[name="od_email"]').val());
            form.find('INPUT[name="mobileNumber"]').val($(source).find('INPUT[name="od_hp"]').val());
        }

        $(function () {
            var $dialog = $('#payup-vbank-container'), form = $('form[name="frmPayUpVbank"]');
            /* 가상계좌 정보 입력창 닫기 */
            $('[data-dismiss="modal"]').on('click', function () {
                $('HTML').css('overflow-y', 'scroll');
                !$dialog.hasClass('hide') && $dialog.addClass('hide');
                form.get(0).reset();
            });

            form.submit(function (event) {
                event.preventDefault();
                if (!form.find('INPUT[name="userName"]').val()) {
                    alert('입금자명을 입력하세요.');
                    return false;
                }
                else if (!form.find('SELECT[name="bankCode"]').val()) {
                    alert('입금은행을 선택하세요');
                    return false;
                }
                else if (form.find('INPUT[name="cashUseFlag"]').is(':checked') && !form.find('INPUT[name="cashNo"]').val()) {
                    alert('현금영수증 식별번호를 입력하세요.')
                    return false;
                }

                var result = {'responseCode': 500, 'responseMsg': 'Internal Server Error\n'};
                var $form = $('FORM[name="forderform"]'), col;
                $.ajax({
                    'type': "POST",
                    'data': form.serialize(),
                    'url': g5_url + "/shop/payup/payup_checkout.php",
                    'cache': false,
                    'async': false,
                    'success': function (response) {
                        result = response;
                    }
                });

                if (result.responseCode != '0000') {
                    return alert(result.responseMsg);
                }

                for (col in result) {
                    if (!result.hasOwnProperty(col)) continue;
                    $form.find('INPUT[name="' + col + '"]').val(result[col]);
                }

                document.getElementById("display_pay_button").style.display = "none";
                document.getElementById("display_pay_process").style.display = "";
                $form.submit();
            });

            /* 현금영수증 발급 처리 */
            $('INPUT[name="cashUseFlag"]').on('change', function () {
                if (this.checked) {
                    $('INPUT[name="cashNo"], INPUT[name="cashType"]').removeAttr('disabled').parent().removeClass('disabled');
                    $('INPUT[name="cashNo"]').attr('required', true);
                }
                else {
                    $('INPUT[name="cashNo"], INPUT[name="cashType"]').attr('disabled', true).parent().addClass('disabled');
                    $('INPUT[name="cashNo"]').removeAttr('required');
                }
            })
        });
    </script>
<?php endif;
/*
  | --------------------------------------------------------------------
  | 플러그인 방식 카드 결제일떄
  | --------------------------------------------------------------------
  */
if ($default['de_payup_way'] == 'manual') :
    add_javascript('<script language="javascript" type="text/javascript" src="' . $PayUp->getPlugInJavascript() . '" charset="UTF-8"></script>', 10);
    ?>
    <script type="text/javascript">
        /**
         *
         * @param form
         * @param [payMethod]
         * @return {*}
         */
        function checkoutPayup(form, payMethod) {
            if (payMethod == '가상계좌') {
                window.doVirtualBankAccount && doVirtualBankAccount(form);
                return;
            }

            var result = {'code': 500, 'message': 'Internal Server Error\n'},
                param = {
                    'merchantId': '<?=$PayUp->getMerchantId()?>'
                    , 'orderNumber': '<?=$od_id?>'
                    , 'amount': form.good_mny.value
                    , 'itemName': form.od_goods_name ? form.od_goods_name.value : '<?php echo $goods; ?>'
                    , 'userName': form.od_name ? form.od_name.value : form.pp_name.value
                    , 'timestamp': null
                    , 'signature': null
                    , 'type': '<?=$is_mobile_order ? 'mb' : 'pc'?>'
                    , 'logo': null
                    , 'logoWidth': null
                    , 'slogan': null
                    , 'userTel': (form.od_hp || {'value': null}).value
                    , 'userEmail': (form.od_email || {'value': null}).value
                    , 'language': null
                    , 'color': null
                    , 'kakaoSend': null
                };

            $.ajax({
                'type': "POST",
                'data': {'amount': param.amount},
                'url': g5_url + "/shop/payup/make_signature.php",
                'cache': false,
                'async': false,
                'success': function (response) {
                    result = response;
                }
            });

            if (result.code != 200) {
                return alert(result.message);
            }

            param.timestamp = result.timestamp;
            param.signature = result.sign;

            Payup.setParam(param);
            Payup.payCall();
        }

        function f_paySuccess(data) {
            var $form = $('FORM[name="forderform"]'), col;
            if (data.responseCode != '0000') {
                alert('[결제오류]' + data.responseMsg);
                return;
            }

            document.getElementById("display_pay_button").style.display = "none";
            document.getElementById("display_pay_process").style.display = "";

            for (col in data) {
                if (!data.hasOwnProperty(col)) continue;
                $form.find('INPUT[name="' + col + '"]').val(data[col]);
            }
            $form.submit();
        }


    </script>
<?php
/*
  | --------------------------------------------------------------------
  | 인앱 또는 API 방식 카드 결제 일떄
  | --------------------------------------------------------------------
  */
else:
    ?>
    <div id="payup-payout-contaner" class="hide">
        <div class="payup-backdrop"></div>
        <div class="payup-frame">
            <iframe name="fraPayUp" frameborder="0" allowtransparency="true" width="100%" height="100%" scrolling="yes"></iframe>
        </div>
        <?php if (G5_IS_MOBILE): ?>
            <div class="payup-popup" data-role="popup">
                <dl>
                    <dt>
                        <button class="popup-close">&times; 닫기</button>
                    </dt>
                    <dd>
                        <iframe name="fraPayPopUp" frameborder="0" allowtransparency="true" width="100%" height="100%" scrolling="yes"></iframe>
                    </dd>
                </dl>
            </div>
        <?php endif ?>
    </div>

    <form name="frmPayUp" method="POST" action="<?= G5_SHOP_URL . ($default['de_payup_way'] == 'api' ? '/payup/payup_capture.php' : '/payup/payup_checkout.php') ?>" target="fraPayUp">
        <input type="hidden" name="payMethod" value="PAYOUT" class="container-fluid" />
        <input type="hidden" name="payUrl" value="" />
        <input type="hidden" name="starturl" value="" />
        <input type="hidden" name="startparams" value="" />
        <input type="hidden" name="transactionId" value="" />
        <input type="hidden" name="orderNumber" value="" />
        <input type="hidden" name="amount" value="" />
        <input type="hidden" name="itemName" value="" />
        <input type="hidden" name="buyerName" value="" />
        <input type="hidden" name="buyerEmail" value="" />
        <input type="hidden" name="buyerMobileNo" value="" />
    </form>

    <script type="text/javascript">
        function popupModal(href, fluid) {
            <?php if(G5_IS_MOBILE):?>
            var container, $frm;
            container = $('#payup-payout-contaner').find('DIV.payup-popup').attr('data-size', fluid ? 'fluid' : '');
            $frm = $('<form />').attr({'action': href, 'target': 'fraPayPopUp'}).appendTo(container);

            container.find('.popup-close').off('click').one('click', function () {
                container.hide();
            });

            $frm.submit();
            container.show(10, function () {
                $frm.remove();
            });
            <?php else:?>
            window.open(href, '', 'width=' + (fluid ? 600 : 450) + ',height=700,toolbar=no,menubar=no');
            <?php endif?>
        }

        function closePayUp() {
            var $dialog = $('#payup-payout-contaner');
            $('HTML').css('overflow-y', 'scroll');
            !$dialog.hasClass('hide') && $dialog.addClass('hide');
        }

        function completePayUp(data) {
            var $form = $('FORM[name="forderform"]'), col;
            try {
                if (data.responseCode != '0000') {
                    alert('[결제오류]' + data.responseMsg);
                    return;
                }

                $("#display_pay_button").show();
                $("#display_pay_process").hide();

                for (col in data) {
                    if (!data.hasOwnProperty(col)) continue;
                    $form.find('INPUT[name="' + col + '"]').val(data[col]);
                }
                $form.submit();
            }
            catch (e) {
                alert('JS 프로그램 오류가 발생하였습니다. 관리자에게 문의하세요.');
            }
        }

        /**
         *
         * @param form
         * @param [payMethod]
         * @return {*}
         */
        function checkoutPayup(form, payMethod) {
            if (payMethod == '가상계좌') {
                window.doVirtualBankAccount && doVirtualBankAccount(form);
                return;
            }

            var result = {'responseCode': 500, 'responseMsg': 'Internal Server Error\n'};
            var $payup = $('form[name="frmPayUp"]'), $dialog = $('#payup-payout-contaner');

            $payup.find('INPUT[name="itemName"]').val(form.od_goods_name ? form.od_goods_name.value : '<?php echo $goods; ?>');
            $payup.find('INPUT[name="buyerName"]').val(form.od_name ? form.od_name.value : form.pp_name.value);
            $payup.find('INPUT[name="buyerEmail"]').val((form.od_email || {'value': null}).value);
            $payup.find('INPUT[name="buyerMobileNo"]').val((form.od_hp || {'value': null}).value);

            <?php if($default['de_payup_way'] == 'api'):?>
            $payup.find('INPUT[name="orderNumber"]').val('<?=$od_id?>');
            $payup.find('INPUT[name="amount"]').val(form.good_mny.value);
            <?php else:?>
            $.ajax({
                'type': "POST",
                'data': {
                    'amount': form.good_mny.value
                    , 'payMethod': 'CARD'
                    , 'itemName': $payup.find('INPUT[name="itemName"]').val()
                    , 'userName': $payup.find('INPUT[name="buyerName"]').val()
                    , 'type': '<?=$is_mobile_order ? 'WM' : 'WP'?>'
                    , 'userTel': $payup.find('INPUT[name="buyerMobileNo"]').val()
                    , 'userEmail': $payup.find('INPUT[name="buyerEmail"]').val()
                },
                'url': g5_url + "/shop/payup/payup_checkout.php",
                'cache': false,
                'async': false,
                'success': function (response) {
                    result = response;
                }
            });

            if (result.responseCode != '0000') {
                return alert('[결제오류]' + result.responseMsg);
            }
            else if (!result.hasOwnProperty('payUrl') || !result.hasOwnProperty('starturl')) {
                return alert('[결제오류] PG사 응답 전문 오류!');
            }


            $payup.find('INPUT[name="payUrl"]').val(result.payUrl);
            $payup.find('INPUT[name="starturl"]').val(result.starturl);
            $payup.find('INPUT[name="startparams"]').val(result.startparams);
            $payup.find('INPUT[name="transactionId"]').val(result.transactionId);
            $payup.find('INPUT[name="orderNumber"]').val(result.orderNumber);
            $payup.find('INPUT[name="amount"]').val(result.amount);

            <?php endif;?>
            $payup.submit();

            <?php if (!G5_IS_MOBILE) {?>
            $('HTML').css('overflow-y', 'hidden');
            $dialog.removeClass('hide').find('.payup-frame').css('top', $(window).scrollTop() + 80).hide(0).slideDown(200);
            <?php } else {?>
            $dialog.removeClass('hide').find('.payup-frame').show();
            <?php }?>


        }
    </script>


<?php endif;
