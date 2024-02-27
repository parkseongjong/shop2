<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/register.lib.php');

$mb_email = isset($_POST['reg_mb_email']) ? trim($_POST['reg_mb_email']) : '';
$mb_id    = isset($_POST['reg_mb_id']) ? trim($_POST['reg_mb_id']) : '';

set_session('ss_check_mb_email', '');

($msg = empty_mb_email($mb_email)) && die($msg);
($member && $member['mb_email'] == $mb_email) && die('동일한 E-mail 주소입니다.');
($msg = valid_mb_email($mb_email)) && die($msg);
($msg = prohibit_mb_email($mb_email)) && die($msg);
($msg = exist_mb_email($mb_email, $mb_id)) && die($msg);

set_session('ss_check_mb_email', $mb_email);