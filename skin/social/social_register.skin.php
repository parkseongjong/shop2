<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!$config['cf_social_login_use']) {     //소셜 로그인을 사용하지 않으면
    return;
}

$social_pop_once = false;

$self_url = G5_BBS_URL . "/login.php";

//새창을 사용한다면
G5_SOCIAL_USE_POPUP && ($self_url = G5_SOCIAL_LOGIN_URL . '/popup.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . get_social_skin_url() . '/style.css?ver=' . G5_CSS_VER . '">', 10);
$domains = [
    'naver' => '네이버'
    , 'kakao' => '카카오'
    , 'facebook' => '페이스북'
    , 'google' => '구글'
    , 'twitter' => '트위터'
    , 'payco' => '페이코'
];
?>
<div id="sns-signUp" class="sns-sign-up-form">
    <?php
    foreach (explode(',', $config['cf_social_servicelist']) as $provider) {
        $title = $domains[$provider] ?? ucfirst($provider);
        print "<a href=\"{$self_url}?provider={$provider}&amp;{$urlencode}\" class=\"sign-up-toggle\" data-label=\"{$provider}\">{$title} <i>아이디로 회원가입하기</i></a>";
    }
    ?>

    <div class="social-divider">또는</div>

</div>

<script type="text/javascript">
    $(function () {
        <?php if (G5_SOCIAL_USE_POPUP && !$social_pop_once): $social_pop_once = true;?>
        $('#sns-signUp').find('A.sign-up-toggle').not('[data-label="local"]').on('click', function (event) {
            event.preventDefault();
            var hWnd, url = $(this).attr('href');
            hWnd = window.open(url, "social_sing_on", "location=0,status=0,scrollbars=1,width=600,height=500");
            (!hWnd || hWnd.closed || typeof hWnd.closed == 'undefined') && alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');
        });
        <?php endif;?>

    })
</script>