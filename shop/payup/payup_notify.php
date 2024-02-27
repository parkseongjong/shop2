<?php
/**
 *
 */
include_once __DIR__.'/_common.php';

if($member && $member['mb_id'] == 'devper') {
    debug($_REQUEST, $_POST, $_GET);
}
$data = [
    'METHOD' => $_SERVER['REQUEST_METHOD']
    , 'REQUEST' => $_REQUEST
];
$content = '----['.date('Y-m-d H:i:s').' ]----'.PHP_EOL.print_r($data, true).PHP_EOL;
@file_put_contents(G5_DATA_PATH.'/pay/notify-'.date('YmdH').'.log', $content, FILE_APPEND);