<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

/**
 * 관리자 메뉴 구성
 */
$_dirname = [
    '100' => 'config',
    '200' => 'member',
    '300' => 'board',
    '400' => 'shop',
    '500' => 'shopetc',
    '600' => '',
    '700' => '',
    #'900' => 'sms',
    '900' => 'coolsms',
    '999' => 'theme',
];

$dir_icon = [
    'config' => 'fa-sliders-h',
    'member' => 'fa-user',
    'board' => 'fa-list-alt',
    'shop' => 'fa-shopping-cart',
    'shopetc' => 'fa-chart-pie',
    'sms' => 'fa-mobile',
    'coolsms' => 'fa-mobile',
    'theme' => 'fa-puzzle-piece',
];

/**
 * 관리자 메뉴 확장
 */
@include_once(EYOOM_ADMIN_INC_PATH . '/admin.menu.extend.php');
/**
 * 메뉴 예외처리
 */
$except_menu = ['cf_theme', 'cf_menu', 'cf_service', 'scf_write_count', 'scf_item_type', 'shop_index'];
if (!$is_youngcart) $except_menu[] = 'eyb_shopmenu';
/**
 * phpinfo
 */
$extra_url = [
    'cf_phpinfo' => EYOOM_ADMIN_CORE_URL . '/config/phpinfo.php',
];

$i = 0;
$admmenu = [];

foreach ($amenu as $key => $value) {
    if ((!$is_youngcart && ($key == 400 || $key == 500)) || !isset($_dirname[$key]) || !isset($menu['menu' . $key][0][2])) continue;

    $subkey = 'menu' . $key;
    $_dir = $_dirname[$key];

    [$_code, $_title, $_link, $_id] = reset($menu[$subkey]);

    $parts = parse_url($_link);
    $entry = [
        'href' => G5_ADMIN_URL . "/?dir={$_dir}&pid=" . pathinfo($parts['path'], PATHINFO_FILENAME)
        , 'menu' => $_title
        , 'active' => $_dir == $dir ? 'active' : ''
        , 'fa_icon' => $dir_icon[$_dir]
    ];
    empty($parts['query']) !== true && ($entry['href'] .= "&{$parts['query']}");

    if ($menu[$subkey] && is_array($menu[$subkey])) {

        foreach ($menu[$subkey] as $submenu) {
            [$subCode, $subTitle, $subLink, $subId, $subRank] = $submenu;

            empty($subCode) == true && ($subCode = ['cf_basic' => '100100', 'cf_auth' => '100200'][$subId]);

            // 최고 관리자가 아닌경우
            if ($subCode === $_code || (!in_array($is_admin, ['super', 'operator']) && (!isset($auth[$subCode]) || strstr($auth[$subCode], 'r'))) || in_array($subId, $except_menu)) {
                continue;
            }
            $parts = parse_url($subLink);
            $row = ['skey' => $subCode, 'menu' => $subTitle];

            if (array_key_exists($subId, $extra_url)) {
                $row['href'] = $extra_url[$subId];
                $row['target'] = 'target="_blank"';
            }
            else {
                $row['href'] = G5_ADMIN_URL . "?dir={$_dir}&pid=" . pathinfo($parts['path'], PATHINFO_FILENAME);
                empty($parts['query']) !== true && ($row['href'] .= "&{$parts['query']}");
            }

            $entry['submenu'][] = $row;
            $auth_menu[$subCode] = $subTitle;
        };
    }

    $admmenu[] = $entry;
}
unset($subkey, $_dir, $_code, $_title, $_link, $_id, $parts, $submenu, $subCode, $subTitle, $subLink, $subId, $subRank);
unset($menu, $amenu);
