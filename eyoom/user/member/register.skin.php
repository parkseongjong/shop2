<?php
include_once(G5_CAPTCHA_PATH . '/captcha.lib.php');
include_once(G5_LIB_PATH . '/register.lib.php');
$register_action_url = G5_HTTPS_BBS_URL . '/register_form_update.php';
$CertifyProvider = [
    'kcb' => G5_OKNAME_URL . '/hpcert1.php',
    'kcp' => G5_KCPCERT_URL . '/kcpcert_form.php',
    'lg' => G5_LGXPAY_URL . '/AuthOnlyReq.php',
];
