<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
/* 주문폼 자바스크립트 에러 방지를 위해 추가함 */
?>
<input type="hidden" name="good_mny"    value="<?=$tot_price; ?>">

<?php /* 공통 응답값 */?>
<input type="hidden" name="responseCode" value="" />
<input type="hidden" name="responseMsg" value="" />
<input type="hidden" name="transactionId" value="" />
<input type="hidden" name="amount" value="" />
<input type="hidden" name="kakaoResultCode" value="" />
<?php
/*
 |  Plug-in 방식 카드결제 응답
 |  ----------------------------------------------------------------
 */
?>
<input type="hidden" name="authDateTime" value="" />
<input type="hidden" name="authNumber" value="" />
<input type="hidden" name="cardName" value="" />
<input type="hidden" name="orderNumber" value="" />
<input type="hidden" name="payupType" value="" />
<input type="hidden" name="sig" value="" />
<?php
/*
 |  가상계좌 발급 응답
 |  ----------------------------------------------------------------
 */
?>
<input type="hidden" name="accountHolder" value="" />
<input type="hidden" name="bankName" value="" />
<input type="hidden" name="account" value="" />
<input type="hidden" name="expireDate" value="" />
<input type="hidden" name="issueDate" value="" />