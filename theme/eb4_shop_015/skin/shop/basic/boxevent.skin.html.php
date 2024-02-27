<?php
/**
 * skin file : /theme/THEME_NAME/skin/shop/basic/boxevent.skin.html.php
 */
if (!defined('_EYOOM_')) exit;
?>

<?php if ($ev_count > 0) { ?>
<style>
.shop-boxevent-wrap {position:relative}
.shop-boxevent {display: flex;justify-content:center;flex-wrap:wrap;margin:0 -5px}
.shop-boxevent .boxevent-box {max-width:33.33%;padding:0 5px}
.shop-boxevent .boxevent-box.box-1 {margin-top:0}
.shop-boxevent .boxevent-box:after {display:block;visibility:hidden;clear:both;content:""}
/* 타이틀 */
.shop-boxevent .boxevent-box-title a {display:block;position:relative}
.shop-boxevent .boxevent-box-title a span {position:absolute;top:50%;left:0;transform:translateY(-50%);z-index:1;width:100%;font-size:22px;font-weight:300;text-align:center;color:#fff}
.shop-boxevent .boxevent-box-title .box-title-txt {height:228px;padding:10px;font-size:20px;background:#ddd}
.shop-boxevent .boxevent-box-title .event-title {position: absolute;bottom:0;left:50%;transform:translateX(-50%);width:91%;padding:12px;margin: 0;font-size:15px;font-weight:700;text-align:center;color:var(--color-p-dark);background-color:#fff;}
/* 아이템 */
.shop-boxevent .boxevent-item-wrap {position:relative}
.shop-boxevent .boxevent-item {}
.shop-boxevent .boxevent-item:after {display:block;visibility:hidden;clear:both;content:""}
.shop-boxevent .boxevent-item-box {padding: 0 20px;margin-top: 10px;}
.shop-boxevent .boxevent-item-box-in {display:flex;flex-wrap:wrap;position:relative;background:#f8f8f8}
.shop-boxevent .boxevent-item-box-in:before {content:"";position:absolute;top:0;left:0;height:100%;width:0%;background:#eee;-webkit-transition:all .4s ease;-moz-transition:all .4s ease;-o-transition:all .4s ease;-ms-transition:all .4s ease;transition:all .4s ease}
.shop-boxevent .boxevent-item-box-in:hover:before {width:100%}
/* 이미지 */
.shop-boxevent .boxevent-item-box-in .boxevent-item-img {position:relative;overflow:hidden;max-width:30%}
.shop-boxevent .boxevent-item-box-in .boxevent-item-img a.nw-wn {opacity:0;position:absolute;top:55%;left:50%;transform:translate(-50%,-50%);width:90px;padding:0 10px;line-height:26px;font-size:11px;text-align:center;color:#333;background:rgba(255,255,255,.8);box-shadow:0 0 3px rgba(0,0,0,.15);border-radius:17px !important;-webkit-transition:all 0.3s ease-in-out;-moz-transition:all 0.3s ease-in-out;-o-transition:all 0.3s ease-in-out;transition:all 0.3s ease-in-out}
.shop-boxevent .boxevent-item-box-in:hover .boxevent-item-img a.nw-wn {opacity:1;top:50%}
.shop-boxevent .boxevent-item-box-in .boxevent-item-img a.nw-wn:hover {color:#fff;background:rgba(0,0,0,.8)}
.shop-boxevent .boxevent-item-box-in .boxevent-item-img img {display:block;width:100% \9;max-width:100%;height:auto}
/* 내용 */
.shop-boxevent .boxevent-item-box-in .boxevent-item-desc {position:relative;overflow:hidden;max-width:70%;padding:10px 15px}
.shop-boxevent .boxevent-item-box-in .boxevent-item-desc h5 {position:relative;overflow:hidden;margin:0 0 10px;font-size:16px}
.shop-boxevent .boxevent-item-box-in .boxevent-item-desc span {display:block;position:relative;font-size:14px;font-weight:700}
.shop-boxevent .boxevent-item-box-in .boxevent-item-desc span small {text-decoration:line-through;color:#959595}
.shop-boxevent .boxevent-item-box-in a:hover h5 {text-decoration:underline;color:#293844}
.shop-boxevent .boxevent-no-item {text-align:center;height:250px;line-height:250px;color:#959595}
</style>
<?php if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때 ?>
<style>
@media (max-width:1199px) {
}
@media (max-width:991px) {
    .shop-boxevent .boxevent-box {max-width:100%;margin-top: 10px;}
    .shop-boxevent .boxevent-item-wrap .boxevent-item {display: flex;flex-wrap:wrap;margin:0 -5px}
    .shop-boxevent .boxevent-item-wrap .boxevent-item .boxevent-item-box {max-width:33.33%;padding:0 5px}
    .shop-boxevent .boxevent-item-box-in .boxevent-item-img, .shop-boxevent .boxevent-item-box-in .boxevent-item-desc {min-width: 100%;}
    .shop-boxevent .boxevent-item-box-in .boxevent-item-desc {padding: 10px;}
    .shop-boxevent .boxevent-item-box-in .boxevent-item-desc h5 {margin-bottom: 5px;font-size: 13px;}
    .shop-boxevent .boxevent-item-box-in .boxevent-item-desc span {font-size: 13px;}
}
@media (max-width:499px) {
}
</style>
<?php } ?>

<section id="sev" class="shop-boxevent-wrap">
    <?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
    <div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="top:-20px">
        <div class="btn-group">
            <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shopetc&amp;pid=itemevent&amp;thema=<?php echo $theme; ?>&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i> 이벤트 설정</a>
            <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shopetc&amp;pid=itemevent&amp;thema=<?php echo $theme; ?>" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
                <i class="far fa-window-maximize"></i>
            </a>
            <button type="button" class="btn-e btn-e-xs btn-e-red btn-e-split-red popovers" data-container="body" data-toggle="popover" data-placement="top" data-html="true" data-content="
                <span class='font-size-11'>
                <strong class='color-indigo'>이미지 권장 사이즈</strong><br>
                <div class='margin-hr-5'></div>
                상품출력은 3개에 맞춰 제작.<br>
                상품출력 수 조정은 /eyoom/core/shop/boxevent.skin.php 파일 26줄 'limit' 에서 수 조정.<br>
                limit 0, <strong>3</strong>
                </span>
            "><i class="fas fa-question-circle"></i></button>
        </div>
    </div>
    <?php } ?>
    <div class="shop-boxevent">
        <?php for ($i=0; $i<$ev_count; $i++) { ?>
        <div class="boxevent-box box-<?php echo $i + 1 ?>">
            <div class="boxevent-box-title hvr-act">
                <a href="<?php echo $ev_list[$i]['href']; ?>">
                <?php if (file_exists($ev_list[$i]['event_img'])) { // 이벤트 이미지가 있다면 이미지 출력 ?>
                    <img src="<?php echo G5_DATA_URL; ?>/event/<?php echo $ev_list[$i]['ev_id']; ?>_m" class="img-responsive" alt="<?php echo $ev_list[$i]['ev_subject']; ?>">
                <?php } else { ?>
                    <img src="<?php echo EYOOM_THEME_URL .'/skin/shop/'.$eyoom['shop_skin']; ?>/img/event.jpg" class="img-responsive" alt="event">
                <?php } ?>
                    <h3 class="event-title"><?php echo $ev_list[$i]['ev_subject']; ?></h3>
                </a>
                <?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
                <div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="bottom:20px">
                    <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shopetc&pid=itemeventform&thema=<?php echo $theme; ?>&ev_id=<?php echo $ev_list[$i]['ev_id']; ?>&w=u&iw=u&wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-dark btn-e-split"><i class="far fa-edit"></i> 개별이벤트 설정</a>
                    <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shopetc&pid=itemeventform&thema=<?php echo $theme; ?>&ev_id=<?php echo $ev_list[$i]['ev_id']; ?>&w=u&iw=u" target="_blank" class="btn-e btn-e-xs btn-e-dark btn-e-split-dark dropdown-toggle" title="새창 열기">
                        <i class="far fa-window-maximize"></i>
                    </a>
                    <button type="button" class="btn-e btn-e-xs btn-e-dark btn-e-split-dark popovers" data-container="body" data-toggle="popover" data-placement="top" data-html="true" data-content="
                        <span class='font-size-11'>
                        <strong class='color-indigo'>이미지 권장 사이즈</strong><br>
                        <div class='margin-hr-5'></div>
                        600 x 375 픽셀 사이즈 권장
                        </span>
                    "><i class="fas fa-question-circle"></i></button>
                </div>
                <?php } ?>
            </div>

            <div class="boxevent-item-wrap">
                <?php if (is_array($ev_list[$i]['ev_prd'])) { ?>
                <div class="boxevent-item">
                    <?php foreach ($ev_list[$i]['ev_prd'] as $k => $ev_prd) { ?>
                    <div class="boxevent-item-box">
                        <div class="boxevent-item-box-in">
                            <div class="boxevent-item-img">
                                <?php echo get_it_image($ev_prd['it_id'], 400, 0, get_text($ev_prd['it_name'])); ?>
                                <?php if(0) { ?>
                                <a href="<?php echo $ev_prd['item_href']; ?>" target="_blank" class="nw-wn">새창에서 열기</a>
                                <?php } ?>
                            </div>
                            <div class="boxevent-item-desc">
                                <a href="<?php echo $ev_prd['item_href']; ?>" class="ev_prd_tit">
                                    <h5><?php echo get_text(cut_str($ev_prd['it_name'], 30)); ?></h5>
                                </a>
                                <span><?php echo $ev_prd['it_price']; ?> <?php if ($ev_prd['it_cust_price']) { ?><small><?php echo $ev_prd['it_cust_price']; ?>원</small><?php } ?></span>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>

                <?php if (count($ev_list[$i]['ev_prd']) == 0) { ?>
                <div class="boxevent-no-item">
                    <i class="fas fa-exclamation-circle"></i> 등록된 상품이 없습니다.
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
<?php } ?>