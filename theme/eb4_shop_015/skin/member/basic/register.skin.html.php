<?php
/**
 * skin file : /theme/THEME_NAME/skin/member/basic/register.skin.html.php
 */
if (!defined('_EYOOM_')) exit;

require_once __DIR__.'/_signup.skin.html.php';
return ;

add_stylesheet('<link rel="stylesheet" href="'.EYOOM_THEME_URL.'/plugins/perfect-scrollbar/perfect-scrollbar.min.css" type="text/css" media="screen">',0);
add_stylesheet('<link rel="stylesheet" href="'.EYOOM_THEME_URL.'/plugins/sweetalert/sweetalert.min.css" type="text/css" media="screen">',0);
?>

<style>
    .member-skin {font-size:12px}
    .member-skin .content-box {border-color:#b5b5b5}
    .member-skin .p-0 {padding: 0 !important;}
    .member-skin .p-0::before, .member-skin .panel-body:before {display: inline; content: '';}

    .member-skin #register_scroll_1 {position:relative;overflow:hidden;height:250px; white-space: pre-wrap}
    .member-skin #register_scroll_2 {position:relative;overflow:hidden;height:250px; white-space: pre-wrap}

    .member-skin .member-box {border:1px solid #ddd;margin-bottom:30px}
    .member-skin .eyoom-form header {padding:15px;background:#fafafa}
    .member-skin .eyoom-form footer {padding:10px 15px;text-align:right}
    .member-skin .eyoom-form fieldse {padding:0}
    .member-skin .eyoom-form fieldset {padding:0}
    .member-skin .member-agree {padding:15px}
    .member-skin .fregister-agree label {display:inline-block;margin-right:5px}
    .member-skin #sns_register {border:1px solid #d5d5d5;box-shadow:none;margin-bottom:30px}
    .member-skin #sns_register h2 {margin:0;padding:15px;font-weight:bold;background:#fafafa;font-size:15px}
    <?php if(G5_IS_MOBILE){?>
    #show {display : none}
    <?php }?>
</style>

<div class="member-skin contents-box-inner">
    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    @include_once(get_social_skin_path().'/social_register.skin.php');
    ?>

    <form name="fregister" id="fregister" action="<?php echo $register_action_url; ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off" class="eyoom-form">

        <div id="show">
            <div class="content-box margin-bottom-30 show">
                <div class="content-box-body">
                    <p><i class="fas fa-exclamation-circle"></i> <strong>회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</strong></p>
                </div>
                <div class="content-box-footer">
                    <div class="fregister-agree">
                        <label class="checkbox" for="agree_all">
                            <input type="checkbox" name="agree_all" value="1" id="agree_all"><i></i><span>아래 약관 및 안내 내용에 <u class="color-red">모두 동의</u></span>
                        </label>
                    </div>
                </div>
            </div>

            <section id="fregister_term" class="member-box">
                <header><h5 class="margin-0"><strong>회원가입약관</strong></h5></header>
                <div class="member-agree p-0">
                    <div id="register_scroll_1" class="panel-body ps-container"><?=html_purifier($config['cf_stipulation']);### @include_once(EYOOM_THEME_PATH . '/page/provision.html.php')?></div>
                </div>
                <footer>
                    <fieldset class="fregister-agree">
                        <label class="checkbox" for="agree11">
                            <input type="checkbox" name="agree" value="1" id="agree11"><i></i>회원가입약관의 내용에 동의합니다.
                        </label>
                    </fieldset>
                </footer>
            </section>

            <section id="fregister_private" class="member-box">
                <header><h5 class="margin-0"><strong>개인정보처리방침안내</strong></h5></header>
                <div class="member-agree p-0">
                    <div id="register_scroll_2" class="panel-body ps-container"><?=html_purifier($config['cf_privacy']);?></div>
                </div>
                <footer>
                    <fieldset class="fregister-agree">
                        <label class="checkbox" for="agree21">
                            <input type="checkbox" name="agree2" value="1" id="agree21"><i></i>개인정보처리방침안내의 내용에 동의합니다.
                        </label>
                    </fieldset>
                </footer>
            </section>

            <div class="btn_confirm text-center">
                <button class="btn-e btn-e-xlg btn-e-red" type="submit" value="회원가입"><i class="fas fa-sign-in-alt"></i> 회원가입</button>
            </div>

    </form>
</div>
</div>
<script src="<?php echo EYOOM_THEME_URL; ?>/plugins/perfect-scrollbar/perfect-scrollbar.jquery.min.js"></script>
<script src="<?php echo EYOOM_THEME_URL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        new PerfectScrollbar('#register_scroll_1');
        new PerfectScrollbar('#register_scroll_2');
    });

    function fregister_submit(f) {
        if (!f.agree.checked) {
            swal({
                title: "중요!",
                text: "회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.",
                confirmButtonColor: "#FF9500",
                type: "warning",
                confirmButtonText: "확인"
            });
            f.agree.focus();
            return false;
        }
        if (!f.agree2.checked) {
            swal({
                title: "중요!",
                text: "개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.",
                confirmButtonColor: "#FF9500",
                type: "warning",
                confirmButtonText: "확인"
            });
            f.agree2.focus();
            return false;
        }
        return true;
    }

    $(function(){
        $("#agree_all").click(function(){
            if ($(this).is(':checked')) {
                $("input:checkbox[id='agree11']").prop("checked", true);
                $("input:checkbox[id='agree21']").prop("checked", true);
            } else {
                $("input:checkbox[id='agree11']").prop("checked", false);
                $("input:checkbox[id='agree21']").prop("checked", false);
            }
        });
    });

    function show(){ // 이메일 show and hide
        var el = $('#show');
        if(el.is(':visible')) {
            el.hide();
        } else {
            el.show();
        }
    }
</script>