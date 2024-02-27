<?php
/**
 * skin file : /theme/THEME_NAME/skin/member/basic/register_form.skin.html.php
 */
defined('_EYOOM_') or exit();
require_once __DIR__.'/_edit.skin.html.php';
return ;

add_javascript('<script type="text/javascript" src="' . G5_URL . '/js/jquery.register_form.js" charset="UTF-8"></script>');
add_javascript('<script type="text/javascript" src="' . EYOOM_THEME_URL . '/js/zxcvbn.js" charset="UTF-8"></script>');
add_javascript('<script type="text/javascript" src="' . EYOOM_THEME_URL . '/js/jquery.password.strength.js" charset="UTF-8"></script>');
($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) && add_javascript('<script type="text/javascript" src="' . G5_URL . '/js/certify.js" charset="UTF-8"></script>');

add_stylesheet('<link rel="stylesheet" href="' . EYOOM_THEME_URL . '/plugins/sweetalert/sweetalert.min.css" type="text/css" media="screen">', 0);
?>
<style type="text/css">
    .register-form {font-size: 12px}
    .register-form .register-box {border: 1px solid #ddd}
    .register-form .address-search-btn {height: 28px;padding: 0 25px;line-height: 28px;font-size: 13px;font-weight: bold}
    .register-form .eyoom-form header {padding: 20px 15px;background: #fafafa}
    .register-form .eyoom-form footer {padding: 10px 15px}
    .register-form .eyoom-form fieldset {padding: 10px}
    .register-form .eyoom-form .vc-captcha fieldset {padding: 0}
    .register-form .border-top {border-top: 1px solid #ddd}
    .register-form .security-display {display: none}
    .register-form .security_0 .security-display, .register-form .security_1 .security-display, .register-form .security_2 .security-display, .register-form .security_3 .security-display, .register-form .security_4 .security-display {display: block}
    .register-form .progress-xxs {height: 3px;float: none}
    .register-form .security_0 .progress-bar {width: 10%}
    .register-form .security_1 .progress-bar {width: 25%}
    .register-form .security_2 .progress-bar {width: 50%}
    .register-form .security_3 .progress-bar {width: 75%}
    .register-form .security_4 .progress-bar {width: 100%}
    .register-form .security_0 .progress-e .progress-bar {background: #000}
    .register-form .security_1 .progress-e .progress-bar {background: #FF4848}
    .register-form .security_2 .progress-e .progress-bar {background: #FF6F42}
    .register-form .security_3 .progress-e .progress-bar {background: #FDAB29}
    .register-form .security_4 .progress-e .progress-bar {background: #73B852}
    .register-form .security_0 .security-heading .pull-right:after {content: "매우약함"}
    .register-form .security_1 .security-heading .pull-right:after {content: "약함"}
    .register-form .security_2 .security-heading .pull-right:after {content: "보통"}
    .register-form .security_3 .security-heading .pull-right:after {content: "강함"}
    .register-form .security_4 .security-heading .pull-right:after {content: "아주강함"}
    .register-form .btn-e-cert {padding: 7px 12px}
</style>

<div class="register-form">
    <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url; ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" class="eyoom-form">
        <input type="hidden" name="w" value="<?php echo $w; ?>">
        <input type="hidden" name="url" value="<?php echo $urlencode; ?>">
        <input type="hidden" name="agree" value="<?php echo $agree; ?>">
        <input type="hidden" name="agree2" value="<?php echo $agree2; ?>">
        <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
        <input type="hidden" name="cert_no" value="">
        <?php if (isset($member['mb_sex'])) { ?>
            <input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex']; ?>"><?php } ?>
        <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { ?>
            <input type="hidden" name="mb_nick_default" value="<?php echo $member['mb_nick']; ?>">
            <input type="hidden" name="mb_nick" value="<?php echo $member['mb_nick']; ?>">
        <?php } ?>
        <input type="hidden" name="mb_1" value="<?php echo $member['mb_1']; ?>">
        <div class="register-box">
            <header><h5 class="margin-0"><strong>사이트 이용정보 입력</strong></h5></header>
            <fieldset>
                <div class="row">
                    <section class="col col-5">
                        <label for="reg_mb_id" class="label width-100 position-relative">아이디<strong class="sound_only"> 필수</strong></label>
                        <label class="input input-button required-mark">
                            <i class="icon-prepend fas fa-user"></i>
                            <input type="text" name="mb_id" value="<?php echo $member['mb_id']; ?>" id="reg_mb_id" <?php if ($w != '') { ?>required readonly<?php } ?> minlength="3" maxlength="20">
                            <?php if ($w == '') { ?>
                                <div class="button" onclick="check_duplication('mb_id');">
                                    <input type="button"><i class="fas fa-check color-red"></i> 중복체크
                                </div>
                            <?php } ?>
                            <?php if ($w == '') { ?>
                                <input type="hidden" name="mb_id_duplicated" id="mb_id_duplicated"><?php } ?>
                            <span id="msg_mb_id"></span>
                        </label>
                        <?php if ($w == '') { ?>
                            <div class="note"><strong>Note:</strong> 아이디 입력 후 <span class="color-yellow">중복체크 필수</span>
                            </div>
                        <?php } ?>
                    </section>
                </div>
                <?php /*소셜로그인이 아닌 경우 */
                if (!$member['mb_2']) { ?>
                    <div class="margin-hr-15"></div>
                    <div class="row">
                        <section class="col col-5">
                            <label for="reg_mb_password" class="label">비밀번호<strong class="sound_only">
                                    필수</strong></label>
                            <label class="input required-mark">
                                <i class="icon-prepend fas fa-lock"></i>
                                <input type="password" name="mb_password" id="reg_mb_password" <?php if ($w != '') { ?>required<?php } ?> minlength="4" maxlength="20">
                            </label>
                        </section>
                        <section class="col col-5">
                            <label for="wr_password" class="label">비밀번호 확인<strong class="sound_only">
                                    필수</strong></label>
                            <label class="input required-mark">
                                <i class="icon-prepend fas fa-lock"></i>
                                <input type="password" name="mb_password_re" id="reg_mb_password_re" <?php if ($w != '') { ?>required<?php } ?> minlength="4" maxlength="20">
                            </label>
                        </section>
                        <div class="clearfix"></div>
                        <div id="pass_meter">
                            <section class="col col-5">
                                <div class="security-display">
                                    <p class="security-heading font-size-11">보안강도체크 <span class="pull-right"></span></p>
                                    <div class="clearfix"></div>
                                    <div class="progress progress-e progress-xxs">
                                        <div class="progress-bar progress-bar-e"></div>
                                    </div>
                                    <div class="note"><strong>Note:</strong> 보안강도는
                                        <span class="color-yellow">보통</span> 이상이어야 합니다.
                                    </div>
                                </div>
                            </section>
                            <section class="col col-4">
                                <div>
                                    <div class="security_text font-size-11 color-red"></div>
                                </div>
                            </section>
                        </div>
                    </div>
                <?php } ?>
            </fieldset>
            <header class="border-top"><h5 class="margin-0"><strong>개인정보 입력</strong></h5></header>
            <fieldset>
                <div class="row">
                    <div class="col col-12 margin-bottom-0">
                        <label for="reg_mb_name" class="label">이름<strong class="sound_only">필수</strong></label>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col col-5">
                        <label class="input required-mark">
                            <i class="icon-prepend fas fa-male"></i>
                            <input type="text" name="mb_name" id="reg_mb_name" value="<?php echo $member['mb_name']; ?>" <?php if ($w != '') { ?>required readonly<?php } ?> size="10">
                        </label>
                    </div>
                    <?php /*소셜 로그인인 경우 휴대폰 번호 입력란에 본인확인 체크*/
                    if (!$member['mb_2']) { ?>
                        <div class="col col-5">
                            <?php if ($config['cf_cert_use']) { ?>
                                <?php if ($config['cf_cert_ipin']) { ?>
                                    <button type="button" id="win_ipin_cert" class="btn-e btn-e-dark btn-e-cert">아이핀
                                        본인확인
                                    </button>
                                <?php } ?>
                                <?php if ($config['cf_cert_hp']) { ?>
                                    <button type="button" id="win_hp_cert" class="btn-e btn-e-dark btn-e-cert">휴대폰
                                        본인확인
                                    </button>
                                <?php } ?>
                                <noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <?php if ($config['cf_cert_use']) { ?>
                            <div class="col col-12">
                                <div class="alert alert-warning padding-all-10 margin-bottom-10 margin-top-10">
                                    <strong>Note:</strong> 아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로
                                    입력할수 없게 됩니다.
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($config['cf_cert_use'] && $member['mb_certify']) { ?>
                            <div class="col col-12">
                                <div id="msg_certify">
                                    <strong><?php if ($member['mb_certify'] == 'ipin') { ?>아이핀<?php } else { ?>휴대폰<?php } ?>
                                        본인확인</strong><?php if ($member['mb_adult']) { ?> 및
                                        <strong>성인인증</strong><?php } ?> 완료
                                </div>
                            </div>
                        <?php } ?>

                    <?php } ?>


                </div>
                <?php if ($req_nick) { ?>
                    <div class="margin-hr-15"></div>
                    <div class="row">
                        <div class="col col-5">
                            <label for="reg_mb_nick" class="label width-100 position-relative">
                                닉네임<strong class="sound_only">필수</strong>
                            </label>
                            <label class="input input-button required-mark">
                                <input type="hidden" name="mb_nick_default" value="<?php if (isset($member['mb_nick'])) { ?><?php echo $member['mb_nick']; ?><?php } ?>">
                                <i class="icon-prepend far fa-smile"></i>
                                <input type="text" name="mb_nick" value="<?php if (isset($member['mb_nick'])) { ?><?php echo $member['mb_nick']; ?><?php } ?>" id="reg_mb_nick" required size="10" maxlength="100">
                                <?php if ($w == '') { ?>
                                    <div class="button" onclick="check_duplication('mb_nick');">
                                        <input type="button"><i class="fas fa-check color-red"></i> 중복체크
                                    </div>
                                <?php } ?>
                                <?php if ($w == '') { ?>
                                    <input type="hidden" name="mb_nick_duplicated" id="mb_nick_duplicated"><?php } ?>
                                <span id="msg_mb_nick"></span>
                            </label>
                            <?php if ($w == '') { ?>
                                <div class="note"><strong>Note:</strong> 닉네임 입력 후
                                    <span class="color-yellow">중복체크 필수</span></div>
                            <?php } ?>
                        </div>
                        <div class="clear"></div>
                        <div class="col col-12">
                            <div class="alert alert-warning padding-all-10 margin-top-10">
                                <strong>Note:</strong> 공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상) | 닉네임을 바꾸시면
                                앞으로 <?php echo $config['cf_nick_modify'] * 1; ?>일 이내에는 변경 할 수 없습니다.
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="margin-hr-15"></div>
                <div class="row">
                    <div class="col col-5">
                        <label for="reg_mb_email" class="label width-100 position-relative">
                            이메일<strong class="sound_only"> 필수</strong>
                        </label>
                        <label class="input input-button required-mark">
                            <input type="hidden" name="old_email" value="<?php echo $member['mb_email']; ?>">
                            <i class="icon-prepend far fa-envelope"></i>
                            <input type="text" name="mb_email" value="<?php if (isset($member['mb_email'])) { ?><?php echo $member['mb_email']; ?><?php } ?>" id="reg_mb_email" required size="70" maxlength="100">
                            <?php if ($w == '') { ?>
                                <div class="button" onclick="check_duplication('mb_email');">
                                    <input type="button"><i class="fas fa-check color-red"></i> 중복체크
                                </div>
                            <?php } ?>
                            <?php if ($w == '') { ?>
                                <input type="hidden" name="mb_email_duplicated" id="mb_email_duplicated"><?php } ?>
                        </label>
                        <?php if ($w == '') { ?>
                            <div class="note"><strong>Note:</strong> 이메일 입력 후 <span class="color-yellow">중복체크 필수</span>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($config['cf_use_email_certify']) { ?>
                        <div class="col col-12">
                            <div class="alert alert-warning padding-all-10 margin-top-10">
                                <strong>Note:</strong> <?php if ($w == '') { ?>E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다.<?php } ?><?php if ($w == 'u') { ?>E-mail 주소를 변경하시면 다시 인증하셔야 합니다.<?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="margin-hr-15"></div>
                <div class="row">
                    <?php if ($config['cf_use_homepage']) { ?>
                        <section class="col col-4">
                            <label for="reg_mb_homepage" class="label">홈페이지<?php if ($config['cf_req_homepage']) { ?>
                                    <strong class="sound_only">필수</strong><?php } ?></label>
                            <label class="input <?php if ($config['cf_req_homepage']) { ?>required-mark<?php } ?>">
                                <i class="icon-prepend fas fa-home"></i>
                                <input type="text" name="mb_homepage" value="<?php echo $member['mb_homepage']; ?>" id="reg_mb_homepage" <?php if ($config['cf_req_homepage']) { ?>required<?php } ?> size="70" maxlength="255">
                            </label>
                        </section>
                    <?php } ?>
                    <?php if ($config['cf_use_tel']) { ?>
                        <section class="col col-4">
                            <label for="reg_mb_tel" class="label">전화번호<?php if ($config['cf_req_tel']) { ?>
                                    <strong class="sound_only">필수</strong><?php } ?></label>
                            <label class="input <?php if ($config['cf_req_tel']) { ?>required-mark<?php } ?>">
                                <i class="icon-prepend fas fa-fax"></i>
                                <input type="text" name="mb_tel" value="<?php echo $member['mb_tel']; ?>" id="reg_mb_tel" <?php if ($config['cf_req_tel']) { ?>required<?php } ?> maxlength="20">
                            </label>
                        </section>
                    <?php } ?>

                    <?php if ($config['cf_use_hp'] || ($config['cf_cert_use'] && $config['cf_cert_hp'])) { ?>
                        <section class="col col-4">
                            <label for="reg_mb_hp" class="label">휴대폰번호<?php if ($config['cf_req_hp']) { ?>
                                    <strong class="sound_only">필수</strong><?php } ?></label>

                            <div style="display: flex">
                                <label class="input <?php if ($config['cf_req_hp']) { ?>required-mark<?php } ?>">
                                    <i class="icon-prepend fas fa-tablet-alt"></i>
                                    <input type="text" name="mb_hp" value="<?php echo $member['mb_hp']; ?>" id="reg_mb_hp" <?php if ($config['cf_req_hp']) { ?>required<?php } ?> maxlength="20">
                                    <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
                                        <input type="hidden" name="old_mb_hp" value="<?php echo $member['mb_hp']; ?>">
                                    <?php } ?>
                                </label>

                                <?php /*소셜회원인 경우 본인 인증 필요*/
                                if ($member['mb_2'] && $config['cf_cert_hp']) { ?>
                                    <button type="button" id="win_hp_cert" class="btn-e btn-e-dark btn-e-cert" style="margin-bottom: 5px;margin-left:5px">
                                        휴대폰 본인확인
                                    </button>
                                    <noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>
                </div>


                <?php if ($config['cf_use_addr']) { ?>
                    <div class="margin-hr-15"></div>
                    <div class="row">
                        <div class="col col-12">
                            <label for="reg_mb_hp" class="label margin-left-5">주소<?php if ($config['cf_req_addr']) { ?>
                                    <strong class="sound_only">필수</strong><?php } ?></label>
                        </div>
                        <div class="col col-4">
                            <label for="reg_mb_zip" class="sound_only">우편번호<?php if ($config['cf_req_addr']) { ?>
                                    <strong class="sound_only"> 필수</strong><?php } ?></label>
                            <label class="input <?php if ($config['cf_req_addr']) { ?>required-mark<?php } ?>">
                                <i class="icon-append fas fa-question-circle"></i>
                                <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1']; ?><?php echo $member['mb_zip2']; ?>" id="reg_mb_zip" <?php if ($config['cf_req_addr']) { ?>required<?php } ?> size="5" maxlength="6">
                                <b class="tooltip tooltip-top-right">우편번호 (주소 검색 버튼을 클릭하여 조회)</b>
                            </label>
                        </div>
                        <div class="col col-4">
                            <button type="button" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');" class="btn-e btn-e-indigo rounded address-search-btn">
                                주소 검색
                            </button>
                        </div>
                        <div class="clearfix margin-bottom-10"></div>
                        <div class="col col-12">
                            <label class="input <?php if ($config['cf_req_addr']) { ?>required-mark<?php } ?>">
                                <input type="text" name="mb_addr1" value="<?php echo $member['mb_addr1']; ?>" id="reg_mb_addr1" <?php if ($config['cf_req_addr']) { ?>required<?php } ?> size="50">
                            </label>
                            <div class="note margin-bottom-10">
                                <strong>Note:</strong> 기본주소<?php if ($config['cf_req_addr']) { ?>
                                    <strong class="sound_only"> 필수</strong><?php } ?></div>
                        </div>
                        <div class="clear"></div>
                        <div class="col col-6">
                            <label class="input">
                                <input type="text" name="mb_addr2" value="<?php echo $member['mb_addr2']; ?>" id="reg_mb_addr2" size="50">
                            </label>
                            <div class="note margin-bottom-10"><strong>Note:</strong> 상세주소</div>
                        </div>
                        <div class="col col-6">
                            <label class="input">
                                <input type="text" name="mb_addr3" value="<?php echo $member['mb_addr3']; ?>" id="reg_mb_addr3" size="50" readonly="readonly">
                            </label>
                            <div class="note margin-bottom-10"><strong>Note:</strong> 참고항목</div>
                        </div>
                        <input type="hidden" name="mb_addr_jibeon" value="<?php echo $member['mb_addr_jibeon']; ?>">
                    </div>
                <?php } ?>
            </fieldset>
            <header class="border-top"><h5 class="margin-0"><strong>기타 개인설정</strong></h5></header>
            <fieldset>
                <?php if ($config['cf_use_signature']) { ?>
                    <div class="row">
                        <section class="col col-12">
                            <label for="reg_mb_signature" class="label">서명<?php if ($config['cf_req_signature']) { ?>
                                    <strong class="sound_only">필수</strong><?php } ?></label>
                            <label class="textarea textarea-resizable <?php if ($config['cf_req_signature']) { ?>required-mark<?php } ?>">
                                <textarea name="mb_signature" id="reg_mb_signature" rows="5" <?php if ($config['cf_req_signature']) { ?>required<?php } ?>><?php echo $member['mb_signature']; ?></textarea>
                            </label>
                        </section>
                    </div>
                <?php } ?>
                <?php if ($config['cf_use_profile']) { ?>
                    <div class="row">
                        <section class="col col-12">
                            <label for="reg_mb_profile" class="label">자기소개</label>
                            <label class="textarea textarea-resizable <?php if ($config['cf_req_profile']) { ?>required-mark<?php } ?>">
                                <textarea name="mb_profile" id="reg_mb_profile" rows="5" <?php if ($config['cf_req_profile']) { ?>required<?php } ?>><?php echo $member['mb_profile']; ?></textarea>
                            </label>
                        </section>
                    </div>
                <?php } ?>
                <?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) { ?>
                    <div class="row">
                        <section class="col col-12">
                            <label for="reg_mb_icon" class="label">회원아이콘</label>
                            <label for="file" class="input input-file">
                                <div class="button bg-color-light-grey">
                                    <input type="file" id="reg_mb_icon" name="mb_icon" value="파일선택" title="파일첨부" onchange="this.parentNode.nextSibling.value = this.value">파일
                                    선택
                                </div>
                                <input type="text" readonly>
                            </label>
                            <div class="clearfix"></div>
                            <?php if ($w == 'u' && file_exists($mb_icon_path)) { ?>
                                <img src="<?php echo $mb_icon_url ?>" alt="회원아이콘">
                                <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon">
                                <label for="del_mb_icon" class="inline">삭제</label>
                            <?php } ?>
                            <div class="note margin-bottom-10">
                                <strong>Note:</strong> 이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀,
                                세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>gif, jpg, png파일만 가능하며
                                용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.
                            </div>
                        </section>
                    </div>
                    <div class="margin-hr-15"></div>
                <?php } ?>
                <?php if ($member['mb_level'] >= $config['cf_icon_level'] && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height']) { ?>
                    <div class="row">
                        <section class="col col-12">
                            <label for="reg_mb_img" class="label">회원이미지</label>
                            <label for="file" class="input input-file">
                                <div class="button bg-color-light-grey">
                                    <input type="file" id="reg_mb_img" name="mb_img" value="파일선택" title="파일첨부" onchange="this.parentNode.nextSibling.value = this.value">파일
                                    선택
                                </div>
                                <input type="text" readonly>
                            </label>
                            <div class="clearfix"></div>
                            <?php if ($w == 'u' && file_exists($mb_img_path)) { ?>
                                <img src="<?php echo $mb_img_url ?>" alt="회원이미지">
                                <input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">
                                <label for="del_mb_img" class="inline">삭제</label>
                            <?php } ?>
                            <div class="note margin-bottom-10">
                                <strong>Note:</strong> 이미지 크기는 가로 <?php echo $config['cf_member_img_width'] ?>픽셀,
                                세로 <?php echo $config['cf_member_img_height'] ?>픽셀 이하로 해주세요.<br>gif, jpg, png파일만 가능하며
                                용량 <?php echo number_format($config['cf_member_img_size']) ?>바이트 이하만 등록됩니다.
                            </div>
                        </section>
                    </div>
                    <div class="margin-hr-15"></div>
                <?php } ?>
                <div class="row">
                    <section class="col col-6">
                        <label for="reg_mb_mailling" class="label">메일링서비스</label>
                        <label class="checkbox">
                            <input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php if ($w == '' || $member['mb_mailling']) { ?>checked<?php } ?>><i></i>정보
                            메일을 받겠습니다.
                        </label>
                    </section>
                    <?php if ($config['cf_use_hp']) { ?>
                        <section class="col col-6">
                            <label for="reg_mb_sms" class="label">SMS 수신여부</label>
                            <label class="checkbox">
                                <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php if ($w == '' || $member['mb_sms']) { ?>checked<?php } ?>><i></i>휴대폰
                                문자메세지를 받겠습니다.
                            </label>
                        </section>
                    <?php } ?>
                </div>
                <div class="margin-hr-15"></div>
                <div class="row">
                    <?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { ?>
                        <section class="col col-6">
                            <label for="reg_mb_open" class="label">정보공개</label>
                            <label class="checkbox">
                                <input type="checkbox" name="mb_open" value="1" <?php if ($w == '' || $member['mb_open']) { ?>checked<?php } ?> id="reg_mb_open"><i></i>다른분들이
                                나의 정보를 볼 수 있도록 합니다.
                                <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open']; ?>">
                            </label>
                            <div class="note margin-bottom-10">
                                <strong>Note:</strong> 정보공개를 바꾸시면 앞으로 <?php echo $config['cf_open_modify'] * 1; ?>일 이내에는
                                변경이 안됩니다.
                            </div>
                        </section>
                    <?php } else { ?>
                        <section class="col col-6">
                            <label for="reg_mb_open" class="label">정보공개</label>
                            <label class="checkbox">
                                <input type="hidden" name="mb_open" value="<?php echo $member['mb_open']; ?>">
                            </label>
                            <div class="note margin-bottom-10">
                                <strong>Note:</strong> 정보공개는 수정후 <?php $config['cf_open_modify'] * 1; ?>일
                                이내, <?php echo $open_day; ?> 까지는 변경이 안됩니다.<br>이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는
                                경우를 막기 위해서 입니다.
                            </div>
                        </section>
                    <?php } ?>
                    <?php
                    //회원정보 수정인 경우 소셜 계정 출력
                    if ($w == 'u' && function_exists('social_member_provider_manage')) {
                        social_member_provider_manage();
                    }
                    ?>
                    <?php /*일반 회원 가입 시*/ if ($w == '' && $config['cf_use_recommend']) { ?>
                        <input type="hidden" id="recommendee" name="recommendee" value="" />
                        <section class="col col-md-6">
                            <label for="reg_mb_recommend" class="label width-100 position-relative">추천인</label>
                            <label class="input input-button col-md-6 padding-0">
                                <i class="icon-prepend fas fa-user"></i>
                                <input type="text" name="mb_recommend" data-labelledby="phone" value="" id="reg_mb_recommend" size="10" maxlength="8" />
                                <button type="button" class="button" id="check-recommend-button">
                                    <i class="fas fa-search"></i> 조회
                                </button>
                            </label>
                            <div class="clear"></div>
                            <div class="alert alert-warning padding-all-10 margin-top-10">
                                <strong>Note:</strong> 통신망 번호(010)을 제외한 추천인의 휴대폰 번호 8자리를 입력하세요.
                            </div>
                        </section>
                    <?php } ?>
                </div>
                <div class="margin-hr-15"></div>
                <div class="row">
                    <section class="col col-12">
                        <label class="label">자동등록방지</label>
                        <div class="vc-captcha"><?php echo captcha_html(); ?></div>
                    </section>
                </div>
            </fieldset>

            <footer class="text-center">
                <?php if ($w == 'u') { ?>
                    <button type="button" value="회원탈퇴" id="btn_remove" class="btn-e btn-e-xlg btn-e-default" onclick="member_leave();">
                        회원탈퇴
                    </button>
                <?php } ?>
                <button type="submit" value="<?php if ($w == '') { ?>회원가입<?php } else { ?>정보수정<?php } ?>" id="btn_submit" class="btn-e btn-e-xlg btn-e-red" accesskey="s"><?php if ($w == '') { ?>회원가입<?php } else { ?>정보수정<?php } ?></button>
            </footer>
        </div>
    </form>
</div>

<script src="<?php echo EYOOM_THEME_URL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#reg_zip_find").css("display", "inline-block");
        <?php if ($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
        // 아이핀인증
        $("#win_ipin_cert").click(function () {
            if (!cert_confirm())
                return false;

            var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
            certify_win_open('kcb-ipin', url);
            return;
        });
        <?php } ?>

        <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
        // 휴대폰인증
        $("#win_hp_cert").click(function () {
            if (!cert_confirm()) return false;

            <?php if ($config['cf_cert_hp'] == 'kcb') { ?>
            certify_win_open("kcb-hp", "<?php echo G5_OKNAME_URL; ?>/hpcert1.php");
            <?php } else if ($config['cf_cert_hp'] == 'kcp') { ?>
            certify_win_open("kcp-hp", "<?php echo G5_KCPCERT_URL; ?>/kcpcert_form.php");
            <?php } else if ($config['cf_cert_hp'] == 'lg') { ?>
            certify_win_open("lg-hp", "<?php echo G5_LGXPAY_URL; ?>/AuthOnlyReq.php");
            <?php } else { ?>
            swal({
                title: "중요!",
                text: "기본환경설정에서 휴대폰 본인확인 설정을 해주십시오.",
                confirmButtonColor: "#FDAB29",
                type: "warning",
                confirmButtonText: "확인"
            });
            return false;
            <?php } ?>

            return;
        });
        <?php } ?>

        $('#check-recommend-button').on('click', function (e) {
            e.preventDefault();
            var msg, input = $('#reg_mb_recommend'), result = $('#recommendee');
            result.val('');
            if (msg = reg_mb_recommend_check()) {
                swal({
                    'title': "중요!",
                    'text': msg,
                    'confirmButtonColor': "#FDAB29",
                    'type': "warning",
                    'confirmButtonText': "확인"
                });
                return;
            }

            swal({
                'title': "OK!",
                'text': "등록되어 있는 추천인입니다.",
                'confirmButtonColor': "#73B852",
                'type': "success",
                'confirmButtonText': "확인"
            });
            result.val('phone');
            input.css('background', '#f5f5f5').attr('readOnly', true);
            $(this).off('click');

        });
    });

    // submit 최종 폼체크
    function fregisterform_submit(f) {
        // 회원아이디 검사
        if (f.w.value == "") {
            var msg = reg_mb_id_check();
            if (msg) {
                swal({
                    title: "중요!",
                    text: msg,
                    confirmButtonColor: "#FF4848",
                    type: "error",
                    confirmButtonText: "확인"
                });
                f.mb_id.select();
                return false;
            }
        }
        <?php if ($w == '') { ?>
        if (f.mb_id_duplicated.value != 'y') {
            swal({
                title: "중요!",
                text: "아이디 중복검사를 하셔야 합니다.",
                confirmButtonColor: "#FDAB29",
                type: "warning",
                confirmButtonText: "확인"
            });
            f.mb_id.select();
            return false;
        }
        <?php } ?>

        if (f.w.value == "") {
            if (f.mb_password.value.length < 4) {
                swal({
                    title: "중요!",
                    text: "비밀번호를 4글자 이상 입력하십시오.",
                    confirmButtonColor: "#FDAB29",
                    type: "warning",
                    confirmButtonText: "확인"
                });
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            swal({
                title: "중요!",
                text: "비밀번호가 같지 않습니다.",
                confirmButtonColor: "#FF4848",
                type: "error",
                confirmButtonText: "확인"
            });
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 4) {
                swal({
                    title: "중요!",
                    text: "비밀번호를 4글자 이상 입력하십시오.",
                    confirmButtonColor: "#FDAB29",
                    type: "warning",
                    confirmButtonText: "확인"
                });
                f.mb_password_re.focus();
                return false;
            }
        }

        // 비밀번호 강도체크
        var pass_strength = $("#pass_meter").attr("class");
        if (!pass_strength || pass_strength == 'security_0' || pass_strength == 'security_1') {
            swal({
                title: "중요!",
                text: "비밀번호의 강도는 '보통' 이상이여야 합니다.",
                confirmButtonColor: "#FDAB29",
                type: "warning",
                confirmButtonText: "확인"
            });
            f.mb_password.focus();
            return false;
        }

        // 이름 검사
        if (f.w.value == "") {
            if (f.mb_name.value.length < 1) {
                swal({
                    title: "중요!",
                    text: "이름을 입력하십시오.",
                    confirmButtonColor: "#FF4848",
                    type: "error",
                    confirmButtonText: "확인"
                });
                f.mb_name.focus();
                return false;
            }

            /*
            var pattern = /([^가-힣\x20])/i;
            if (pattern.test(f.mb_name.value)) {
                swal({
                    title: "중요!",
                    text: "이름은 한글로 입력하십시오.",
                    confirmButtonColor: "#FDAB29",
                    type: "warning",
                    confirmButtonText: "확인"
                });
                f.mb_name.select();
                return false;
            }
            */
        }

        <?php if ($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
        // 본인확인 체크
        if (f.cert_no.value == "") {
            swal({
                title: "중요!",
                text: "회원가입을 위해서는 본인확인을 해주셔야 합니다.",
                confirmButtonColor: "#FDAB29",
                type: "warning",
                confirmButtonText: "확인"
            });
            return false;
        }
        <?php } ?>

        // 닉네임 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
            var msg = reg_mb_nick_check();
            if (msg) {
                swal({
                    title: "중요!",
                    text: msg,
                    confirmButtonColor: "#FDAB29",
                    type: "warning",
                    confirmButtonText: "확인"
                });
                f.reg_mb_nick.select();
                return false;
            }
        }
        <?php if ($w == '') { ?>
        if (f.mb_nick_duplicated.value != 'y') {
            swal({
                title: "중요!",
                text: "닉네임 중복검사를 하셔야 합니다.",
                confirmButtonColor: "#FDAB29",
                type: "warning",
                confirmButtonText: "확인"
            });
            f.reg_mb_nick.select();
            return false;
        }
        <?php } ?>


        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                swal({
                    title: "중요!",
                    text: msg,
                    confirmButtonColor: "#FF4848",
                    type: "error",
                    confirmButtonText: "확인"
                });
                f.reg_mb_email.select();
                return false;
            }
        }

        <?php if ($w == '') { ?>
        if (f.mb_email_duplicated.value != 'y') {
            swal({
                title: "중요!",
                text: "이메일 중복검사를 하셔야 합니다.",
                confirmButtonColor: "#FDAB29",
                type: "warning",
                confirmButtonText: "확인"
            });
            f.reg_mb_email.select();
            return false;
        }
        <?php } ?>

        <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) { ?>
        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            swal({
                title: "중요!",
                text: msg,
                confirmButtonColor: "#FDAB29",
                type: "warning",
                confirmButtonText: "확인"
            });
            f.reg_mb_hp.select();
            return false;
        }
        <?php } ?>

        if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
            if (!f.recommendee.value) {
                swal({
                    title: "중요!",
                    text: "추천인 등록여부를 확인하셔야 합니다.",
                    confirmButtonColor: "#FDAB29",
                    type: "warning",
                    confirmButtonText: "확인"
                });
                f.mb_recommend.select();
                return false;
            }
        }


        /*
            if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
                if (f.mb_id.value == f.mb_recommend.value) {
                    swal({
                        title: "중요!",
                        text: "본인을 추천할 수 없습니다.",
                        confirmButtonColor: "#FF4848",
                        type: "error",
                        confirmButtonText: "확인"
                    });
                    f.mb_recommend.focus();
                    return false;
                }

                var msg = reg_mb_recommend_check();
                if (msg) {
                    swal({
                        title: "중요!",
                        text: msg,
                        confirmButtonColor: "#FDAB29",
                        type: "warning",
                        confirmButtonText: "확인"
                    });
                    f.mb_recommend.select();
                    return false;
                }
            }
        */
        <?php chk_captcha_js(); ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

    function check_duplication(target) {
        switch (target) {
            case 'mb_id':
                var mb_id = $('#reg_mb_id').val();
                if (!mb_id) {
                    alert('아이디를 입력해 주세요.');
                    return false;
                }
                var msg = reg_mb_id_check();
                if (msg) {
                    swal({
                        title: "중요!",
                        text: msg,
                        confirmButtonColor: "#FF4848",
                        type: "error",
                        confirmButtonText: "확인"
                    });
                    $("#reg_mb_id").focus();
                    $("#reg_mb_id").select();
                    return false;
                }
                else {
                    swal({
                        title: "OK!",
                        text: "사용가능한 아이디입니다.",
                        confirmButtonColor: "#73B852",
                        type: "success",
                        confirmButtonText: "확인"
                    });
                    $("#reg_mb_id").attr('readonly', 'true');
                    $("#mb_id_duplicated").val('y');
                    $("#reg_mb_id").css('background', '#f5f5f5');
                }
                break;
            case 'mb_nick':
                var mb_nick = $('#reg_mb_nick').val();
                if (!mb_nick) {
                    alert('닉네임을 입력해 주세요.');
                    return false;
                }
                var msg = reg_mb_nick_check();
                if (msg) {
                    swal({
                        title: "중요!",
                        text: msg,
                        confirmButtonColor: "#FF4848",
                        type: "error",
                        confirmButtonText: "확인"
                    });
                    $("#reg_mb_nick").focus();
                    $("#reg_mb_nick").select();
                    return false;
                }
                else {
                    swal({
                        title: "OK!",
                        text: "사용가능한 닉네임입니다.",
                        confirmButtonColor: "#73B852",
                        type: "success",
                        confirmButtonText: "확인"
                    });
                    $("#reg_mb_nick").attr('readonly', 'true');
                    $("#mb_nick_duplicated").val('y');
                    $("#reg_mb_nick").css('background', '#f5f5f5');
                }
                break;
            case 'mb_email':
                var mb_email = $('#reg_mb_email').val();
                if (!mb_email) {
                    alert('이메일을 입력해 주세요.');
                    return false;
                }
                var msg = reg_mb_email_check();
                if (msg) {
                    swal({
                        title: "중요!",
                        text: msg,
                        confirmButtonColor: "#FF4848",
                        type: "error",
                        confirmButtonText: "확인"
                    });
                    $("#reg_mb_email").focus();
                    $("#reg_mb_email").select();
                    return false;
                }
                else {
                    swal({
                        title: "OK!",
                        text: "사용가능한 이메일입니다.",
                        confirmButtonColor: "#73B852",
                        type: "success",
                        confirmButtonText: "확인"
                    });
                    $("#reg_mb_email").attr('readonly', 'true');
                    $("#mb_email_duplicated").val('y');
                    $("#reg_mb_email").css('background', '#f5f5f5');
                }
                break;
        }
    }
    <?php if ($w == 'u') { ?>
    function member_leave() {  // 회원 탈퇴 tto
        swal({
                html: true,
                title: "중요!",
                text: "<div class='alert alert-warning font-size-12'>회원 탈퇴를 하시면 모든 포인트와 경험치가 삭제되며, 복구할 수 없습니다.</div><strong>정말로 회원 탈퇴를 하시겠습니까?</strong>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FDAB29",
                confirmButtonText: "탈퇴",
                cancelButtonText: "취소",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    location.href = '<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php';
                }
            });
    }
    <?php } ?>
    function initializeStrengthMeter() {
        $("#pass_meter").PasswordStrengthManager({
            password: $("#reg_mb_password").val(),
            confirm_pass: $("#reg_mb_password_re").val(),
            minChars: $("#reg_mb_password").attr("minlength"),
            maxChars: $("#reg_mb_password").attr("maxlength"),
            blackList: []
        });
    }

    // 암호강도체크
    $(function () {
        $("#reg_mb_password, #reg_mb_password_re").on('keyup', initializeStrengthMeter);
        (function () {
            var form = $('form[name="fregisterform"]'), elements = form.find('SELECT[name="districts[]"]');
            var depth = ['city', 'town'], entries = <?=json_encode($Districts)?>;
            elements.each(function (index) {
                var el = $(this);
                el.on('change', function (event) {
                    event.preventDefault();
                    var entry, n, i = 0, val;
                    try {
                        if (!depth[index] || !entries.hasOwnProperty(depth[index]) || !(n = elements.eq(index + 1)).length) return false;

                        for (; i <= index; i++) {
                            !entry && (entry = entries[depth[index]]);
                            entry = entry[elements.eq(i).val()]
                        }

                        n.children().not(':eq(0)').remove();
                        for (val in entry) {
                            entry.hasOwnProperty(val) && n.append("<option value=\"" + val + "\">" + entry[val] + "</option>");
                        }
                    }
                    catch (_) {
                        console.error(_)
                    }
                });

            });
            // ----

            /*$('#btn-agent-search').on('click', function (event) {
                event.preventDefault();
                if (!elements.eq(0).val()) {
                    alert('지역을 선택해주세요.');
                    elements.eq(0).focus();
                    return false;
                }
                var district = elements.map(function () {
                    return this.selectedIndex > 0 ? $(this).val() : null;
                }).get().pop();
                /**
                 * @typdef {{}} DistrictSearchResultType
                 * @param {number} code
                 * @param {string} [message]
                 * @param {number} [page]
                 * @param {number} [pages]
                 * @param {number} [totals]
                 * @param {[{}]} [item]
                 * /
                var container = $('#agent-listing');
                container.html('');

                $.post(g5_url + "/shop/ajax.agent.php", {'scope': 'search', 'value': district},
                    /**
                     * @param {DistanceModelType} response
                     * @returns {*}
                     * /
                    function (response) {
                        if (response.code != 200) {
                            return swal({
                                'title': "중요!",
                                'text': response.message,
                                'confirmButtonColor': "#FF4848",
                                'type': "error",
                                'confirmButtonText': "확인"
                            });
                        }
                        else if (!response.totals) {
                            container.html('<div class="col col-12 alert alert-warning">검색 결과가 없습니다.</div>');
                            return false;
                        }
                        var row;
                        do {
                            row = response.item.shift();
                            container.append("<label><input type=\"radio\" name=\"mb_1\" value=\"" + row.id + "\" />" + row.title + "</label>");
                        } while (response.item.length > 0);
                    });
            });*/
        })();
    });


    //


</script>