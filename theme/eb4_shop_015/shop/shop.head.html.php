<?php
if (!defined('_EYOOM_')) exit;
define('_IS_SHOP_', true);
require __DIR__.'/../head.html.php';
return ;



add_stylesheet('<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;700&display=swap" rel="stylesheet">', 0);

if ($eyoom['is_responsive'] == '1' || G5_IS_MOBILE) { // 반응형 또는 모바일일때
    add_stylesheet('<link rel="stylesheet" href="' . EYOOM_THEME_URL . '/css/shop-style.css?ver=' . G5_CSS_VER . '">', 0);
    add_stylesheet('<link rel="stylesheet" href="' . EYOOM_THEME_URL . '/css/grid.css?ver=' . G5_CSS_VER . '">', 0);
}
else if ($eyoom['is_responsive'] == '0' && !G5_IS_MOBILE) { // 비반응형이면서 PC버전일때
    add_stylesheet('<link rel="stylesheet" href="' . EYOOM_THEME_URL . '/css/shop-style-nr.css?ver=' . G5_CSS_VER . '">', 0);
    add_stylesheet('<link rel="stylesheet" href="' . EYOOM_THEME_URL . '/css/grid-nr.css?ver=' . G5_CSS_VER . '">', 0);
}
add_stylesheet('<link rel="stylesheet" href="' . EYOOM_THEME_URL . '/css/custom.css?ver=' . G5_CSS_VER . '">', 0);

/**
 * 로고 타입 : 'image' || 'text'
 */
$logo = 'image';

/**
 * 상품 이미지 미리보기 종류 : 'zoom' || 'slider'
 */
$item_view = 'zoom';

?>

<?php if (!$wmode) { ?>
    <div class="wrapper">
    <?php
    // 팝업창
    if (defined('_INDEX_') && $newwin_contents) { // index에서만 실행
        echo $newwin_contents;
    }
    ?>
    <?php /* 편집버튼 */ ?>
    <?php if ($is_admin) { // 관리자일 경우 ?>
        <div class="btn-edit-admin eyoom-form visible-lg">
            <input type="hidden" name="edit_mode" id="edit_mode" value="<?php echo $eyoom_default['edit_mode']; ?>">
            <label class="toggle red-toggle">
                <input type="checkbox" id="btn_edit_mode" <?php echo $eyoom_default['edit_mode'] == 'on' ? 'checked' : ''; ?>><i></i><span class="color-grey font-size-12">편집모드</span>
            </label>
        </div>
    <?php } ?>
<div class="wrapper-inner <?php if ($eyoom['layout'] == 'boxed') echo 'wrapper-boxed'; ?>">
    <header class="header">
        <?php /* EB슬라이더 - shop015 top banner */ ?>
        <?php echo eb_slider('1628830035'); ?>
        <div class="top-bar">
            <div class="f-container">
                <div class="f-row">
                    <div class="f-col-lg-6">
                        <ul class="top-bar-left">
                            <li>
                                <?php if ($is_member) { // 회원일 경우 ?>
                                    <a href="<?php echo G5_BBS_URL; ?>/logout.php">로그아웃</a>
                                <?php } else { ?>
                                    <a href="<?php echo G5_BBS_URL; ?>/login.php">로그인</a>
                                <?php } ?>
                            </li>
                            <li>
                                <?php if ($is_member) { // 회원일 경우 ?>
                                    <a href="<?php echo G5_SHOP_URL; ?>/mypage.php">마이페이지</a>
                                <?php } else { ?>
                                    <a href="<?php echo G5_BBS_URL; ?>/register.php">회원가입</a>
                                <?php } ?>
                            </li>
                            <!-- li><a href="<?php echo G5_SHOP_URL; ?>/couponzone.php">쿠폰</a></li -->
                            <li>
                                <a href="<?php echo G5_SHOP_URL; ?>/wishlist.php">
                                    위시리스트<span><?php echo get_wishlist_datas_count(); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo G5_SHOP_URL; ?>/cart.php">
                                    장바구니<span><?php echo get_boxcart_datas_count(); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="f-col-lg-6 hidden-xs hidden-sm">
                        <div class="top-bar-right">
                            <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);" class="eyoom-form">
                                <input type="hidden" name="sfl" value="wr_subject||wr_content">
                                <input type="hidden" name="sop" value="and">
                                <label for="head_sch_str" class="sound_only">검색어 입력 필수</strong></label>
                                <div class="input input-button">
                                    <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="head_sch_str" class="sch_stx" placeholder="상품 검색어 입력" required>
                                    <div class="button"><input type="submit"><i class="fa fa-search"></i></div>
                                </div>
                            </form>
                            <div class="btn-icon">
                                <a href="<?php echo G5_URL; ?>" title="커뮤니티"><i class="fas fa-comment-alt"></i></a>
                            </div>
                            <div class="btn-icon">
                                <a id="bookmarkme" href="javascript:void(0);" rel="sidebar" title="북마크"><i class="fas fa-bookmark"></i></a>
                                <script>
                                    $(function () {
                                        $("#bookmarkme").click(function () {
                                            // Mozilla Firefox Bookmark
                                            if ('sidebar' in window && 'addPanel' in window.sidebar) {
                                                window.sidebar.addPanel(location.href, document.title, "");
                                            }
                                            else if (/*@cc_on!@*/false) { // IE Favorite
                                                window.external.AddFavorite(location.href, document.title);
                                            }
                                            else { // webkit - safari/chrome
                                                alert('단축키 ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Command' : 'CTRL') + ' + D를 눌러 북마크에 추가하세요.');
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-title">
            <div class="f-container">
                <?php /* 배너 슬라이더 왼쪽 */ ?>
                <div class="header-banner header-banner-left">
                    <?php /* EB 슬라이더 - shop015 header slider */ ?>
                    <?php echo eb_slider('1628830352'); ?>
                </div>

                <?php /* 로고 */ ?>
                <div class="logo-header">
                    <?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
                        <div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="top:-2px;left:15px;text-align:left">
                            <div class="btn-group">
                                <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=biz_info&amp;amode=shoplogo&amp;thema=<?php echo $theme; ?>&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i>
                                    로고 설정</a>
                                <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=biz_info&amp;amode=shoplogo&amp;thema=<?php echo $theme; ?>" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
                                    <i class="far fa-window-maximize"></i>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    <h1>
                        <a href="<?php echo G5_SHOP_URL; ?>">
                            <?php if ($logo == 'text') { ?>
                                <span><?php echo $config['cf_title']; ?></span>
                            <?php } else if ($logo == 'image') { ?>
                                <?php if (!G5_IS_MOBILE) { ?>
                                    <?php if (file_exists($top_logo) && !is_dir($top_logo)) { ?>
                                        <img src="<?php echo $logo_src['top']; ?>" alt="<?php echo $config['cf_title']; ?>">
                                    <?php } else { ?>
                                        <img src="<?php echo EYOOM_THEME_URL; ?>/image/site_logo.png" alt="<?php echo $config['cf_title']; ?>">
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if (file_exists($top_mobile_logo) && !is_dir($top_mobile_logo)) { ?>
                                        <img src="<?php echo $logo_src['mobile_top']; ?>" alt="<?php echo $config['cf_title']; ?>">
                                    <?php } else { ?>
                                        <img src="<?php echo EYOOM_THEME_URL; ?>/image/site_logo.png" alt="<?php echo $config['cf_title']; ?>">
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </a>
                    </h1>
                </div>

                <?php /* 배너 슬라이더 오른쪽 */ ?>
                <div class="header-banner header-banner-right">
                    <?php /* EB 슬라이더 - shop015 header slider */ ?>
                    <?php echo eb_slider('1628830606'); ?>
                </div>
            </div>
        </div>

        <div class="gnb header-nav <?php if ($eyoom['sticky'] == 'y') echo 'header-fixed-on'; ?>">
            <nav class="navbar f-container">
                <?php /* 메뉴 편집 버튼 */ ?>
                <?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
                    <div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="top:-2px">
                        <div class="btn-group">
                            <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=menu_list&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="btn-e btn-e-xs btn-e-red btn-e-split"><i class="far fa-edit"></i>
                                메뉴 설정</a>
                            <a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=menu_list" target="_blank" class="btn-e btn-e-xs btn-e-red btn-e-split-red dropdown-toggle" title="새창 열기">
                                <i class="far fa-window-maximize"></i>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <h5 class="mobile-nav-title">메인 메뉴</h5>
                <?php /* Header Nav - 메인메뉴 */ ?>
                <ul class="nav navbar-nav">

                    <?php if (true) {

                        $categories = fn_shop_categories_map(true);
                        foreach ($categories as $category) {
                            if (!$category['active']) continue;
                            $has_child = $category['child'] && is_array($category['child']) === true ? 'true' : 'false';
                            $trigger = 'data-' . (G5_IS_MOBILE ? 'toggle' : 'hover') . '="dropdown"';

                            print "<li class=\"dropdown division\" data-has-child=\"{$has_child}\">";
                            print "<a href=\"{$category['link']}\" class=\"dropdown-toggle\" {$trigger}>{$category['title']}</a>";

                            if ($has_child === 'true') {
                                print "<ul class=\"dropdown-menu\">";
                                foreach ($category['child'] as $child) {
                                    print "<li><a href=\"{$child['link']}\">{$child['title']}</a></li>";
                                }
                                print '</ul>';
                            }
                            print "</li>";
                        }
                        ?>
                    <?php } else if ($eyoom['use_eyoom_shopmenu'] == 'n') { // 영카트 분류가 쇼핑몰 메뉴 출력 ?>
                        <?php if (isset($menu) && is_array($menu)) { ?>
                            <?php foreach ($menu as $key => $menu_1) { ?>
                                <li class="<?php if (isset($menu_1['active']) && $menu_1['active']) echo 'active'; ?> dropdown division">
                                    <a href="<?php echo $menu_1['href']; ?>" class="dropdown-toggle" <?php echo G5_IS_MOBILE ? 'data-toggle="dropdown"' : 'data-hover="dropdown"'; ?>>
                                        <?php echo $menu_1['ca_name']; ?>
                                    </a>
                                    <?php $index2 = 0;
                                    $size2 = count((array)$menu_1['submenu']); ?>
                                    <?php if (isset($menu_1['submenu']) && is_array($menu_1['submenu'])) { ?>
                                        <?php foreach ($menu_1['submenu'] as $subkey => $menu_2) { ?>
                                            <?php if ($index2 == 0) { ?>
                                                <ul class="dropdown-menu">
                                            <?php } ?>
                                            <li class="<?php if (isset($menu_2['active']) && $menu_2['active']) echo 'active'; ?>">
                                                <a href="<?php echo $menu_2['href']; ?>"><?php echo $menu_2['ca_name']; ?></a>
                                            </li>
                                            <?php if ($index2 == $size2 - 1) { ?>
                                                </ul>
                                            <?php } ?>
                                            <?php $index2++;
                                        } ?>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    <?php } else if ($eyoom['use_eyoom_shopmenu'] == 'y') { // 이윰 쇼핑몰 메뉴 출력 ?>
                        <?php if (isset($menu) && is_array($menu)) { ?>
                            <?php foreach ($menu as $key => $menu_1) { ?>
                                <li class="<?php if (isset($menu_1['active']) && $menu_1['active']) echo 'active'; ?> <?php if (isset($menu_1['submenu']) && $menu_1['submenu']) echo 'dropdown'; ?> division">
                                    <a href="<?php echo $menu_1['me_link']; ?>" target="_<?php echo $menu_1['me_target']; ?>" class="dropdown-toggle disabled" <?php echo G5_IS_MOBILE && isset($menu_1['submenu']) && $menu_1['submenu'] ? 'data-toggle="dropdown"' : 'data-hover="dropdown"'; ?>>
                                        <?php if ($menu_1['me_icon']) { ?>
                                        <i class="<?php echo $menu_1['me_icon']; ?>"></i><?php } ?>
                                        <?php echo $menu_1['me_name'] ?>
                                    </a>
                                    <?php if (isset($menu_1['submenu']) && is_array($menu_1['submenu'])) { ?>
                                        <a href="#" class="cate-dropdown-open dorpdown-toggle hidden-lg hidden-md" data-toggle="dropdown"></a>
                                    <?php } ?>
                                    <?php $index2 = 0;
                                    $size2 = count((array)$menu_1['submenu']); ?>
                                    <?php if (isset($menu_1['submenu']) && is_array($menu_1['submenu'])) { ?>
                                        <?php foreach ($menu_1['submenu'] as $subkey => $menu_2) { ?>
                                            <?php if ($index2 == 0) { ?>
                                                <ul class="dropdown-menu">
                                            <?php } ?>
                                            <li class="dropdown-submenu <?php if (isset($menu_2['active']) && $menu_2['active']) echo 'active'; ?>">
                                                <a href="<?php echo $menu_2['me_link']; ?>" target="_<?php echo $menu_2['me_target']; ?>">
                                                    <?php if (isset($menu_2['me_icon']) && $menu_2['me_icon']) { ?>
                                                        <i class="<?php echo $menu_2['me_icon']; ?>"></i>
                                                    <?php } ?>
                                                    <?php echo $menu_2['me_name']; ?>
                                                </a>
                                                <?php $index3 = 0;
                                                $size3 = count((array)$menu_2['subsub']); ?>
                                                <?php if (isset($menu_2['subsub']) && is_array($menu_2['subsub'])) { ?>
                                                    <?php foreach ($menu_2['subsub'] as $ssubkey => $menu_3) { ?>
                                                        <?php if ($index3 == 0) { ?>
                                                            <ul class="dropdown-menu">
                                                        <?php } ?>
                                                        <li class="dropdown-submenu <?php if (isset($menu_3['active']) && $menu_3['active']) echo 'active'; ?>">
                                                            <a href="<?php echo $menu_3['me_link']; ?>" target="_<?php echo $menu_3['me_target']; ?>">
                                                                <?php if (isset($menu_3['me_icon']) && $menu_3['me_icon']) { ?>
                                                                    <i class="<?php echo $menu_3['me_icon']; ?>"></i>
                                                                <?php } ?>
                                                                <span class="hidden-md hidden-lg">-</span> <?php echo $menu_3['me_name']; ?>
                                                                <?php if (isset($menu_3['sub']) && $menu_3['sub'] == 'on') { ?>
                                                                    <i class="fas fa-angle-right sub-caret hidden-sm hidden-xs"></i>
                                                                    <i class="fas fa-angle-down sub-caret hidden-md hidden-lg"></i>
                                                                <?php } ?>
                                                            </a>
                                                        </li>
                                                        <?php if ($index3 == $size3 - 1) { ?>
                                                            </ul>
                                                        <?php } ?>
                                                        <?php $index3++;
                                                    } ?>
                                                <?php } ?>
                                            </li>
                                            <?php if ($index2 == $size2 - 1) { ?>
                                                </ul>
                                            <?php } ?>
                                            <?php $index2++;
                                        } ?>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </header>

    <?php /* header-sticky-space */ ?>
    <div class="header-sticky-space <?php if ($eyoom['sticky'] == 'y') echo 'header-fixed-on'; ?>"></div>

    <?php /* 사이드 고정 콘텐츠 */ ?>
    <div class="fix-wrap">
        <?php /* pc:우측 고정 메뉴 / 모바일:하단메뉴 */ ?>
        <div class="fix-navi clear-after">
            <ul class="list-unstyled">
                <li class="hidden-md hidden-lg text-center">
                    <a href="<?php echo G5_SHOP_URL; ?>">
                        <img src="<?php echo EYOOM_THEME_URL; ?>/image/icons/icon_home.png" alt="홈">
                    </a>
                    <p>홈</p>
                </li>
                <li class="text-center">
                    <a href="#" data-toggle="modal" data-target=".search-contents-modal">
                        <img src="<?php echo EYOOM_THEME_URL; ?>/image/icons/icon_search.png" alt="검색">
                    </a>
                    <p class="text-center">검색</p>
                </li>
                <li class="btn-latest-goods text-center">
                    <a href="">
                        <img src="<?php echo EYOOM_THEME_URL; ?>/image/icons/icon_clock.png" alt="최근본상품">
                        <em><?php echo get_view_today_items_count(); ?></em>
                    </a>
                    <p>검색</p>
                </li>
                <li class="text-center">
                    <a href="<?php echo G5_SHOP_URL; ?>/cart.php">
                        <img src="<?php echo EYOOM_THEME_URL; ?>/image/icons/icon_bag.png" alt="장바구니">
                        <em><?php echo get_boxcart_datas_count(); ?></em>
                    </a>
                    <p>장바구니</p>
                </li>
                <li class="text-center">
                    <?php if ($is_member) { // 회원일 경우 ?>
                    <a href="<?php echo G5_SHOP_URL; ?>/mypage.php">
                        <?php } else { ?>
                        <a href="<?php echo G5_BBS_URL; ?>/login.php">
                            <?php } ?>
                            <img src="<?php echo EYOOM_THEME_URL; ?>/image/icons/icon_user.png" alt="마이페이지">
                        </a>
                        <p>마이페이지</p>
                </li>
                <?php if ($is_admin == 'super' || $is_auth) { // 관리자일 경우 ?>
                    <li class="text-center">
                        <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">
                            <img src="<?php echo EYOOM_THEME_URL; ?>/image/icons/icon_cog.png" alt="관리자">
                        </a>
                        <p>관리자</p>
                    </li>
                <?php } ?>
                <?php if ($is_member) { // 회원일 경우 ?>
                    <li class="hidden-md hidden-lg text-center">
                        <a href="<?php echo G5_BBS_URL; ?>/logout.php"><img src="<?php echo EYOOM_THEME_URL; ?>/image/icons/icon_power.png" alt="로그아웃"></a>
                        <p>로그아웃</p>
                    </li>
                <?php } ?>
                <li class="btn-mo-nav hidden-md hidden-lg text-center">
                    <a href=""><img src="<?php echo EYOOM_THEME_URL; ?>/image/icons/icon_bar.png" alt="메인메뉴"></a>
                    <p>메인메뉴</p>
                </li>
                <li class="hidden-xs hidden-sm go-to-top">
                    <a href="">
                        <i class="fas fa-caret-up"></i>
                    </a>
                </li>
                <li class="hidden-xs hidden-sm go-to-bottom">
                    <a href="">
                        <i class="fas fa-caret-down"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <?php /* 최근본상품 */ ?>
    <div class="latest-goods"><?php include(EYOOM_THEME_SHOP_SKIN_PATH . '/boxtodayview.skin.html.php'); // 오늘 본 상품 ?></div>

    <?php /* 검색모달 */ ?>
    <div class="modal fade contents-modal shop-contents-modal search-contents-modal" aria-hidden="true">
        <div class="modal-box">
            <div class="modal-content">
                <button type="button" data-dismiss="modal" class="btn-close"><i class="fas fa-times"></i></button>
                <div class="modal-body">
                    <div class="search-contents">
                        <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);" class="eyoom-form">
                            <input type="hidden" name="sfl" value="wr_subject||wr_content">
                            <input type="hidden" name="sop" value="and">
                            <label for="side_sch_str" class="sound_only">검색어 입력 필수</strong></label>
                            <div class="input input-button">
                                <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="modal_sch_str" placeholder="상품 검색어 입력" required>
                                <div class="button"><input type="submit">검색</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php /* Basic Body */ ?>
<main class="basic-body <?php if (!defined('_INDEX_')) { ?>sub-basic-body<?php } ?>">
    <?php /* 페이지 타이틀 */ ?>
    <?php if (!defined('_INDEX_')) { ?>
        <div class="f-container">
            <div class="page-title-wrap">
                <?php if (!defined('_EYOOM_MYPAGE_')) { ?>
                    <h2 class="pull-left">
                        <i class="fas fa-map-marker-alt"></i> <?php echo $subinfo['title']; ?>
                    </h2>
                    <?php if (!$it_id) { ?>
                        <ul class="breadcrumb pull-right hidden-xs">
                            <?php echo $subinfo['path']; ?>
                        </ul>
                    <?php } ?>
                    <div class="clearfix"></div>
                <?php } else { ?>
                    <h2><i class="fas fa-map-marker-alt"></i> 마이페이지</h2>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <?php if (!defined('_INDEX_')) { ?>
    <div class="basic-body-page">
        <?php /* 페이지 카테고리 시작, 서브페이지 사이드 레이아웃 사용 + 991px 이하에서만 출력 */ ?>
        <?php if ($side_layout['use'] == 'yes') { ?>
            <div class="category-mobile-area">
                <?php if ($sidemenu) { ?>
                    <div class="tab-scroll-page-category">
                        <div class="scrollbar">
                            <div class="handle">
                                <div class="mousearea"></div>
                            </div>
                        </div>
                        <div id="tab-page-category">
                            <div class="page-category-list">
                                <?php foreach ($sidemenu as $smenu) { ?>
                                    <span <?php if ($smenu['active']) echo 'active'; ?>><a href="<?php echo $smenu['me_link']; ?>" target="_<?php echo $smenu['me_target']; ?>"><?php echo $smenu['me_name']; ?></a></span>
                                <?php } ?>
                                <span class="fake-span"></span>
                            </div>
                            <div class="controls">
                                <button class="btn prev"><i class="fas fa-caret-left"></i></button>
                                <button class="btn next"><i class="fas fa-caret-right"></i></button>
                            </div>
                        </div>
                        <div class="tab-page-category-divider"></div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php /* 페이지 카테고리 끝 */ ?>
    </div>

    <div class="f-container">
    <div class="f-row">
<?php } ?>

    <?php if ($side_layout['use'] == 'yes') { ?>
    <?php
    if ($side_layout['pos'] == 'left') {
        /* 사이드영역 시작 */
        include_once(EYOOM_THEME_SHOP_PATH . '/shop.side.html.php');
        /* 사이드영역 끝 */
    }
    ?>
    <article class="basic-body-main <?php if ($side_layout['pos'] == 'left') {
        echo 'right';
    }
    else {
        echo 'left';
    } ?>-main f-col-md-9">
    <?php } else { ?>
    <article class="basic-body-main f-col-12">
<?php } ?>


<?php } ?>