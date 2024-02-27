<?php
if (!defined('_EYOOM_')) exit;
//......
?>

<?php /*
5. 페이크로드
 */ ?>
 
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
        <?php /* EB콘텐츠 - 4개 배너 */ ?>
        <?php echo eb_contents('1628832002'); ?>
    </div>
</section>

<section class="section section-2">
    <div class="f-container">
        <?php /* 히트, 추천, 최신상품 */ ?>
        <div class="shop-tabs">
		    <ul class="shop-tabs-nav">
		        <li class="active"><a href="#shop-tabs-1" data-toggle="tab">히트 상품</a></li>
		        <li><a href="#shop-tabs-2" data-toggle="tab">추천 상품</a></li>
		        <li><a href="#shop-tabs-3" data-toggle="tab">신상품</a></li>
		    </ul>
		    <div class="tab-content shop-tabs-content">
		        <div class="tab-pane fade in active" id="shop-tabs-1">
		        	<div class="shop-tabs-item">
			        	<?php /* 히트상품 시작 */ ?>
						<?php if($default['de_type1_list_use']) { ?>
						    <?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
							<div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm">
							    <div class="btn-group">
							        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&amp;pid=configform&amp;amode=ittype&amp;thema=<?php echo $theme; ?>&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> 유형별 상품진열 설정</a>
							        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&amp;pid=configform&amp;thema=<?php echo $theme; ?>#anc_scf_index" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
							            <i class="far fa-window-maximize"></i>
							        </a>
							    </div>
							</div>
							<?php } ?>

					        <?php
					        $list = new item_list($skin_dir.'/'.$default['de_type1_list_skin']);
					        $list->set_type(1);
					        $list->set_view('it_img', true);
					        $list->set_view('it_id', false);
					        $list->set_view('it_name', true);
					        $list->set_view('it_basic', true);
					        $list->set_view('it_cust_price', true);
					        $list->set_view('it_price', true);
					        $list->set_view('it_icon', true);
					        $list->set_view('sns', true);
					        echo $list->run();
					        ?>
						<?php } ?>
						<div class="btn-more text-center margin-top-20"><a href="<?php echo shop_type_url(1); ?>">더보기</a></div>
						<?php /* 히트상품 끝 */ ?>
		        	</div>
		        </div>
		        <div class="tab-pane fade in" id="shop-tabs-2">
		        	<div class="shop-tabs-item">
			        	<?php /* 추천상품 */ ?>
			        	<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
				        <div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="margin-top:-20px;">
				            <div class="btn-group">
				                <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&amp;pid=configform&amp;amode=ittype&amp;thema=<?php echo $theme; ?>&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> 유형별 상품진열 설정</a>
				                <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&amp;pid=configform&amp;thema=<?php echo $theme; ?>#anc_scf_index" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
				                    <i class="far fa-window-maximize"></i>
				                </a>
				            </div>
				        </div>
				        <?php } ?>

				        <?php if($default['de_type2_list_use']) { ?>
				            <?php
				            $list = new item_list($skin_dir.'/'.$default['de_type2_list_skin']);
				            $list->set_type(2);
				            $list->set_view('it_id', false);
				            $list->set_view('it_name', true);
				            $list->set_view('it_basic', true);
				            $list->set_view('it_cust_price', true);
				            $list->set_view('it_price', true);
				            $list->set_view('it_icon', true);
				            $list->set_view('sns', true);
				            echo $list->run();
				            ?>
				        <?php } ?>
						<div class="btn-more text-center margin-top-20"><a href="<?php echo shop_type_url(2); ?>">더보기</a></div>
			        	<?php /* 추천상품 끝 */ ?>
		        	</div>
		        </div>
		        <div class="tab-pane fade in" id="shop-tabs-3">
		        	<div class="shop-tabs-item">
			        	<?php /* 최신상품 시작 */ ?>
						<?php if($default['de_type3_list_use']) { ?>
							<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
							<div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="margin-top:-20px;">
							    <div class="btn-group">
							        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&amp;pid=configform&amp;amode=ittype&amp;thema=<?php echo $theme; ?>&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> 유형별 상품진열 설정</a>
							        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&amp;pid=configform&amp;thema=<?php echo $theme; ?>#anc_scf_index" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
							            <i class="far fa-window-maximize"></i>
							        </a>
							    </div>
							</div>
							<?php } ?>
						    <?php
						    $list = new item_list($skin_dir.'/'.$default['de_type3_list_skin']);
						    $list->set_type(3);
						    $list->set_view('it_id', false);
						    $list->set_view('it_name', true);
						    $list->set_view('it_basic', true);
						    $list->set_view('it_cust_price', true);
						    $list->set_view('it_price', true);
						    $list->set_view('it_icon', true);
						    $list->set_view('sns', true);
						    $list->set_view('star', true);
						    echo $list->run();
						    ?>
						<?php } ?>
						<div class="btn-more text-center margin-top-20"><a href="<?php echo shop_type_url(3); ?>">더보기</a></div>
						<?php /* 최신상품 끝 */ ?>
		        	</div>
		        </div>
		    </div>
	    </div>
    </div>
</section>

<section class="section section-3">
    <div class="f-container">
        <div class="f-row g-3">
            <div class="f-col-lg-3">
                <?php /* EB콘텐츠 - shop015 two banner */ ?>
                <?php echo eb_contents('1628832388'); ?>
            </div>
            <div class="f-col-lg-6">
                <?php /* EB슬라이더 - shop015 one slider */ ?>
                <?php echo eb_slider('1628830950'); ?>
            </div>
            <div class="f-col-lg-3">
                <?php /* EB콘텐츠 - shop015 two banner */ ?>
                <?php echo eb_contents('1628832485'); ?>
            </div>
        </div>
    </div>
</section>

<section class="section section-4">
    <div class="f-container">
		<?php /* EB상품 */ ?>
		<?php echo eb_goods('1628829696'); ?>
	</div>
</section>


<section class="section section-5">
    <div class="f-container">
		<?php /* EB슬라이더 - shop015 two slider */ ?>
		<?php echo eb_slider('1628831134'); ?>
	</div>
</section>


<section class="section section-6">
    <div class="f-container">
		<?php /* 인기상품 */ ?>
		<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
        <div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="margin-top:-20px;">
            <div class="btn-group">
                <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&amp;pid=configform&amp;amode=ittype&amp;thema=<?php echo $theme; ?>&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> 유형별 상품진열 설정</a>
                <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&amp;pid=configform&amp;thema=<?php echo $theme; ?>#anc_scf_index" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
                    <i class="far fa-window-maximize"></i>
                </a>
            </div>
        </div>
        <?php } ?>

	    <div class="shop-main-title">
			<h2><strong>인기 상품</strong></h2>
			<p>인기상품을 한눈에 만나 보세요</p>
		</div>
        <?php if($default['de_type4_list_use']) { ?>
        <?php
        $list = new item_list($skin_dir.'/'.$default['de_type4_list_skin']);
        $list->set_type(4);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_basic', true);
        $list->set_view('it_cust_price', true);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', true);
        $list->set_view('sns', true);
        echo $list->run();
    ?>
        <?php } ?>
		<div class="btn-more text-center margin-top-20"><a href="<?php echo shop_type_url(4); ?>">더보기</a></div>
	</div>
</section>

<section class="section section-7">
    <div class="f-container">
		<?php /* 이벤트 */ ?>
		<?php include_once(EYOOM_THEME_SHOP_SKIN_PATH.'/boxevent.skin.html.php'); // 이벤트 ?>
	</div>
</section>

<section class="section section-8">
    <div class="f-container">
		<?php /* 할인상품 */ ?>
		<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
		<div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="margin-top:-20px;">
		    <div class="btn-group">
		        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&amp;pid=configform&amp;amode=ittype&amp;thema=<?php echo $theme; ?>&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> 유형별 상품진열 설정</a>
		        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&amp;pid=configform&amp;thema=<?php echo $theme; ?>#anc_scf_index" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
		            <i class="far fa-window-maximize"></i>
		        </a>
		    </div>
		</div>
		<?php } ?>

		<div class="shop-main-title">
			<h2><strong>할인 상품</strong></h2>
			<p>할인된 가격의 상품을 지금 만나보세요</p>
		</div>
		<?php if($default['de_type5_list_use']) { ?>
		    <?php
		    $list = new item_list($skin_dir.'/'.$default['de_type5_list_skin']);
		    $list->set_type(5);
		    $list->set_view('it_id', false);
		    $list->set_view('it_name', true);
		    $list->set_view('it_basic', true);
		    $list->set_view('it_cust_price', true);
		    $list->set_view('it_price', true);
		    $list->set_view('it_icon', true);
		    $list->set_view('sns', true);
		    $list->set_view('star', true);
		    echo $list->run();
		    ?>
		<?php } ?>
		<div class="btn-more text-center margin-top-20"><a href="<?php echo shop_type_url(5); ?>">더보기</a></div>
	</div>
</section>

<section class="section section-9">
    <div class="f-container">
		<?php /* EB콘텐츠 - shop015 one banner */ ?>
		<?php echo eb_contents('1628832601'); ?>
	</div>
</section>

<section class="section section-10">
    <div class="f-container">
		<div class="shop-main-title">
	        <h2><strong>상품 리퓨</strong></h2>
			<p>내돈내산의 솔직한 후기를 만나보세요</p>
	    </div>
	    <?php
	    $sql = " select a.is_id, a.is_subject, a.is_content, a.it_id, b.it_name
	                from `{$g5['g5_shop_item_use_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id)
	                where a.is_confirm = '1'
	                order by a.is_id desc
	                limit 0,10 ";
	    $result = sql_query($sql);

	    for($i=0; $row=sql_fetch_array($result); $i++) {
	        if($i == 0) {
	            echo '<div id="main_review" class="review-slider">'.PHP_EOL;
	            echo '<div class="review-slider-inner">'.PHP_EOL;
	        }

	        $review_href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'].'#sit_use';
	    ?>
	        <div class="item item-<?php echo $i + 1 ?>">
		        <div class="item-in">
			        <div class="item-image">
				        <?php /* 사용후기 이미지 사이즈 500 x 500 으로 설정되어 있으며 이미지 등록하지 않은 후기는 상품 이미지가 등록. 이때 비율을 맞추기 위해 흰색 여백이 발생. */ ?>
		                <a href="<?php echo $review_href; ?>" class="review-img"><?php echo get_itemuselist_thumbnail($row['it_id'], $row['is_content'], 500, 500); ?></a>
		            </div>
	                <div class="item-content">
		                <div class="item-content-in">
		                    <div class="product-info"><?php echo $row['it_name']; ?></div>
		                    <h5><a href="<?php echo $review_href; ?>" class="ellipsis"><?php echo get_text(cut_str($row['is_subject'], 50)); ?></a></h5>
		                    <p><?php echo get_text(cut_str(strip_tags($row['is_content']), 90), 1); ?></p>
		                </div>
	                </div>
		        </div>
	        </div>
	    <?php
	    }

	    if($i > 0) {
	        echo '</div>'.PHP_EOL;
	        echo '<p class="notice-mo"><i class="fas fa-arrows-alt-h"></i> 손가락으로 좌우 스크롤해 주세요.</p>'.PHP_EOL;
	        echo '</div>'.PHP_EOL;
	    }
	    ?>

	    <div class="btn-more text-center"><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php">더보기</a></div>
	    <script>
		$('.review-slider-inner').slick({
		    dots: false,
		    infinite: true,
		    slidesToShow: 4,
		    slidesToScroll: 1,
		    autoplay: true,
			autoplaySpeed: 15000,// 15초
		    <?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
		    responsive: [
		        {
		            breakpoint: 992,
		            settings: {
		                slidesToShow: 3,
						arrows: false
		            }
		        },
		        {
		            breakpoint: 768,
		            settings: {
		                slidesToShow: 2,
						arrows: false
		            }
		        }
		    ]
		    <?php } ?>
		});
	    </script>
	</div>
</section>
<?php /* 사용후기 */ ?>

<script>
/* 페이지 로더 */
$(window).on('load', function() {
	$('.page-loader').fadeOut();
});
</script>
