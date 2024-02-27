<?php
if (!defined('_EYOOM_')) exit;
?>

<?php /* 페이지 로더 */ ?>
<div class="page-loader">
    <div class="logo-loader">
        <?php if (file_exists($top_logo) && !is_dir($top_logo)) { ?>
        <img src="<?php echo $logo_src['top']; ?>" class="title-logo-image" alt="<?php echo $config['cf_title']; ?>">
        <?php } else { ?>
        <img src="<?php echo EYOOM_THEME_URL; ?>/image/site_logo.png" class="title-logo-image" alt="<?php echo $config['cf_title']; ?>">
        <?php } ?>
    </div>
</div>

<?php /* EB슬라이더 - main slider */ ?>
<?php echo eb_slider('1628830724'); ?>

<section class="section section-1">
    <div class="f-container">
        <?php /* EB최신글 - shop015 gallery */ ?>
        <?php echo eb_latest('1628833147'); ?>
    </div>
</section>

<section class="section section-2">
    <div class="f-container">
		<?php /* EB콘텐츠 - shop015 one banner */ ?>
		<?php echo eb_contents('1628832601'); ?>
	</div>
</section>

<section class="section section-1">
    <div class="f-container">
        <div class="row">
            <div class="col-md-6">
                <?php /* EB최신글 - shop015 basic */ ?>
                <?php echo eb_latest('1628833288'); ?>
            </div>
            <div class="col-md-6">
                <?php /* EB최신글 - shop015 basic */ ?>
                <?php echo eb_latest('1628833362'); ?>
            </div>
        </div>
    </div>
</section>

<script>
/* 페이지 로더 */
$(window).on('load', function() {
	$('.page-loader').fadeOut();
});
</script>