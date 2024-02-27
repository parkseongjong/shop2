<?php
include_once G5_LIB_PATH.'/PHPExcel.php';
!function_exists('json_encode') && include_once(G5_LIB_PATH . '/json.lib.php');

ini_set('memory_limit','-1');
ini_set('output_buffering', 'Off');
ini_set('zlib.output_compression', 'Off');

session_write_close();
// Clean output buffer
ob_implicit_flush(true);
ob_get_level() !== 0 && @ob_end_clean() === false && ob_clean();

define('_EXPORT_PATH_', G5_DATA_PATH . '/export');
define('_EXPORT_ROW_MAX_', 1000000);

/*
 | ---------------------------------------------------------------
 |
 | ---------------------------------------------------------------
 */
$param = array_merge($_GET, $_POST);
array_walk($param, function (&$value, &$key) {
    $value = clean_xss_tags($value);
});

/*
 | ---------------------------------------------------------------
 |
 | ---------------------------------------------------------------
 */
$_CONTENT_TYPE_ = null;
$param['debug'] != 'Y' && ($_CONTENT_TYPE_ = $param['responseType'] == 'json' ? 'text/json; charset=UTF-8' : 'text/event-stream'); // HTTP 1.1.
$_CONTENT_TYPE_ && header("Content-Type: {$_CONTENT_TYPE_}");

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.


function export_message($text, $event = 'walk', $parameter = null, $exist = false)
{
    global $param;

    if ($param['debug'] == 'Y') {
       debug($event, $text, $parameter);
    }
    else if ($param['debug'] == 'X') {

    }
    else if($param['responseType'] == 'json') {
        print json_encode(['code' => $event == 'error' ? 400 : $event, 'message' => $text, 'param' => $parameter]);
        die;
    }
    else {
        $stringify = json_encode(['message' => $text, 'param' => $parameter]);
        print "event: {$event}\ndata: {$stringify}\n\n";
        @ob_flush();
        flush();
        $exist === true && die;
    }
}

if(!function_exists('conv_telno')):

function conv_telno($t)
{
    // 숫자만 있고 0으로 시작하는 전화번호
    if (!preg_match("/[^0-9]/", $t) && preg_match("/^0/", $t))  {
        if (preg_match("/^01/", $t)) {
            $t = preg_replace("/([0-9]{3})(.*)([0-9]{4})/", "\\1-\\2-\\3", $t);
        } else if (preg_match("/^02/", $t)) {
            $t = preg_replace("/([0-9]{2})(.*)([0-9]{4})/", "\\1-\\2-\\3", $t);
        } else {
            $t = preg_replace("/([0-9]{3})(.*)([0-9]{4})/", "\\1-\\2-\\3", $t);
        }
    }

    return $t;
}
endif;


