<?php
if (!defined('_EYOOM_')) exit;

add_stylesheet('<link rel="stylesheet" href="'.EYOOM_THEME_URL.'/plugins/slick/slick.min.css" type="text/css" media="screen">',0);
?>
<div class="btn-edit-mode-wrap">
    <?php /* eb최신글 편집 버튼 */ ?>
    <?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
    <div class="btn-edit-mode text-center hidden-xs hidden-sm">
        <div class="btn-group">
            <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=eblatest_form&amp;thema=<?php echo $theme; ?>&amp;el_code=<?php echo $el_master['el_code']; ?>&amp;w=u&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> EB최신글 마스터 설정</a>
            <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=eblatest_form&amp;thema=<?php echo $theme; ?>&amp;el_code=<?php echo $el_master['el_code']; ?>&amp;w=u" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
                <i class="far fa-window-maximize"></i>
            </a>
        </div>
    </div>
    <?php } ?>
</div>

<?php if (isset($el_master) && $el_master['el_state'] == '1') { // 보이기 상태에서만 출력 ? ?>
<style>
.gallery-latest {position:relative}
/* 최신글 타이틀 */
.gallery-latest .latest-title {margin:0 0 30px;padding-bottom:10px;text-align:center;border-bottom:1px solid #ddd}
.gallery-latest .latest-title h2 {display:inline-block;position:relative;margin:0;line-height:20px;font-size:15px}
.gallery-latest .latest-title h2:after {content:"";display:block;position:absolute;bottom:-13px;left:0;z-index:1;width:100%;height:3px;background-color:var(--color-p-light)}
.gallery-latest .latest-title h2 a {display:block;transition:.3s}
.gallery-latest .latest-title h2 a:hover {color:var(--color-p-dark)}

/* 아이템 - 이미지와 내용 */
.gallery-latest .gallery-wrap {padding:0}
.gallery-wrap .gallery-item {margin-bottom:30px}
.gallery-wrap .gallery-image .img-box {height:240px;overflow:hidden}
.gallery-wrap .gallery-image .img-box .no-image {display:block;width:100%;height:100%;padding-top:120px;text-align:center;color:#fff;background:#aaa}
.gallery-wrap .gallery-content h5 {margin:10px 0;max-height:40px;text-overflow:ellipsis;white-space:nowrap;word-wrap:normal;overflow:hidden}
.gallery-wrap .gallery-content h5 a {font-size:14px;line-height:20px;color:#333;font-weight:700}
.gallery-wrap .gallery-content h5 a:hover {text-decoration:underline}
.gallery-wrap .gallery-content p {color:#707070}

<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
@media (min-width:992px) and (max-width:1199px){
    .gallery-wrap .gallery-image .img-box {height:190px}
}
@media (max-width:991px){
    .gallery-wrap .gallery-image .img-box {height:230px}
}
@media (max-width:767px){
    .gallery-wrap .gallery-image .img-box {height:auto}
}
<?php } ?>
</style>
<div class="gallery-latest">
    <?php if (is_array($el_item)) { foreach ($el_item as $k => $eb_latest) { ?>
    <div class="latest-title">
        <h2><a href="<?php echo $eb_latest['li_link']; ?>"><strong><?php echo $eb_latest['li_title']; ?></strong></a></h2>
    </div>
    <div class="gallery-wrap">
        <div class="row">
            <?php if (count((array)$eb_latest['list']) > 0) { foreach ($eb_latest['list'] as $data) { ?>
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item">
                    <div class="gallery-image">
                        <a href="<?php echo $data['href']; ?>">
                            <div class="img-box">
                                <?php if ($data['wr_image']) { ?>
                                <img class="img-responsive" src="<?php echo $data['wr_image']; ?>">
                                <?php } else { ?>
                                <span class="no-image">No Image</span>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                    <div class="gallery-content">
                        <h5><a href="<?php echo $data['href']; ?>"><?php echo $data['wr_subject']; ?></a></h5>
                        <?php if ($eb_latest['li_content'] == 'y') { ?>
                        <p><?php echo $data['wr_content']; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php }} else { ?>
            <div class="gallery-item"><p class="text-center color-grey font-size-13 margin-top-30"><i class="fa fa-exclamation-circle"></i> 최신글이 없습니다.</p>
            <?php } ?>
        </div>
    </div>

    <div class="btn-edit-mode-wrap">
        <?php /* eb최신글 아이템 편집 버튼 */ ?>
        <?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
        <div class="text-center margin-top-10 btn-edit-mode hidden-xs hidden-sm">
            <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=eblatest_itemform&amp;thema=<?php echo $theme; ?>&amp;el_code=<?php echo $el_master['el_code']; ?>&amp;li_no=<?php echo $eb_latest['li_no']; ?>&amp;w=u&amp;iw=u&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-dark"><i class="far fa-edit"></i> EB최신글 아이템 설정</a>
        </div>
        <?php } ?>
    </div>
    <?php }} ?>

    <?php if ($el_default) { ?>
    <p class="text-center color-grey font-size-13 margin-top-30"><i class="fa fa-exclamation-circle"></i> 최신글이 없습니다.</p>
    <?php } ?>
</div>
<?php } ?>