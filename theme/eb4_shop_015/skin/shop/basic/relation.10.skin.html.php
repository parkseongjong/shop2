<?php
/**
 * skin file : /theme/THEME_NAME/skin/shop/basic/relation.10.skin.html.php
 */
if (!defined('_EYOOM_')) exit;
?>

<style>
.relation-10 {position:relative}
.relation-10-in {margin-left:-5px;margin-right:-5px}
.relation-10 .item-relation-10 {position:relative;padding-left:5px;padding-right:5px;outline:none}
.relation-10 .item-relation-10-in {position:relative;background:#eee;-webkit-transition:all 0.3s ease-in-out;-moz-transition:all 0.3s ease-in-out;-o-transition:all 0.3s ease-in-out;transition:all 0.3s ease-in-out}
.relation-10 .item-relation-10-in:hover {background:#eee}
/* 이미지 */
.relation-10 .product-img-wrap {position:relative;overflow:hidden;background:#fff}
.relation-10 .product-img-wrap a {display:block}
.relation-10 .product-img-wrap a.nw-wn {opacity:0;position:absolute;top:55%;left:50%;transform:translate(-50%,-50%);width:100px;padding:0 10px;line-height:34px;font-size:11px;text-align:center;color:#333;background:rgba(255,255,255,.8);box-shadow:0 0 3px rgba(0,0,0,.15);border-radius:17px !important;-webkit-transition:all 0.3s ease-in-out;-moz-transition:all 0.3s ease-in-out;-o-transition:all 0.3s ease-in-out;transition:all 0.3s ease-in-out}
.relation-10 .item-relation-10-in:hover a.nw-wn {opacity:1;top:50%}
.relation-10 .product-img-wrap a.nw-wn:hover {color:#fff;background:rgba(0,0,0,.8)}
.relation-10 .product-img-in {position:relative;overflow:hidden;width:100%}
.relation-10 .product-img-in img {display:block;width:100% \9;max-width:100% !important;height:auto !important;}
.relation-10 .item-relation-10-in .hvr-img {position: absolute;top: -100%;left: 0;width: 100%;transition:.3s}
.relation-10 .item-relation-10-in:hover .hvr-img {top:0;}
/* 상품정보 */
.relation-10 .product-description {position:relative;overflow:hidden}
.relation-10 .product-description:before {content:"";position:absolute;top:0;left:0;height:0;width:100%;background:#f8f8f8;border-radius: 0 0 50% 50% !important;;-webkit-transition:all .4s ease;-moz-transition:all .4s ease;-o-transition:all .4s ease;-ms-transition:all .4s ease;transition:all .4s ease}
.relation-10 .item-relation-10-in:hover .product-description:before {height:190%}
.relation-10 .product-description .product-description-in {position:relative;bottom:0;overflow:hidden;z-index:1;padding:0 10px 10px}
.relation-10 .product-description .product-name {position:relative;overflow:hidden;margin:5px 0;}
.relation-10 .product-description .product-name a {display:block;line-height:18px;font-size:14px;color:#333}
.relation-10 .product-description .product-name a:hover {text-decoration:underline}
.relation-10 .product-description .title-price {font-size:13px;color:#333}
.relation-10 .product-description .line-through {font-size:11px;color:#959595;text-decoration:line-through;margin-left:7px}
.relation-10 .product-description .product-id {color:#757575;display:block;font-size:12px;margin-top:8px}
.relation-10 .product-description .product-info {position:relative;overflow:hidden;height:34px;color:#959595;font-size:11px;margin-top:8px}
/* 컨트롤 좌우 */
.relation-10 .slick-next, .relation-10 .slick-prev {top:-30px;width:30px;height:30px;background:none;border:2px solid #333;-webkit-transition: all .3s ease;-moz-transition: all .3s ease;-o-transition: all .3s ease;-ms-transition: all .3s ease;transition: all .3s ease}
.relation-10 .slick-next {right:6px;z-index:1}
.relation-10 .slick-prev {left:6px;z-index:1}
.relation-10 .slick-next:hover, .relation-10 .slick-prev:hover {background:#333}
.relation-10 .slick-next:before, .relation-10 .slick-prev:before {content:"";display:block;opacity:1;position:absolute;top:50%;width:12px;height:12px;margin-top:-6px;-webkit-transform:rotate(45deg);-moz-transform:rotate(45deg);-o-transform:rotate(45deg);-ms-transform:rotate(45deg);transform:rotate(45deg);transition:.3s}
.relation-10 .slick-next:before {right:10px;border-right:2px solid #333;border-top:2px solid #333}
.relation-10 .slick-prev:before {left:10px;border-left:2px solid #333;border-bottom:2px solid #333}
.relation-10 .slick-next:hover:before, .relation-10 .slick-prev:hover:before {border-color:#fff}

.notice-mo {display:none}
<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
@media (max-width:991px) {
	.relation-10 .item-relation-10-in {margin-bottom:10px}
    .relation-10 .product-img-wrap a.nw-wn {opacity:1;top:inherit !important;bottom:0}
    .relation-10 .product-description .product-name a {font-size:13px}
    .relation-10 .product-img a.nw-wn {opacity:1;top:inherit !important;bottom:10px}
    .relation-10 .product-description:before {display:none}
    .relation-10 .product-description .product-description-in {padding:0 10px 10px}
    .relation-10 .product-description .product-name a {font-size:13px}
    .notice-mo {display:block;margin:0 0 10px;padding:2px 5px;font-size:11px;color:#909090;background:#f8f8f8}
}
<?php } ?>
</style>

<div class="relation-10">
    <div class="relation-10-in">
        <?php for ($i=0; $i<count((array)$list); $i++) { ?>
        <div class="item-relation-10">
            <div class="item-relation-10-in">
                <div class="product-img-wrap">
                    <?php if ($list[$i]['href']) { ?>
                    <a href="<?php echo $list[$i]['href']; ?>">
                    <?php } ?>
                        <div class="product-img">
                            <div class="product-img-in">
                                <?php if ($list[$i]['it_image2']) { ?>
                                <div class="hvr-img"><?php echo $list[$i]['it_image2']; ?></div>
                                <?php } ?>
                                <?php echo $list[$i]['it_image']; ?>
                            </div>
                        </div>
                    <?php if ($list[$i]['href']) { ?>
                    </a>
                    <?php } ?>

	                <?php if ($list[$i]['href']) { ?>
	                <a href="<?php echo $list[$i]['href']; ?>" target="_blank" class="nw-wn">새창에서 열기</a>
	                <?php } ?>
                </div>

                <?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
                <div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="margin-top:-35px">
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
                        <?php if ($list[$i]['href']) { ?>
                        <h4 class="product-name">
                            <a href="<?php echo $list[$i]['href']; ?>">
                        <?php } ?>
                            <?php if ($this->view_it_name) { echo stripslashes($list[$i]['it_name']); } ?>
                        <?php if ($list[$i]['href']) { ?>
                            </a>
                        </h4>
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

<script>
$('.relation-10-in').slick({
    dots: false,
    infinite: true,
    centerMode: true,
    centerPadding: '0px',
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 4000,
    <?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 4
            }
        },
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 3,
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
            }
        }
    ]
    <?php } ?>
});
</script>