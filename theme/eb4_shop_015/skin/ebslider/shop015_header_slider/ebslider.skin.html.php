<?php
if (!defined('_EYOOM_')) exit;
add_stylesheet('<link rel="stylesheet" href="'.EYOOM_THEME_URL.'/plugins/slick/slick.min.css" type="text/css" media="screen">',0);
?>

<?php /* eb슬라이더 편집 버튼 */ ?>
<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
<div class="btn-edit-mode-wrap <?php if ($es_master['es_state'] == '2') { ?>hidden-message<?php } ?>">
	<div class="btn-edit-mode text-center hidden-xs hidden-sm">
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
			1. 슬라이더 마스터 제목 : 헤더 슬라이더<br>
			2. 스킨선택 : shop015_header_slider<br>
			3. 아이템 링크수 : 1개<br>
			4. 아이템 이미지수 : 1개<br>
			<span class='color-indigo'>[EB 슬라이더 - 아이템 관리]</span><br>
			1. EB 슬라이더 아이템 추가 클릭<br>
			2. 연결주소 [링크] 입력 (자세히보기 버튼 출력)<br>
			3. 이미지 #1업로드<br>
			<div class='margin-hr-5'></div>
			헤더 슬라이더(EB슬라이더)는 992px 이상에서만 출력됩니다.<br>
			대표타이틀, 연결주소 [링크] #1 입력, 이미지 #1 업로드 합니다.<br>
			이미지 비율 620x300 픽셀 이미지 사용.<br>
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
.header-slider {position:relative;width:250px}
.header-slider-inner {position:relative;overflow:hidden;display:none}
.header-slider .header-slider-list {margin-bottom:0}
.header-slider .header-slider-item {position:relative;outline:none;overflow:hidden}
/* 이미지 */
.header-slider .header-slider-image {position:relative}
.header-slider .header-slider-image a {display:block}
.header-slider .header-slider-image img {max-height:120px;width:auto}
/* 컨트롤 점 - 숫자 */
.header-slider .slick-dots {
    bottom: 10px;
    text-align: center;
}
.header-slider .slick-dots li {
    display: inline-block;
	overflow: hidden;
    margin: 0 2px;
    width: 10px;
    height: 10px;
    background: #ccc;
	border-radius: 50% !important;
}
.slick-dots li button {
    width: 10px;
    height: 10px;
	padding: 0;
}
.header-slider .slick-dots li button:before {
    content: "";
    width: 100%;
    height: 10px;
    -webkit-transition: all 0.3s linear;
    -moz-transition: all 0.3s linear;
    -o-transition: all 0.3s linear;
    -ms-transition: all 0.3s linear;
    transition: all 0.3s linear
}
.header-slider .slick-dots li.slick-active button:before {
    background: var(--color-primary);
}
</style>

<div class="header-slider header-slider-<?php echo $es_code; ?>">
	<?php /* eb슬라이더 */ ?>
	<div class="header-slider-inner">
		<div class="header-slider-list">
		<?php if (is_array($slider)) { ?>
			<?php foreach ($slider as $k => $item) { ?>
			<div class="header-slider-item item-<?php echo $k + 1 ?>">
				<div class="header-slider-image">
					<?php if ($item['href_1']) { ?>
                    <a href="<?php echo $item['href_1']; ?>" target="<?php echo $item['target_1']; ?>">
                    <?php } ?>
						<img src="<?php echo $item['src_1']?>" alt="<?php echo $item['ei_title']?>">
						<h4 class="sound_only"><?php echo $item['ei_title']?></h4>
					<?php if ($item['href_1']) { ?>
                    </a>
                    <?php } ?>
				</div>

				<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
				<div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="bottom:0">
					<a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&pid=ebslider_itemform&thema=<?php echo $theme; ?>&es_code=<?php echo $es_code; ?>&ei_no=<?php echo $item['ei_no']; ?>&w=u&iw=u&wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-dark"><i class="far fa-edit"></i> EB슬라이더 아이템 수정</a>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		<?php } ?>

		<?php if ($es_default) { ?>
			<div class="header-slider-item">
				<div class="header-slider-image">
    				<a href="">
						<img src="<?php echo $ebslider_skin_url; ?>/image/01.jpg" alt="image">
						<h4 class="sound_only">헤더 슬라이더 1</h4>
					</a>
				</div>
			</div>
			<div class="header-slider-item">
				<div class="header-slider-image">
    				<a href="">
						<img src="<?php echo $ebslider_skin_url; ?>/image/01.jpg" alt="image">
						<h4 class="sound_only">헤더 슬라이더 2</h4>
					</a>
				</div>
			</div>
			<div class="header-slider-item">
				<div class="header-slider-image">
    				<a href="">
						<img src="<?php echo $ebslider_skin_url; ?>/image/01.jpg" alt="image">
						<h4 class="sound_only">헤더 슬라이더 3</h4>
					</a>
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
	<script src="<?php echo EYOOM_THEME_URL; ?>/plugins/slick/slick.min.js"></script>
	<script>
	$(window).load(function(){
		//slick 슬라이더 설정
		$('.header-slider-<?php echo $es_code; ?> .header-slider-inner').show();
		$('.header-slider-<?php echo $es_code; ?> .header-slider-list').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 10000,//10초
			arrows: false,
			dots: true,
			pauseOnHover: false,
		});
	});
	</script>
</div>
<?php } ?>