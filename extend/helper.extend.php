<?php
!defined('_GNUBOARD_') && exit; // 개별 페이지 접근 불가
/**
 * @changelog Lee, Namdu 2022.05.16
 * 회사 내 추가 DB 테이블 생성에 따른 최초 규칙 생성
 */
define('HANS_DB_TABLE_PREFIX', 'tb_');
$g5['tb_agent_list'] = HANS_DB_TABLE_PREFIX . 'agent_list'; // 대리점 설정 테이블

$g5['tb_agents'] = HANS_DB_TABLE_PREFIX . 'agents'; // 대리점 설정 테이블
$g5['tb_agent_point'] = HANS_DB_TABLE_PREFIX . 'agent_point'; // 대리점 지급 포인트
$g5['tb_payout'] = HANS_DB_TABLE_PREFIX . 'payout'; // 결제 로그 테이블

if (G5_ENV !== 'production' && strpos(G5_DOMAIN, 'bm.devper.dev4.kr') !== false) {
    $config['cf_naver_clientid'] = 'vlLbl5UeOUIXZNt50F0b';
    $config['cf_naver_secret'] = 'VafYUajSC0';
    $config['cf_kakao_rest_key'] = '77a323e25a9cd641cf16856b868bb900';
    $config['cf_kakao_client_secret'] = 'Zi3d6BiJqWwMbNCHAPF1p7RGJ2F8ApxY';
    $config['cf_kakao_js_apikey'] = 'a2b617c997a1b61bcf616ae50444c202';
}

// ------------------------------------------------------------------------

/**
 * @access      public
 */
if (!function_exists('fn_content_type')) :
    function fn_content_type()
    {
        if (PHP_SAPI === 'cli' OR defined('STDIN')) return 'cli';

        $accept = $_SERVER['HTTP_ACCEPT'];
        $params = array_merge($_GET, $_POST);

        $content_type = 'html';
        if (!empty($accept)) {
            if (strpos($accept, 'application/json') !== false || $params['dataType'] == 'json') {
                $content_type = 'json';
            }
            else if (strpos($accept, 'text/javascript') !== false || $params['dataType'] == 'javascript') {
                $content_type = 'js';
            }
            else if (strpos($accept, 'text/xml') !== false || $params['dataType'] == 'xml') {
                $content_type = 'xml';
            }
            else if (strpos($accept, 'text/plan') !== false) $content_type = 'text';
        }
        return $content_type;
    }
endif;

// ------------------------------------------------------------------------

/**
 * @access    public
 * @return    void
 */
if (!function_exists('debug')) :
    class DEBUG_THEME
    {
        const WARRING = 'theme:warring';
        const ERROR = 'theme:error';
        const INFO = 'theme:info';
        const STICKY = 'theme:sticky';
        const MEMO = 'theme:memo';
        const BLUE = 'theme:green';
        const GREEN = 'theme:green';
        const LAME = 'theme:lame';
        const BLACK = 'theme:black';
    }


    /**
     * @param mixed $var
     * @param mixed|null $param [optional]
     * @return void
     */
    function debug($var, ...$param)
    {
        $args = func_get_args();
        $themes = [
            'default' => 'color:#000080;background-color:#eeeeea;',
            'warring' => 'color:#ff0033;background-color:#FFC7CE',
            'error' => 'color:red;background-color:#333;',
            'info' => 'color:#000080;background-color:#F7A694;',
            'sticky' => 'color:#FF2200;background-color:#F8D79B;',
            'memo' => 'color:black;background-color:#FFFFCC',
            'blue' => 'color:black;background-color:#CBE9FF',
            'green' => 'color:#FFFFF1;background-color:#2E762D',
            'lame' => 'color:#cc0066;background-color:#99FF99',
            'black' => 'color:yellow;background-color:black;',
        ];
        $theme = $themes['default'];
        $inner_style = '';
        $data = null;
        foreach ($args as $index => $arg) {
            if (is_string($arg)) {
                $lower = strtolower(trim($arg));
                if (preg_match('/^(theme:)([\w\d\-\_]+)$/', $lower, $m)) {
                    if ($themes[$m[2]]) {
                        $theme = $themes[$m[2]];
                        continue;
                    }
                }
                else if (preg_match('/^(style[\t\s]*["\']?=)([^\t\s]+)/i', $lower, $m)) {
                    $inner_style = $m[1];
                    continue;
                }
                /*else if($lower == 'force') {
                    $is_skip = FALSE;
                    continue;
                }*/
            }
            $data[] = $arg;
        }

        if (defined('ENVIRONMENT') === true && constant('ENVIRONMENT') == 'production') {
            return;
        }


        if (empty($data)) {
            $data = '';
        }
        else if (!count($data)) {
            ;
        }
        else if (count($data) <= 1) {
            $data = array_shift($data);
        }

        //========================
        switch (fn_content_type()) {
            case 'cli':
                {
                    print (is_scalar($data) ? $data : print_r($data, true)) . PHP_EOL;
                    break;
                }
            case 'json' :
                {
                    print json_encode($data);
                    break;
                }
            case 'js' :
                {
                    if (!is_scalar($data)) {
                        if (is_object($data)) {
                            $data = fn_obj2arr($data);
                        }
                        else if (is_resource($data)) {
                            $data = ['resource' => get_resource_type($data)];
                        }

                        $data = print_r($data, true);
                    }
                    print 'var message=' . json_encode($data) . ';';
                    print 'alert(message)';
                    break;
                }

            default:
                {
                    $data = htmlentities(is_scalar($data) ? $data : print_r($data, true));
                    #$data = str_replace(['<'.'?', '?'.'>'], ['&lt;?', '?&gt;'], $data);
                    print '<div style="clear:both;margin:5px auto;padding:5px;zoom:1;display:block;text-align:left;' . $theme . '">';
                    print '<code style="margin:5px 0;padding:5px;text-align:left;line-height:1.5em;font-size:11px;font-family:Verdana;';
                    print 'word-break:break-all;word-wrap:break-word;white-space:pre-wrap;' . $theme . ';' . $inner_style . '">' . $data . '</code></div>';
                    break;
                }

            //========================
        }
    }
endif;
// ---------------------------------------------------------------------------------------------------

/**
 * MySQL - 특수문자 escape 처리 함수
 * @param $value array|string|int
 * @param mysqli|resource $link
 * @return string
 */
function fn_sql_quote($value, $link = null)
{
    global $g5;
    !$link && ($link = $g5['connect_db']);

    $returnValue = $value;

    if (is_array($returnValue) === true) {
        array_walk($returnValue, function (&$val, &$key) {
            global $link;
            $val = fn_sql_quote($val, $link);
        });
    }
    else if (is_scalar($returnValue) === true) {
        $returnValue = '\'' . (function_exists('mysqli_real_escape_string') ? mysqli_real_escape_string($link, $returnValue) : mysql_real_escape_string($returnValue, $link)) . '\'';
    }

    return $returnValue;
}

// ---------------------------------------------------------------------------------------------------

/**
 * MySQL - 쿼리 실행 후 특정 필드의 값만 가져오기
 * @param $sql
 * @param int $rowIndex
 * @param bool $error
 * @param null $link
 * @return bool
 */
function fn_sql_row($sql, $rowIndex = 0, $error = G5_DISPLAY_SQL_ERROR, $link = null)
{
    global $g5;

    !$link && ($link = $g5['connect_db']);
    $smth = sql_query($sql, $error, $link);
    if (!$smth) return false;

    $row = function_exists('mysqli_fetch_row') ? mysqli_fetch_row($smth) : mysql_fetch_row($smth);
    return $row[$rowIndex];
}

// ---------------------------------------------------------------------------------------------------

/**
 * MySQL - 쿼리 실행 후 모든 데이터 가져오기
 * @param $sql
 * @param int $mode MYSQLI_ASSOC | MYSQLI_NUM | MYSQLI_BOTH
 * @param bool $error
 * @param mysqli|resource $link
 * @return array|bool|null
 */
function fn_sql_fetch_all($sql, $mode = MYSQLI_ASSOC, $error = G5_DISPLAY_SQL_ERROR, $link = null)
{
    global $g5;
    $rows = [];

    ($mode !== MYSQLI_ASSOC && $mode !== MYSQLI_NUM && $mode !== MYSQLI_BOTH) && die('<p>Invalid callback parameter(mode).</p><p>File: ' . basename($_SERVER['SCRIPT_NAME']) . '</p>');

    !$link && ($link = $g5['connect_db']);
    $smth = sql_query($sql, $error, $link);

    if (!$smth) {
        return false;
    }
    else if (function_exists('mysqli_fetch_all') === true) {
        $rows = mysqli_fetch_all($smth, $mode);
    }
    else {
        $callback = [MYSQLI_ASSOC => 'mysql_fetch_assoc', MYSQLI_NUM => 'mysql_fetch_row', MYSQLI_BOTH => 'mysql_fetch_array'][$mode];
        while ($row = call_user_func_array($callback, [$smth])) {
            $rows[] = $row;
        }
    }

    if (MYSQLI_NUM == $mode) {
        foreach ($rows as &$row) $row = $row[0];
    }
    return $rows;
}

// ---------------------------------------------------------------------------------------------------

/**
 * @param int $page_no
 * @param int $total
 * @return array
 * @example
 * [$limit, $pages, $max_no] = fn_sql_build_limit($page, $total);
 * $paging = fn_sql_build_limit($page, $total);
 * echo 'Limit: ', $paging['limit'], ', Pages: ', $paging['pages'];
 */
function fn_sql_build_limit($page_no = 1, $total = 0)
{
    global $config;

    $page_no = max($page_no, 1);
    $row_count = $config['cf_page_rows'];
    $return = [];


    if ($total < $row_count) {
        $return[0] = $return['limit'] = '';
        $return[1] = $return['pages'] = 1;
        $return[2] = $return['max_no'] = $total;
    }
    else {
        $offset = ($page_no - 1) * $row_count;
        $return[0] = $return['limit'] = "limit {$offset}, {$row_count}";
        $return[1] = $return['pages'] = (int)ceil($total / $row_count);
        $return[2] = $return['max_no'] = $total - $offset;
    }

    return $return;
}

// ------------------------------------------------------------------------

/**
 * 상품분류를 JSON 형때로 출력하기 위한 함수
 * @param bool $is_cache
 * @return  array
 */
function fn_shop_categories_map($is_cache = false)
{
    $categories = get_shop_category_array($is_cache);
    return __shop_categories_map_recursion($categories);
}

/**
 * fn_shop_categories_map의 재귀용 함수
 * @access  private
 * @param   array $rows
 * @return  array
 */
function __shop_categories_map_recursion(array & $rows)
{
    $return_value = [];
    foreach ($rows as $id => $row) {
        $info = $row['text'];
        unset($row['text']);

        $category = [
            'id' => $info['ca_id']
            , 'title' => $info['ca_name']
            , 'active' => intval($info['ca_use']) === 1
            , 'link' => $info['url']
            , 'child' => null
        ];

        empty($row) !== true && $category['child'] = __shop_categories_map_recursion($row);
        $return_value[] = $category;
    }
    return $return_value;
}

// ------------------------------------------------------------------------

/**
 * @return string
 */
function fn_shop_categories_nav()
{
    $categories = fn_shop_categories_map(true);
    ob_start();
    print '<div class="dropdown-menu">';
    array_walk($categories, '__shop_categories_nav_list');
    print '</div>';
    $buffer = ob_get_clean();
    return $buffer;
}

function __shop_categories_nav_list(&$category)
{
    $has_child = $category['child'] && is_array($category['child']) ? 'true' : '';
    if (!$category['active']) return true;

    print "<a class=\"dropdown-menu-item\" href=\"{$category['link']}\" data-has-child=\"{$has_child}\">{$category['title']}";

    if ($has_child) {
        print '<ul class="dropdown-menu">';
        array_walk($category['child'], '__shop_categories_nav_list');
        print '</ul>';
    }
    print "</a>";

    return true;
}

// ------------------------------------------------------------------------

function fn_get_agent($mb_id)
{
    global $g5;
    if (preg_match("/[^0-9a-z_]+/i", $mb_id)) return [];

    $sql = "SELECT * FROM {$g5['tb_agents']} WHERE ag_mb_id = " . fn_sql_quote($mb_id);
    return sql_fetch($sql);

}

function fn_ajax_output($response)
{
    ob_get_level() > 0 && ob_end_clean();

    @header('Content-type: text/json; charset=UTF-8');
    is_array($response) && ($response = json_encode($response, JSON_UNESCAPED_UNICODE));
    print $response;
    die;
}

// -----------------------------------------------------------------------------------

if (!function_exists('fn_tp')):
    /**
     * 경과 시간 계산(인식 가능하도록 시:분:초단위로 표시
     * @param string|float $microTime microtime(TRUE)
     * @return string 00:00:00.000
     */
    function fn_tp($microTime)
    {
        $time = '';
        list($sec, $msec) = explode('.', sprintf('%0.3f', microtime(true) - $microTime));

        if ($sec >= 3600) {// 1시간 이상
            $time .= sprintf('%02d', floor($sec / 3600)) . ':';
            $sec = $sec % 3600;
        }

        if ($sec >= 60) { // 1분 이상
            $time .= sprintf('%02d', floor($sec / 60)) . ':';
            $sec = $sec % 60;
        }
        else {
            $time .= '00:';
        }
        $time .= sprintf('%02d', $sec) . '.' . $msec;
        return $time;
    }
endif;

// -----------------------------------------------------------------------------------

/**
 * 추천인 포인트 지급(본인인증 값으로 중복 지급 체크)
 * @param string $to        피추천인
 * @param string $from      추천한 사람
 * @param string|int $point 지급 포인트
 * @param string $dupinfo   본인인증 DI 값
 * @return bool
 */
function fn_reward_nominee($to, $from, $point, $dupinfo = '')
{

    global $g5;
    if (empty($dupinfo) === true) return false;
    $in = "SELECT mb_id FROM {$g5['member_table']} WHERE mb_dupinfo = " . fn_sql_quote($dupinfo);
    $sql = "SELECT COUNT(0) FROM {$g5['point_table']} WHERE mb_id=" . fn_sql_quote($to) . " AND po_rel_table = '@recommend' AND po_rel_id IN($in)";
    
    if (fn_sql_row($sql) > 0) return true;
    insert_point($to, $point, $from . '의 추천인', '@recommend', $to, $from . ' 추천', -1);

    return true;
}

// -----------------------------------------------------------------------------------

/**
 * 추천인 포인트 회수
 * @param string $to    피추천인
 * @param string $from  추천했던 사람
 */
function fn_withdrawal_nominee($to, $from)
{
    global $g5;
    $sql = "SELECT po_point FROM {$g5['point_table']} WHERE mb_id=" . fn_sql_quote($to) . " AND po_rel_table = '@recommend' AND po_rel_id =" . fn_sql_quote($from);
    ($point = fn_sql_row($sql)) > 0 &&
    insert_point($to, $point * -1, $from . '님 탈퇴 - 추천 포인트 반환', '@recommend', $to, "{$from} 탈퇴-추천인 삭제", -1);
}