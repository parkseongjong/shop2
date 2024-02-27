<?php
if (!defined('_EYOOM_')) exit;
add_stylesheet('<link rel="stylesheet" href="'.EYOOM_THEME_URL.'/plugins/slick/slick.min.css" type="text/css" media="screen">',0);
?>

<?php /* eb슬라이더 편집 버튼 */ ?>
<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
<div class="btn-edit-mode-wrap <?php if ($es_master['es_state'] == '2') { ?>hidden-message<?php } ?>">
	<div class="btn-edit-mode text-center hidden-xs hidden-sm" style="top:80px">
		<div class="btn-group">
			<a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=ebslider_form&thema=<?php echo $theme; ?>&es_code=<?php echo $es_code; ?>&w=u&wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> EB슬라이더 마스터 설정</a>
			<a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=ebslider_form&thema=<?php echo $theme; ?>&es_code=<?php echo $es_code; ?>&w=u" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
				<i class="far fa-window-maximize"></i>
			</a>
			<button type="button" class="btn-e btn-e-xs btn-e-red popovers" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-content="
			<span class='font-size-11'>
			<strong class='color-indigo'>좌측 [EB슬라이더 설정하기] 버튼 클릭 후 아래 설명 참고</strong><br>
			<div class='margin-hr-5'></div>
			<span class='color-indigo'>[설정정보]</span><br>
			1. 슬라이더 마스터 제목 : 메인 슬라이더<br>
			2. 스킨선택 : shop015_two_slider<br>
			3. 아이템 링크수 : 1개<br>
			4. 아이템 이미지수 : 1개<br>
			<span class='color-indigo'>[EB 슬라이더 - 아이템 관리]</span><br>
			1. EB 슬라이더 아이템 추가 클릭<br>
			2. 대표 타이틀 입력<br>
			3. 서브 타이틀 입력<br>
			5. 연결주소 [링크] 입력 (자세히보기 버튼 출력)<br>
			6. 이미지 #1 업로드<br>
			<div class='margin-hr-5'></div>
            대표타이틀, 연결주소 [링크] #1 입력, 이미지 #1 업로드 합니다.<br>
			이미지 비율 644x430 픽셀 이미지 사용.<br>
			웹접근성을 위해 대표타이틀은 이미지 설명 내용을 입력하기 바랍니다.
			</span>
		"><i class="fas fa-question-circle"></i>
			</button>
		</div>
	</div>
</div>
<?php } ?>

<?php if (isset($es_master) && $es_master['es_state'] == '1') { // 보이기 상태에서만 출력 ?>
<style>
.two-slider-<?php echo $es_code; ?> {
    position: relative;
    overflow: hidden;
}
.two-slider-inner {
    position: relative;
    display: none
}
.two-slider-<?php echo $es_code; ?> .two-slider-list {
    margin: 0 -5px;
    padding-bottom: 20px;
}
.two-slider-<?php echo $es_code; ?> .two-slider-list .slick-slide {
    padding: 0 6px;
}
.two-slider-<?php echo $es_code; ?> .item {
    position: relative;
    outline: none;
    overflow: hidden;
}
.two-slider-<?php echo $es_code; ?> .item > a {
    display: block;
    width: 100%;
    height: 100%;
    border: 1px solid #ddd;
    transition: .3s;
}
.two-slider-<?php echo $es_code; ?> .item a:hover {
    border-color: var(--color-p-light);
}
/* 이미지 */
.two-slider-<?php echo $es_code; ?> .two-slider-image {
    position: relative;
}
/* 컨트롤 점 - 숫자 */
.two-slider-<?php echo $es_code; ?> .slick-dots {
    bottom: 0;
    padding: 0 10px;
    text-align: center;
}
.two-slider-<?php echo $es_code; ?> .slick-dots li {
    display: inline-block;
    margin: 0 1px;
    width: 30px;
    height: 3px;
    background: var(--color-p-light);
}
.two-slider-<?php echo $es_code; ?> .slick-dots li button:before {
    content: "";
    width: 100%;
    height: 3px;
    -webkit-transition: all 0.3s linear;
    -moz-transition: all 0.3s linear;
    -o-transition: all 0.3s linear;
    -ms-transition: all 0.3s linear;
    transition: all 0.3s linear
}
.two-slider-<?php echo $es_code; ?> .slick-dots li.slick-active button:before {
    background: var(--color-p-dark)
}
/* 컨트롤 좌우 */
.two-slider-<?php echo $es_code; ?> .slick-next,
.two-slider-<?php echo $es_code; ?> .slick-prev {
    opacity: 0;
    width: 40px;
    height: 40px;
    background: rgba(0,0,0,.6);
    -webkit-transition: all 0.3s linear;
    -moz-transition: all 0.3s linear;
    -o-transition: all 0.3s linear;
    -ms-transition: all 0.3s linear;
    transition: all 0.3s linear;
    border-radius: 50% !important;
}
.two-slider-<?php echo $es_code; ?> .slick-next:hover,
.two-slider-<?php echo $es_code; ?> .slick-prev:hover {
    background: rgba(0,0,0,.8);
}
.two-slider-<?php echo $es_code; ?> .slick-next {
    right: 15px;
    z-index: 1
}
.two-slider-<?php echo $es_code; ?> .slick-prev {
    left: 15px;
    z-index: 1
}
.two-slider-<?php echo $es_code; ?>:hover .slick-next {
    right: 25px;
    opacity: 1;
}
.two-slider-<?php echo $es_code; ?>:hover .slick-prev {
    left: 25px;
    opacity: 1;
}
.two-slider-<?php echo $es_code; ?> .slick-next:before,
.two-slider-<?php echo $es_code; ?> .slick-prev:before {
    content: "";
    display: block;
    position: absolute;
    top: 50%;
    width: 14px;
    height: 14px;
    margin-top: -7px;
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    transition: all 0.3s linear;
}
.two-slider-<?php echo $es_code; ?> .slick-next:before {
    right: 15px;
    border-right: 1px solid #eee;
    border-top: 1px solid #eee
}
.two-slider-<?php echo $es_code; ?> .slick-prev:before {
    left: 15px;
    border-left: 1px solid #eee;
    border-bottom: 1px solid #eee
}

.two-slider-<?php echo $es_code; ?> .item > a {position: relative}
.two-slider-<?php echo $es_code; ?> button.product-view {position: absolute;right: .5rem;top: .5rem;font-size: 1rem;margin: 0;padding: .25rem .75rem;border: 1px solid #a7a7a7;background-color:#fff; color: #333}
.two-slider-<?php echo $es_code; ?> button.product-view:hover {border-color:#FF4848;color: #FF4848}

</style>
<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
<style>
@media(max-width:1399px) {
    .two-slider-<?php echo $es_code; ?> {
        height: auto;
    }
}
@media(max-width:991px) {
    .two-slider-<?php echo $es_code; ?> .two-slider-caption {
        left: 0;
        width: 100%;
        padding: 0 80px
    }
    .two-slider-<?php echo $es_code; ?> .two-slider-caption h4 {
        font-size: 35px
    }
    .two-slider-<?php echo $es_code; ?> .two-slider-caption h5 {
        font-size: 16px
    }
}
@media(max-width:767px) {
    .two-slider-<?php echo $es_code; ?> .two-slider-image .img-pc {
        display: none
    }
    .two-slider-<?php echo $es_code; ?> .two-slider-image .img-mo {
        display: block
    }
    .two-slider-<?php echo $es_code; ?> .two-slider-caption {
        padding: 0 15px
    }
    .two-slider-<?php echo $es_code; ?> .two-slider-caption h4 {
        margin-bottom: 5px;
        font-size: 23px
    }
    .two-slider-<?php echo $es_code; ?> .two-slider-caption h5 {
        font-size: 14px
    }
    .two-slider-<?php echo $es_code; ?> .slick-dots li {
        width: 30px
    }
}
</style>
<?php } ?>

<div class="two-slider-<?php echo $es_code; ?>">
	<?php /* eb슬라이더 */ ?>
	<div class="two-slider-inner">
		<div class="two-slider-list">
		<?php if (is_array($slider)) { ?>
			<?php foreach ($slider as $k => $item) { ?>
			<div class="item item-<?php echo $k + 1 ?> hvr-act">
                <?php if ($item['href_1']) { ?>
                <a href="<?php echo $item['href_1']; ?>" target="<?php echo $item['target_1']; ?>">
                <?php } ?>
                    <div class="two-slider-image">
                        <img src="<?php echo $item['src_1']?>" alt="image" class="img-responsive">
                        <h4 class="sound_only"><?php echo $item['ei_title']?></h4>
                    </div>
                <?php if ($item['href_1']) { ?>
                    <button type="button" class="product-view">상세보기</button>
                </a>
                <?php } ?>

				<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
				<div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="bottom:30px">
					<a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&pid=ebslider_itemform&thema=<?php echo $theme; ?>&es_code=<?php echo $es_code; ?>&ei_no=<?php echo $item['ei_no']; ?>&w=u&iw=u&wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-dark"><i class="far fa-edit"></i> EB슬라이더 아이템 수정</a>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		<?php } ?>

		<?php if ($es_default) { ?>
			<div class="item hvr-act">
                <a href="">
                    <div class="two-slider-image">
                        <img src="<?php echo $ebslider_skin_url; ?>/image/01.jpg" alt="image" class="img-responsive">
                        <h4 class="sound_only">투 슬라이더 1</h4>
                    </div>
                </a>
			</div>
			<div class="item hvr-act">
                <a href="">
                    <div class="two-slider-image">
                        <img src="<?php echo $ebslider_skin_url; ?>/image/02.jpg" alt="image" class="img-responsive">
                        <h4 class="sound_only">투 슬라이더 2</h4>
                    </div>
                </a>
			</div>
			<div class="item hvr-act">
                <a href="">
                    <div class="two-slider-image">
                        <img src="<?php echo $ebslider_skin_url; ?>/image/01.jpg" alt="image" class="img-responsive">
                        <h4 class="sound_only">투 슬라이더 3</h4>
                    </div>
                </a>
			</div>
			<div class="item hvr-act">
                <a href="">
                    <div class="two-slider-image">
                        <img src="<?php echo $ebslider_skin_url; ?>/image/01.jpg" alt="image" class="img-responsive">
                        <h4 class="sound_only">투 슬라이더 4</h4>
                    </div>
                </a>
			</div>
		<?php } ?>
		</div>
	</div>
	<script src="<?php echo EYOOM_THEME_URL; ?>/plugins/slick/slick.min.js"></script>
	<script>
	$(window).load(function(){
		//시작시 애니메이션 효과 주기
		setTimeout(function() {
			$('.two-slider-<?php echo $es_code; ?> .item').addClass("item-animation");
		}, 700);

		//slick 슬라이더 설정
		$('.two-slider-<?php echo $es_code; ?> .two-slider-inner').show();
		$('.two-slider-<?php echo $es_code; ?> .two-slider-list').slick({
			slidesToShow: 2,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 8000,//8초
			arrows: true,
			dots: true,
			pauseOnHover: false,
		    <?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
		    responsive: [
		        {
                    breakpoint: 768,
		            settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
		                arrows: false
		            }
		        }
		    ]
		    <?php } ?>
		});
	});
	</script>
</div>
<?php } ?>