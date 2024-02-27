<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
require_once G5_SHOP_PATH.'/payup/'.basename(__FILE__);

?>
<input type="hidden" name="od_goods_name" value="<?php echo $goods; ?>">

<div id="display_pay_button" class="btn_confirm">
    <span id="show_req_btn"><input type="button" name="submitChecked" onClick=" pay_approval();" value="주문하기" class="btn_submit"></span>
    <span id="show_pay_btn" style="display:none;"><input type="button" onClick="forderform_check();" value="주문하기" class="btn_submit"></span>
    <a href="<?php echo G5_SHOP_URL; ?>" class="btn_cancel">취소</a>
</div>

<div id="display_pay_process" class="allow-checkout">
    <div class="checkout-backdrop"></div>
    <div class="checkout-wait">
        <article>
            <img src="<?php echo G5_URL; ?>/shop/img/loading.gif" alt="loading" />
            <h4>주문완료 중입니다.<br /> 잠시만 기다려 주십시오.</h4>
        </article>
    </div>
</div>
