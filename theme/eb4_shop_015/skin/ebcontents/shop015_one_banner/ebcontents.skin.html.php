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
            2. 스킨선택 : shop015_one_banner<br>
            3. 컨텐츠 아이템에서 사용할 링크수 : 1개<br>
            4. 컨텐츠 아이템에서 사용할 이미지수 : 2개<br>
            5. 컨텐츠 아이템에서 사용할 필드수 : 1개<br>
            <span class='color-indigo'>[EB 컨텐츠 - 아이템 관리]</span><br>
            1. EB컨텐츠 아이템 추가 클릭<br>
            2. 연결주소 [링크] #1 입력<br>
            3. 이미지 #1~2 업로드<br>
            <div class='margin-hr-5'></div>
            아이템 이미지만 출력되는 스킨으로 이미지, 연결주소 입력<br>
            이미지 비율 pc:1303x318 / mobile:800x400 픽셀 이미지 사용 <br>
			웹접근성을 위해 텍스트 필드 #1은 이미지 설명 내용을 입력하기 바랍니다.
            </span>
            "><i class="fas fa-question-circle"></i></button>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($ec_master) && $ec_master['ec_state'] == '1') { // 보이기 상태에서만 출력 ? ?>
<style>
.ebcontents-two-banner {position:relative}
.ebcontents-two-banner .item {position:relative}
.ebcontents-two-banner .item-1 {
    margin-bottom: 10px;
}
/* 타이틀 */
.ebcontents-two-banner .item a {
    display: block;
    border: 1px solid #ddd;
    transition: .3s;
}
.ebcontents-two-banner .item a:hover {
    border-color: var(--color-p-light);
}
</style>

<div class="ebcontents ebcontents-two-banner">
    <?php /* ebcontents item */?>
    <div class="ebcontents-two-banner-inner">
        <?php if (is_array($contents)) { ?>
            <?php foreach ($contents as $k => $item) { ?>
            <div class="item item-<?php echo $k + 1 ?> hvr-act">
                <?php if ($item['href_1']) { ?>
                <a href="<?php echo $item['href_1']; ?>" target="<?php echo $item['target_1']; ?>">
                <?php } ?>
	                <img src="<?php echo $item['src_1']?>" alt="<?php echo $item['ci_subject_1']; ?>" class="img-responsive hidden-xs">
	                <img src="<?php echo $item['src_2']?>" alt="<?php echo $item['ci_subject_1']; ?>" class="img-responsive visible-xs">
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
	                <img src="<?php echo $ebcontents_skin_url; ?>/image/01.jpg" alt="image" class="img-responsive hidden-xs">
	                <img src="<?php echo $ebcontents_skin_url; ?>/image/01m.jpg" alt="image" class="img-responsive visible-xs">
                    <h4 class="sound_only">원 배너 </h4>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
<?php } ?>