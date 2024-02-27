<?php
if (!defined('_GNUBOARD_')) exit;
require_once G5_PLUGIN_PATH . '/coolsms/class.CoolSMS.php';
define('COOLSMS_API_KEY', 'NCS0UL6ZHENHTIXT');
define('COOLSMS_API_SECRET', 'LQRTNFBN4VDGDPBFNXLFHP1KUXSLGFMU');

// ------------------------------------------------------------------------

/**
 * @return Coolsms
 */
function load_coolsms()
{
    static $class;
    if (isset($class) !== true) {
        $class = new Coolsms(COOLSMS_API_KEY, COOLSMS_API_SECRET);
        $class->setFrom('02-3489-3237');
    }
    return $class;
}

// ------------------------------------------------------------------------

/**
 * @param string $to 수신번호
 * @param string $message 전송 메시지
 * @param string $type 전송타입(SMS | LMS)
 * @param string $from 발신 번호
 * @return bool
 */
function sms_single_send($to, $message, $type = '', $from = '')
{
    $class = load_coolsms();
    empty($from) !== true && $class->setFrom($from);
    $result = $class->single(new CoolSMSMessageType($to, $message, $type));
    return (isset($result['statusCode']) == true && $result['statusCode'] == 2000) ? true : $result['errorMessage'];
}

// ------------------------------------------------------------------------

/**
 * @param array $messages
 *         [to=> '', 'message'=> ''], [to=> '', 'message'=> ''], ...
 *         or ['to', 'message']
 * @param string $type SMS | LMS
 * @return bool
 */
function sms_multi_send(array $messages, $type = 'SMS')
{
    ## $class = load_coolsms();
    $types = [];
    foreach ($messages as $row) {
        [$to, $text] = array_values($row);
        $types[] = new CoolSMSMessageType($to, $text, $type);
    }

    $result = load_coolsms()->multiple($types);
    return (isset($result['status']) == true && $result['status'] == 'SENDING') ? true : $result['errorMessage'];
}



