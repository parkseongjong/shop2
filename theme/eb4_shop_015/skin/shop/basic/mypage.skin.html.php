<?php
/**
 * skin file : /theme/THEME_NAME/skin/shop/basic/mypage.skin.html.php
 * @type array $Agent
 */
if (!defined('_EYOOM_')) exit;
$recommend_editable = empty($member['mb_recommend']) === true || ($member['mb_datetime'] < '2022-07-06' && !$member['mb_3']);
?>

<style type="text/css">

    #smb_my {margin-bottom: 0}
    .shop-mypage .panel-group {position: relative;margin-bottom: 70px}
    .shop-mypage .panel-oc-btn {position: absolute;bottom: -30px;left: 50%;width: 50px;height: 30px;margin-left: -25px;border: 1px solid #d5d5d5;border-top: 0;text-align: center;padding: 5px 0 0;background: #f8f8f8}
    .shop-mypage .panel-oc-btn .fas {display: block;line-height: 1;font-size: 11px;color: #757575}
    .shop-mypage .panel-oc-btn .fa-caret-down {margin-top: -5px}
    .shop-mypage .panel-heading {background: #f8f8f8}
    .shop-mypage .panel-body .op_area {margin: 3px 5px;width: calc(50% - 12px);display: inline-flex;}
    .shop-mypage .panel-body .op_area dt, .shop-mypage .panel-body .op_area dd {margin: 0;padding: 0}
    .shop-mypage .panel-body .op_area dt {width: 15%; min-width: 15%;font-weight: bold}
    .shop-mypage .panel-body .op_area dd {flex-grow: 1;white-space: normal;padding-left:.75rem;}
    .shop-mypage .mypage-wishlist-container {margin-left: -10px;margin-right: -10px}
    .shop-mypage .mypage-wishlist-box {position: relative;width: 25%}
    .shop-mypage .mypage-wishlist-box-pd {padding: 10px}
    .shop-mypage .mypage-wishlist-box-in {position: relative;border: 1px solid #dadada;padding: 10px;background: #fff}
    .shop-mypage .mypage-wishlist-box .mypage-wishlist-img {margin-bottom: 15px}
    .shop-mypage .mypage-wishlist-box .mypage-wishlist-img img {display: block;width: 100% \9;max-width: 100%;height: auto}
    .shop-mypage .mypage-wishlist-box h5 {font-size: 15px}
    .shop-mypage .mypage-wishlist-box .mypage-wishlist-date {font-size: 13px;color: #959595}
    <?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
    .ext-btn {display: none;}
    @media (max-width: 991px) {
        .shop-mypage-wishlist .mypage-wishlist-box {width: 33.33333%}
    }
    @media (max-width: 767px) {

        .shop-mypage .mypage-wishlist-container {margin-left: -5px;margin-right: -5px}
        .shop-mypage .mypage-wishlist-box {width: 50%}
        .shop-mypage .mypage-wishlist-box-pd {padding: 5px}
        .ext-btn {display: inline-flex; float: right;margin-top: -.5rem;margin-right: -10px}
        .ext-btn::after {display: block; content: ''; clear: both;}
        .ext-btn .btn-e {padding: .25rem .5rem;margin-left: 1px; font-weight: normal}
    }
    .mypage-agent-group {position: relative}
    <?php } ?>

    .member-editable {display: inline-flex}
    .member-editable .list-box {position: relative;z-index: 1;margin: 0;font-weight: normal}
    .member-editable .list-box > select {position: relative;font-size: 11px;line-height: 1;z-index: 2;padding: 5px 24px 5px 8px;-webkit-appearance: none;-moz-appearance: none;appearance: none;outline: 0;border: 1px solid #7a7a7a;min-width: 105px;}
    .member-editable .list-box::before,
    .member-editable .list-box::after {content: '';position: absolute;z-index: 11;right: 8px; border: 4px solid transparent;pointer-events: none; }
    .member-editable .list-box::before {top: calc(50% - 8px);border-bottom-color: #7a7a7a;}
    .member-editable .list-box::after {top: calc(50% + 2px);border-top-color: #7a7a7a;}
    .member-editable .list-box > select:focus {z-index: 10;}
    .member-editable > .editable-control {margin-left: -1px;}
    .member-editable .btn-e {padding: 2px 8px; font-size: 11px;line-height: 1}
    .member-editable > INPUT.editable-control {position: relative;font-size: 11px;line-height: 1;z-index: 2;border: 1px solid #7a7a7a;padding-left: 8px;padding-right: 8px;}
    .panel-body .input-group-sm .form-control {font-size: 11px;padding: .25rem .5rem;height: auto}
    .panel-body .input-group-sm .btn {font-size: 11px;padding: .25rem .5rem;height: auto}
    .member-editable > INPUT.editable-control::placeholder, .member-editable > INPUT.editable-control::-webkit-input-placeholder, .panel-body INPUT::placeholder, .panel-body INPUT::-webkit-input-placeholder {font-weight: normal; color: #00aced;font-size: 11px;letter-spacing: -1px;}
    .panel-body INPUT[type="number"] {-moz-appearance: textfield;}
    .panel-body INPUT[type="number"]::-webkit-outer-spin-button,
    .panel-body INPUT[type="number"]::-webkit-inner-spin-button {-webkit-appearance: none;margin: 0;}
    .form-password {display: none; position: fixed;left: 0;top: 0;width: 100vw;height: 100vh;z-index: 501;background-color: rgba(0, 0, 0, .475);}
    .form-password .form-password-content {width: 100%;max-width: 400px;border: 1px solid #7a7a7a;padding: 15px;background-color: #fff;margin: 20% auto 0 auto;}
    button.d-block, label.d-block {display: block !important; width: 100%;}
    .help-block {color: #AA3510}
    #certification-mobile {position: relative}
    #certification-mobile .cert-dismiss {position: fixed;top: 0;left: 0;width: 100vw;z-index: 202;padding: 15px 15px 0 0;}
    #certification-mobile iframe {position: fixed;top: 0;left: 0;width: 100vw; height: 100vh;z-index: 200;}
    #certification-mobile .help-tip {position: absolute;left: 0;top: 26px;z-index: 100;display: none}
    #certification-mobile button:hover + .help-tip {display: block;}
    #certification-mobile .help-tip .alert {padding: .2rem .5rem;}
    #certification-mobile .help-tip .alert:before {content: '';position: absolute;left: 6px;top: -16px; border: 8px solid transparent;pointer-events: none;border-bottom-color: #ECB45A }
    @media (max-width: 767px) {
        .alert-helper {margin-top: 5px;}
        .shop-mypage .panel-body .op_area {display: flex;width: 100%;}
        .shop-mypage .panel-body .op_area dt {width: 20%; min-width: 20%;}
        .shop-mypage .panel-body .op_area:not(:last-child) {margin-bottom: 10px;}
    }
    .spinner, .spinner:after {
        border-radius: 50% !important;
        width: 10px;
        height: 10px;
    }
    .spinner {
        display: inline-block;
        margin: 0 0 0 -6px;
        font-size: 10px;
        position: relative;
        text-indent: -9999em;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-left-color: #fff;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation: ani-spinner 1.1s infinite linear;
        animation: ani-spinner 1.1s infinite linear;
    }
    @-webkit-keyframes ani-spinner {
        0% {-webkit-transform: rotate(0deg);transform: rotate(0deg);}
        100% {-webkit-transform: rotate(360deg);transform: rotate(360deg);}
    }
    @keyframes ani-spinner {
        0% {-webkit-transform: rotate(0deg);transform: rotate(0deg);}
        100% {-webkit-transform: rotate(360deg);transform: rotate(360deg);}
    }
    .btn-link{display: inline-block;border:1px solid;}


</style>

<div id="fakeloader"></div>

<?php /* ---------- 마이페이지 시작 ---------- */ ?>
<div id="smb_my" class="shop-mypage">
    <div class="text-right margin-bottom-10">
        <?php if ($is_admin == 'super') { ?>
            <a href="<?php echo G5_ADMIN_URL; ?>/" class="btn-e btn-e-red">관리자</a>
        <?php } ?>
        <a <?php if (!G5_IS_MOBILE) { ?>href="javascript:void(0);" onclick="memo_modal();" <?php } else { ?>href="<?php echo G5_BBS_URL; ?>/memo.php" target="_blank"<?php } ?> class="btn-e btn-e-dark">쪽지함</a>

        <!-- a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php" class="btn-e btn-e-dark">내 정보수정</a -->
        <a href="<?php echo G5_BBS_URL; ?>/register_form.php" class="btn-e btn-e-dark">내 정보수정</a>

        <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();" class="btn-e btn-e-default">회원탈퇴</a>
    </div>

    <?php /* 회원정보 개요 시작 */ ?>
    <div class="panel-group accordion-default">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="fas fa-user-circle margin-right-5"></i>
                    <a href="#mypage_panel" data-toggle="collapse">
                        <strong><?php echo $member['mb_name']; ?></strong>
                    </a>
                    <?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE): ?>
                        <div class="ext-btn">
                            <a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank" class="btn-e btn-e-xs btn-e-dark">포인트
                                조회</a>
                            <a href="<?php echo G5_SHOP_URL; ?>/coupon.php" target="_blank" class="btn-e btn-e-xs btn-e-dark">쿠폰
                                조회</a>
                        </div>
                    <?php endif; ?>
                </h4>
                <div class="margin-top-10">
                    <span>보유포인트</span>
                    <a <?php if (!G5_IS_MOBILE) { ?>href="javascript:void(0);" onclick="point_modal();" <?php } else { ?>href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank"<?php } ?>><u class="color-red"><strong><?php echo number_format($member['mb_point']); ?></strong></u></a>
                    점
                    <a <?php if (!G5_IS_MOBILE) { ?>href="javascript:void(0);" onclick="point_modal();" <?php } else { ?>href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank"<?php } ?> class="btn-e btn-e-xs btn-e-default margin-left-5 hidden-xs">상세보기</a>
                    <span class="margin-left-10 margin-right-10 color-light-grey">/</span>
                    <span>보유쿠폰</span>
                    <a <?php if (!G5_IS_MOBILE) { ?>href="javascript:void(0);" onclick="coupon_modal();" <?php } else { ?>href="<?php echo G5_SHOP_URL; ?>/coupon.php" target="_blank"<?php } ?>><u class="color-red"><strong><?php echo number_format($cp_count); ?></strong></u></a>
                    개
                    <a <?php if (!G5_IS_MOBILE) { ?>href="javascript:void(0);" onclick="coupon_modal();" <?php } else { ?>href="<?php echo G5_SHOP_URL; ?>/coupon.php" target="_blank"<?php } ?> class="btn-e btn-e-xs btn-e-default margin-left-5 hidden-xs">상세보기</a>
                    <dl class="mypage-agent-group">
                        <dt><i class="fas fa-map-marked-alt"></i> 대리점</dt>
                        <dd>
                            <?php if (empty($member['mb_1']) === true): ?>
                                <form name="frmAgent" class="form-inline">
                                    <input type="hidden" name="scope" value="agent" />
                                    <input type="hidden" name="passwd" value="" />

                                    <div class="member-editable">
                                        <label class="list-box editable-control">
                                            <select name="state" data-label="state">
                                                <option value="">지역 선택</option>
                                                <?php foreach ($Agent['States'] as $code => $title) print sprintf('<option value="%s">%s</option>', $code, $title); ?>
                                            </select>
                                        </label>
                                        <label class="list-box editable-control">
                                            <select name="agent" data-label="agent" disabled>
                                                <option value="">대리점 선택</option>
                                            </select>
                                        </label>
                                        <button type="submit" class="btn-e btn-e-red editable-control">등록</button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <strong class="color-indigo"><?php echo implode(' ', $member['agent']); ?></strong>
                            <?php endif ?>
                        </dd>
                    </dl>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div id="mypage_panel" class="panel-collapse collapse in">
                <div class="panel-body">
                    <dl class="op_area">
                        <dt>연락처</dt>
                        <dd><?php echo($member['mb_tel'] ? $member['mb_tel'] : '미등록'); ?></dd>
                    </dl>
                    <dl class="op_area">
                        <dt>이메일</dt>
                        <dd><?php echo($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></dd>
                    </dl>
                    <dl class="op_area">
                        <dt>접속일시</dt>
                        <dd><?= (new DateTime($member['mb_today_login']))->format('Y-m-d H:i'); ?></dd>
                    </dl>
                    <dl class="op_area">
                        <dt>가입일시</dt>
                        <dd><?= (new DateTime($member['mb_datetime']))->format('Y-m-d H:i'); ?></dd>
                    </dl>
                    <dl class="op_area">
                        <dt>주소</dt>
                        <dd><?php echo sprintf("(%s%s)", $member['mb_zip1'], $member['mb_zip2']) . ' ' . print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?></dd>
                    </dl>
                    <?php if ($config['cf_use_recommend']): ?>
                        <dl class="op_area">
                            <dt>추천인</dt>
                            <dd><?php
                                if (empty($member['mb_recommend']) !== true) {
                                    $mentor = empty($member['mentor']) !== true ? substr(str_replace('-', '', $member['mentor']['mb_hp']), -8) : '';
                                    if (empty($member['mentor']) !== true) {
                                        $len = strlen($member['mentor']['mb_name']);
                                        print substr($member['mentor']['mb_name'], 0, 1) . str_repeat('*', max($len - 2, 1));
                                        $len > 2 && print (substr($member['mentor']['mb_name'], $len - 1, 1));
                                        print  ' (' . substr($member['mentor']['mb_hp'], -4) . ')';
                                    }
                                    else {
                                        print '<span class="color-grey">탈퇴 또는 정지된 추천인</span>';
                                    }
                                }
                                else {
                                    print '<span class="color-grey">미등록</span>';
                                }
                                ?>

                            </dd>
                        </dl>
                    <?php endif; ?>
                </div>

            </div>

        </div>
        <a href="#mypage_panel" data-toggle="collapse" class="panel-oc-btn">
            <i class="fas fa-caret-up"></i>
            <i class="fas fa-caret-down"></i>
        </a>

    </div>
    <?php /* 회원정보 개요 끝 */ ?>

    <?php /* 최근 주문내역 시작 */ ?>
    <div class="margin-bottom-50">
        <div class="headline-short">
            <h4><strong>최근 주문내역</strong></h4>
            <a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php" class="headline-btn btn-e btn-e-brd btn-e-default"><i class="fas fa-plus"></i>
                더보기</a>
        </div>
        <?php
        // 최근 주문내역
        define("_ORDERINQUIRY_", true);

        $limit = " limit 0, 5 ";
        include $skin_dir . '/orderinquiry.sub.php';
        ?>
    </div>
    <?php /* 최근 주문내역 끝 */ ?>

    <?php /* 최근 위시리스트 시작 */ ?>
    <div class="mypage-wishlist-wrap">
        <div class="headline-short">
            <h4><strong>최근 위시리스트</strong></h4>
            <a href="<?php echo G5_SHOP_URL; ?>/wishlist.php" class="headline-btn btn-e btn-e-brd btn-e-default"><i class="fas fa-plus"></i>
                더보기</a>
        </div>
        <div class="mypage-wishlist-container">
            <?php for ($i = 0; $i < $wish_count; $i++) { ?>
                <div class="mypage-wishlist-box">
                    <div class="mypage-wishlist-box-pd">
                        <div class="mypage-wishlist-box-in">
                            <div class="mypage-wishlist-img">
                                <?php echo $wish_list[$i]['image']; ?>
                            </div>
                            <h5>
                                <a href="<?php echo shop_item_url($wish_list[$i]['it_id']); ?>"><strong><?php echo stripslashes($wish_list[$i]['it_name']); ?></strong></a>
                            </h5>
                            <div class="mypage-wishlist-date">
                                <i class="far fa-clock"></i> <?php echo $wish_list[$i]['wi_time']; ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php if ($wish_count == 0) { ?>
            <div class="text-center color-grey margin-top-20"><i class="fas fa-exclamation-circle"></i> 보관 내역이 없습니다.
            </div>
        <?php } ?>
    </div>
    <?php /* 최근 위시리스트 끝 */ ?>
</div>


<section class="form-password">
    <div class="form-password-content">
        <form name="frmConfirmPassword">
            <div class="form-group">
                <label for="confirm-password" class="d-block">비밀번호
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-append fas fa-lock"></i></span>
                    <input type="password" name="confirm" class="form-control" id="confirm-password" placeholder="비밀번호" required />
                </div>
            </div>
            <div class="help-block">
                <i class="fas fa-exclamation-circle"></i> 회원님의 정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.
            </div>
            <button type="submit" class="btn-e btn-e-red btn-e-lg d-block">확인</button>
        </form>
    </div>
</section>


<script type="text/javascript">
    function showPasswordModal(target) {
        $('SECTION.form-password').show().find('form[name="frmConfirmPassword"]').data('form', 'FORM[name="' + $(target).attr('name') + '"]');
    }

    $(function () {
        $('FORM[name="frmConfirmPassword"]').submit(function (event) {
            event.preventDefault();
            var target = $($(this).data('form'));

            if (target.length > 0 && target.find('INPUT[name="passwd"]').length > 0) {
                target.find('INPUT[name="passwd"]').val(this.confirm.value);
                target.submit();
            }
            $('SECTION.form-password').hide(0);
        }).find('BUTTON[data-dismiss="modal"]').on('click', function () {
            $('SECTION.form-password').hide(0);
        });

        <?php /* 대리점 미등록 상태*/ if (empty($member['mb_1']) === true) : ?>
        (function () {
            var form = $('FORM[name="frmAgent"]'), agents = <?=json_encode(getAgentToArray())?>;
            form.find('SELECT[name="state"]').on('change', function () {
                var parent = $(this).val(), $el = form.find('SELECT[name="agent"]'), code;
                $el.find('OPTION').not(':eq(0)').remove();
                if (!parent || !agents.hasOwnProperty(parent)) {
                    $el.attr('disabled', true);
                    return true;
                }
                for (code in agents[parent]) {
                    if (!agents[parent].hasOwnProperty(code)) continue;
                    $('<option />').text(agents[parent][code]).val(code).appendTo($el);
                }
                $el.removeAttr('disabled');
            });


            form.submit(function (event) {
                event.preventDefault();
                var el = form.find('SELECT[name="agent"]');

                if (!form.find('SELECT[name="state"]').val()) {
                    alert('등록할 대리점 지역을 선택하세요.');
                    form.find('SELECT[name="state"]').focus();
                    return false;
                }
                else if (!el.val()) {
                    alert('등록할 대리점을 선택하세요.');
                    el.focus();
                    return false;
                }
                <?php  /* 소셜 회원이 아닌 경우*/ if(empty($member['mb_2']) == true):?>
                else if (!form.find('INPUT[name="passwd"]').val()) {
                    showPasswordModal(this);
                    return false;
                }
                <?php endif;?>
                else if (!confirm('"' + el.find('option:selected').text() + '" 대리점으로 등록 후 변경이 불가능합니다.\n계속 진행하시려면 [확인] 버튼을 누르세요.')) {
                    return false;
                }

                $.post('<?=G5_BBS_URL?>/ajax.mb_update.php', form.serialize(), function (response) {
                    response.message && alert(response.message);
                    response.code == 200 && window.location.reload(true);
                    if (response.code == 401) {
                        $('SECTION.form-password').show().find('INPUT[type="password"]:eq(0)').focus();
                        form.find('INPUT[name="passwd"]').val('');
                    }
                });

            });
        })();
        <?php endif?>

        <?php /*휴대폰 본인인증 미완료 상태*/ if ($config['cf_cert_hp'] && !$member['mb_certify']) :
        $EndPoints = [
            'kcb' => G5_OKNAME_URL . '/hpcert1.php'
            , 'kcp' => G5_KCPCERT_URL . '/kcpcert_form.php'
            , 'lg' => G5_LGXPAY_URL . '/AuthOnlyReq.php'
        ];
        ?>
        (function () {
            var container = $('#certification-mobile'), form = container.find('FORM.form-cert-hp'), toggle = container.find('button');
            form.on('submit', function (event) {
                event.preventDefault();
                if (!form.find('INPUT[name="cert_no"]').val()) return false;

                <?php  /* 소셜 회원이 아닌 경우*/ if(empty($member['mb_2']) == true):?>
                if (!form.find('INPUT[name="passwd"]').val()) {
                    showPasswordModal(this);
                    return false;
                }
                <?php endif;?>

                toggle.attr('disabled', true).html('<i class="spinner"></i> 확인 중 ...');

                $.post('<?=G5_BBS_URL?>/ajax.mb_update.php', form.serialize(), function (response) {
                    response.message && alert(response.message);
                    response.code == 200 && window.location.reload(true);
                    if (response.code == 401) {
                        $('SECTION.form-password').show().find('INPUT[type="password"]:eq(0)').focus();
                        form.find('INPUT[name="passwd"]').val('');
                    }
                    toggle.removeAttr('disabled').html('휴대폰 본인확인');
                });
            });

            form.data('feed', function () {
                form.submit();
            });

            toggle.on('click', function (event) {
                form.get(0).reset();
                certify_win_open('<?=$config['cf_cert_hp']?>-hp', '<?=$EndPoints[$config['cf_cert_hp']] ?>', event);
            });
        })();


        <?php /*추천인 등록 or 변경*/ elseif ($recommend_editable === true):?>
        (function () {
            var form = $('form[name="frmAttr"]');
            form.on('submit', function (event) {
                event.preventDefault();
                var input = form.find('input[name="mobileNo"]');
                if (!input.val() || !(/^([\d]{8})$/).test(input.val())) {
                    alert('통신망 번호(010)을 제외한 추천인의 휴대폰 번호 8자리를 입력하세요.');
                    input.focus();
                    return false;
                }
                else if (input.val() == '<?=$mentor?>') {
                    alert('변경하려는 추천인의 휴대폰 번호 8자리를 입력하세요.');
                    input.select().focus();
                    return false;
                }
                <?php  /* 소셜 회원이 아닌 경우*/ if(empty($member['mb_2']) == true):?>
                else if (!form.find('INPUT[name="passwd"]').val()) {
                    showPasswordModal(this);
                    return false;
                }
                <?php endif;?>


                $.post('<?=G5_BBS_URL?>/ajax.mb_update.php', form.serialize(), function (response) {
                    response.message && alert(response.message);
                    response.code == 200 && window.location.reload(true);
                    if (response.code == 401) {
                        $('SECTION.form-password').show().find('INPUT[type="password"]:eq(0)').focus();
                        form.find('INPUT[name="passwd"]').val('');
                    }
                });
            });

        })();

        <?php endif?>

    });


</script>

<?php /* ---------- 마이페이지 끝 ---------- */ ?>

<script src="<?php echo EYOOM_THEME_URL; ?>/plugins/fakeLoader/fakeLoader.min.js"></script>
<script src="<?php echo EYOOM_THEME_URL; ?>/plugins/masonry/masonry.pkgd.min.js"></script>
<script src="<?php echo EYOOM_THEME_URL; ?>/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript">
    $('#fakeloader').fakeLoader({
        timeToHide: 3000,
        zIndex: "11",
        spinner: "spinner6",
        bgColor: "#fff",
    });

    $(window).load(function () {
        $('#fakeloader').fadeOut(300);
    });

    $(document).ready(function () {
        var $container = $('.mypage-wishlist-container');
        $container.imagesLoaded(function () {
            $container.masonry({
                columnWidth: '.mypage-wishlist-box',
                itemSelector: '.mypage-wishlist-box'
            });
        });
    });

    function member_leave() {
        return confirm('정말 회원에서 탈퇴 하시겠습니까?')
    }
</script>