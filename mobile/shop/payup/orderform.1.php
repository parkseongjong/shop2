<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<form name="sm_form" method="POST">
<input type="hidden" name="good_mny"    value="<?=$tot_price; ?>">
</form>
<?php

require_once G5_SHOP_PATH.'/payup/'.basename(__FILE__);