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
            <button type="button" class="btn-e btn-e-xs btn-e-red popovers" data-container="body" data-toggle="popover" data-placement="top" data-html="true" data-content="
            <span class='font-size-11'>
            <strong class='color-indigo'>좌측 [EB컨텐츠 설정하기 버튼] 클릭 후 아래 설명 참고</strong><br>
            <div class='margin-hr-5'></div>
            <span class='color-indigo'>[설정정보]</span><br>
            1. 컨텐츠 마스터 제목 : banner<br>
            2. 스킨선택 : shop015_two_banner<br>
            3. 컨텐츠 아이템에서 사용할 링크수 : 1개<br>
            4. 컨텐츠 아이템에서 사용할 이미지수 : 1개<br>
            5. 컨텐츠 아이템에서 사용할 필드수 : 1개<br>
            <span class='color-indigo'>[EB 컨텐츠 - 아이템 관리]</span><br>
            1. EB컨텐츠 아이템 추가 클릭<br>
            2. 텍스트 필드 #1 입력<br>
            3. 연결주소 [링크] #1 입력<br>
            4. 이미지 #1 업로드<br>
            <div class='margin-hr-5'></div>
            아이템 이미지만 출력되는 스킨으로 이미지, 연결주소 입력<br>
            이미지 비율 500x470픽셀 이미지 사용 <br>
            EB컨텐츠 아이템 2개로 맞춰 디자인<br>
			웹접근성을 위해 텍스트 필드 #1은 이미지 설명 내용을 입력하기 바랍니다.
            </span>
            "><i class="fas fa-question-circle"></i></button>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($ec_master) && $ec_master['ec_state'] == '1') { // 보이기 상태에서만 출력 ? ?>
<style>
.ebcontents-two-banner-<?php echo $ec_code; ?> {position:relative}
.ebcontents-two-banner-<?php echo $ec_code; ?> .item {position:relative}
.ebcontents-two-banner-<?php echo $ec_code; ?> .item-1 {
    margin-bottom: 10px;
}
/* 타이틀 */
.ebcontents-two-banner-<?php echo $ec_code; ?> .item a {
    display: block;
}
</style>

<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
<style>
@media (max-width:991px){
    .ebcontents-two-banner-<?php echo $ec_code; ?> .ebcontents-two-banner-inner {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -5px;
    }
    .ebcontents-two-banner-<?php echo $ec_code; ?> .ebcontents-two-banner-inner .item {
        flex: 0 0 50%;
        min-width: 50%;
        padding: 0 5px;
    }
    .ebcontents-two-banner-<?php echo $ec_code; ?> .item-1 {
        margin-bottom: 0;
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

<div class="ebcontents ebcontents-two-banner-<?php echo $ec_code; ?>">
    <?php /* ebcontents item */?>
    <div class="ebcontents-two-banner-inner">
        <?php if (is_array($contents)) { ?>
            <?php foreach ($contents as $k => $item) { ?>
            <div class="item item-<?php echo $k + 1 ?> hvr-act">
                <?php if ($item['href_1']) { ?>
                <a href="<?php echo $item['href_1']; ?>" target="<?php echo $item['target_1']; ?>">
                <?php } ?>
	                <img src="<?php echo $item['src_1']?>" alt="<?php echo $item['ci_subject_1']; ?>" class="img-responsive">
                    <h4 class="sound_only"><?php echo $item['ci_subject_1']; ?></h4>
                <?php if ($item['href_1']) { ?>
                </a>
                <?php } ?>
            </div>
            <?php } ?>
        <?php } ?>

        <?php if ($ec_default) { ?>
            <div class="item item-1 hvr-act">
	            <a href="">
	                <img src="<?php echo $ebcontents_skin_url; ?>/image/01.jpg" alt="image" class="img-responsive">
                    <h4 class="sound_only">투 배너 1</h4>
                </a>
            </div>
            <div class="item item-2 hvr-act">
	            <a href="">
	                <img src="<?php echo $ebcontents_skin_url; ?>/image/02.jpg" alt="image" class="img-responsive">
                    <h4 class="sound_only">투 배너 2</h4>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
<?php } ?>