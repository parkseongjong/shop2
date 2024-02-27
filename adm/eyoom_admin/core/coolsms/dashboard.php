<?php
/**
 *
 * User: Lee, Namdu
 * Date: 2022-06-15
 * Time: 오후 2:58
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;


$sub_menu = "900100";
$g5['title'] = "CoolSMS 현황";

/** @type $auth array */
auth_check_menu($auth, $sub_menu, 'r');
$fromDate = (new DateTime('-3 month'))->format('Y-m-01');
/**
 * 탭메뉴
 */
$pg_anchor = array(
    'anc_cf_monthly' => '월별통계',
    'anc_cf_daily' => '일별통계',
);

