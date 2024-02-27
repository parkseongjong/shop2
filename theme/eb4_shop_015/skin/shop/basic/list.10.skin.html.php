<?php
/**
 * skin file : /theme/THEME_NAME/skin/shop/basic/list.10.skin.html.php
 */
if (!defined('_EYOOM_')) exit;
?>

<style>
.product-list-10 .item-list {position:relative;background:#f8f8f8;-webkit-transition:all 0.3s ease-in-out;-moz-transition:all 0.3s ease-in-out;-o-transition:all 0.3s ease-in-out;transition:all 0.3s ease-in-out}
.product-list-10 .item-list:hover {background:#eee}
/* 이미지 */
.product-list-10 .product-img {position:relative;overflow:hidden}
.product-list-10 .product-img a {display:block}
.product-list-10 .product-img a.nw-wn {opacity:0;position:absolute;top:55%;left:50%;transform:translate(-50%,-50%);width:100px;padding:0 10px;line-height:26px;font-size:11px;text-align:center;color:#333;background:rgba(255,255,255,.8);box-shadow:0 0 3px rgba(0,0,0,.15);border-radius:17px !important;-webkit-transition:all 0.3s ease-in-out;-moz-transition:all 0.3s ease-in-out;-o-transition:all 0.3s ease-in-out;transition:all 0.3s ease-in-out}
.product-list-10 .item-list:hover a.nw-wn {opacity:1;top:50%}
.product-list-10 .product-img a.nw-wn:hover {color:#fff;background:rgba(0,0,0,.8)}
.product-list-10 .product-img-in {position:relative;overflow:hidden;width:100%}
.product-list-10 .product-img-in img {display:block;width:100% \9;max-width:100% !important;height:auto !important;}
.product-list-10 .item-list .hvr-img {position: absolute;top: -100%;left: 0;width: 100%;transition:.3s}
.product-list-10 .item-list:hover .hvr-img {top:0;}

.product-list-10 button.product-view {position: absolute;right: 1rem;top: 1rem;font-size: 1rem;margin: 0;padding: .25rem .75rem;border: 1px solid #a7a7a7;background-color:#fff; color: #333}
.product-list-10 button.product-view:hover {border-color:#FF4848;color: #FF4848}
/* 상품 유형 */
.product-list-10 .rgba-banner-area {position:absolute;top:10px;left:10px}
.product-list-10 .shop-rgba-red {background:#FF4848;opacity:0.9}
.product-list-10 .shop-rgba-yellow {background:#FDAB29;opacity:0.9}
.product-list-10 .shop-rgba-green {background:#73B852;opacity:0.9}
.product-list-10 .shop-rgba-purple {background:#907EEC;opacity:0.9}
.product-list-10 .shop-rgba-orange {background:#FF6F42;opacity:0.9}
.product-list-10 .shop-rgba-dark {background:#4B4B4D;opacity:0.9}
.product-list-10 .shop-rgba-default {background:#A6A6A6;opacity:0.9}
.product-list-10 .rgba-banner {padding:.25rem calc(.5rem - 1px); opacity:.7; line-height:14px;color:#fff;font-size:.7rem;text-align:center;font-weight:normal;position:relative;text-transform:uppercase;margin-bottom:1px}
/* 소셜링크 */
.product-list-10 .product-img .product-sns {position:absolute;top:10px;right:-40px;z-index:1;-webkit-transition:all 0.3s ease-in-out;-moz-transition:all 0.3s ease-in-out;-o-transition:all 0.3s ease-in-out;transition:all 0.3s ease-in-out}
.product-list-10 .item-list:hover .product-img .product-sns {right:10px}
.product-list-10 .product-img .product-sns ul {margin:0;padding:0;list-style:none}
.product-list-10 .product-img .product-sns ul li {margin-bottom:5px}
.product-list-10 .product-img .product-sns ul li:last-child {margin-bottom:0}
.product-list-10 .product-img .product-sns ul li a {display:inline-block;width:26px;height:26px;line-height:26px;text-align:center;background:#c5c5c5;color:#fff;font-size:12px}
.product-list-10 .product-img .product-sns ul .s-facebook a {background:#405892}
.product-list-10 .product-img .product-sns ul .s-twitter a {background:#4CA0EB}
.product-list-10 .product-img .product-sns ul .s-google a {background:#D8503F}
.product-list-10 .product-img .product-sns ul li a:hover {background:#333}
/* 상품정보 */
.product-list-10 .product-description {position:relative;overflow:hidden;padding:0 10px}
.product-list-10 .product-description:before {content:"";position:absolute;top:0;left:0;height:0;width:100%;background:#fff;border-radius: 0 0 50% 50% !important;;-webkit-transition:all .4s ease;-moz-transition:all .4s ease;-o-transition:all .4s ease;-ms-transition:all .4s ease;transition:all .4s ease}
.product-list-10 .item-list:hover .product-description:before {height:190%}
.product-list-10 .product-description .product-description-in {position:relative;bottom:0;overflow:hidden;z-index:1;padding:0 5px 15px}
.product-list-10 .product-description .product-id {color:#757575;display:block;font-size:12px;margin-top:8px}
.product-list-10 .product-description .product-info {position:relative;overflow:hidden;height:11px;line-height:11px;margin:15px 0 5px;color:#959595;font-size:11px}
.product-list-10 .product-description .product-name {position:relative;overflow:hidden;margin:0 0 5px;height:36px}
.product-list-10 .product-description .product-name a {display:block;line-height:18px;font-size:16px;color:#333}
.product-list-10 .product-description .product-name a:hover {text-decoration:underline}
.product-list-10 .product-description .title-price {margin-right:5px;font-size:13px;font-weight:bold;color:#333;}
.product-list-10 .product-description .line-through {font-size:11px;color:#959595;text-decoration:line-through;font-weight:normal}

/* 상품별점 */
.product-list-10 .product-description-bottom {position:relative;overflow:hidden;padding:7px 10px;border-top:1px solid #e5e5e5}
.product-list-10 .product-description-bottom > a {line-height:20px}
.product-list-10 .product-ratings {margin:0;padding:0;margin-right:3px}
.product-list-10 .product-ratings li {padding:0;margin-right:-3px;line-height:20px}
.product-list-10 .product-ratings li .rating {color:#959595;line-height:normal;font-size:11px}
.product-list-10 .product-ratings li .rating-selected {color:#FF4848;font-size:11px}
/* 리스트형 */
.product-type-list .product-list-10 .f-col-md-3 {width:50%;padding-left:5px;padding-right:5px}
.product-type-list .product-list-10 .item-list {border:1px solid #e5e5e5}
.product-type-list .product-list-10 .product-img {position:absolute;z-index:1;overflow:hidden;background:#fff;width:146px}
.product-type-list .product-list-10 .product-description {padding-left:155px;min-height:146px;text-align:left}
</style>

<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
<style>
@media (max-width:991px) {
    .product-list-10 .item-list .product-img .product-sns {right:10px}
    .product-list-10 .item-list a.nw-wn {opacity:1;top:inherit !important;bottom:0}
    .product-list-10 .product-description {padding: 0;}
    .product-list-10 .product-description:before {display:none}
    .product-list-10 .product-description .product-description-in {padding:0 10px 10px}
    .product-list-10 .product-description .product-name {height:38px}
    .product-list-10 .product-description .product-name a {font-size:13px}
    .product-list-10 .product-description .product-price {height:37px}
    .product-list-10 .product-description .title-price {display:block}
    .product-list-10 .product-description-bottom {padding:7px 5px}
}
@media (max-width:767px) {
    .product-type-list .product-list-10 .f-col-md-3 {width:100%}
    .product-list-10 .product-description .product-name {margin-top:10px}
}
</style>
<?php } ?>

<div id="product_list" class="product-type-gallery">
    <div class="product-list-10 f-row g-3">
        <?php for ($i=0; $i<count((array)$list); $i++) { ?>
        <div class="f-col-6 f-col-md-3">
            <div class="item-list">
                <div class="product-img">
                    <?php if ($list[$i]['href']) { ?>
                    <a href="<?php echo $list[$i]['href']; ?>">
                    <?php } ?>
                        <div class="product-img-in">
                            <?php if ($list[$i]['it_image2']) { ?>
                            <div class="hvr-img"><?php echo $list[$i]['it_image2']; ?></div>
                            <?php } ?>
                            <?php echo $list[$i]['it_image']; ?>
                            <?php if ($this->view_it_icon) { ?>
                            <?php echo $list[$i]['it_icon']; ?>
                            <?php } ?>
                            <?php if ($list[$i]['href']) : ?><button type="button" class="product-view">상세보기</button><?php endif;?>
                        </div>
                    <?php if ($list[$i]['href']) { ?>
                    </a>
                    <?php } ?>

	                <?php if ($list[$i]['href']) { ?>
	                <!-- <a href="<?php echo $list[$i]['href']; ?>" target="_blank" class="nw-wn">새창에서 열기</a> -->
	                <?php } ?>

                    <?php if ($this->view_sns) { ?>
                    <!-- <div class="product-sns">
                        <ul>
                            <li class="s-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $data['sns_url']; ?>&amp;p=<?php echo $data['sns_title']; ?>" target="_blank" class="facebook-icon" title="페이스북"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="s-twitter"><a href="https://twitter.com/share?url=<?php echo $data['sns_url']; ?>&amp;text=<?php echo $data['sns_title']; ?>" target="_blank" class="twitter-icon" title="트위터"><i class="fab fa-twitter"></i></a></li>
                    <li class="s-google"><a href="https://plus.google.com/share?url=<?php echo $data['sns_url']; ?>" arget="_blank" class="google-icon"><i class="fab fa-google-plus-g" title="구글플러스"></i></a></li>
                        </ul>
                    </div> -->
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
                        <?php if ($this->view_it_id) { ?>
                        <span class="product-id"><?php echo stripslashes($list[$i]['it_id']); ?></span>
                        <?php } ?>

                        <?php if ($this->view_it_basic) { ?>
                        <div class="product-info"><?php echo stripslashes($list[$i]['it_basic']); ?></div>
                        <?php } ?>

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
                <div class="clearfix"></div>
                <div class="product-description-bottom">
                    <a class="pull-left font-size-12" href="<?php echo G5_SHOP_URL; ?>/itemuselist.php?sfl=a.it_id&stx=<?php echo $list[$i]['it_id']; ?>">리뷰보기</a>
                    <ul class="list-inline product-ratings pull-right">
                        <li><i class="rating<?php if ($list[$i]['star_score'] > 0) { ?>-selected fas fa-star<?php } else { ?> far fa-star<?php } ?>"></i></li>
                        <li><i class="rating<?php if ($list[$i]['star_score'] > 1) { ?>-selected fas fa-star<?php } else { ?> far fa-star<?php } ?>"></i></li>
                        <li><i class="rating<?php if ($list[$i]['star_score'] > 2) { ?>-selected fas fa-star<?php } else { ?> far fa-star<?php } ?>"></i></li>
                        <li><i class="rating<?php if ($list[$i]['star_score'] > 3) { ?>-selected fas fa-star<?php } else { ?> far fa-star<?php } ?>"></i></li>
                        <li><i class="rating<?php if ($list[$i]['star_score'] > 4) { ?>-selected fas fa-star<?php } else { ?> far fa-star<?php } ?>"></i></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if (count((array)$list) == 0) { ?>
        <p class="text-center font-size-13 color-grey margin-top-10"><i class="fa fa-exclamation-circle"></i> 등록된 상품이 없습니다.</p>
        <?php } ?>
    </div>
</div>