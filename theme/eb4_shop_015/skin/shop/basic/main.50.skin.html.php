<?php
if (!defined('_EYOOM_')) exit;
add_stylesheet('<link rel="stylesheet" href="'.EYOOM_THEME_URL.'/plugins/slick/slick.min.css" type="text/css" media="screen">',0);
?>

<style>
.product-main-50 {position:relative}
.product-main-50-in {margin-left:-5px;margin-right:-5px}
.product-main-50 .item-main-50 {position:relative;padding-left:5px;padding-right:5px;outline:none}
.product-main-50 .item-main-50-in {position:relative;background:#f8f8f8}
.product-main-50 .item-main-50-in:before {content:"";position:absolute;top:0;left:0;height:100%;width:0%;background:#eee;-webkit-transition:all .4s ease;-moz-transition:all .4s ease;-o-transition:all .4s ease;-ms-transition:all .4s ease;transition:all .4s ease;}
.product-main-50 .item-main-50-in:hover:before {width:100%}
/* 이미지 */
.product-main-50 .product-img {position:relative;overflow:hidden;float:left;width:40%;}
.product-main-50 .product-img a {display:block}
.product-main-50 .product-img a.nw-wn {opacity:0;position:absolute;top:55%;left:50%;transform:translate(-50%,-50%);width:100px;padding:0 10px;line-height:26px;font-size:11px;text-align:center;color:#333;background:rgba(255,255,255,.8);box-shadow:0 0 3px rgba(0,0,0,.15);border-radius:13px !important;-webkit-transition:all 0.3s ease-in-out;-moz-transition:all 0.3s ease-in-out;-o-transition:all 0.3s ease-in-out;transition:all 0.3s ease-in-out}
.product-main-50 .item-main-50:hover a.nw-wn {opacity:1;top:50%}
.product-main-50 .product-img a.nw-wn:hover {color:#fff;background:rgba(0,0,0,.8)}
.product-main-50 .product-img-in {position:relative;overflow:hidden;width:100%}
.product-main-50 .product-img-in img {display:block;width:100% \9;max-width:100% !important;height:auto !important;}
.product-main-50 .item-main-50 .hvr-img {position: absolute;top:0;left: -100%;width: 100%;transition:.3s}
.product-main-50 .item-main-50:hover .hvr-img {left:0;}
.product-main-50 button.product-view {font-size: 1rem;margin:.75rem 0 0 0;padding: .25rem .75rem;border: 1px solid #a7a7a7;background-color:#fff; color: #333}
.product-main-50 button.product-view:hover {border-color:#FF4848;color: #FF4848}
/* 상품정보 */
.product-main-50 .product-description {position:relative;overflow:hidden;float:left;width:60%}
.product-main-50 .product-description .product-description-in {position:relative;bottom:0;overflow:hidden;z-index:1;padding:0 35px 10px 10px}
.product-main-50 .product-description .product-name {position:relative;overflow:hidden;margin:5px 0}
.product-main-50 .product-description .product-name a {display:block;line-height:16px;font-size:14px;color:#333}
.product-main-50 .product-description .product-name a:hover {text-decoration:underline}
.product-main-50 .product-description .title-price {margin-right:5px;font-size:16px;font-weight:bold;color:#333}
.product-main-50 .product-description .line-through {font-size:13px;color:#959595;text-decoration:line-through;font-weight:normal}
/* 소셜링크 */
.product-main-50 .product-description .product-sns {position:absolute;top:10px;right:-40px;z-index:1;-webkit-transition:all 0.3s ease-in-out;-moz-transition:all 0.3s ease-in-out;-o-transition:all 0.3s ease-in-out;transition:all 0.3s ease-in-out}
.product-main-50 .item-main-50:hover .product-description .product-sns {right:10px}
.product-main-50 .product-description .product-sns ul {margin:0;padding:0;list-style:none}
.product-main-50 .product-description .product-sns ul li {margin-bottom:5px}
.product-main-50 .product-description .product-sns ul li:last-child {margin-bottom:0}
.product-main-50 .product-description .product-sns ul li a {display:inline-block;width:26px;height:26px;line-height:26px;text-align:center;background:#c5c5c5;color:#fff;font-size:12px}
.product-main-50 .product-description .product-sns ul .s-facebook a {background:#405892}
.product-main-50 .product-description .product-sns ul .s-twitter a {background:#4CA0EB}
.product-main-50 .product-description .product-sns ul .s-google a {background:#D8503F}
.product-main-50 .product-description .product-sns ul li a:hover {background:#333}
/* 상품 유형 */
.product-main-50 .rgba-banner-area {margin-bottom:10px}
.product-main-50 .shop-rgba-red {background:#FF4848;opacity:0.9}
.product-main-50 .shop-rgba-yellow {background:#FDAB29;opacity:0.9}
.product-main-50 .shop-rgba-green {background:#73B852;opacity:0.9}
.product-main-50 .shop-rgba-purple {background:#907EEC;opacity:0.9}
.product-main-50 .shop-rgba-orange {background:#FF6F42;opacity:0.9}
.product-main-50 .shop-rgba-dark {background:#4B4B4D;opacity:0.9}
.product-main-50 .shop-rgba-default {background:#A6A6A6;opacity:0.9}
.product-main-50 .rgba-banner {display:inline-block;height:16px;width:auto;padding:0 9px;margin-right:3px;line-height:16px;color:#fff;font-size:10px;text-align:center;font-weight:normal;position:relative;text-transform:uppercase}
/* 별점 */
.product-main-50 .product-description-bottom {position:relative;overflow:hidden;padding:7px 10px;border-top:1px solid #e5e5e5}
.product-main-50 .product-ratings {margin:5px 0 0;padding:0}
.product-main-50 .product-ratings li {padding:0;margin-right:-3px}
.product-main-50 .product-ratings li .rating {color:#959595;line-height:normal;font-size:11px}
.product-main-50 .product-ratings li .rating-selected {color:#FF4848;font-size:11px}
/* 컨트롤 좌우 */
.product-main-50 .slick-next, .product-main-50 .slick-prev {top:inherit;bottom:-73px;width:30px;height:30px;background:none;border:2px solid #333;-webkit-transition: all .3s ease;-moz-transition: all .3s ease;-o-transition: all .3s ease;-ms-transition: all .3s ease;transition: all .3s ease}
.product-main-50 .slick-next {right:5px;z-index:1}
.product-main-50 .slick-prev {left:5px;z-index:1}
.product-main-50 .slick-next:hover, .product-main-50 .slick-prev:hover {background:#333}
.product-main-50 .slick-next:before, .product-main-50 .slick-prev:before {content:"";display:block;opacity:1;position:absolute;top:50%;width:12px;height:12px;margin-top:-6px;-webkit-transform:rotate(45deg);-moz-transform:rotate(45deg);-o-transform:rotate(45deg);-ms-transform:rotate(45deg);transform:rotate(45deg);transition:.3s}
.product-main-50 .slick-next:before {right:10px;border-right:2px solid #333;border-top:2px solid #333}
.product-main-50 .slick-prev:before {left:10px;border-left:2px solid #333;border-bottom:2px solid #333}
.product-main-50 .slick-next:hover:before, .product-main-50 .slick-prev:hover:before {border-color:#fff}

.notice-mo {display:none}
</style>
<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
<style>
@media (max-width:1199px) {
	.product-main-50-in {margin-left:-5px;margin-right:-5px}
	.product-main-50 .item-main-50 {padding-left:5px;padding-right:5px}
}
@media (max-width:991px) {
	.product-main-50 .item-main-50-in {margin-bottom:10px}
	.product-main-50 .item-main-50-in:before {display:none}
    .product-main-50 .product-img a.nw-wn {opacity:1;top:inherit !important;bottom:0}
	.product-main-50 .product-description:before {display:none}
    .product-main-50 .product-description .product-description-in {padding:0 35px 10px 10px}
	.product-main-50 .item-main-50 .product-description .product-sns {right:10px}
    .product-main-50 .product-description .product-name a {font-size:13px}
    .notice-mo {display:block;margin:0 0 10px;padding:2px 5px;font-size:11px;color:#909090;background:#f8f8f8}
}
</style>
<?php } ?>

<div class="product-main-50">
	<div class="product-main-50-in">
		<?php for ($i=0; $i<count((array)$list); $i++) { ?>
		<div class="item-main-50">
			<div class="item-main-50-in clear-after">
                <div class="product-img">
                    <?php if ($list[$i]['href']) { ?>
                    <a href="<?php echo $list[$i]['href']; ?>">
                    <?php } ?>
                    <div class="product-img-in">
                        <?php if ($list[$i]['it_image2']) { ?>
                        <div class="hvr-img"><?php echo $list[$i]['it_image2']; ?></div>
                        <?php } ?>
                        <?php echo $list[$i]['it_image']; ?>
                    </div>
                    <?php if ($list[$i]['href']) { ?>
                    </a>
                    <?php } ?>

	                <?php if ($list[$i]['href']) { ?>
<!--	                <a href="--><?php //echo $list[$i]['href']; ?><!--" target="_blank" class="nw-wn">새창에서 열기</a>-->
	                <?php } ?>
                </div>

                <?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
                <div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="margin-top:-10px">
                    <div class="btn-group">
                        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&pid=itemform&w=u&it_id=<?php echo $list[$i]['it_id']; ?>&wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-dark btn-e-split"><i class="far fa-edit"></i> 개별상품 설정</a>
                        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&pid=itemform&w=u&it_id=<?php echo $list[$i]['it_id']; ?>" target="_blank" class="btn-e btn-e-xs btn-e-dark btn-e-split-dark dropdown-toggle" title="새창 열기">
                            <i class="far fa-window-maximize"></i>
                        </a>
                    </div>
                </div>
                <?php } ?>

		        <div class="product-description">
		            <div class="product-description-in">
	                    <?php if ($this->view_sns) { ?>
	                    <!--<div class="product-sns">
	                        <ul>
	                            <li class="s-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php /*echo $data['sns_url']; */?>&amp;p=<?php /*echo $data['sns_title']; */?>" target="_blank" class="facebook-icon" title="페이스북"><i class="fab fa-facebook-f"></i></a></li>
	                            <li class="s-twitter"><a href="https://twitter.com/share?url=<?php /*echo $data['sns_url']; */?>&amp;text=<?php /*echo $data['sns_title']; */?>" target="_blank" class="twitter-icon" title="트위터"><i class="fab fa-twitter"></i></a></li>
	                        </ul>
	                    </div>-->
	                    <?php } ?>

		                <ul class="list-inline product-ratings">
                            <li><i class="rating<?php if ($list[$i]['star_score'] > 0) { ?>-selected fas fa-star<?php } else { ?> far fa-star<?php } ?>"></i></li>
                            <li><i class="rating<?php if ($list[$i]['star_score'] > 1) { ?>-selected fas fa-star<?php } else { ?> far fa-star<?php } ?>"></i></li>
                            <li><i class="rating<?php if ($list[$i]['star_score'] > 2) { ?>-selected fas fa-star<?php } else { ?> far fa-star<?php } ?>"></i></li>
                            <li><i class="rating<?php if ($list[$i]['star_score'] > 3) { ?>-selected fas fa-star<?php } else { ?> far fa-star<?php } ?>"></i></li>
                            <li><i class="rating<?php if ($list[$i]['star_score'] > 4) { ?>-selected fas fa-star<?php } else { ?> far fa-star<?php } ?>"></i></li>
		                </ul>
		                <div class="clearfix"></div>

                        <?php if ($list[$i]['href']) { ?>
                        <h4 class="product-name">
                            <a href="<?php echo $list[$i]['href']; ?>">
                        <?php } ?>

                            <?php if ($this->view_it_name) { echo stripslashes($list[$i]['it_name']); } ?>
                        <?php if ($list[$i]['href']) { ?>
                            </a>
                        </h4>
                        <?php } ?>

                        <?php if ($this->view_it_icon) { ?>
                        <?php echo $list[$i]['it_icon']; ?>
                        <?php } ?>

                        <?php if ($this->view_it_cust_price || $this->view_it_price) { ?>
                        <div class="product-price">
                            <?php if ($this->view_it_price) { ?>
                            <span class="title-price">₩ <?php echo $list[$i]['it_tel_inq']; ?></span>
                            <?php } ?>
                            <?php if ($this->view_it_cust_price && $list[$i]['it_cust_price']) { ?>
                            <span class="title-price line-through">₩ <?php echo $list[$i]['it_cust_price']; ?></span>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        <?php if ($list[$i]['href']) : ?><div><button type="button" class="product-view">상세보기</button></div><?php endif;?>
		            </div>
		        </div>
		    </div>
	    </div>
	    <?php } ?>
        <?php if (count((array)$list) == 0) { ?>
        <p class="text-center font-size-13 color-grey margin-top-10"><i class="fa fa-exclamation-circle"></i> 등록된 상품이 없습니다.</p>
        <?php } ?>
	</div>
    <p class="notice-mo"><i class="fas fa-arrows-alt-h"></i> 손가락으로 좌우 스크롤해 주세요.</p>
</div>

<script src="<?php echo EYOOM_THEME_URL; ?>/plugins/slick/slick.min.js"></script>
<script>
$('.product-main-50-in').slick({
    dots: true,
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
	autoplaySpeed: 4000,// 4초
    dots: false,
    <?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 3
            }
        },
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 2,
                arrows: false
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                arrows: false
            }
        }
    ]
    <?php } ?>
});
</script>