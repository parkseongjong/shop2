<?php
/**
 * Eyoom Admin Skin File
 * @file    ~/theme/basic/skin/shop/orderlist.html.php
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;
add_stylesheet('<link rel="stylesheet" href="' . G5_JS_URL . '/daterangepicker/css/daterangepicker.css" type="text/css" media="screen" />', 0);
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/moment.min.js"></script>');
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/moment-locale.ko.js"></script>');
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/daterangepicker/js/daterangepicker-3.14.1.min.js"></script>');



$OrderStatusTheme = [
    '주문' => 'red', '입금' => 'blue', '준비' => 'yellow', '배송' => 'green', '완료' => 'default'
    , '취소' => 'brown', '반품' => 'indigo', '품절' => 'dark',
];

$filter = $param;
unset($filter['dir'], $filter['pid']);
?>

<style type="text/css">
    P, A, H4 {color: inherit}
    .admin-iframe-modal iframe {height: 80vh}
    .admin-shop-orderlist .orderlist-img img {display: block;width: 100% \9;max-width: 100%;height: auto}
    .list-box {display: inline-block;padding: 0;position: relative;margin: 0; width: 100%;}
    .list-box select {height: auto; width: auto;padding: 4px 20px 4px .5rem;border-radius: 0;-webkit-appearance: none;-moz-appearance: none;appearance: none;outline: 0;position: relative;z-index: 1;min-width: 90px;}
    .list-box select::-ms-expand {display: none;}
    .list-box select:disabled {color: #666;background-color: #f0f0f0;text-shadow: 1px 1px rgba(255, 255, 255, 1);}
    .list-box select option {padding: 0;}
    .list-box::before,
    .list-box::after {content: '';position: absolute;right: 10px;border: 4px solid transparent;pointer-events: none;top: 50%;z-index: 101;}
    .list-box::after {border-top-color: #7a7a7a;}
    .list-box::before {border-bottom-color: #7a7a7a;margin-top: -9px;}
    .list-box + .form-control {margin-left: -1px;width: auto}
    .list-box select, .form-control {font-weight: normal;line-height: 1.5; font-size: 12px;}
    .form-control {padding: 4px .5rem;height: auto;}
    .form-section {border: 1px solid #434350;}
    .form-section DL, .form-section DT, .form-section DD {margin: 0; padding: 0;}
    .form-section DL {display: flex;flex-wrap: nowrap;width: 100%;}
    .form-section DT {width: 120px;min-width: 120px;background: #72727f;color: #fff;display: flex; align-items: center;padding-left: .5rem;}
    .form-section DT > label {margin: 0;padding: 0; font-weight: normal;}
    .form-section DD {padding: .5rem;}
    .form-section .d-flex {align-items: center}
    .form-section DL:not(:first-child) {border-top: 1px solid #666}
    .form-section .list-box select {width: 100%;}
    .form-section .checkbox {position: relative;margin: 0;padding-left: 30px;margin-left: -1px;}
    .form-section .checkbox input[type=checkbox] {position: absolute;margin-top: 6px;border: 0;border-radius: 0;background-color: #fff;}
    .form-section .checkbox-text {display: inline-block;padding: 2px 1.25rem;font-weight: normal;line-height: 1.5;text-align: center;white-space: nowrap;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;background-image: none;border: 1px solid transparent;margin-left: -.75rem; }
    .form-section .checkbox-text {color: #fff;margin-left: -30px;padding-left: 30px;border-color: rgba(0, 0, 0, .1)}
    .form-section .checkbox-text.btn-e-default {color: #333}
    .form-section .checkbox input:checked + .checkbox-text {border-color: rgba(0, 0, 0, .25);box-shadow: inset 0 2px 4px rgba(0, 0, 0, .125)}
    .form-section .date-range-picker {margin-left: -1px;}
    .form-section .date-range-picker .date-range-picker-toggle {padding-top: 0;padding-bottom: 0;line-height: 1.37857143;font-weight: normal;font-size: 12px;}
    .form-section .deactivate {opacity: 1}
    .form-section .deactivate + .checkbox-text {opacity: .75}
    /**
     |
     |
     |*/
    .page-summary {margin: 20px 0 5px 0;display: flex}
    .page-summary > div:first-child {flex: 1 1 auto}
    A.sort {position: relative;display: block;color: #333;}
    A.sort::after {content: '';position: absolute;right: .5rem;border: solid transparent;border-width: 0 3px 3px 0;display: inline-block;padding: 3px;}
    A.sort::after {border-color: #ccc; top: 4px;transform: rotate(45deg);-webkit-transform: rotate(45deg);}
    A.sort[data-order]::after {border-color: #0f70be;}
    A.sort[data-order="D"]::after {}
    A.sort[data-order="A"]::after {top: 7px;transform: rotate(-135deg);-webkit-transform: rotate(-135deg);}
    .order-content {max-width: 100vw;overflow: hidden; overflow-x: auto;border: 1px solid #ccc;}
    /*Border*/
    .order-list {display: table; border-spacing: 0; margin: 0;padding: 0;background-color: #fff;width: 100%;}
    .order-list > li {display: table-row; margin: 0;padding: 0; color: #5e5e5e;cursor: default;}
    .order-list > li > .checklist,
    .order-list > li > ins {display: table-cell;vertical-align: middle; min-width: 24px;font-style: normal; text-decoration: none; margin: 0;padding: .5rem 1.25rem; border-right: 1px solid #E8E9EC;border-bottom: 1px solid #E8E9EC;}
    .order-list > li:first-child {background-color: #E8E9EC;text-align: center;font-weight: 600;}
    .order-list > li:first-child > .checklist, .order-list > li:first-child > ins {border-bottom-color: #ccc; padding: .5rem 0}
    .order-list > li > ins:last-child {border-right: 0;}
    .order-list > li:last-child > .checklist, .order-list > li:last-child > ins {border-bottom: 0;}
    .order-list > li:hover {background-color: #f0f0f0;}
    .order-list > li[data-even="N"] {background-color: #f6f6f6;}
    .order-list > li[data-even="N"]:hover {background-color: #e6e6e6;}
    /* */
    .order-list > li > .checklist .checkmark {top: 50%;margin-top: -8px; left: 50%; margin-left: -8px}
    .order-list > li > .checklist {min-width: 28px;width: 28px;}
    .order-list > li > ins[data-role="no"] {text-align: center;min-width: 80px;width: 80px;}
    .order-list > li > ins[data-role="ord-inf"] {min-width: 0}
    .order-list > li > ins[data-role="pay"] {min-width: 180px;width: 180px;}
    .order-list > li > ins[data-role="buyer"] {min-width: 160px;width: 15%;color: #666}
    .order-list > li > ins[data-role="receiver"] {min-width: 240px;width: 15%;}
    .order-list > li > ins[data-role="dateTime"] {min-width: 180px;width: 180px;}
    .order-list > li > ins[data-role="buyer"] I, .order-list > li > ins[data-role="receiver"] I {margin-right: .5rem;color: #a2a2af}
    .order-list > li:not(:first-child) > ins[data-role="pay"], .order-list > li:not(:first-child) > ins[data-role="dateTime"] {text-align: right}
    .order-list > li > ins[data-role="pay"] I, .order-list > li > ins[data-role="dateTime"] I {float: left;}
    .order-list > li > ins[data-role="pay"] P, .order-list > li > ins[data-role="dateTime"] P {min-height: 20px;line-height: 1 }
    .order-list > li > ins[data-role="dateTime"] I {color: #a2a2af}
    .order-list > li > ins[data-role="dateTime"] I[data-at="Y"] {color: #666}
    .order-list A {color: #53A5FA; text-decoration: #53A5FA dashed underline}
    .order-list .ord-item {margin: 0;padding: 0;display: flex;align-content: center;line-height: 1;}
    .order-list .ord-item DT, .order-list .ord-item DD {margin: 0;padding: 0;position: relative;}
    .order-list .ord-item DT {width: 59px;flex-grow: 0;}
    .order-list .ord-item DT A {display: inline-block;border: 1px solid #d2d2d2;margin-top: 2px;position: relative}
    .order-list .ord-item DT A I {position: absolute;right: -.5rem; top: -.5rem;color: #666}
    .order-list .item-title {display: flex;font-size: 12px;font-weight: 700;padding: 0;margin: .375rem 0;}
    .order-list .item-title span[data-role="subject"] {flex-shrink: 1; flex-grow: 1;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;max-width: 100%;padding-right: 5px;}
    .order-list .item-title span[data-role="suffix"] { flex-shrink: 0; flex-grow: 0;white-space: nowrap;color: #FF6F42;}
    .order-list .amount-summary {font-size: 11px;letter-spacing: 0}
    .order-list .ord-id {display: inline-block;}
    .order-list .ord-id > A:first-child {text-shadow: 0 0 2px rgba(0, 0, 0, .375);text-decoration: none}
    .order-list .ord-id > A[target="_blank"] {margin-left: .5rem;font-size: 11px;color: #7a7a7a; text-decoration: none}
    .order-list P {margin: 0; padding: 0; display: block;}
    .order-list P:after {content: ''; display: block; clear: both}
    .order-list sub {bottom: 0;margin-bottom: 0; font-size: 86%;padding: 0 .25rem;}
    .order-list .ord-badge {font-style: normal; font-weight: normal; color: #fff;font-size: 11px;padding: .175rem .25rem;margin-left: 1.5rem;}
    .order-list .text-ellipsis {white-space: nowrap; overflow: hidden; text-overflow: ellipsis;max-width: 186px;}
    .order-list .unpaid {color: #FF6F42;font-size: 11px;font-weight: bold}
    .order-list .pay-amount {font-size: 1.375rem;}
    .order-list .pay-sign::before {width: 19px;display: inline-flex}
    .order-list .pay-sign::after {color: #ccc;margin-left: .5rem;text-align: right;font-size: 11px;}
    .order-list .pay-sign[data-label="minus"]::after {content: "\f056";}
    .order-list .pay-sign[data-label="plus"]::after {content: "\f055";}
    .order-list .pay-sign[data-label="equal"]::after {content: "\f52c";font-weight: 900;}
</style>
<div class="adm-headline adm-headline-btn">
    <h3>주문 내역</h3>
</div>


<form name="frmSearch">
    <input type="hidden" name="dir" value="<?= $param['dir'] ?>">
    <input type="hidden" name="pid" value="<?= $param['pid'] ?>">
    <input type="hidden" name="fromDate" id="from-date" value="<?= $param['fromDate'] ?>">
    <input type="hidden" name="toDate" id="to-date" value="<?= $param['toDate'] ?>">
    <section class="form-section">
        <dl>
            <dt><label for="search-keyword">검색어</label></dt>
            <dd>
                <div class="d-flex flex-nowrap">
                    <label class="list-box">
                        <select name="search">
                            <?php foreach ($PageConfig['searchLabel'] as $value => $label) {
                                print sprintf('<option value="%s"%s>%s</option>', $value, $value == $param['search'] ? ' selected' : '', $label);
                            } ?>
                        </select>
                    </label>
                    <input type="text" name="keyword" id="search-keyword" size="30" value="<?= $param['keyword'] ?>" class="form-control" placeholder="검색어를 입력하세요" />
                </div>

            </dd>
        </dl>
        <dl>
            <dt><label for="search-keyword">주문상태</label></dt>
            <dd>
                <div class="d-flex">
                    <label class="checkbox">
                        <input type="checkbox" id="status-toggle" value="All" <?= $param['status'] ? '' : ' checked' ?>/>
                        <span class="checkbox-text btn-e-dark">전체</span>
                    </label>
                    <?php foreach ($PageConfig['status'] as $value => $label) { ?>
                        <label class="checkbox">
                        <input type="checkbox" name="status[]" value="<?= $value ?>"<?= in_array($value, $param['status']) ? ' checked' : '' ?> />
                        <span class="checkbox-text btn-e-<?= $OrderStatusTheme[$label] ?? 'default' ?>"><?= $label ?></span>
                        </label><?php } ?>
                </div>
            </dd>
        </dl>
        <dl>
            <dt><label for="search-keyword">주문날짜</label></dt>
            <dd>
                <div class="d-flex">
                    <label class="list-box">
                        <select name="term">
                            <?php foreach ($PageConfig['termLabel'] as $value => $label) {
                                print sprintf('<option value="%s"%s>%s</option>', $value, $value == $param['search'] ? ' selected' : '', $label);
                            } ?>
                        </select>
                    </label>
                    <label class="date-range-picker" data-bind='#from-date,#to-date' data-start-date="<?= $param['fromDate'] ?>" data-end-date="<?= $param['toDate'] ?>" data-ranges="monthly"></label>
                    <button type="submit" class="margin-left-10 btn-e btn-e-lg btn-e-dark" accesskey="s">
                        <i class="fa fa-search"></i> 검색
                    </button>

                </div>
            </dd>
        </dl>

    </section>
</form>

<div class="page-summary">
    <div>검색결과: <strong><?= number_format($totals) ?></strong> 중 <strong><?= number_format($subtotals) ?></strong>건 상품 주문
    </div>
    <div>
        <button type="button" class="btn-e btn-e-dark btn-import" data-filter="order">
            <i class="fas fa-file-import"></i> 운송장 업로드
        </button>
        <button type="button" class="btn-e btn-e-dark btn-export" data-filter="<?= rtrim('dir=export&pid=order_export&' . http_build_query($filter), '&') ?>">
            <i class="far fa-file-excel"></i> 엑셀 다운로드
        </button>
    </div>
</div>

<div class="order-content">
    <ul class="order-list">
        <li>
            <label class="checklist checklist-toggle"><input type="checkbox" value="checked" /><i class="checkmark"></i></label>
            <ins data-role="no">No.</ins>
            <ins data-role="ord-inf">주문내역</ins>
            <ins data-role="pay">결제금액</ins>
            <ins data-role="buyer">주문자</ins>
            <ins data-role="receiver">받는이</ins>
            <ins data-role="dateTime">날짜</ins>
        </li>
        <?php
        foreach ($rows as $i => $row):
            [$item_id, $item_title] = explode('|', $row['item']);
            // 총 주문금액
            $amount = $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'];
            // 할인금액
            $discount = $row['od_cart_coupon'] + $row['od_coupon'] + $row['od_send_coupon'] + $row['od_receipt_point'];
            // 결제금액

            //
            $badge_color = $OrderStatusTheme[$row['od_status']] ?? 'dark';
            $row['od_receipt_time'] = trim(str_replace(['0000-00-00', '00:00:00'], '', $row['od_receipt_time']));
            $row['od_invoice_time'] = trim(str_replace(['0000-00-00', '00:00:00'], '', $row['od_invoice_time']));
            $orderDateTime = (new DateTime($row['od_time']))->format('Y-m-d H:i');
            $checkoutDateTime = $row['od_receipt_time'] ? (new DateTime($row['od_receipt_time']))->format('Y-m-d H:i') : '';
            $shippingDateTime = $row['od_invoice_time'] ? (new DateTime($row['od_invoice_time']))->format('Y-m-d H:i') : '';
            $shippingDateTime && $row['od_dlivery_company'] && ($shippingDateTime = '<strong class="color-green">' . mb_substr($row['od_delivery_company'], 0, 2) . '</strong> ' . $shippingDateTime);
            $view = G5_ADMIN_URL . "?dir=shop&pid=orderform&od_id={$row['od_id']}";
            ?>
            <li data-even="<?= $i % 2 === 0 ? 'Y' : 'N' ?>">
                <label class="checklist"><input type="checkbox" name="idx[]" value="<?= $row['od_id'] ?>" /><i class="checkmark"></i></label>
                <ins data-role="no"><?= $max_no-- ?></ins>
                <ins data-role="ord-inf">

                    <dl class="ord-item" data-value="<?= $row['od_id'] ?>">
                        <dt><a href="<?= $view ?>"><?= get_it_image($item_id, 50, 50) ?></a></dt>
                        <dd>
                            <div class="ord-id">
                                <a href="<?= $view ?>"><?= $row['od_id'] ?></a>
                                <span class="ord-badge btn-e-<?= $badge_color ?>"><?= $row['od_status'] ?></span>
                                <a href="<?= $view ?>" target="_blank">새창 <i class="fas fa-external-link-alt"></i></a>
                            </div>

                            <h4 class="item-title">
                                <span data-role="subject"><?= $item_title ?></span>
                                <span data-role="suffix"><?= $row['item_volume'] > 0 ? '외 <strong>' . number_format($row['item_volume']) . '</strong>' : '' ?></span>
                            </h4>

                            <div class="amount-summary">
                                상품금액:
                                <span class="color-indigo"><?= number_format($row['od_cart_price']) ?></span><sub>원</sub>
                                / 배송:
                                <span class="color-indigo"><?= number_format($row['od_send_cost'] + $row['od_send_cost2']) ?></span><sub>원</sub>
                            </div>
                        </dd>
                    </dl>
                </ins>
                <ins data-role="pay">
                    <p>
                        <i class="fas fa-cash-register"></i>
                        <span class="color-blue"><?= number_format($amount) ?></span><sub>원</sub>
                    </p>
                    <p>
                        <i class="pay-sign fas fa-tags" data-label="minus"></i>
                        <span class="color-orange"><?= number_format($discount) ?></span><sub>원</sub>
                    </p>
                    <p>
                        <i class="pay-sign <?= ['무통장' => 'fas fa-won-sign', '신용카드' => 'far fa-credit-card'][$row['od_settle_case']] . ($row['od_misu'] > 0 ? ' color-red' : '') ?>" data-label="equal"></i>
                        <strong class="pay-amount color-green"><?= $row['od_misu'] > 0 ? number_format($row['od_misu']) : number_format($row['od_receipt_price']) ?></strong><sub>원</sub>
                    </p>
                </ins>
                <ins data-role="buyer">
                    <p><i class="far fa-user-circle"></i><?= $row['od_name'] ?></p>
                    <p><i class="fas fa-mobile-alt"></i><?= $row['od_hp'] ?></p>
                    <p><i class="fas fa-id-badge"></i><?php if ($row['mb_id']): ?>
                            <a href="<?= G5_BBS_URL . "/profile.php?mb_id={$row['mb_id']}" ?>" class="member-profile"><?= $row['mb_name'] ?></a><?php else: print '손님'; endif; ?>
                    </p>
                </ins>
                <ins data-role="receiver">
                    <p><i class="far fa-user-circle"></i><strong><?= $row['od_b_name'] ?></strong></p>
                    <p><i class="fas fa-mobile-alt"></i><?= $row['od_b_hp'] ?></p>
                    <p class="text-ellipsis"><i class="fas fa-map-marker-alt"></i><?= $row['od_b_addr1'] ?></p>
                </ins>
                <ins data-role="dateTime">
                    <p title="주문일">
                        <i class="fas fa-cart-plus" data-at="Y"></i> <?= $orderDateTime ?>
                    </p>
                    <p title="입금/결제일">
                        <i class="fas fa-money-check-alt" data-at="<?= $checkoutDateTime ? 'Y' : '' ?>"></i> <?= $checkoutDateTime ? $checkoutDateTime : '<small class="unpaid">' . ($row['od_status'] == '주문' ? '미입금' : '미확인') . '</small>' ?>
                    </p>
                    <p title="배송일">
                        <i class="fas fa-truck" data-at="<?= $shippingDateTime ? 'Y' : '' ?>"></i> <?= $shippingDateTime ? $shippingDateTime : '-' ?>
                    </p>
                </ins>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?= eb_paging($eyoom['paging_skin']); ?>


<div class="modal fade admin-iframe-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">주문정보</h4>
            </div>
            <div class="modal-body">
                <iframe width="100%" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn-e btn-e-lg btn-e-dark" type="button">
                    <i class="fas fa-times"></i> 닫기
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        // 검색 처리
        (function () {
            var $form = $('form[name="frmSearch"]'), $checkbox = $form.find('input[name="status[]"][type=checkbox]'), $p = $form.find('input#status-toggle');
            $checkbox.on('change', function () {
                $p.prop('checked', $checkbox.filter(':checked').length == $checkbox.length).change();
            });
            $p.on('change', function () {
                $p.is(':checked') ? $checkbox.prop('checked', false).addClass('deactivate') : $checkbox.removeClass('deactivate');
            });
            $p.change();
        })();

        // 체크박스 컨트롤
        var $control = $('.order-list > LI:first-child').find('input:checkbox'),
            $bind = $('.order-list > LI').find('LABEL.checklist > INPUT:checkbox').not($control),
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
        // 회원 프로필
        $('A.member-profile').on('click', function (event) {
            event.preventDefault();
            win_profile($(this).attr('href'));
        });
        //
        <?php if (!(G5_IS_MOBILE || $wmode)) : ?>
        var $dialog = $('DIV.admin-iframe-modal');

        $dialog.on('hidden.bs.modal', function () {
            $('html').css('overflow', 'auto');
            $dialog.find('.modal-body iframe').attr('src', '');
        }).on('show.bs.modal', function () {
            $('html').css('overflow', 'hidden');
        });

        $('DIV.ord-id > A:first-child').on('click', function (event) {
            event.preventDefault();
            var href = $(this).attr('href');
            if (!href) return false;

            $dialog.modal('show').find('.modal-body iframe').attr('src', href + '&wmode=1');
            $dialog.find('.modal-title').text($(this).text() + ' 주문정보');
        });
        <?php endif;?>
    });


</script>
<!-- div class="export-container">
<section class="export-dialog">
    <div class="export-content">
        <article class="export-progress"><span class="export-progressbar"></span><em></em></article>
        <article class="export-message" data-feedback="error">Error!!</article>
        <article class="export-button">
            <button type="button">닫기</button>
        </article>
    </div>
</section>
</div -->
