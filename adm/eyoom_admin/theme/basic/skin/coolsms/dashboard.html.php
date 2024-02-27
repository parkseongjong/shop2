<?php
/**
 *
 * User: Lee, Namdu
 * Date: 2022-06-15
 * Time: 오후 3:00
 */
/**
 * @type array $Summary
 */
// -- 차트
add_stylesheet('<link rel="stylesheet" href="' . EYOOM_ADMIN_THEME_URL . '/plugins/c3/c3.min.css" type="text/css" media="screen">', 0);
add_javascript('<script type="text/javascript" src="' . EYOOM_ADMIN_THEME_URL . '/plugins/d3/d3.min.js"></script>');
add_javascript('<script type="text/javascript" src="' . EYOOM_ADMIN_THEME_URL . '/plugins/c3/c3.min.js"></script>');

// -- 갤린더
add_stylesheet('<link rel="stylesheet" href="' . G5_JS_URL . '/daterangepicker/css/daterangepicker.css" type="text/css" media="screen">', 0);
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/moment.min.js"></script>');
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/moment-locale.ko.js"></script>');

add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/daterangepicker/js/daterangepicker-3.14.1.min.js"></script>');
?>
<style type="text/css">
    .count-suffix:after {content: '건'; font-weight: normal; font-size: .72375em;padding: 0 .25rem;color: #676769;}
    .krw-suffix:after {content: '원'; font-weight: normal; font-size: .72375em;padding: 0 .25rem;color: #676769;}
    .point-suffix:after {content: 'P'; font-weight: normal; font-size: .72375em;padding: 0 .25rem;color: #676769;}
    @media (min-width: 1100px) {
        .pg-anchor-in.tab-e2 .nav-tabs li a {font-size: 14px;font-weight: bold;padding: 8px 17px}
        .pg-anchor-in.tab-e2 .nav-tabs li.active a {z-index: 1;border: 1px solid #000;border-top: 1px solid #DE2600;color: #DE2600}
        .pg-anchor-in.tab-e2 .tab-bottom-line {position: relative;display: block;height: 1px;background: #000; margin-bottom: 20px;}
    }
    @media (max-width: 1099px) {
        .pg-anchor-in {position: relative;overflow: hidden;margin-bottom: 20px;border: 1px solid #757575}
        .pg-anchor-in.tab-e2 .nav-tabs li {width: 33.33333%;margin: 0}
        .pg-anchor-in.tab-e2 .nav-tabs li a {font-size: 11px;padding: 6px 0;text-align: center;border-bottom: 1px solid #d5d5d5;margin-right: 0;font-weight: bold;background: #fff}
        .pg-anchor-in.tab-e2 .nav-tabs li.active a {border: 0;border-bottom: 1px solid #d5d5d5 !important;color: #DE2600;background: #fff1f0}
        .pg-anchor-in.tab-e2 .nav-tabs li:nth-child(1) a {border-right: 1px solid #d5d5d5}
        .pg-anchor-in.tab-e2 .nav-tabs li:nth-child(2) a {border-right: 1px solid #d5d5d5}
        .pg-anchor-in.tab-e2 .nav-tabs li:nth-child(4) a {border-right: 1px solid #d5d5d5}
        .pg-anchor-in.tab-e2 .nav-tabs li:nth-child(5) a {border-right: 1px solid #d5d5d5}
        .pg-anchor-in.tab-e2 .nav-tabs li:nth-child(7) a {border-right: 1px solid #d5d5d5;border-bottom: 0 !important}
        .pg-anchor-in.tab-e2 .nav-tabs li:nth-child(8) a {border-right: 1px solid #d5d5d5;border-bottom: 0 !important}
        .pg-anchor-in.tab-e2 .nav-tabs li:nth-child(9) a {border-bottom: 0 !important}
        .pg-anchor-in.tab-e2 .tab-bottom-line {display: none}
    }

</style>
<div class="admin-sms-container">
    <div class="adm-headline adm-headline-btn">
        <h3><?= $g5['title'] ?></h3>
    </div>
    <div class="container margin-0 padding-0 ">
        <form name="frmSearch" class="margin-bottom-20">
            <input type="hidden" name="scope" value="stats" />
            <input type="hidden" name="from" id="from-date" value="<?= $fromDate ?>">
            <input type="hidden" name="to" id="to-date" value="<?= date('Y-m-t') ?>">

            <div class="d-flex">
                <label class="date-range-picker" data-bind='#from-date,#to-date' data-start-date="<?= $fromDate ?>" data-end-date="<?= date('Y-m-t') ?>" data-ranges="tpl"></label>
                <button type="submit" class="margin-left-10 btn-e btn-e-lg btn-e-red"><i class="fa fa-search"></i> 검색
                </button>
            </div>
        </form>

        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="d-flex unlisted" id="summary-stats">
                    <li class="flex-fill">
                        <h5>발송건수</h5>
                        <strong data-label="total" class="summary-stats-item font-size-18 color-dark count-suffix">0</strong>
                    </li>
                    <li class="flex-fill">
                        <h5>실패건수</h5>
                        <strong data-label="failure" class="summary-stats-item font-size-18 color-pink count-suffix">0</strong>
                    </li>
                    <li class="flex-fill">
                        <h5>차감금액</h5>
                        <strong data-label="cost" class="summary-stats-item font-size-18 color-indigo krw-suffix">0</strong>
                    </li>
                    <li class="flex-fill">
                        <h5>차감포인트</h5>
                        <strong data-label="point" class="summary-stats-item font-size-18 color-blue point-suffix">0</strong>
                    </li>
                </ul>

                <ul class="d-flex unlisted" id="summary-stats-avg">
                    <li class="flex-fill">
                        <h5 class="color-grey">일일평균</h5>
                        <strong data-label="total" class="summary-stats-item font-size-16 color-grey count-suffix">0</strong>
                    </li>
                    <li class="flex-fill">
                        <h5 class="color-grey">일일평균</h5>
                        <strong data-label="failure" class="summary-stats-item font-size-16 color-grey count-suffix">0</strong>
                    </li>
                    <li class="flex-fill">
                        <h5 class="color-grey">일일평균</h5>
                        <strong data-label="cost" class="summary-stats-item font-size-16 color-grey krw-suffix">0</strong>
                    </li>
                    <li class="flex-fill">
                        <h5 class="color-grey">일일평균</h5>
                        <strong data-label="point" class="summary-stats-item font-size-16 color-grey point-suffix">0</strong>
                    </li>
                </ul>


            </div>
        </div>

        <?php foreach ($pg_anchor as $_id => $_text) { ?>
            <div class="pg-anchor"><?= adm_pg_anchor($_id); ?></div>
            <div id="anc_cf_monthly" class="tabs-container">
                <h4 class="tabs-header"><i class="fas fa-caret-right"></i> <?= $_text ?></h4>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">날짜</th>
                        <th class="text-center">총 발송</th>
                        <th class="text-center">발송 실패</th>
                        <th class="text-center">사용금액</th>
                        <th class="text-center">환급금액</th>
                    </tr>
                    </thead>
                    <tbody id="list-stats-<?= str_replace('anc_cf_', '', $_id) ?>">
                    </tbody>
                </table>
            </div>
        <?php } ?>

    </div>
</div>
<script type="text/javascript">
    $(function () {
        var form = $('form[name="frmSearch"]');

        function fnl_get_summary(is_hide_load_bar) {
            is_hide_load_bar !== true && $('.ajax-load-container').css('z-index', 501).show();

            $.post(g5_admin_url + '/ajax.coolsms.php', form.serialize(), function (data) {
                if (data.code != 200) {
                    alert(data.message);
                    return false;
                }
                $('#summary-stats .summary-stats-item').each(function () {
                    var el = $(this), label = el.attr('data-label');
                    switch (label) {
                        case 'total':
                            el.text(data.result.total.total.numberFormat());
                            break;
                        case 'success':
                            el.text(data.result.successed.total.numberFormat());
                            break;
                        case 'failure':
                            el.text(data.result.failed.total.numberFormat());
                            break;
                        case 'cost':
                            el.text(data.result.balance.numberFormat());
                            break;
                        case 'point':
                            el.text(data.result.point.numberFormat());
                            break;
                    }
                });
                $('#summary-stats-avg .summary-stats-item').each(function () {
                    var el = $(this), label = el.attr('data-label');
                    switch (label) {
                        case 'total':
                            el.text(Math.round(data.result.dailyTotalCountAvg).numberFormat());
                            break;
                        case 'success':
                            el.text(Math.round(data.result.dailySuccessedCountAvg).numberFormat());
                            break;
                        case 'failure':
                            el.text(Math.round(data.result.dailyFailedCountAvg).numberFormat());
                            break;
                        case 'cost':
                            el.text(Math.round(data.result.dailyBalanceAvg).numberFormat());
                            break;
                        case 'point':
                            el.text(Math.round(data.result.dailyPointAvg).numberFormat());
                            break;
                    }
                });
                var monthly = $('#list-stats-monthly'), daily = $('#list-stats-daily');
                monthly.children().remove();
                daily.children().remove();

                $(data.result.monthPeriod).each(function () {
                    var dates = this.date.split('/'), row = $('<TR />');
                    $('<TD class="text-center"/>').html(dates[0] + '년 ' + dates[1] + '월').appendTo(row);
                    $('<TD class="text-right" />').html('<strong class="color-dark count-suffix">' + this.total.total.numberFormat() + '</strong>').appendTo(row);
                    $('<TD class="text-right" />').html('<span class="color-pink count-suffix">' + this.failed.total.numberFormat() + '</span>').appendTo(row);
                    $('<TD class="text-right" />').html('<strong class="color-indigo krw-suffix">' + this.balance.numberFormat() + '</strong>(<small class="color-dark point-suffix">' + this.point.numberFormat() + '</small>)').appendTo(row);
                    $('<TD class="text-right" />').html('<strong class="color-dark krw-suffix">' + this.refund.balance.numberFormat() + '</strong>(<small class="color-dark point-suffix">' + this.refund.point.numberFormat() + '</small>)').appendTo(row);

                    row.appendTo(monthly);
                });

                $(data.result.dayPeriod).each(function () {
                    var dates = this.date.split('/'), row = $('<TR />');
                    $('<TD class="text-center"/>').html(dates[0] + '년 ' + dates[1] + '월 ' + dates[2] + '일').appendTo(row);
                    $('<TD class="text-right" />').html('<strong class="color-dark count-suffix">' + this.total.total.numberFormat() + '</strong>').appendTo(row);
                    $('<TD class="text-right" />').html('<span class="color-pink count-suffix">' + this.failed.total.numberFormat() + '</span>').appendTo(row);
                    $('<TD class="text-right" />').html('<strong class="color-indigo krw-suffix">' + this.balance.numberFormat() + '</strong>(<small class="color-dark point-suffix">' + this.point.numberFormat() + '</small>)').appendTo(row);
                    $('<TD class="text-right" />').html('<strong class="color-dark krw-suffix">' + this.refund.balance.numberFormat() + '</strong>(<small class="color-dark point-suffix">' + this.refund.point.numberFormat() + '</small>)').appendTo(row);

                    row.appendTo(daily);
                });
            }).always(function () {
                $('.ajax-load-container').hide('slow');
            });
        }

        form.submit(function (event) {
            event.preventDefault();
            fnl_get_summary();
        });

        fnl_get_summary(true);

    });


</script>

<div class="ajax-load-container">
    <div class="load-backdrop"></div>
    <div class="load-content">Searching . . .</div>
</div>
