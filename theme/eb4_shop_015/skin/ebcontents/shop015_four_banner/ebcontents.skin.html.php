<?php
if (!defined('_EYOOM_')) exit;
?>
<?php /* eb콘텐츠 편집 버튼 */ ?>
<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
<div class="btn-edit-mode-wrap <?php if ($ec_master['ec_state'] == '2') { ?>hidden-message<?php } ?>">
    <div class="btn-edit-mode text-center hidden-xs hidden-sm">
        <div class="btn-group">
            <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=ebcontents_form&amp;thema=<?php echo $theme; ?>&amp;ec_code=<?php echo $ec_master['ec_code']; ?>&amp;w=u&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> EB컨텐츠 마스터 설정</a>
            <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=ebcontents_form&amp;thema=<?php echo $theme; ?>&amp;ec_code=<?php echo $ec_master['ec_code']; ?>&amp;w=u" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
                <i class="far fa-window-maximize"></i>
            </a>
            <button type="button" class="btn-e btn-e-xs btn-e-red popovers" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-content="
                <span class='font-size-11'>
            <strong class='color-indigo'>좌측 [EB컨텐츠 설정하기 버튼] 클릭 후 아래 설명 참고</strong><br>
            <div class='margin-hr-5'></div>
            <span class='color-indigo'>[설정정보]</span><br>
            1. 컨텐츠 마스터 제목 : icons<br>
            2. 스킨선택 : shop015_four_banner<br>
            3. 컨텐츠 아이템에서 사용할 링크수 : 1개<br>
            4. 컨텐츠 아이템에서 사용할 이미지수 : 1개<br>
            5. 컨텐츠 아이템에서 사용할 필드수 : 1개<br>
            <span class='color-indigo'>[EB 컨텐츠 - 아이템 관리]</span><br>
            1. EB컨텐츠 아이템 추가 클릭<br>
            2. 텍스트 필드 #1 입력<br>
            3. 연결주소 [링크] 입력 (자세히보기 버튼 출력)<br>
            4. 이미지 #1 업로드<br>
            <div class='margin-hr-5'></div>
            이미지 비율 550x300 픽셀 이미지 사용.<br>
            아이템 4개에 맞춰 디자인.<br>
			웹접근성을 위해 텍스트 필드 #1은 이미지 설명 내용을 입력하기 바랍니다.
            </span>
            "><i class="fas fa-question-circle"></i></button>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($ec_master) && $ec_master['ec_state'] == '1') { // 보이기 상태에서만 출력 ? ?>
<style>
.ebcontents-four-banner {
	padding: 5px 0 10px;
}
.ebcontents-four-banner .item {
    position: relative
}
.ebcontents-four-banner .item-box {}
.ebcontents-four-banner .item-box a {
	display: block;
    position: relative;
	border: 1px solid #ddd;
	transition: .3s;
}
.ebcontents-four-banner .item-box a:hover {
	border-color: var(--color-p-light);
}
.ebcontents-four-banner .item-box .item-image {}
.ebcontents-four-banner .item-box .item-image img {}
.ebcontents-four-banner button.product-view {position: absolute;right: .5rem;bottom: .5rem;font-size: 1rem;margin: 0;padding: .25rem .75rem;border: 1px solid #a7a7a7;background-color:#fff; color: #333}
.ebcontents-four-banner button.product-view:hover {border-color:#FF4848;color: #FF4848}
</style>

<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
<style>
@media (max-width:1199px){
	.ebcontents-four-banner .item-box .item-content {
		width:80%;
	}
	.ebcontents-four-banner .item-box h4 {
		font-size:18px;
	}
}
@media (max-width:767px){
	.ebcontents-four-banner .item-box .item-content {
		width:100%;
		padding:0 15px;
	}
	.ebcontents-four-banner .item-box h4 {
		margin-bottom:5px;
		font-size:16px;
	}
	.ebcontents-four-banner .item-box p {
		font-size:13px;
	}
}
</style>
<?php } ?>

<div class="ebcontents ebcontents-four-banner">
    <div class="f-row g-3">
    <?php /* ebcontents item */?>
    <?php if (is_array($contents)) { ?>
        <?php foreach ($contents as $k => $item) { ?>
    	<div class="f-col-6 f-col-lg-3">
	    	<div class="item item-<?php echo $k + 1 ?>">
	            <div class="item-box hvr-act">
					<?php if ($item['href_1']) { ?>
                    <a href="<?php echo $item['href_1']; ?>" target="<?php echo $item['target_1']; ?>">
                    <?php } ?>
						<div class="item-image">
							<img src="<?php echo $item['src_1']?>" alt="<?php echo $item['ci_subject_1']; ?>" class="img-responsive">
							<h4 class="sound_only"><?php echo $item['ci_subject_1']; ?></h4>
						</div>
					<?php if ($item['href_1']) { ?>
                        <button type="button" class="product-view">상세보기</button>
                    </a>
                    <?php } ?>
	            </div>
	        </div>
    	</div>
        <?php } ?>
    <?php } ?>

    <?php if ($ec_default) { ?>
    	<div class="f-col-6 f-col-lg-3">
	    	<div class="item item-1">
	            <div class="item-box hvr-act">
					<a href="">
						<div class="item-image">
							<img src="<?php echo $ebcontents_skin_url; ?>/image/01.jpg" alt="image" class="img-responsive">
							<h4 class="sound_only">포 배너 1 </h4>
						</div>
					</a>
	            </div>
	        </div>
    	</div>
    	<div class="f-col-6 f-col-lg-3">
	    	<div class="item item-2">
	            <div class="item-box hvr-act">
					<a href="">
						<div class="item-image">
							<img src="<?php echo $ebcontents_skin_url; ?>/image/02.jpg" alt="image" class="img-responsive">
							<h4 class="sound_only">포 배너 2</h4>
						</div>
					</a>
	            </div>
	        </div>
    	</div>
    	<div class="f-col-6 f-col-lg-3">
	    	<div class="item item-1">
	            <div class="item-box hvr-act">
					<a href="">
						<div class="item-image">
							<img src="<?php echo $ebcontents_skin_url; ?>/image/03.jpg" alt="image" class="img-responsive">
							<h4 class="sound_only">포 배너 3</h4>
						</div>
					</a>
	            </div>
	        </div>
    	</div>
    	<div class="f-col-6 f-col-lg-3">
	    	<div class="item item-2">
	            <div class="item-box hvr-act">
					<a href="">
						<div class="item-image">
							<img src="<?php echo $ebcontents_skin_url; ?>/image/04.jpg" alt="image" class="img-responsive">
							<h4 class="sound_only">포 배너 4</h4>
						</div>
					</a>
	            </div>
	        </div>
    	</div>
    <?php } ?>
    </div>
</div>
<?php } ?>