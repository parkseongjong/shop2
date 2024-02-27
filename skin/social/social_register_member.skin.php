<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!$config['cf_social_login_use']) {     //소셜 로그인을 사용하지 않으면
    return;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . G5_JS_URL . '/remodal/remodal.css">', 11);
add_stylesheet('<link rel="stylesheet" href="' . G5_JS_URL . '/remodal/remodal-default-theme.css">', 12);
add_stylesheet('<link rel="stylesheet" href="' . str_replace(G5_PATH, G5_URL, G5_SOCIAL_SKIN_BASE_PATH) . '/style.css?ver=' . G5_CSS_VER . '">', 13);

add_javascript('<script src="' . G5_JS_URL . '/remodal/remodal.js"></script>', 10);
($config['cf_cert_use'] && $config['cf_cert_hp']) && add_javascript('<script type="text/javascript" src="' . G5_URL . '/js/certify.js?ver=' . G5_JS_VER . '" charset="UTF-8"></script>');
add_javascript('<script type="text/javascript" src="' . G5_URL . '/js/member-form.js?ver=' . G5_JS_VER . '" charset="UTF-8"></script>');
/**
 * @type string $urlencode
 * @type string $user_email
 */
$email_msg = $is_exists_email ? '등록할 이메일이 중복되었습니다.다른 이메일을 입력해 주세요.' : '';
$mb_nick_name = isset($user_nick) ? get_text($user_nick) : '';
$CertifyProvider = [
    'kcb' => G5_OKNAME_URL . '/hpcert1.php',
    'kcp' => G5_KCPCERT_URL . '/kcpcert_form.php',
    'lg' => G5_LGXPAY_URL . '/AuthOnlyReq.php',
];
?>
<!-- 회원정보 입력/수정 시작 { -->
<div class="mbskin" id="register_member">

    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>

    <!-- 새로가입 시작 -->
    <form id="fregisterform" name="fregisterform" class="form-cert-hp" action="<?php echo $register_action_url; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" value="<?= $w; ?>" />
        <input type="hidden" name="url" value="<?= $urlencode; ?>" />

        <input type="hidden" name="provider" value="<?= $provider_name; ?>" />
        <input type="hidden" name="action" value="register" />

        <input type="hidden" name="mb_id" id="reg_mb_id" value="<?= $user_id; ?>" />
        <input type="hidden" name="mb_nick_default" value="<?= $mb_nick_name ?>" />
        <input type="hidden" name="mb_nick" value="<?= $mb_nick_name ?>" />

        <input type="hidden" name="mb_2" value="<?= strtolower($provider) ?>" />


        <input type="hidden" name="cert_type" value="" />
        <input type="hidden" name="mb_name" value="<?= $user_name ?? $mb_nick_name ?>" />
        <input type="hidden" name="mb_hp" value="" />
        <input type="hidden" name="cert_no" value="" />

        <section class="sns-member-form">
            <ul class="terms-group custom-checkbox">
                <li>
                    <label class="checklist">
                        <input type="checkbox" name="agree_all" class="terms-check" data-role="control" value="1" /><i class="checkmark"></i>
                        <strong>전체 약관 동의</strong>
                    </label>
                </li>
                <li>
                    <div class="terms-item">
                        <label class="checklist">
                            <input type="checkbox" name="agree" class="terms-check" value="1" /><i class="checkmark"></i>
                            회원가입약관<sub>(필수)</sub>
                        </label>
                        <span class="buttons"><button type="button" class="btn btn-e-indigo toggle-terms">확인하기</button></span>
                    </div>

                    <div class="terms-content sbc">
                        <p><?php echo conv_content($config['cf_stipulation'], 0); ?></p>
                    </div>
                </li>
                <li>
                    <div class="terms-item">
                        <label class="checklist">
                            <input type="checkbox" name="agree1" class="terms-check" value="1" /><i class="checkmark"></i>
                            개인정보처리방침안내<sub>(필수)</sub>
                        </label>
                        <span class="buttons"><button type="button" class="btn btn-e-indigo toggle-terms">확인하기</button></span>
                    </div>
                    <div class="terms-content sbc" id="terms-privacy">
                        <p><?php echo conv_content($config['cf_privacy'], 0); ?></p>
                    </div>
                </li>

            </ul>
        </section>

        <section class="sns-member-form">
            <h4 class="subtitle">개인정보 입력</h4>

            <?php
            /*
             |
             | 휴대폰 본인 인증
             */
            if ($config['cf_cert_use'] && $config['cf_cert_hp']) : ?>
                <div class="form-item-group">
                    <span class="control-label">휴대폰 번호<sub>(필수)</sub></span>
                    <span class="append"><button type="button" class="btn btn-e-red toggle-trigger" data-toggle="confirmMobile"><i class="fas fa-mobile-alt"></i> 휴대폰 본인 확인</button></span>
                    <span class="add-on-text" id="mobile-check-message"></span>
                </div>
            <?php endif ?>
            <label class="form-item-group">
                <span class="control-label">이메일<sub>(필수)</sub></span>
                <input type="email" id="reg_mb_email" name="mb_email" class="form-control" data-require="true" placeholder="이메일 주소를 입력해주세요" value="<?= $user_email ?>" style="max-width: 480px" />
                <i></i>
            </label>
            <?php
            /*
             |
             | 추천인 제도
             */
            if ($config['cf_use_recommend']):?>
                <label class="form-item-group">
                    <input type="hidden" id="recommendee" name="recommendee" value="" />
                    <span class="control-label">추천인</span>
                    <input type="tel" id="reg_mb_recommend" name="mb_recommend" class="form-control inline" data-labelledby="phone" placeholder="휴대폰 번호 8자리를 입력하세요." value="" size="18" maxlength="8" />
                    <span class="append"><button type="button" class="btn btn-e-dark toggle-trigger" data-toggle="findRecommend"><i class="fas fa-search"></i> 조회</button></span>
                </label>
                <div class="form-helper">
                    <div class="alert alert-warning">
                        <strong>Note:</strong> 통신망 번호(010)을 제외한 추천인의 휴대폰 번호 8자리를 입력하세요.
                    </div>
                </div>
            <?php endif ?>
        </section>

        <div class="btn_confirm">
            <button type="submit" class="btn_submit" accesskey="s">회원가입</button>
            <a href="<?php echo G5_URL ?>" class="btn_default_trigger">홈으로</a>
        </div>
    </form>
    <!-- 새로가입 끝 -->

    <!-- 기존 계정 연결 -->

    <div class="member_connect">
        <p class="strong">혹시 기존 회원이신가요?</p>
        <button type="button" class="connect-opener btn-txt" data-remodal-target="modal">
            기존 계정에 연결하기
            <i class="fa fa-angle-double-right"></i>
        </button>
    </div>

    <div id="sns-link-pnl" class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
        <button type="button" class="connect-close" data-remodal-action="close">
            <i class="fa fa-close"></i>
            <span class="txt">닫기</span>
        </button>
        <div class="connect-fg">
            <form method="post" action="<?php echo $login_action_url ?>" onsubmit="return social_obj.flogin_submit(this);">
                <input type="hidden" id="url" name="url" value="<?php echo $login_url ?>">
                <input type="hidden" id="provider" name="provider" value="<?php echo $provider_name ?>">
                <input type="hidden" id="action" name="action" value="social_account_linking">

                <div class="connect-title">기존 계정에 연결하기</div>

                <div class="connect-desc">
                    기존 아이디에 SNS 아이디를 연결합니다.<br>
                    이 후 SNS 아이디로 로그인 하시면 기존 아이디로 로그인 할 수 있습니다.
                </div>

                <div id="login_fs">
                    <label for="login_id" class="login_id">아이디<strong class="sound_only"> 필수</strong></label>
                    <span class="lg_id"><input type="text" name="mb_id" id="login_id" class="frm_input required" size="20" maxLength="20"></span>
                    <label for="login_pw" class="login_pw">비밀번호<strong class="sound_only"> 필수</strong></label>
                    <span class="lg_pw"><input type="password" name="mb_password" id="login_pw" class="frm_input required" size="20" maxLength="20"></span>
                    <br>
                    <input type="submit" value="연결하기" class="login_submit btn_submit">
                </div>

            </form>
        </div>
    </div>


    <script type="text/javascript">
        $(function () {
            var $form = $('FORM[name="fregisterform"]');

            $form.data('feed', function () {
                var toggle = $form.find('button.toggle-trigger[data-toggle="confirmMobile"]');
                toggle.removeClass('btn-e-red').addClass('btn-success').attr('disabled', true);
                toggle.find('I.fa-mobile-alt').removeClass('fa-mobile-alt').addClass('fa-check-circle');
            });

            function checkAgree() {
                if (!$form.find('INPUT[name="agree"]').is(':checked')) {
                    alert('회원가입약관에 동의하지 않으셨습니다.');
                    return false;
                }
                else if (!$form.find('INPUT[name="agree1"]').is(':checked')) {
                    alert('개인정보처리방침안내에 동의하지 않으셨습니다.');
                    return false;
                }
                return true;
            }


            window.confirmMobile = function () {
                //if (!checkAgree()) return false;
                var endpoint = '<?=$CertifyProvider[$config['cf_cert_hp']]?>';
                endpoint ? certify_win_open('<?=$config['cf_cert_hp']?>-hp', endpoint) : alert('휴대폰 본인확인 설정이 필요합니다.\n관리자에게 문의하세요.')
            };

            window.findRecommend = function (src) {
                var msg, input = $('#reg_mb_recommend'), result = $('#recommendee');
                result.val('');
                if (msg = reg_mb_recommend_check()) {
                    input.focus();
                    alert(msg);
                    return;
                }
                alert("등록되어 있는 추천인입니다.");
                result.val('phone');
                input.css('background', '#f5f5f5').attr('readOnly', true);
                $(src).off('click');
            };


            $form.on('submit', function (event) {
                event.preventDefault();
                var err;
                if (!checkAgree()) {
                    return false;
                }
                else if (!$form.find('INPUT[name="agree"]').is(':checked')) {
                    alert('회원가입약관에 동의하지 않으셨습니다.');
                    return false;
                }
                else if (!$form.find('INPUT[name="agree1"]').is(':checked')) {
                    alert('개인정보처리방침안내에 동의하지 않으셨습니다.');
                    return false;
                }
                <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) : ?>
                else if (!$form.find('INPUT[name="mb_hp"]').val()) {
                    alert('휴대폰 본인 확인 후 회원 가입을 하실 수 있습니다.');
                    return false;
                }
                <?php endif;?>
                else if(!$form.find('INPUT[name="mb_email"]').val()) {
                    alert('이메일 주소를 입력하세요.');
                    $form.find('INPUT[name="mb_email"]').focus();
                    return false;
                }
                else if ((err = reg_mb_email_check())) {
                    alert(err);
                    $form.find('INPUT[name="mb_email"]').focus();
                    return false;
                }
                $form.find('INPUT[name="mb_email"]').css('background', '#f5f5f5').attr('readOnly', true);
                <?php if($config['cf_use_recommend']):?>
                if ($form.find('INPUT[name="mb_recommend"]').val() && !$form.find('INPUT[name="recommendee"]').val()) {
                    alert('추천인 등록여부를 확인하셔야 합니다.');
                    return false;
                }
                <?php endif;?>
                $form.get(0).submit();
            });

            $form.find('button.toggle-trigger').on('click', function (event) {
                event.preventDefault();
                var method = $(this).attr('data-toggle');
                window[method] && window[method](this);
            });


        });


    </script>

</div>
<!-- } 회원정보 입력/수정 끝 -->