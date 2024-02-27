<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<div id="display_pay_button" class="btn_confirm">
    <input type="button" value="주문하기" onclick="forderform_check(this.form);" class="btn_submit">
    <a href="javascript:history.go(-1);" class="btn01">취소</a>
</div>

<div id="display_pay_process" class="allow-checkout">
    <div class="checkout-backdrop"></div>
    <div class="checkout-wait">
        <article>
            <img src="<?php echo G5_URL; ?>/shop/img/loading.gif" alt="loading" />
            <h4>주문완료 중입니다. 잠시만 기다려 주십시오.</h4>
        </article>
    </div>
</div>
