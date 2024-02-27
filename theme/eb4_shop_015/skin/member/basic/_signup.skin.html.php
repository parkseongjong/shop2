<?php
/**
 * skin file : /theme/THEME_NAME/skin/member/basic/register.skin.html.php
 */
if (!defined('_EYOOM_')) exit;
add_stylesheet('<link rel="stylesheet" href="' . EYOOM_THEME_URL . '/plugins/sweetalert/sweetalert.min.css" type="text/css" media="screen">', 0);

add_javascript('<script type="text/javascript" src="' . EYOOM_THEME_URL . '/js/zxcvbn.js" charset="UTF-8"></script>');
add_javascript('<script type="text/javascript" src="' . EYOOM_THEME_URL . '/plugins/sweetalert/sweetalert.min.js" charset="UTF-8"></script>');

$config['cf_cert_use'] && add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/certify.js" charset="UTF-8"></script>');
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/member-sign-up.js?ver=' . G5_JS_VER . '" charset="UTF-8"></script>');

?>
<script type="text/javascript">
    <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) : ?>
    window.confirmMobile = function () {
        var endpoint = '<?=$CertifyProvider[$config['cf_cert_hp']]?>';
        endpoint ? certify_win_open('<?=$config['cf_cert_hp']?>-hp', endpoint) : alert('휴대폰 본인확인 설정이 필요합니다.\n관리자에게 문의하세요.')
    };
    <?php endif;?>
</script>

<style type="text/css">
    html, body, .wrapper {min-height: 100vh;}
    .wrapper-inner {display: flex;flex-flow: column nowrap;min-height: 100vh;overflow-y: auto;}
    .basic-body.sub-basic-body {flex-grow: 1;display: flex;flex-flow: nowrap column; }
    .f-container.basic-page-content {flex-grow: 1;display: flex;flex-flow: nowrap column;}
    .f-container.basic-page-content .f-row {flex-grow: 1;display: flex;flex-flow: nowrap column;}
    .f-container.basic-page-content .f-row .basic-body-main {flex-grow: 1;display: flex;flex-flow: nowrap column;}
</style>

<div class="form-container">
    <form name="frmSignUp" action="<?= $register_action_url; ?>" method="post" enctype="multipart/form-data" autocomplete="off" class="form-cert-hp">
        <input type="hidden" name="w" value="" />
        <input type="hidden" name="url" value="<?= $urlencode; ?>">
        <input type="hidden" name="cert_type" value="" />
        <input type="hidden" name="cert_no" value="" />
        <input type="hidden" name="mb_name" value="" />
        <input type="hidden" name="mb_hp" value="" />

        <input type="hidden" name="mb_nick" value="" />

        <div class="form-content">
            <section class="form-section">
                <?php /* 소셜로그인 사용시 소셜로그인 버튼*/
                empty($config['cf_social_servicelist']) !== true && @include_once(get_social_skin_path() . '/social_register.skin.php'); ?>
                <article>
                    <label class="control-label" for="reg_mb_id">아이디</label>
                    <div class="control-group md-w-sz">
                        <input type="text" name="mb_id" id="reg_mb_id" class="control-input" placeholder="3자 이상 영문, 숫자, _ 조합" minlength="3" maxlength="20" autocomplete="username"  />
                        <span class="control-group-button">
                            <button type="button" class="btn btn-default form-is-exists" data-own="mb_id" data-role="retry"><i class="fas fa-user"></i> 중복검사 </button>
                        </span>
                    </div>
                    <div class="control-feedback" data-control="mb_id"></div>
                </article>

                <div class="group-container">
                    <article data-score="0">
                        <label class="control-label" for="reg_mb_password">비밀번호</label>
                        <div class="control-group in">
                            <input type="password" name="mb_password" id="reg_mb_password" class="control-input" placeholder="비밀번호를 입력하세요" minlength="6" maxlength="40" autocomplete="new-password"  />
                            <span class="control-group-suffix"><i class="fas fa-lock"></i></span>
                        </div>
                        <div class="control-feedback" data-control="mb_password">긴 문장에 숫자, 특수문자를 포함하세요.</div>
                    </article>

                    <article data-score="0">
                        <label class="control-label" for="reg_mb_password_re">비밀번호 확인</label>
                        <div class="control-group in">
                            <input type="password" name="mb_password_re" id="reg_mb_password_re" class="control-input" placeholder="비밀번호를 다시 입력해주세요" minlength="6" maxlength="40" autocomplete="new-password"  />
                            <span class="control-group-suffix"><i class="fas fa-lock"></i></span>
                        </div>
                        <div class="control-feedback" data-control="mb_password_re"></div>
                    </article>
                </div>


                <article>
                    <label class="control-label" for="reg_mb_email">이메일</label>
                    <div class="control-group">
                        <input type="email" name="mb_email" id="reg_mb_email" class="control-input" placeholder="이메일 주소를 입력하세요" maxlength="100" autocomplete="email"  />
                        <span class="control-group-button">
                            <button type="button" class="btn btn-default form-is-exists" data-own="mb_email" data-role="retry"><i class="fas fa-envelope"></i> 중복검사 </button>
                        </span>
                    </div>
                    <div class="control-feedback" data-control="mb_email"></div>
                </article>


                <article>
                    <label class="control-label" for="reg_mb_mailling">메일링서비스</label>
                    <label class="checklist">
                        <input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" checked /><i class="checkmark"></i>
                        정보 메일을 받겠습니다.
                    </label>
                </article>
            </section>
            <?php
            /*
             |
             | 휴대폰 본인 인증
             */
            if ($config['cf_cert_use'] && $config['cf_cert_hp']) : ?>
                <input type="hidden" name="mobileOwnerVerify" value="N" />

                <h3 class="form-caption">본인 인증</h3>
                <div class="form-section form-section-toolbar">

                    <button type="button" class="btn-toolbar " id="mobile-owner-verify-toggle">
                        <i class="fas fa-mobile-alt"></i> 휴대폰 본인 확인
                    </button>
                </div>
            <?php endif; ?>
            <?php
            /*
             |
             | 추천인
             */
            if ($config['cf_use_recommend']): ?>
                <h3 class="form-caption">추가 정보</h3>
                <input type="hidden" name="recommendee" value="" />
                <div class="form-section">
                    <article>
                        <label class="control-label" for="reg_mb_email">추천인 등록</label>
                        <div class="control-group md-w-sz">
                            <input type="tel" name="mb_recommend" data-labelledby="phone" value="" id="reg_mb_recommend" size="10" maxlength="8" class="control-input" placeholder="휴대폰 번호 8자리" autocomplete="recommendee" />
                            <span class="control-group-button">
                            <button type="button" class="btn btn-default form-is-exists" data-own="mb_recommend"><i class="fas fa-user-friends"></i> 조회 </button>
                        </span>
                        </div>
                        <div class="control-feedback" data-control="mb_recommend">통신망 번호(010)을 제외한 추천인의 휴대폰 번호 8자리를
                            입력하세요.
                        </div>
                    </article>
                </div>
            <?php endif; ?>
            <h3 class="form-caption">약관 동의</h3>
            <section class="form-section">
                <ul class="terms-group custom-checkbox">
                    <li>
                        <div class="terms-item">
                            <label class="checklist">
                                <input type="checkbox" name="agree_all" class="terms-check" data-role="control" value="1" /><i class="checkmark"></i>
                                전체 약관 동의
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="terms-item">
                            <label class="checklist">
                                <input type="checkbox" name="agree" class="terms-check" value="1" /><i class="checkmark"></i>
                                회원가입약관<sub>(필수)</sub>
                            </label>
                            <span class="buttons"><button type="button" class="btn btn-e-indigo toggle-terms">확인하기</button></span>
                        </div>

                        <div class="terms-content sbc sbc-primary">
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
                        <div class="terms-content sbc sbc-primary" id="terms-privacy">
                            <p><?php echo conv_content($config['cf_privacy'], 0); ?></p>
                        </div>
                    </li>

                </ul>
            </section>


            <h3 class="form-caption">자동등록방지</h3>
            <section class="form-section" data-role="captcha"><?php echo captcha_html(); ?></section>
            <div class="form-submit">
                <button class="btn-e btn-e-red" type="submit">
                    <i class="fas fa-sign-in-alt"></i> 회원가입
                </button>
            </div>
        </div>
    </form>
</div>


