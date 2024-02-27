<?php
if (!defined('_EYOOM_')) exit;
?>
<div class="btn-edit-mode-wrap">
	<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
	<div class="headline-btn text-center btn-edit-mode hidden-xs hidden-sm">
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
.list-latest {position:relative}
/* 최신글 타이틀 */
.list-latest .latest-title {margin:0 0 30px;padding-bottom:10px;text-align:center;border-bottom:1px solid #ddd}
.list-latest .latest-title h2 {display:inline-block;position:relative;margin:0;line-height:20px;font-size:15px}
.list-latest .latest-title h2:after {content:"";display:block;position:absolute;bottom:-13px;left:0;z-index:1;width:100%;height:3px;background-color:var(--color-p-light)}
.list-latest .latest-title h2 a {display:block;transition:.3s}
.list-latest .latest-title h2 a:hover {color:var(--color-p-dark)}

/* 최신글 리스트 */
.list-latest ul {margin:0}
.list-latest ul li {margin-bottom:15px}
.list-latest ul li:last-child {margin-bottom:0}
.list-latest ul li h4 {margin:0}
.list-latest ul li h4 a {position:relative;display:block;padding-right:100px;font-size:13px;color:#555}
.list-latest ul li:last-child h4 a {border-bottom:0 none}
.list-latest ul li h4 a:hover {text-decoration:underline}
.list-latest ul li h4 a .latest-date {position:absolute;top:2px;right:0;color:#909090;font-size:12px}

<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
@media (max-width:767px){
	.list-latest ul {padding:0}
	.list-latest ul li h4 a {font-size:13px}
	.list-latest ul li h4 a .latest-date {top:0}
}
<?php } ?>
</style>

<div class="list-latest">
	<?php if (is_array($el_item)) { foreach ($el_item as $k => $eb_latest) { ?>
	<div class="latest-title"><h2><a href="<?php echo $eb_latest['li_link']; ?>"><strong><?php echo $eb_latest['li_title']; ?></strong></a></h2></div>
	<ul class="list-unstyled">
	<?php if (count((array)$eb_latest['list']) > 0) { foreach ($eb_latest['list'] as $data) { ?>
		<li>
			<h4>
				<a href="<?php echo $data['href']; ?>" class="ellipsis">
					&middot; <?php echo $data['wr_subject']; ?>
					<span class="latest-date"><?php echo $eb_latest['li_date_type'] == '1' ? $eb->date_time("{$eb_latest['li_date_kind']}",$data['wr_datetime']):  $eb->date_format("{$eb_latest['li_date_kind']}",$data['wr_datetime']); ?></span>
				</a>
			</h4>
		</li>
	<?php }} else { ?>
		<li><p class="text-center color-dark font-size-13 margin-top-30">최신글이 없습니다.</p></li>
	<?php } ?>
	</ul>

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
	<p class="text-center color-dark font-size-13 margin-top-30">최신글이 없습니다.</p>
	<?php } ?>
</div>
<?php } ?>