<?php
$CertifyProvider = [
    'kcb' => G5_OKNAME_URL . '/hpcert1.php',
    'kcp' => G5_KCPCERT_URL . '/kcpcert_form.php',
    'lg' => G5_LGXPAY_URL . '/AuthOnlyReq.php',
];
empty($member['mb_recommend']) !== true && ($member['mentor'] = sql_fetch("SELECT mb_id, mb_nick, mb_hp, mb_name FROM {$g5['member_table']} WHERE mb_id=" . fn_sql_quote($member['mb_recommend'])));