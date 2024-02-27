<?php
/**
 *
 * User: Lee, Namdu
 * Date: 2022-05-16
 * Time: 오후 1:25
 */
/**
 * @type $max_no int
 */
$States = getDistrictState();
add_stylesheet('<link rel="stylesheet" href="' . G5_JS_URL . '/daterangepicker/css/daterangepicker.css" type="text/css" media="screen">', 0);
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/moment.min.js"></script>');
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/moment-locale.ko.js"></script>');
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/daterangepicker/js/daterangepicker-3.14.1.min.js"></script>');
!$page && ($page = 1);
$filter = $param;
unset($filter['dir'], $filter['pid']);
?>
<style type="text/css">
    .form-item {display: flex;margin: 0; padding: 0; max-width: 100%; }
    .form-item dt {width: 15%;max-width: 150px;}
    .form-item dt { margin: 0; padding: 12px 0 0 10px; font-style: normal;border: 1px solid #434350; font-weight: 700; background-color: #72727f; color: #fff;}
    .form-item dd { flex-grow: 1;margin: 0 0 0 -1px; padding: 8px; font-style: normal; border: 1px solid #434350; }
    .form-item:not(:first-child) {margin-top: -1px}
    form dl.form-group .form-control {padding: .25rem .5rem;height: auto;}
    form dl.form-group .form-control.inline {width: auto;}
    form dl.form-group .checkbox {display: inline-block;margin: 0;cursor: pointer;}
    form dl.form-group .checkbox + .checkbox {margin: 0 0 0 10px;}
    form dl.form-group .checkbox INPUT {vertical-align: middle;margin: 0;}
    form dl.form-group > dd {padding-left: .75rem; padding-right: 1.25rem;}
    .list-box {display: inline-block;padding: 0;position: relative;margin-bottom: .25rem; width: 100%; }
    label.list-box {margin-bottom: .25rem;}
    .list-box select {height: auto; width: calc(100% - 1rem);font-weight: normal;padding: 5px .5rem;line-height: 1.5;border-radius: 0;-webkit-appearance: none;-moz-appearance: none;appearance: none;outline: 0;position: relative;z-index: 1;min-width: 90px;}
    .list-box select::-ms-expand {display: none;}
    .list-box select:disabled {color: #666;background-color: #f0f0f0;text-shadow: 1px 1px rgba(255, 255, 255, 1);}
    .list-box::before,
    .list-box::after {content: '';position: absolute;right: 5px;border: 4px solid transparent;pointer-events: none;top: 50%;z-index: 101;}
    .list-box::before {border-bottom-color: #7a7a7a;margin-top: -9px;}
    .list-box::after {border-top-color: #7a7a7a;}
    /*--*/
    body.modal-open {padding-right: 0 !important;}
    .modal .modal-dialog {margin: 0 auto;height: 100%;width: 100%;display: flex;}
    .modal .modal-content {margin: auto;text-align: left;font-size: 11px;min-height: 438px;width: 100%;}
    .modal .modal-dialog .modal-header {padding-top: .5rem; padding-bottom: .5rem;}
    .modal .modal-dialog .agent-label {padding-left: .75rem}
    .modal .modal-dialog .agent-label small {color: #f2f2f2;display: inline;font-size: 12px;}
    .modal .eb-pagination-wrap {margin-top: auto;}
    .modal .ajax-load-container {display: block;position: relative;width: 100%;}
    .modal .ajax-load-container .load-content {position: static;margin: 20% auto;box-shadow: none}
    .modal .list-container {display: none;}
    .modal[data-loaded="true"] .ajax-load-container {display: none;}
    .modal[data-loaded="true"] .list-container {display: flex;flex-direction: column;min-height: 385px;}
    .modal .list-container .page-nav {margin-top: auto;}
    .modal .list-container .list-group-item:hover {background-color: #f2f2f2;}
    .point-suffix::after {font-family: "Font Awesome 5 Brands";-webkit-font-smoothing: antialiased;display: inline-block;font-style: normal;font-variant: normal;text-rendering: auto;line-height: 1;font-weight: 400;content: "\f288";box-sizing: border-box;margin-left: 2px;font-size: xx-small;color: #3a3a48;}
    .table-content {width: 100%;overflow: hidden; overflow-x: auto;font-size: 13px;}
    A.sort {position: relative;display: block;color: #333;}
    A.sort::after {content: '';position: absolute;right: .5rem;border: solid transparent;border-width: 0 3px 3px 0;display: inline-block;padding: 3px;}
    A.sort::after {border-color: #ccc; top: 4px;transform: rotate(45deg);-webkit-transform: rotate(45deg);}
    A.sort[data-order]::after {border-color: #0f70be;}
    A.sort[data-order="D"]::after {}
    A.sort[data-order="A"]::after {top: 7px;transform: rotate(-135deg);-webkit-transform: rotate(-135deg);}
    .list-group-item { display: flex; padding: 0 15px;text-align: left;cursor: default;max-width: calc(100vw - 20px); color: #666}
    .list-group-item:first-child {font-weight: 700;background-color: #E8E9EC;border-top-color: #353535;border-top-width: 2px;}
    .list-group-item:nth-child(2) {border-top-color: #353535;}
    .list-group-item > .checklist {min-width: 27px; margin: 0;}
    .list-group-item > .checklist .checkmark {top: .75rem;}
    .list-group-item > em {min-width: 80px;font-style: normal; display: inline-block; padding: .5rem .5rem;}
    .list-group-item > .checklist, .list-group-item > em {border-right: 1px solid #f0f0f0;}
    .list-group-item:first-child > .checklist,
    .list-group-item:first-child > em {border-right-color: #cdcdcd}
    .list-group-item > em:first-child {padding-left: 0}
    .list-group-item > em:last-child {padding-right: 0;border-right: 0}
    .list-group-item > em[data-value] {cursor: pointer;color: #000}
    .list-group-item > em[data-value]:hover {color: #f30;text-shadow: 1px 1px 2px rgba(0, 0, 0, .215)}
    .list-group-item > em[data-role="no"] {min-width: 60px;text-align: center;}
    .list-group-item > em[data-role="code"] {min-width: 120px;text-align: center;}
    .list-group-item > em[data-role="name"] {flex-grow: 1;text-align: left;}
    .list-group-item > em[data-role="subtotal"] {min-width: 110px;text-align: right;font-weight: 900}
    .list-group-item > em[data-role="volume"] {min-width: 80px;text-align: right;}
    .list-group-item > em[data-role="withdraw"] {min-width: 110px;text-align: right;font-weight: 600}
    .list-group-item > em[data-role="source"] {min-width: 160px;font-weight: 600;text-align: center}
    .list-group-item > em[data-role="point"] {min-width: 80px;text-align: right;font-weight: 600}
    .list-group-item > em[data-role="isWithdraw"] {min-width: 60px;text-align: center;}
    .list-group-item > em[data-role="dateTime"] {min-width: 92px;text-align: right;}
    .list-group-item > em[data-role="note"] {flex-grow: 1; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;}
    .list-group-item > em[data-role="isWithdraw"][data-value="Y"] {color: #1ea505;font-weight: 500;max-width: 60px;overflow: hidden;text-overflow: ellipsis}
    .list-group-item > em[data-role="dateTime"].withdraw { color: #1ea505;font-weight: 500 }
    .list-group-item > em[data-role="isWithdraw"] .btn {font-size: 11px;padding: .175rem .25rem;height: auto}
    .list-group-item.item-subtotal {background-color: #ecece8}
    .modal .list-group-item > em[data-role="no"] {min-width: 32px;}
    .toolbars {display: flex;align-content: stretch;}
    .toolbars button.toolbar-toggle {border: 1px solid #ccc; padding: .25rem .5rem;position: relative;z-index: 1; cursor: pointer}
    .toolbars button.toolbar-toggle:disabled {opacity: .5; cursor: not-allowed}
    .toolbars button.toolbar-toggle:not(:disabled):hover {background-color: #ccc; border-color: #aaa;}
    .toolbars button.toolbar-toggle:not(:first-child) {margin-left: -1px;}
    .toolbars button.toolbar-toggle:first-child {border-top-left-radius: .5rem !important; border-bottom-left-radius: .5rem !important }
    .toolbars button.toolbar-toggle:last-child {border-top-right-radius: .5rem !important; border-bottom-right-radius: .5rem !important;}
    .toolbars .toolbar-help {padding: .5rem .5rem;color: #007aff;font-size: 11px;}
    .table-list .list-group-item > em[data-role="name"] {display: flex;}
    .table-list .list-group-item > em[data-role="name"] > A {flex-grow: 1;white-space: nowrap; display: block;overflow: hidden; text-overflow: ellipsis}
    .table-list .list-group-item > em[data-role="name"] .history-icon {color: #666;margin-left: auto;font-size: 11px;}
    @media (min-width: 768px) {
        label.list-box {margin-bottom: 0;}
        .list-box {width: auto; margin-right: .5rem; margin-bottom: 0}
        .list-box select {line-height: 16px}
        form dl.form-group {display: flex;align-items: stretch;margin: -1px 0 0 0;width: 100%;}
        form dl.form-group > dt, form dl.form-group > dd {margin: 0;padding: .75rem;border: 1px solid #ddd;}
        form dl.form-group dt {width: 25%;max-width: 150px;display: flex;flex-direction: row;align-items: center;background-color: #f5f6f8;}
        form dl.form-group dd {flex-grow: 1;margin-left: -1px;}
        form dl.form-group dt label {padding: 0;margin: 0;color: #093289;font-weight: 600;display: inline-block;}
        #agent-point-history .modal-dialog {width: 96%; max-width: 1200px;}
    }
    @media (max-width: 767px) {
        .sm-hidden {display: none;}
        .list-group-item > em[data-role="no"] {min-width: 30px;}
        .list-group-item > em[data-role="code"] {min-width: 72px}
        .list-group-item > em[data-role="subtotal"],
        .list-group-item > em[data-role="withdraw"] {min-width: 80px;}
        .list-group-item > em[data-role="volume"] {min-width: 36px;}
    }
</style>
<div class="admin-agent-list">
    <div class="adm-headline adm-headline-btn">
        <h3><?= $g5['title'] ?></h3>
        <button type="button" class="btn-e btn-e-lg btn-e-green btn-export" data-filter="<?= rtrim('dir=export&pid=agent_export&scope=point&' . http_build_query($filter), '&') ?>">
            <i class="far fa-file-excel"></i> 검색결과 엑셀 다운로드
        </button>
    </div>

    <form name="frmSearch" action="<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?>" class="eyoom-form">
        <input type="hidden" name="dir" value="<?= $dir ?>" />
        <input type="hidden" name="pid" value="<?= $pid ?>" />
        <input type="hidden" name="sort" value="<?= $param['sort'] ?>" />
        <input type="hidden" name="order" value="<?= $param['order'] ?>" />

        <input type="hidden" name="fromDate" id="from-date" value="<?= $param['fromDate'] ?>">
        <input type="hidden" name="toDate" id="to-date" value="<?= $param['toDate'] ?>">

        <div class="adm-table-form-wrap adm-search-box">
            <dl class="form-item">
                <dt>검색어</dt>
                <dd class="input inline">
                    <div class="d-md-flex">
                        <label class="list-box">
                            <select name="state">
                                <option value="">시/도 전체</option>
                                <?php
                                foreach (getDistrictState() as $code => $text):
                                    print sprintf('<option value="%s"%s>%s</option>', $code, $code == $state ? ' selected' : '', $text);
                                endforeach;
                                ?>
                            </select>
                        </label>
                        <div class="d-flex flex-nowrap">
                            <label class="date-range-picker" data-bind='#from-date,#to-date' data-start-date="<?= $param['fromDate'] ?>" data-end-date="<?= $param['toDate'] ?>" data-ranges="monthly"></label>
                            <button type="submit" class="margin-left-10 btn-e btn-e-lg btn-e-dark" accesskey="s">
                                <i class="fa fa-search"></i> 검색
                            </button>
                        </div>
                    </div>
                </dd>
            </dl>
        </div>


        <div class="row">
            <div class="col col-9">
                <div class="padding-top-5">
                <span class="font-size-12 color-grey">
                    &nbsp;&nbsp;Total : <?php echo number_format($totals); ?></span>
                </div>
            </div>
        </div>
    </form>

    <?php if (G5_IS_MOBILE) { ?>
        <p class="font-size-11 color-grey text-right margin-bottom-5"><i class="fas fa-info-circle"></i> Note! 좌우스크롤 가능
            (<i class="fas fa-arrows-alt-h"></i>)</p>
    <?php } ?>

    <div class="table-content">
        <ul class="list-group table-list">
            <li class="list-group-item">
                <label class="checklist checklist-toggle"><input type="checkbox" value="checked" /><i class="checkmark"></i></label>
                <em data-role="no">No</em>
                <em data-role="code"><a href="" class="sort" data-label="A">코드</a></em>
                <em data-role="name"><a href="" class="sort" data-label="B">대리점</a></em>
                <em data-role="subtotal">누적<span class="sm-hidden">금액(소계)</span></em>
                <em data-role="volume">건수</em>
                <em data-role="withdraw">출금</em>
                <em data-role="debt">미정산</em>
            </li>
            <?php $subtotal = [];foreach ($list as $row): $label = '<span class="sm-hidden">' . $States[substr($row['agent'], 0, 2)] . ' / </span>' . $row['name'];
                $text_color = $row['subtotal'] > 0 ? 'text-info' : 'text-danger';
                $subtotal['subtotal'] += $row['subtotal']; $subtotal['volume'] += $row['volume'];$subtotal['withdraw'] += $row['withdrawAmount'];$subtotal['debt'] += $row['debtAmount'];?>
                <li class="list-group-item">
                    <label class="checklist"><input type="checkbox" name="idx[]" value="<?= $row['agent'] ?>" /><i class="checkmark"></i></label>
                    <em data-role="no"><?= $max_no-- ?></em>
                    <em data-role="code" data-value="<?= $row['agent'] ?>"><?= $row['agent'] ?></em>
                    <em data-role="name" data-value="<?= $row['agent'] ?>"><?= $label ?></em>
                    <em data-role="subtotal"><span class='<?= $text_color ?> point-suffix'><?= number_format($row['subtotal']) ?></span></em>
                    <em data-role="volume" data-value="<?= $row['agent'] ?>"><span class='volume-suffix'><?= number_format($row['volume']) ?></span></em>
                    <em data-role="withdraw"><?php if ($row['withdrawAmount'] > 0)  : ?>
                        <span class='point-suffix text-success'><?= number_format($row['withdrawAmount']) ?></span><?php else: print '-'; endif; ?>
                    </em>
                    <em data-role="withdraw" data-value="<?= $row['agent'] ?>">
                        <?php if ($row['debtAmount'] > 0)  : ?><span class='point-suffix color-red'><?=number_format($row['debtAmount'])?></span><?php else: print '-'; endif; ?>
                    </em>
                </li>
            <?php endforeach; ?>
            <li class="list-group-item item-subtotal">
                <label class="checklist"></label>
                <em data-role="no"></em>
                <em data-role="code"></em>
                <em data-role="name"></em>
                <em data-role="subtotal"><span class='point-suffix text-danger'><?= number_format($subtotal['subtotal']) ?></span></em>
                <em data-role="volume"><span class='volume-suffix text-danger'><?= number_format($subtotal['volume']) ?></span></em>
                <em data-role="withdraw"><span class='point-suffix text-danger'><?= number_format($subtotal['withdraw']) ?></span></em>
                <em data-role="withdraw"><span class='point-suffix color-red'><?= number_format($subtotal['debt']) ?></span></em>
            </li>
        </ul>
    </div>

    <div class="toolbars margin-top-20">
        <button type="button" class="toolbar-toggle" disabled="disabled" data-label="withdraw" data-value="Y">
            <i class="fas fa-money-check-alt"></i> 출금 승인
        </button>

        <button type="button" class="toolbar-toggle" disabled="disabled" data-label="withdraw" data-value="N">
            <i class="fab fa-creative-commons-nc"></i> 출금 미승인
        </button>
        <div class="toolbar-help">검색날짜 기준으로 출금 승인으로 처리됩니다.</div>
    </div>

    <?= eb_paging($eyoom['paging_skin']); ?>
    <div class="margin-bottom-20"></div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" id="agent-point-history">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title"><i class="fas fa-history"></i><span class="agent-label"></span></h4>
            </div>
            <div class="ajax-load-container">
                <div class="load-content">페이지 불러오는 중 . . .</div>
            </div>
            <div class="list-container">

            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
    $(function () {
        var $search = $('form[name="frmSearch"]'), $dialog = $('#agent-point-history');
        var $from = $search.find('INPUT[name="fromDate"]'), $to = $search.find('INPUT[name="toDate"]');

        function __get_history(agentCode, pageNo, callback) {
            var query = '?dir=agent&pid=point_history&agent=' + agentCode;
            query += '&fromDate=' + $from.val();
            query += '&toDate=' + $to.val();
            query += '&page=' + pageNo;

            $dialog.removeAttr('data-loaded');

            $.get(g5_admin_url + query, function (data) {
                $dialog.modal('show');
                $dialog.find('.list-container').html(data).find('.eb-pagination A').one('click', function (event) {
                    event.preventDefault();
                    var matches = (/&page=(\d+)/gi).exec($(this).attr('href'));
                    if (!matches || matches.length != 2) return false;
                    __get_history(agentCode, matches[1], callback)
                });

                $dialog.find('.list-container').find('button.withdrawal-cancel').on('click', function (event) {
                    event.preventDefault();
                    var $btn = $(this);
                    if (!confirm('정산처리된 항목을 취소하시겠습니까?')) return false;
                    $.post(g5_admin_url + '?dir=agent&pid=agent_exec&scope=suspended&target=' + $btn.attr('data-value'), function (result) {
                        if (result.code != 200) {
                            alert(result.message);
                            return false;
                        }
                        alert('미정산으로 변경되었습니다.');
                        $btn.parent().attr('data-value', 'N').text('N');
                    });
                });
                typeof(callback) === 'function' && callback();
            }).always(function () {
                setTimeout(function () {
                    $dialog.attr('data-loaded', true);
                }, 100);
            });
        }

        $('UL.table-list > LI.list-group-item:not(:first-child) > em[data-value]').on('click', function () {
            var $self = $(this);
            __get_history($self.attr('data-value'), 1, function () {
                $dialog.find('.modal-title .agent-label').html($self.text() + '<small>(' + moment($from.val()).format('YY.MM.DD') + '~' + moment($to.val()).format('YY.MM.DD') + ')</small>');
            });
        });
        // -----------------------------------------------------------------

        var $control = $('UL.table-list .list-group-item:first-child').find('input:checkbox'),
            $bind = $('UL.table-list').find('LABEL.checklist > INPUT:checkbox').not($control),
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


        $toolbar.on('click', function (event) {
            event.preventDefault();
            var $self = $(this), param = {
                'scope': 'invoice'
                , 'target': $bind.filter(':checked').map(new Function('return this.value;')).get()
                , 'attribute': $self.attr('data-label')
                , 'value': $self.attr('data-value')
                , 'from': moment($from.val()).format('YYYY-MM-DD')
                , 'to': moment($to.val()).format('YYYY-MM-DD')
            };

            if (!param.target) {
                alert('하나 이상의 항목을 선택하세요.');
                return false;
            }
            else if (!confirm('선택한 항목에 대해 "' + $(this).text().trim() + '" 처리 하시겠습니까?')) {
                return false;
            }

            $.post(g5_admin_url + '/?dir=agent&pid=agent_exec', param, function (result) {
                if (result.code != 200) {
                    alert(result.message);
                    return false;
                }
                alert('수정되었습니다.');
                window.location.reload(true);
            });


            // data-label="withdraw" data-value="N"
        });


        // -----------------------------------------------------------------

        $('A.sort').on('click', function (event) {
            event.preventDefault();
            var el = $(this);
            if (el.attr('data-label') == '<?=$param['sort']?>') {
                $search.find('INPUT[name="order"]').val('<?=$param['order'] != 'D' ? 'D' : 'A'?>');
            }
            else {
                $search.find('INPUT[name="sort"]').val(el.attr('data-label'));
                $search.find('INPUT[name="order"]').val('D');
            }
            $search.submit();
        }).filter('[data-label="<?=$param['sort']?>"]').attr('data-order', '<?=$param['order']?>');

        // -----------------------------------------------------------------

    });
</script>