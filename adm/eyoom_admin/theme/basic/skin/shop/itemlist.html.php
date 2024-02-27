<?php
/**
 * Eyoom Admin Skin File
 * @file    ~/theme/basic/skin/shop/itemlist.html.php
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;

add_stylesheet('<link rel="stylesheet" href="' . EYOOM_ADMIN_THEME_URL . '/plugins/jsgrid/jsgrid.min.css" type="text/css" media="screen">', 0);
add_stylesheet('<link rel="stylesheet" href="' . EYOOM_ADMIN_THEME_URL . '/plugins/jsgrid/jsgrid-theme.min.css" type="text/css" media="screen">', 0);
$sheet = [];

foreach ($list as $index => $item) {
    $item_id = $item['it_id'];
    $item_url = G5_ADMIN_URL . "/?dir=shop&pid=itemform&it_id={$item['it_id']}&w=u";
    $copy_url = G5_ADMIN_URL . "?dir=shop&pid=itemcopy&it_id={$row['it_id']}&ca_id={$item['ca_id']}&wmode=1" . ($qstr ? "&{$qstr}" : '');
    $edit_popup = G5_IS_MOBILE || $wmode ? '' : "{$item_url}&wmode=1";

    $sheet[] = [
        'check' => "<label class=\"checklist\"><input type=\"checkbox\" name=\"idx[]\" value=\"{$item_id}\" /><i class=\"checkmark\"></i></label>",
        'manage' => "<a href='{$item_url}&ca_id={$item['ca_id']}&{$qstr}'><u>수정</u></a><!--
                        --><a href='{$copy_url}' class='itemcopy eb-modal margin-left-10'><u>복사</u></a><!--
                        --><a href='{$item['href']}' target='_blank' class='margin-left-10'><u>보기</u></a>",
        'itemID' => "<a href='{$edit_popup}' class='eb-modal'><i class='fas fa-external-link-alt color-light-grey margin-right-5 hidden-xs'></i><strong>{$item['it_id']}</strong></a>",
        'photo' => "<div style='width:50px;margin:0 auto'><a href='{$item['href']}' target='_blank'>{$item['image']}</a></div>",
        'itemName' => "<label class='input'><input type='text' name='item[{$item_id}][it_name]' id='it_name_{$index}' value='" . get_text($item['it_name']) . "' required></label>
                        <div class='item-type-divider'></div>
                        <div class='item-type-box'>
                            <div class='inline-group item-type-group'>
                                <label class='checkbox' for='it_type1_{$index}'>
                                    <input type='checkbox' name='item[{$item_id}][it_type1]' id='it_type1_{$index}' value='1'" . ($item['it_type1'] ? ' checked' : '') . " /><i></i>
                                    <span class='label bg-dark lighter color-white'>히트</span>
                                </label>
                                <label class='checkbox' for='it_type2_{$index}'>
                                    <input type='checkbox' name='item[{$item_id}][it_type2]' id='it_type2_{$index}' value='1'" . ($item['it_type2'] ? ' checked' : '') . " /><i></i>
                                    <span class='label bg-yellow lighter color-white'>추천</span>
                                </label>
                                <label class='checkbox' for='it_type3_{$index}'>
                                    <input type='checkbox' name='item[{$item_id}][it_type3]' id='it_type3_{$index}' value='1'" . ($item['it_type3'] ? ' checked' : '') . " /><i></i> 
                                    <span class='label bg-red lighter color-white'>신상</span>
                                </label>
                                <label class='checkbox' for='it_type4_{$index}'>
                                    <input type='checkbox' name='item[{$item_id}][it_type4]' id='it_type4_{$index}' value='1'" . ($item['it_type4'] ? ' checked' : '') . " /><i></i> 
                                    <span class='label bg-green lighter color-white'>인기</span>
                                </label>
                                <label class='checkbox' for='it_type5_{$index}'>
                                    <input type='checkbox' name='item[{$item_id}][it_type5]' id='it_type5_{$index}' value='1'" . ($item['it_type5'] ? ' checked' : '') . " /><i></i> 
                                    <span class='label bg-purple lighter color-white'>할인</span>
                                </label>
                            </div>
                        </div>",
        'sort' => "<label class='input'><input type='text' name='item[{$item_id}][it_order]' id='it_order_{$index}' value='{$item['it_order']}'>",
        'stockQuantity' => number_format($item['it_stock_qty']) . ($item['processing'] > 0 ? ' (<strong class="color-orange">-' . number_format($item['processing']) . '</strong>)' : ''),
        'toShip' => $item['processing'] ? number_format($item['processing']) : 0,
        'soldQuantity' => $item['sales'] ? number_format($item['sales']) : 0,

        'listing' => "<label class='checkbox'><input type='checkbox' name='item[{$item_id}][it_use]' id='it_use_{$index}' value='1'" . ($item['it_use'] ? ' checked' : '') . " /><i></i></label>",
        'soldOut' => "<label class='checkbox'><input type='checkbox' name='item[{$item_id}][it_soldout]' id='it_soldout_{$index}' value='1'" . ($item['it_soldout'] ? ' checked' : '') . " /><i></i></label>",
        'listPrice' => "<label class='input'><input type='text' name='item[{$item_id}][it_price]' id='it_price_{$index}' value='{$item['it_price']}' />",
        'sellPrice' => "<label class='input'><input type='text' name='item[{$item_id}][it_cust_price]' id='it_cust_price_{$index}' value='{$item['it_cust_price']}' />",
        'createdAtDate' => (new DateTime($item['it_time']))->format('Y-m-d'),
    ];
}
?>

<style type="text/css">
    .admin-shop-itemlist .search-item-type .radio {margin-right: 20px}
    .admin-shop-itemlist .search-item-type .radio b {display: inline-block;font-weight: normal;width: 40px}
    .admin-shop-itemlist .search-item-type .radio .label {padding: 2px 0 1px;font-size: 10px;width: 40px;text-align: center}
    .admin-shop-itemlist #admin-shop-itemlist img {display: block;width: 100% \9;max-width: 100%;height: auto}
    .admin-shop-itemlist #admin-shop-itemlist .item-type-divider {border-bottom: 1px solid #e5e5e5;margin: 0.5em -0.5em}
    .admin-shop-itemlist #admin-shop-itemlist .item-type-box {margin-bottom: 0.5em}
    .admin-shop-itemlist #admin-shop-itemlist .item-type-group .checkbox {width: 115px;margin-right: 10px;padding: 0 0 0 25px;margin: inherit}
    .admin-shop-itemlist #admin-shop-itemlist .item-type-group .checkbox i {top: 5px}
    .admin-shop-itemlist #admin-shop-itemlist .item-type-group .checkbox .label {margin-left: 5px;padding: 2px 7px 1px;font-size: 10px}
    .checklist {margin-left: 6px;}
</style>

<div class="admin-shop-itemlist">
    <div class="adm-headline adm-headline-btn">
        <h3>상품 관리</h3>
        <div class="headline-btn">
            <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&pid=itemform" class="btn-e btn-e-red btn-e-lg"><i class="fas fa-plus"></i>
                상품등록</a>
            <?php if (!G5_IS_MOBILE) { ?>
                <a href="<?php echo G5_ADMIN_URL; ?>/?dir=shop&pid=itemexcel&wmode=1" class="eb-modal btn-e btn-e-teal btn-e-lg"><i class="fas fa-plus"></i>
                    상품일괄등록</a>
            <?php } ?>
        </div>
    </div>

    <form id="flist" name="flist" class="eyoom-form" method="get">
        <input type="hidden" name="dir" value="<?php echo $dir; ?>" id="dir">
        <input type="hidden" name="pid" value="<?php echo $pid; ?>" id="pid">
        <input type="hidden" name="sst" id="sst" value="<?php echo $sst; ?>">
        <input type="hidden" name="sod" id="sod" value="<?php echo $sod; ?>">

        <div class="adm-table-form-wrap adm-search-box">
            <div class="table-list-eb">
                <?php if (!G5_IS_MOBILE) { ?>
                <div class="table-responsive">
                    <?php } ?>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th class="table-form-th">
                                <label class="label">검색어</label>
                            </th>
                            <td colspan="3">
                                <div <?php if (!G5_IS_MOBILE) { ?>class="inline-group"<?php } ?>>
                                    <div class="margin-bottom-5">
                                        <label class="select form-width-150px">
                                            <select name="sfl" id="sfl">
                                                <option value="it_name" <?php echo get_selected($sfl, 'it_name'); ?>>
                                                    상품명
                                                </option>
                                                <option value="it_id" <?php echo get_selected($sfl, 'it_id'); ?>>상품코드
                                                </option>
                                                <option value="it_maker" <?php echo get_selected($sfl, 'it_maker'); ?>>
                                                    제조사
                                                </option>
                                                <option value="it_origin" <?php echo get_selected($sfl, 'it_origin'); ?>>
                                                    원산지
                                                </option>
                                                <option value="it_sell_email" <?php echo get_selected($sfl, 'it_sell_email'); ?>>
                                                    판매자 e-mail
                                                </option>
                                            </select><i></i>
                                        </label>
                                    </div>
                                    <span>
                                    <label class="input form-width-250px">
                                        <input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" autocomplete="off">
                                    </label>
                                </span>
                                </div>
                            </td>
                        </tr>
                        <?php if (!G5_IS_MOBILE) { ?>
                            <tr>
                            <th class="table-form-th">
                                <label class="label">기간검색</label>
                            </th>
                            <td>
                                <div class="inline-group">
                                    <div class="margin-bottom-5">
                                        <label class="select form-width-150px">
                                            <select name="sdt" id="sdt">
                                                <option value="it_time" <?php echo get_selected($sdt, 'it_time'); ?>>
                                                    등록일
                                                </option>
                                                <option value="it_update_time" <?php echo get_selected($sdt, 'it_update_time'); ?>>
                                                    수정일
                                                </option>
                                            </select><i></i>
                                        </label>
                                    </div>
                                    <span>
                                    <label class="input form-width-150px">
                                        <input type="text" id="fr_date" name="fr_date" value="<?php echo $fr_date; ?>" maxlength="10">
                                    </label>
                                </span>
                                    <span> - </span>
                                    <span>
                                    <label class="input form-width-150px">
                                        <input type="text" id="to_date" name="to_date" value="<?php echo $to_date; ?>" maxlength="10">
                                    </label>
                                </span>
                                    <span class="search-btns">
                                    <button type="button" onclick="javascript:set_date('오늘');" class="btn-e btn-e-sm btn-e-default">오늘</button>
                                    <button type="button" onclick="javascript:set_date('어제');" class="btn-e btn-e-sm btn-e-default">어제</button>
                                    <button type="button" onclick="javascript:set_date('이번주');" class="btn-e btn-e-sm btn-e-default">이번주</button>
                                    <button type="button" onclick="javascript:set_date('이번달');" class="btn-e btn-e-sm btn-e-default">이번달</button>
                                    <button type="button" onclick="javascript:set_date('지난주');" class="btn-e btn-e-sm btn-e-default">지난주</button>
                                    <button type="button" onclick="javascript:set_date('지난달');" class="btn-e btn-e-sm btn-e-default">지난달</button>
                                    <button type="button" onclick="javascript:set_date('전체');" class="btn-e btn-e-sm btn-e-default">전체</button>
                                </span>
                                </div>
                            </td>
                            <?php if (G5_IS_MOBILE) { ?>
                                </tr>
                                <tr>
                            <?php } ?>
                            <th class="table-form-th border-left-th">
                                <label class="label">판매여부</label>
                            </th>
                            <td>
                                <div class="inline-group">
                                    <label for="ituse_1" class="radio"><input type="radio" id="ituse_1" name="ituse" value="" <?php echo !$ituse ? 'checked' : ''; ?>><i></i>
                                        전체</label>
                                    <label for="ituse_2" class="radio"><input type="radio" id="ituse_2" name="ituse" value="1" <?php echo $ituse == '1' ? 'checked' : ''; ?>><i></i>
                                        예</label>
                                    <label for="ituse_3" class="radio"><input type="radio" id="ituse_3" name="ituse" value="2" <?php echo $ituse == '2' ? 'checked' : ''; ?>><i></i>
                                        아니오</label>
                                </div>
                            </td>
                            </tr>
                            <tr>
                            <th class="table-form-th">
                                <label class="label">카테고리</label>
                            </th>
                            <td>
                                <div class="inline-group">
                                <span>
                                    <label class="select form-width-150px">
                                        <select name="cate_a" id="cate_1" onchange="fsearchform_submit(1);">
                                            <option value="">::대분류::</option>
                                            <?php foreach ($cate1 as $ca) { ?>
                                                <option value="<?php echo $ca['ca_id']; ?>" <?php echo $cate_a == $ca['ca_id'] ? 'selected' : ''; ?>><?php echo $ca['ca_name']; ?></option>
                                            <?php } ?>
                                        </select><i></i>
                                    </label>
                                </span>
                                    <span>
                                    <label class="select form-width-150px">
                                        <select name="cate_b" id="cate_2" onchange="fsearchform_submit(2);">
                                            <option value="">::중분류::</option>
                                            <?php foreach ($cate2 as $ca) { ?>
                                                <option value="<?php echo $ca['ca_id']; ?>" <?php echo $cate_b == $ca['ca_id'] ? 'selected' : ''; ?>><?php echo $ca['ca_name']; ?></option>
                                            <?php } ?>
                                        </select><i></i>
                                    </label>
                                </span>
                                    <span>
                                    <label class="select form-width-150px">
                                        <select name="cate_c" id="cate_3" onchange="fsearchform_submit(3);">
                                            <option value="">::소분류::</option>
                                            <?php foreach ($cate3 as $ca) { ?>
                                                <option value="<?php echo $ca['ca_id']; ?>" <?php echo $cate_c == $ca['ca_id'] ? 'selected' : ''; ?>><?php echo $ca['ca_name']; ?></option>
                                            <?php } ?>
                                        </select><i></i>
                                    </label>
                                </span>
                                    <span>
                                    <label class="select form-width-150px">
                                        <select name="cate_d" id="cate_4" onchange="fsearchform_submit(4);">
                                            <option value="">::세분류::</option>
                                            <?php foreach ($cate4 as $ca) { ?>
                                                <option value="<?php echo $ca['ca_id']; ?>" <?php echo $cate_d == $ca['ca_id'] ? 'selected' : ''; ?>><?php echo $ca['ca_name']; ?></option>
                                            <?php } ?>
                                        </select><i></i>
                                    </label>
                                </span>
                                </div>
                            </td>
                            <?php if (G5_IS_MOBILE) { ?>
                                </tr>
                                <tr>
                            <?php } ?>
                            <th class="table-form-th border-left-th">
                                <label class="label">품절여부</label>
                            </th>
                            <td>
                                <div class="inline-group">
                                    <label for="itsoldout_1" class="radio"><input type="radio" id="itsoldout_1" name="itsoldout" value="" <?php echo !$itsoldout ? 'checked' : ''; ?>><i></i>
                                        전체</label>
                                    <label for="itsoldout_2" class="radio"><input type="radio" id="itsoldout_2" name="itsoldout" value="1" <?php echo $itsoldout == '1' ? 'checked' : ''; ?>><i></i>
                                        예</label>
                                    <label for="itsoldout_3" class="radio"><input type="radio" id="itsoldout_3" name="itsoldout" value="2" <?php echo $itsoldout == '2' ? 'checked' : ''; ?>><i></i>
                                        아니오</label>
                                </div>
                            </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th class="table-form-th">
                                <label class="label">상품유형</label>
                            </th>
                            <td colspan="3">
                                <div class="inline-group search-item-type">
                                    <label class="radio" for="itype0">
                                        <input type="radio" name="itype" id="itype0" value="" <?php echo !$itype ? 'checked' : ''; ?>><i></i>
                                        <b>전체</b>
                                        <span class="label label-default color-white">전체</span>
                                    </label>
                                    <label class="radio" for="itype1">
                                        <input type="radio" name="itype" id="itype1" value="1" <?php echo $itype == '1' ? 'checked' : ''; ?>><i></i>
                                        <span class="label bg-dark lighter color-white">히트</span>
                                    </label>
                                    <label class="radio" for="itype2">
                                        <input type="radio" name="itype" id="itype2" value="2" <?php echo $itype == '2' ? 'checked' : ''; ?>><i></i>
                                        <span class="label bg-yellow lighter color-white">추천</span>
                                    </label>
                                    <label class="radio" for="itype3">
                                        <input type="radio" name="itype" id="itype3" value="3" <?php echo $itype == '3' ? 'checked' : ''; ?>><i></i>
                                        <span class="label bg-red lighter color-white">신상</span>
                                    </label>
                                    <label class="radio" for="itype4">
                                        <input type="radio" name="itype" id="itype4" value="4" <?php echo $itype == '4' ? 'checked' : ''; ?>><i></i>
                                        <span class="label bg-green lighter color-white">인기</span>
                                    </label>
                                    <label class="radio" for="itype5">
                                        <input type="radio" name="itype" id="itype5" value="5" <?php echo $itype == '5' ? 'checked' : ''; ?>><i></i>
                                        <span class="label bg-purple lighter color-white">할인</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?php if (!G5_IS_MOBILE) { ?>
                </div>
            <?php } ?>
            </div>
        </div>

        <?php echo $frm_submit; ?>

        <div class="margin-bottom-30"></div>

        <div class="row">
            <div class="col col-9">
                <div class="margin-bottom-5">
                <span class="font-size-12 color-grey">
                    <a href="<?php echo G5_ADMIN_URL; ?>/?dir=<?php echo $dir; ?>&amp;pid=<?php echo $pid; ?>">[전체목록]</a><span class="margin-left-10 margin-right-10 color-light-grey">|</span>등록된 상품 <?php echo number_format($total_count); ?>
                    건
                </span>
                </div>
            </div>
            <div class="col col-3">
                <section>
                    <label for="sort_list" class="select" style="width:200px;float:right;">
                        <select name="sort_list" id="sort_list" onchange="sorting_list(this.form, this.value);">
                            <option value="">:: 정렬방식선택 ::</option>
                            <option value="it_id|asc" <?php echo $sst == 'it_id' && $sod == 'asc' ? 'selected' : ''; ?>>
                                제품코드
                                정방향 (↓)
                            </option>
                            <option value="it_id|desc" <?php echo $sst == 'it_id' && $sod == 'desc' ? 'selected' : ''; ?>>
                                제품코드 역방향 (↑)
                            </option>
                            <option value="it_name|asc" <?php echo $sst == 'it_name' && $sod == 'asc' ? 'selected' : ''; ?>>
                                제품명 정방향 (↓)
                            </option>
                            <option value="it_name|desc" <?php echo $sst == 'it_name' && $sod == 'desc' ? 'selected' : ''; ?>>
                                제품명 역방향 (↑)
                            </option>
                            <option value="it_order|asc" <?php echo $sst == 'it_order' && $sod == 'asc' ? 'selected' : ''; ?>>
                                순서 정방향 (↓)
                            </option>
                            <option value="it_order|desc" <?php echo $sst == 'it_order' && $sod == 'desc' ? 'selected' : ''; ?>>
                                순서 역방향 (↑)
                            </option>
                            <!-- option value="it_stock_qty|asc" <?php echo $sst == 'it_stock_qty' && $sod == 'asc' ? 'selected' : ''; ?>>재고수량 정방향 (↓)</option>
                        <option value="it_stock_qty|desc" <?php echo $sst == 'it_stock_qty' && $sod == 'desc' ? 'selected' : ''; ?>>재고수량 역방향 (↑) </option-->
                            <option value="it_price|asc" <?php echo $sst == 'it_price' && $sod == 'asc' ? 'selected' : ''; ?>>
                                판매가격 정방향 (↓)
                            </option>
                            <option value="it_price|desc" <?php echo $sst == 'it_price' && $sod == 'desc' ? 'selected' : ''; ?>>
                                판매가격 역방향 (↑)
                            </option>
                            <option value="it_cust_price|asc" <?php echo $sst == 'it_cust_price' && $sod == 'asc' ? 'selected' : ''; ?>>
                                시중가격 정방향 (↓)
                            </option>
                            <option value="it_cust_price|desc" <?php echo $sst == 'it_cust_price' && $sod == 'desc' ? 'selected' : ''; ?>>
                                시중가격 역방향 (↑)
                            </option>
                            <option value="it_time|asc" <?php echo $sst == 'it_time' && $sod == 'asc' ? 'selected' : ''; ?>>
                                등록일 정방향 (↓)
                            </option>
                            <option value="it_time|desc" <?php echo $sst == 'it_time' && $sod == 'desc' ? 'selected' : ''; ?>>
                                등록일 역방향 (↑)
                            </option>
                            <option value="it_update_time|asc" <?php echo $sst == 'it_update_time' && $sod == 'asc' ? 'selected' : ''; ?>>
                                수정일 정방향 (↓)
                            </option>
                            <option value="it_update_time|desc" <?php echo $sst == 'it_update_time' && $sod == 'desc' ? 'selected' : ''; ?>>
                                수정일 역방향 (↑)
                            </option>
                        </select><i></i>
                    </label>
                </section>
            </div>
        </div>

    </form>

    <form name="fitemlistupdate" method="post" action="<?php echo $action_url1; ?>" autocomplete="off" class="eyoom-form">
        <input type="hidden" name="sca" value="<?php echo $sca; ?>">
        <input type="hidden" name="sst" value="<?php echo $sst; ?>">
        <input type="hidden" name="sod" value="<?php echo $sod; ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
        <input type="hidden" name="stx" value="<?php echo $stx; ?>">
        <input type="hidden" name="sdt" value="<?php echo $sdt; ?>">
        <input type="hidden" name="fr_date" value="<?php echo $fr_date; ?>">
        <input type="hidden" name="to_date" value="<?php echo $to_date; ?>">
        <input type="hidden" name="cate_a" value="<?php echo $cate_a; ?>">
        <input type="hidden" name="cate_b" value="<?php echo $cate_b; ?>">
        <input type="hidden" name="cate_c" value="<?php echo $$cate_c; ?>">
        <input type="hidden" name="cate_d" value="<?php echo $cate_d; ?>">
        <input type="hidden" name="page" value="<?php echo $page; ?>">

        <?php if (G5_IS_MOBILE) { ?>
            <p class="font-size-11 color-grey text-right margin-bottom-5"><i class="fas fa-info-circle"></i> Note! 좌우스크롤
                가능 (<i class="fas fa-arrows-alt-h"></i>)</p>
        <?php } ?>

        <div id="admin-shop-itemlist"></div>

        <?php if (!$wmode) { ?>
            <div class="margin-top-20">
                <input type="submit" name="act_button" value="선택수정" class="btn-e btn-e-xs btn-e-red" onclick="document.pressed=this.value">
                <?php if ($is_admin == 'super' && $is_admin == 'operator') { ?>
                    <input type="submit" name="act_button" value="선택삭제" class="btn-e btn-e-xs btn-e-dark" onclick="document.pressed=this.value">
                <?php } ?>
            </div>
        <?php } ?>
    </form>
</div>

<div class="modal fade admin-iframe-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">상품 관리</h4>
            </div>
            <div class="modal-body">
                <iframe id="modal-iframe" width="100%" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn-e btn-e-lg btn-e-dark" type="button">
                    <i class="fas fa-times"></i> 닫기
                </button>
            </div>
        </div>
    </div>
</div>

<?php /* 페이지 */ ?>
<?php echo eb_paging($eyoom['paging_skin']); ?>

<script src="<?php echo EYOOM_ADMIN_THEME_URL; ?>/plugins/jsgrid/jsgrid.min.js"></script>
<script src="<?php echo EYOOM_ADMIN_THEME_URL; ?>/js/jsgrid.js"></script>
<script type="text/javascript">

    function fitemlist_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }
        if (document.pressed == "선택삭제") {
            if (!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
                return false;
            }
        }

        return true;
    }

    function fsearchform_submit(num) {
        var f = document.flist;
        var number = parseInt(num) + 1;

        for (var i = number; i <= 4; i++) {
            $("#cate_" + number).val('');
        }
        f.submit();
    }

    function eb_modal(href) {

        return false;
    }

    window.closeModal = function (url) {
        $('.admin-iframe-modal').modal('hide');
        document.location.href = url;
    };


    $(function () {
        $('#fr_date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            prevText: '<i class="fas fa-angle-left"></i>',
            nextText: '<i class="fas fa-angle-right"></i>',
            showMonthAfterYear: true,
            monthNames: ['년 1월', '년 2월', '년 3월', '년 4월', '년 5월', '년 6월', '년 7월', '년 8월', '년 9월', '년 10월', '년 11월', '년 12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            onSelect: function (selectedDate) {
                $('#to_date').datepicker('option', 'minDate', selectedDate);
            }
        });
        $('#to_date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            prevText: '<i class="fas fa-angle-left"></i>',
            nextText: '<i class="fas fa-angle-right"></i>',
            showMonthAfterYear: true,
            monthNames: ['년 1월', '년 2월', '년 3월', '년 4월', '년 5월', '년 6월', '년 7월', '년 8월', '년 9월', '년 10월', '년 11월', '년 12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            onSelect: function (selectedDate) {
                $('#fr_date').datepicker('option', 'maxDate', selectedDate);
            }
        });
        window.db = {
            deleteItem: function (deletingClient) {
                var clientIndex = $.inArray(deletingClient, this.clients);
                this.clients.splice(clientIndex, 1)
            },
            insertItem: function (insertingClient) {
                this.clients.push(insertingClient)
            },
            loadData: function (filter) {
                return $.grep(this.clients, function (client) {
                    return !(filter.체크 && !(client.체크.indexOf(filter.체크) > -1))
                })
            },
            updateItem: function (updatingClient) {
            },
            'clients': <?=json_encode($sheet)?>
        };


        var container = $('#admin-shop-itemlist');

        container.jsGrid({
            filtering: false,
            editing: false,
            sorting: false,
            paging: true,
            autoload: true,
            controller: db,
            deleteConfirm: "정말로 삭제하시겠습니까?\n한번 삭제된 데이터는 복구할수 없습니다.",
            pageButtonCount: 5,
            pageSize: <?php echo $config['cf_page_rows']; ?>,
            width: "100%",
            height: "auto",
            fields: [
                {name: "check", title: "체크", type: "text", width: 30},
                {name: "manage", title: "관리", type: "text", align: "center", width: 96, headercss: "set-btn-header", css: "set-btn-field"},
                {name: "itemID", title: "제품코드", type: "text", align: "center", width: 110},
                {name: "photo", title: "이미지", type: "image", align: "center", width: 60},
                {name: "itemName", title: "제품명(유형)", type: "text", width: 500},
                {name: "stockQuantity", title: "재고(-주문)수량", type: "number", width: 80},

                {name: "soldQuantity", title: "판매소계", type: "number", width: 80},
                {name: "sort", title: "순서", type: "text", align: "center", width: 60},
                {name: "listing", title: "판매", type: "text", align: "center", width: 40},
                {name: "soldOut", title: "품절", type: "text", align: "center", width: 40},
                {name: "listPrice", title: "판매가격", type: "number", width: 80},
                {name: "sellPrice", title: "시중가격", type: "number", width: 80},
                {name: "createdAtDate", title: "등록일", type: "text", align: "center", width: 80},
            ]
        });

        $("#sort").click(function () {
            var field = $("#sortingField").val();
            $("#admin-shop-itemlist").jsGrid("sort", field);
        });


        var $th = container.find('.jsgrid-grid-header:eq(0) .jsgrid-header-row:eq(0) .jsgrid-header-cell:eq(0)');
        if ($th.text() == '체크') {
            $th.html('<label class="checklist checklist-toggle"><input type="checkbox" value="checked" /><i class="checkmark"></i></label>');

            var $control = $th.find('input:checkbox'),
                $bind = container.find('LABEL.checklist > INPUT:checkbox').not($control),
                $toolbar = $('.toolbars button.toolbar-toggle');

            $control.change(function () {
                $bind.prop('checked', this.checked);
                this.checked ? $toolbar.removeAttr('disabled') : $toolbar.attr('disabled', true);
            });

            $bind.change(function () {
                var checked = $bind.filter(':checked').length;
                if (!checked) {
                    $control.removeClass('partial').prop('checked', false);
                    $toolbar.attr('disabled', true);
                }
                else if (checked == $bind.length) {
                    $control.removeClass('partial').prop('checked', true);
                    $toolbar.removeAttr('disabled');
                }
                else {
                    $control.addClass('partial').prop('checked', false);
                    $toolbar.removeAttr('disabled');
                }
            });
        }

        $('A.eb-modal').on('click', function (event) {
            event.preventDefault();
            var href = $(this).attr('href'), $modal = $('.admin-iframe-modal');
            if (!href) return false;

            <?php if (!(G5_IS_MOBILE || $wmode)) : ?>
            $modal.modal('show').on('hidden.bs.modal', function () {
                $("#modal-iframe").attr("src", "");
                $('html').css({overflow: ''});
            }).on('shown.bs.modal', function () {
                $("#modal-iframe").attr("src", href);
                $('#modal-iframe').height(parseInt($(window).height() * 0.85));
                $('html').css({overflow: 'hidden'});
            });
            <?php endif; ?>
        });


        $('form[name="fitemlistupdate"]').on('submit', function (event) {
            var checked = container.find('LABEL.checklist > INPUT:checkbox').not('.checklist-toggle').filter(':checked').length;
            if (!checked) {
                alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
                return false;
            }
            else if (document.pressed == "선택삭제" && !confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
                return false;
            }
            this.submit();
        });


    });


    function del_confirm() {
        if (confirm('정말로 선택한 상품을 삭제하시겠습니까?')) {
            return true;
        }
        else {
            return false;
        }
    }

    function sorting_list(f, str) {
        var sort = str.split('|');

        $("#sst").val(sort[0]);
        $("#sod").val(sort[1]);

        if (sort[0] && sort[1]) {
            f.submit();
        }
    }

    function set_date(today) {
        <?php
        $date_term = date('w', G5_SERVER_TIME);
        $week_term = $date_term + 7;
        $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME));
        ?>
        if (today == "오늘") {
            document.getElementById("fr_date").value = "<?php echo G5_TIME_YMD; ?>";
            document.getElementById("to_date").value = "<?php echo G5_TIME_YMD; ?>";
        }
        else if (today == "어제") {
            document.getElementById("fr_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
            document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
        }
        else if (today == "이번주") {
            document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-' . $date_term . ' days', G5_SERVER_TIME)); ?>";
            document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
        }
        else if (today == "이번달") {
            document.getElementById("fr_date").value = "<?php echo date('Y-m-01', G5_SERVER_TIME); ?>";
            document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
        }
        else if (today == "지난주") {
            document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-' . $week_term . ' days', G5_SERVER_TIME)); ?>";
            document.getElementById("to_date").value = "<?php echo date('Y-m-d', strtotime('-' . ($week_term - 6) . ' days', G5_SERVER_TIME)); ?>";
        }
        else if (today == "지난달") {
            document.getElementById("fr_date").value = "<?php echo date('Y-m-01', strtotime('-1 Month', $last_term)); ?>";
            document.getElementById("to_date").value = "<?php echo date('Y-m-t', strtotime('-1 Month', $last_term)); ?>";
        }
        else if (today == "전체") {
            document.getElementById("fr_date").value = "";
            document.getElementById("to_date").value = "";
        }
    }

    <?php if($_wmode) { ?>
    $(function () {
        $(".goods-select").click(function () {
            var pfno = $(this).attr('title');
            parent.set_goods(pfno);
            parent.jQuery('.vbox-close, .vbox-overlay').trigger('click');
        });
    });
    <?php } ?>
</script>