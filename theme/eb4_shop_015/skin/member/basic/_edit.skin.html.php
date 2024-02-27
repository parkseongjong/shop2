<?php
/**
 * skin file : /theme/THEME_NAME/skin/member/basic/register_form.skin.html.php
 */
if (!defined('_EYOOM_')) exit;
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

add_stylesheet('<link rel="stylesheet" href="' . EYOOM_THEME_URL . '/plugins/sweetalert/sweetalert.min.css" type="text/css" media="screen">', 0);
add_javascript('<script type="text/javascript" src="' . EYOOM_THEME_URL . '/js/zxcvbn.js" charset="UTF-8"></script>');
add_javascript('<script type="text/javascript" src="' . EYOOM_THEME_URL . '/plugins/sweetalert/sweetalert.min.js" charset="UTF-8"></script>');
$config['cf_cert_use'] && add_javascript('<script type="text/javascript" src="' . G5_URL . '/js/certify.js" charset="UTF-8"></script>');

add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/member-editable.js?ver=' . G5_JS_VER . '" charset="UTF-8"></script>');

$mobile_no = '';
empty($member['mb_hp']) !== true && ($mobile_no = preg_replace('/^010-(\d)\d{3}-(\d)\d{2}(\d+)$/', '+82 10-$1***-$2**$3', $member['mb_hp']));
$recommend_editable = empty($member['mb_recommend']) === true || ($member['mb_datetime'] < '2022-07-06' && !$member['mb_3']);
?>
<script type="text/javascript">
    $(function () {
        var $form = $('form[name="frmProfile"]');

        $form<?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) : ?>.data('feed', function () {
            var val = $form.find('INPUT[name="mb_hp"]').val().replace(/^010-(\d)\d{3}-(\d)\d{2}(\d+)$/, '+82 10-$1***-$2**$3') || '';
            $('#reg_mb_hp').attr('data-feedback', 'success').text(val);
            $form.find('button.btn-call[data-own="mb_hp"]').off('click').removeClass('btn-primary').addClass('btn-success').find('SPAN').text('완료');

        })<?php endif;?>.find('button.btn-call').on('click', function () {
            var own = $(this).attr('data-own');
            switch (own) {
                case 'mb_zip' : {
                    win_zip('frmProfile', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');
                    break;
                }
            <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) : ?>
                case 'mb_hp': {
                    var endpoint = '<?=$CertifyProvider[$config['cf_cert_hp']]?>';
                    if (!endpoint) {
                        return alert('휴대폰 본인확인 설정이 필요합니다.\n관리자에게 문의하세요.');
                    }

                    certify_win_open('<?=$config['cf_cert_hp']?>-hp', endpoint);
                    break;
                }
            <?php endif;?>
            }
        });


    });
</script>

<div class="form-container">
    <form name="frmProfile" action="<?= $register_action_url; ?>" method="post" enctype="multipart/form-data" class="form-cert-hp">
        <input type="hidden" name="w" value="u" />
        <input type="hidden" name="url" value="<?= $urlencode; ?>" />
        <input type="hidden" name="mb_id" value="<?= $member['mb_id']; ?>">
        <input type="hidden" name="mb_1" value="<?php echo $member['mb_1']; ?>">

        <?php if (isset($member['mb_sex'])) { ?>
            <input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex']; ?>">
        <?php } ?>

        <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { ?>
            <input type="hidden" name="mb_nick_default" value="<?php echo $member['mb_nick']; ?>">
        <?php }?>

        <input type="hidden" name="mb_nick" value="<?php echo $member['mb_nick']; ?>">

        <input type="hidden" name="cert_type" value="<?= $member['mb_certify'] ?>" />
        <input type="hidden" name="cert_no" value="" />
        <input type="hidden" name="mb_name" value="<?= $member['mb_name'] ?>" />
        <input type="hidden" name="mb_hp" value="<?= $member['mb_hp'] ?>" />

        <div class="form-content">
            <h3 class="form-caption">기본 정보</h3>

            <section class="form-section">
                <article>
                    <label class="control-label">이름</label>
                    <div class="md-w-sz"><span class="control-input"><?= $member['mb_name']; ?></span></div>
                    <div class="control-feedback">본인 인증 후 자동 적용됩니다.</div>
                </article>


                <article>
                    <label class="control-label" for="reg_mb_hp">휴대전화</label>
                    <div class="control-group md-w-sz">
                        <span class="control-input inline" id="reg_mb_hp"><?= $mobile_no ?></span>
                        <span class="control-group-button">
                            <button type="button" class="btn btn-primary btn-call" data-own="mb_hp"><i class="fas fa-mobile-alt"></i> <span><?= $mobile_no ? '수정' : '인증' ?></span></button>
                        </span>
                    </div>
                    <div class="control-feedback" data-control="verify-mobile"></div>
                </article>

                <article class="editable-group" data-expanded="false">
                    <label class="control-label" for="reg_mb_email">이메일</label>

                    <div class="control-group" data-role="read">
                        <span class="control-input editable-item-read"><?= $member['mb_email'] ?></span>
                        <span class="control-group-button">
                            <button type="button" class="btn btn-e-dark editable-toggle"><i class="fas fa-pen"></i> 수정 </button>
                        </span>
                    </div>

                    <div class="control-group" data-role="write">
                        <input type="email" name="mb_email" id="reg_mb_email" class="control-input editable-item-write" placeholder="이메일 주소를 입력하세요" maxlength="100" value="<?= $member['mb_email'] ?>" autocomplete="email" data-value="<?= $member['mb_email'] ?>" />
                        <div class="control-group-button">
                            <button type="button" class="btn btn-e-dark form-is-exists" data-own="mb_email" data-role="retry">
                                <i class="fas fa-envelope"></i> 중복검사
                            </button>
                            <button type="button" class="btn btn-default editable-close"><i class="fas fa-times"></i> 취소
                            </button>
                        </div>
                    </div>

                    <div class="control-feedback" data-control="mb_email"></div>
                </article>

                <article>
                    <label class="control-label" for="reg_mb_mailling">메일링서비스</label>
                    <label class="checklist">
                        <input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?= $member['mb_mailling'] ? 'checked' : '' ?> /><i class="checkmark"></i>
                        정보 메일을 받겠습니다.
                    </label>
                </article>
            </section>
            <h3 class="form-caption"></h3>
            <section class="form-section">

                <article class="editable-group" data-expanded="false">
                    <div data-role="read">
                        <label class="control-label" for="reg_mb_password">비밀번호</label>
                        <div class="control-group">
                            <span class="control-input editable-item-read"><?= str_repeat('*', rand(12, 20)) ?></span>
                            <div class="control-group-button">
                                <button type="button" class="btn btn-e-dark editable-toggle">
                                    <i class="fas fa-pen"></i> 수정
                                </button>
                            </div>
                        </div>
                    </div>

                    <div data-role="write">
                        <article data-score="0">
                            <label class="control-label control-label-block" for="reg_mb_password">비밀번호
                                <button type="button" class="btn btn-default editable-close" data-role="sm">
                                    <i class="fas fa-times"></i></button>
                            </label>
                            <div class="control-group in">
                                <input type="password" name="mb_password" id="reg_mb_password" class="control-input" placeholder="새 비밀번호를 입력하세요" minlength="6" maxlength="40" autocomplete="new-password" />
                                <span class="control-group-suffix"><i class="fas fa-lock"></i></span>
                            </div>
                            <div class="control-feedback" data-control="mb_password">긴 문장에 숫자, 특수문자를 포함하세요.</div>
                        </article>

                        <article data-score="0">
                            <label class="control-label" for="reg_mb_password_re">비밀번호 확인</label>
                            <div class="control-group in">
                                <input type="password" name="mb_password_re" id="reg_mb_password_re" class="control-input" placeholder="새 비밀번호를 다시 입력해주세요" minlength="6" maxlength="40" autocomplete="new-password" />
                                <span class="control-group-suffix"><i class="fas fa-lock"></i></span>
                            </div>
                            <div class="control-feedback" data-control="mb_password_re"></div>
                        </article>

                    </div>
                </article>
            </section>


            <h3 class="form-caption">추가 정보</h3>
            <section class="form-section">
                <?php
                /*
                 |
                 | 추천인
                 */
                ##$recommend_editable = true;
                if ($config['cf_use_recommend']): ?>
                    <article class="editable-group" data-expanded="false">
                        <label class="control-label" for="reg_mb_email">추천인</label>
                        <?php /*실명인증이 안된 경우*/
                        if ($config['cf_cert_hp'] && $member['mb_certify'] != 'hp') { ?>
                            <div class="control-group">
                                <span class="control-input"></span>
                                <span class="control-group-button"><button type="button" class="btn btn-default" disabled><i class="fas fa-pen"></i> 조회 </button></span>
                            </div>
                            <div class="control-feedback" data-feedback="error"> 휴대폰 본인확인 후 추천인 등록이 가능합니다.</div>
                            <?php
                        }
                        /*추천인 등록/수정 가능일때*/
                        elseif ($recommend_editable === true) {
                            $mentor = empty($member['mentor']) !== true ? substr(str_replace('-', '', $member['mentor']['mb_hp']), -8) : '';
                            ?>
                            <input type="hidden" name="recommendee" value="N" />
                            <?php if ($mentor): ?>
                                <div class="control-group md-w-sz" data-role="read">
                                    <span class="control-input editable-item-read"><?= $mentor ?></span>
                                    <span class="control-group-button"><button type="button" class="btn btn-e-dark editable-toggle"><i class="fas fa-pen"></i> 수정 </button></span>
                                </div>


                                <div class="control-group md-w-sz" data-role="write">
                                    <input type="tel" name="mb_recommend" data-labelledby="phone" value="<?= $mentor ?>" data-value="<?= $mentor ?>" id="reg_mb_recommend" size="10" maxlength="8" class="control-input editable-item-write" placeholder="휴대폰 번호 8자리" autocomplete="recommendee" />
                                    <div class="control-group-button">
                                        <button type="button" class="btn btn-e-dark form-is-exists" data-own="mb_recommend" data-role="retry">
                                            <i class="fas fa-user-friends"></i> 변경
                                        </button>
                                        <button type="button" class="btn btn-default editable-close">
                                            <i class="fas fa-times"></i> 취소
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="control-group md-w-sz">
                                    <input type="tel" name="mb_recommend" data-labelledby="phone" value="<?= $mentor ?>" data-value="<?= $mentor ?>" id="reg_mb_recommend" size="10" maxlength="8" class="control-input editable-item-write" placeholder="휴대폰 번호 8자리" autocomplete="recommendee" />
                                    <div class="control-group-button">
                                        <button type="button" class="btn btn-e-dark form-is-exists" data-own="mb_recommend" data-role="retry">
                                            <i class="fas fa-user-friends"></i> 등록
                                        </button>
                                    </div>
                                </div>

                            <?php endif; ?>
                            <div class="control-feedback" data-control="mb_recommend"></div>
                            <?php
                        }
                        /*추천인 등록된 경우*/
                        elseif (empty($member['mentor']) !== true) {
                            $len = strlen($member['mentor']['mb_name']);
                            $mentor = substr($member['mentor']['mb_name'], 0, 1) . str_repeat('*', max($len - 2, 1));
                            $len > 2 && ($mentor .= substr($member['mentor']['mb_name'], $len - 1, 1));
                            $mentor .= ' (' . substr($member['mentor']['mb_hp'], -4) . ')';
                            ?>
                            <span class="control-input md-w-sz"><?= $mentor ?></span>
                            <?php
                        }
                        /*추천인 정보가 없음*/
                        else {
                            print '<span class="color-grey">탈퇴 또는 정지된 추천인</span>';
                        }
                        ?>
                    </article>
                <?php endif; ?>
                <article>
                    <label class="control-label" for="reg_mb_zip">주소</label>
                    <div class="control-group margin-bottom-5">
                        <input type="text" class="control-input inline" name="mb_zip" value="<?= $member['mb_zip1'] . $member['mb_zip2']; ?>" id="reg_mb_zip" size="5" maxlength="6" readonly />
                        <span class="control-group-button"><button type="button" class="btn btn-e-dark btn-call" data-own="mb_zip"><i class="fas fa-map-marked-alt"></i> 주소검색 </button></span>
                    </div>
                    <input type="text" class="control-input margin-bottom-5" placeholder="기본주소" name="mb_addr1" value="<?= $member['mb_addr1']; ?>" id="reg_mb_addr1" size="50" readonly />
                    <div class="control-group">
                        <input type="text" class="control-input" placeholder="상세주소(주소검색 후 입력하세요)" name="mb_addr2" value="<?= $member['mb_addr2']; ?>" id="reg_mb_addr2" size="50" />
                        <input type="text" class="control-input inline" placeholder="건물/법정동" name="mb_addr3" value="<?= $member['mb_addr3']; ?>" id="reg_mb_addr3" size="20" readonly />
                    </div>
                    <input type="hidden" name="mb_addr_jibeon" value="<?php echo $member['mb_addr_jibeon']; ?>">
                </article>
            </section>

            <?php
            //회원정보 수정인 경우 소셜 계정 출력
            if (function_exists('social_member_provider_manage')) {
                social_member_provider_manage();
            }
            ?>


            <h3 class="form-caption">자동등록방지</h3>
            <section class="form-section" data-role="captcha"><?php echo captcha_html(); ?></section>
            <div class="form-submit">
                <button class="btn-e btn-e-red" type="submit">
                    <i class="fas fa-check"></i> 정보수정
                </button>
            </div>

        </div>
    </form>
</div>
