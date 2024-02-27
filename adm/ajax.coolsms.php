<?php
include_once('./_common.php');


$CoolSMS = load_coolsms();

$params = array_merge($_GET, $_POST);
switch ($params['scope']) {
    default:
        {
            fn_ajax_output(['code' => 403, 'message' => 'Invalid access, does not contain scope.']);
            break;
        }
    case 'stats':
        {
            $params = $_POST;

            empty($params['from']) === true && ($params['from'] = (new DateTime('-3 month'))->format('Y-m-01'));
            empty($params['to']) === true && ($params['to'] = (new DateTime())->format('Y-m-t'));

            $server_time = defined('G5_SERVER_TIME') ? G5_SERVER_TIME : time();

            $cache_path = G5_DATA_PATH . '/cache/coolsms.summary.json';
            $cache_key = md5("{$params['from']}-{$params['to']}");
            $cache_ttl = 5; // minute

            //
            $re_write = false;
            $storage = null;

            if (file_exists($cache_path) === true) {
                $storage = json_decode(file_get_contents($cache_path), true);
                json_last_error() !== JSON_ERROR_NONE && ($storage = null);
            }

            if (empty($storage) !== true && is_array($storage) === true) {
                foreach ($storage as $ck => &$cv) {
                    if ($server_time < $cv['time'] + $cv['ttl']) continue;
                    unset($storage[$ck]);

                    $re_write = true;
                }
            }

            //
            if (!$storage || isset($storage[$cache_key]) !== true) {
                $storage[$cache_key]['time'] = time();
                $storage[$cache_key]['ttl'] = $cache_ttl * 60;
                $storage[$cache_key]['data'] = $CoolSMS->summary($params['from'], $params['to']);

                $re_write = true;
            }

            $re_write === true && @file_put_contents($cache_path, json_encode($storage));


            $summary = &$storage[$cache_key]['data'];
            $result = [
                'code' => 200,
                'result' => $summary
            ];

            fn_ajax_output($result);
            break;
        }
}


