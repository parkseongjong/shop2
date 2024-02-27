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
            <strong class='color-indigo'>좌측 [EB컨텐츠 설정하기 버튼] 클릭 후 아래 설명 참고<br>
            <div class='margin-hr-5'></div>
            <span class='color-indigo'>[설정정보]</span><br>
            1. 컨텐츠 마스터 제목 : 회사개요<br>
            2. 스킨선택 : shp015_sub01_aboutus<br>
            3. 컨텐츠 아이템에서 사용할 링크수 : 0개<br>
            4. 컨텐츠 아이템에서 사용할 이미지수 : 1개<br>
            5. 컨텐츠 아이템에서 사용할 필드수 : 3개<br>
            <span class='color-indigo'>[EB 컨텐츠 - 아이템 관리]</span><br>
            1. EB컨텐츠 아이템 추가 클릭<br>
            2. 텍스트 필드 #1~3 입력<br>
            3. 설명글 #1,2 입력<br>
            4. 이미지 #1 업로드(배경 이미지)<br>
            <div class='margin-hr-5'></div>
            이미지 1000x1000 픽셀 이미지 사용.<br>
            설명글에 strong태그 사용시 볼드체 출력.<br>
            설명글에 br태그 사용시 줄바뀜.<br>
            텍스트필드 #3은 마지막에 출력.
            </span>
            "><i class="fas fa-question-circle"></i></button>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($ec_master) && $ec_master['ec_state'] == '1') { // 보이기 상태에서만 출력 ? ?>
<style>
.ebcontents-aboutus {position:relative;margin:20px 0}
/* 마스터 */
.ebcontents-aboutus .master-title h2 {position:relative;padding:0 0;margin:0 0 50px;font-size:38px;font-weight:300;text-align:center;color:#344044}
.ebcontents-aboutus .master-title h2:before {content:"";display:block;position:absolute;bottom:-20px;left:50%;width:40px;height:1px;margin-left:-20px;background:#344044}
/* 아이템 */
.ebcontents-aboutus .ebcontents-box {position:relative}
.ebcontents-aboutus .ebcontents-box:after {content:"";display:block;clear:both}
/* 이미지 */
.ebcontents-aboutus .ebcontents-box .ebcontents-image {float:left;width:45%}
.ebcontents-aboutus .ebcontents-box .ebcontents-image img {max-width:100%;height:auto}
/* 내용 */
.ebcontents-aboutus .ebcontents-box .ebcontents-content {float:right;width:50%;padding: 0}
.ebcontents-aboutus .ebcontents-box .ebcontents-content h5 {margin:30px 0 20px;line-height:34px;font-size:24px;font-weight:300}
.ebcontents-aboutus .ebcontents-box .ebcontents-content h4 {margin:0 0 30px;line-height:40px;font-size:34px}
.ebcontents-aboutus .ebcontents-box .ebcontents-content-box {padding:20px 0 20px 40px;border-left:1px solid #ccc}
.ebcontents-aboutus .ebcontents-box .ebcontents-content p {margin-bottom:20px;line-height:30px;font-size:15px;font-weight:300}
.ebcontents-aboutus .ebcontents-box .ebcontents-content h6 {margin:0;font-size:17px;font-weight:700}
</style>

<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
<style>
@media (max-width:1199px){
    .ebcontents-aboutus .ebcontents-box .ebcontents-content h5 {margin-top:0;line-height:30px;font-size:20px}
    .ebcontents-aboutus .ebcontents-box .ebcontents-content h4 {line-height:36px;font-size:26px}
    .ebcontents-aboutus .ebcontents-box .ebcontents-content-box {padding:0 0 0 30px}
}
@media (max-width:767px) {
    .ebcontents-aboutus .ebcontents-box .ebcontents-image {float:none;width:100%;max-width:360px;margin:10px auto}
    .ebcontents-aboutus .ebcontents-box .ebcontents-content {float:none;width:100%}
    .ebcontents-aboutus .ebcontents-box .ebcontents-content h5 {margin:20px 0 10px;line-height:26px;font-size:16px}
    .ebcontents-aboutus .ebcontents-box .ebcontents-content h4 {margin-bottom:20px;line-height:30px;font-size:20px}
    .ebcontents-aboutus .ebcontents-box .ebcontents-content-box {padding-left:20px}
    .ebcontents-aboutus .ebcontents-box .ebcontents-content p {line-height:20px;font-size:13px}
    .ebcontents-aboutus .ebcontents-box .ebcontents-content h6 {font-size:15px}
}
</style>
<?php } ?>

<div class="ebcontents ebcontents-aboutus">
    <div class="ebcontents-aboutus">
    <?php /* ebcontents item */?>
    <?php if (is_array($contents)) { ?>
        <?php foreach ($contents as $k => $item) { ?>
        <div class="ebcontents-box ebcontents-box-<?php echo $k + 1 ?>">
            <div class="ebcontents-image"><img src="<?php echo $item['src_1']?>" alt="image"></div>
            <div class="ebcontents-content">
                <?php if ($item['ci_subject_1']) { ?>
                <h5><?php echo $item['ci_subject_1']; ?></h5>
                <?php } ?>
                <?php if ($item['ci_subject_2']) { ?>
                <h4><?php echo $item['ci_subject_2']; ?></h4>
                <?php } ?>
                <div class="ebcontents-content-box">
                    <?php if ($item['ci_text_1']) { ?>
                    <p><?php echo $item['ci_text_1']; ?></p>
                    <?php } ?>
                    <?php if ($item['ci_text_2']) { ?>
                    <p><?php echo $item['ci_text_2']; ?></p>
                    <?php } ?>
                    <?php if ($item['ci_subject_3']) { ?>
                    <h6><?php echo $item['ci_subject_3']; ?></h6>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php } ?>

    <?php if ($ec_default) { ?>
        <div class="ebcontents-box ebcontents-box-1">
            <div class="ebcontents-image"><img src="<?php echo $ebcontents_skin_url; ?>/image/01.jpg" alt="image"></div>
            <div class="ebcontents-content">
                <h5>ACHROMATIC과 함께하는 패션 라이프<br>소중한 당신을 위해 만들었습니다.</h5>
                <h4><strong>ACHROMATIC</strong> Life Style</h4>
                <div class="ebcontents-content-box">
                    <p>온라인상에서 소셜미디어에 의한 쌍방향 소통을 바탕으로 한 관계 지향적이고 집단 기능적 속성을 가진 소셜펀딩이다.<br>파도를 넘어 저 이상을 향해 항해할 준비가 됐습니다. 혁신적 기술, 독특한 디자인을 겸비한 제품을 통해 렌즈 산업의 선두에 있습니다. <br>공간의 경계를 뛰어넘는 새로운 가능성을 제공하기 위해 끊임없이 도전해 나갈 것 입니다.</p>
                    <p>파도를 넘어 저 이상을 향해 항해할 준비가 됐습니다. 혁신적 기술, 독특한 디자인을 겸비한 제품을 통해 렌즈 산업의 선두에 있습니다. <br>온라인상에서 소셜미디어에 의한 쌍방향 소통을 바탕으로 한 관계 지향적이고 집단 기능적 속성을 가진 소셜펀딩이다.</p>
                    <h6>ACHROMATIC 사람들</h6>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<?php } ?>