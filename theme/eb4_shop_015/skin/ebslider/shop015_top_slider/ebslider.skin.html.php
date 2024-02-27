<?php
/**
 * skin file : /theme/THEME_NAME/skin/ebslider/top-bnnr_banner_top/ebslider.skin.html.php
 */
if (!defined('_EYOOM_')) exit;
?>

<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
<div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="top:0;z-index:10">
    <div class="btn-group">
        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=ebslider_form&thema=<?php echo $theme; ?>&es_code=<?php echo $es_code; ?>&w=u&wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> EB슬라이더 마스터 설정</a>
        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=ebslider_form&thema=<?php echo $theme; ?>&es_code=<?php echo $es_code; ?>&w=u" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
            <i class="far fa-window-maximize"></i>
        </a>
        <button type="button" class="btn-e btn-e-xs btn-e-red btn-e-split-red popovers" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-content="
        <span class='font-size-11'>
        <strong class='color-indigo'>좌측 [EB슬라이더 마스터 설정 버튼] 클릭 후 아래 설명 참고</strong><br>
        <div class='margin-hr-5'></div>
        <span class='color-indigo'>[설정정보]</span><br>
        1. 슬라이더마스터 제목 : 베너 슬라이더 상단<br>
        2. 슬라이더마스터 스킨 : shop015_top_banner<br>
        <span class='color-indigo'>[EB 슬라이더 - 아이템 관리]</span><br>
        1. EB슬라이더 아이템 추가 클릭<br>
        2. 대표 타이틀 입력 - 미출력 됨<br>
        3. 연결주소 [링크] #1 입력<br>
        4. 이미지 #1 업로드 (배너 이미지)<br>
        <div class='margin-hr-5'></div>
        대표타이틀, 연결주소 [링크] #1 입력, 이미지 #1 업로드 합니다.<br>
        이미지 비율 1920x100 픽셀 사이즈 사용.<br>
        웹접근성을 위해 대표타이틀은 이미지 설명 내용을 입력하기 바랍니다.
        </span>
        "><i class="fas fa-question-circle"></i></button>
    </div>
</div>
<?php } ?>

<?php if (isset($es_master) && $es_master['es_state'] == '1') { // 보이기 상태에서만 출력 ?>
<style>
/* master */
.top-slider {position:relative;transition:all .3s linear}
.header-fixed-trans .top-slider {margin-top:-90px;overflow:hidden}
/* 컨트롤 */
.top-slider .carousel-control {z-index:1;top:30px;width:100%;height:0}
.top-slider .carousel-control a {display:block;opacity:.8;position:absolute;z-index:1;width:30px;height:30px;line-height:30px;font-size:13px;text-align:center;color:#fff;background:rgba(0,0,0,.7);transition:.3s;border-radius:15px !important}
.top-slider .carousel-control a:hover {opacity:1;}
.top-slider .carousel-control a.control-right {right:-45px}
.top-slider .carousel-control a.control-left {left:-45px}
.top-slider:hover .carousel-control a.control-right {right:15px}
.top-slider:hover .carousel-control a.control-left {left:15px}
/* 아이템 */
.top-slider .item a {display:block;cursor:pointer}
.top-slider .item a > div {height:90px;background-size:cover;background-repeat:no-repeat;background-position:center}
/* 닫기버튼 */
.top-slider .top-bnnr-close {position:absolute;top:40px;right:50px;z-index:1;opacity:0;transition:.3s}
.top-slider:hover .top-bnnr-close {top:30px;opacity:1}
.top-slider .top-bnnr-close form {display:flex;justify-content:center}
.top-slider .top-bnnr-close label {position:relative;padding:0;margin:0}
.top-slider .top-bnnr-close label input {position:absolute;z-index:1;opacity:0;width:30px;height:30px;padding:0;margin:0;cursor:pointer}
.top-slider .top-bnnr-close label i {display:block;position:relative;z-index:10;width:30px;height:30px;line-height:30px;font-size:13px;text-align:center;background:rgba(255,255,255,.9);cursor:pointer;box-shadow: 0 0 2px rgba(0,0,0,.15);transition:.3s;border-radius:15px !important}
.top-slider .top-bnnr-close label:hover i {color:#2196f3}
.top-slider .top-bnnr-close label input:checked + i {color:#f44336}
.top-slider .top-bnnr-close label span {position:absolute;top:0;left:-110px;opacity:0;width:100px;height:30px;line-height:30px;padding:0 30px 0 10px;font-size:11px;font-weight:400;background:rgba(255,255,255,.7);box-shadow: 0 0 2px rgba(0,0,0,.15);transition:.5s;border-radius:15px !important}
.top-slider .top-bnnr-close label:hover span {opacity:1}
.top-slider .btn-close {width:30px;height:30px;margin-left:5px;line-height:30px;font-size:13px;text-align:center;background:rgba(255,255,255,.9);cursor:pointer;box-shadow: 0 0 2px rgba(0,0,0,.15);transition:.3s;border-radius:15px !important}
.top-slider .btn-close:hover {color:#2196f3}
</style>

<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
<style>
@media (max-width:1199px) {
}
@media (max-width:1199px) {
}
@media (max-width:767px) {
	.top-slider .carousel-control {display:none}
	.top-slider .item a > div {height:50px;background-size: auto 100%}
	.top-slider .top-bnnr-close {top:15px !important;right:7px;opacity:1}
	.top-slider .top-bnnr-close label i, .top-slider .btn-close {width:20px;height:20px;line-height:20px;font-size:11px}
    .top-slider .top-bnnr-close label span {display: none;}
}
</style>
<?php } ?>

<div class="top-slider">
	<div id="carouselBannerTop" class="carousel slide carousel-roll-left vertical" data-ride="carousel">
	    <?php /* 콘트롤 */ ?>
	    <div class="carousel-control">
		    <a class="slider-control control-right" data-slide="next" href="#carouselBannerTop"><i class="fas fa-chevron-right"></i></a>
		    <a class="slider-control control-left" data-slide="prev" href="#carouselBannerTop"><i class="fas fa-chevron-left"></i></a>
	    </div>

		<?php /* 아이템 */ ?>
		<div class="carousel-inner" role="listbox">
    		<?php if (is_array($slider)) { ?>
                <?php foreach ($slider as $k => $item) { ?>
                <div class="item item-<?php echo $k + 1 ?> hvr-act">
                    <?php if ($item['href_1']) { ?>
                    <a href="<?php echo $item['href_1']; ?>" target="<?php echo $item['target_1']; ?>">
                    <?php } ?>
                        <div class="top-bnnr-img" style="background-image:url(<?php echo $item['src_1']?>)">
                            <h4 class="sound_only"><?php echo $item['ei_title']?></h4>
                        </div>
                    <?php if ($item['href_1']) { ?>
                    </a>
                    <?php } ?>

                    <?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
                    <div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="bottom:5px">
                        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&pid=ebslider_itemform&thema=<?php echo $theme; ?>&es_code=<?php echo $es_code; ?>&ei_no=<?php echo $item['ei_no']; ?>&w=u&iw=u&wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-dark btn-e-split"><i class="far fa-edit"></i> EB슬라이더 아이템 수정</a>
                        <button type="button" class="btn-e btn-e-xs btn-e-dark btn-e-split-dark popovers" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-content="
                        <span class='font-size-11'>
                        <span class='color-indigo'>[EB 슬라이더 - 아이템 관리]</span><br>
                        1. 대표 타이틀 입력<br>
                        2. 서브 타이틀 입력<br>
                        4. 연결주소 [링크] #1 입력<br>
                        4. 이미지 #1 업로드 (배너 이미지)<br>
                        <div class='margin-hr-5'></div>
                        이미지 비율 620x300 픽셀 사이즈 권장
                        </span>
                        "><i class="fas fa-question-circle"></i></button>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            <?php } ?>

            <?php if ($es_default) { ?>
            <div class="item item-1 hvr-act">
                <a href="">
                    <div class="top-bnnr-img" style="background-image:url(<?php echo $ebslider_skin_url; ?>/image/01.jpg)">
                        <h4 class="sound_only">탑 슬라이더 1</h4>
                    </div>
                </a>
            </div>
            <div class="item item-2 hvr-act">
                <a href="">
                    <div class="top-bnnr-img" style="background-image:url(<?php echo $ebslider_skin_url; ?>/image/02.jpg)">
                        <h4 class="sound_only">탑 슬라이더 2</h4>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>

	<div class="top-bnnr-close">
        <form method="post" name="sbtclose_form" class="eyoom-form">
            <label><input type="checkbox" id="check_close"><i class="fas fa-check"></i><span>하루동안 열지 않기</span></label>
            <div class="btn-close" id="sbt_close"><i class="fas fa-times"></i></div>
        </form>
    </div>
</div>

<script>
// 슬라이더 시간 설정
$(document).ready(function(){
	$(".top-slider .item").eq(0).addClass("active");
	$("#carouselBannerTop").carousel({
        interval: 8000,
        pause: 'hover'
    });
});

// 쿠키를 통해 배너를 하루동안 열지 않기
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    var date = new Date();
    date.setTime(date.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+date.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function bannerTopClose(){
    if($("#check_close").is(":checked") == true){
        setCookie("close","Y",1);
    }
    $(".top-slider").hide();
}

$(document).ready(function(){
    cookiedata = document.cookie;
    if(cookiedata.indexOf("close=Y")<0){
        $(".top-slider").show();
    }else{
        $(".top-slider").hide();
    }
    $("#sbt_close").click(function(){
        bannerTopClose();
    });
});
</script>
<?php } ?>