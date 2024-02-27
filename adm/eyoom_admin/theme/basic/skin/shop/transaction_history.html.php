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

?>
<style type="text/css">
    .form-item {display: flex;margin: 0; padding: 0; max-width: 100%; }
    .form-item dt {width: 15%;max-width: 150px;}
    .form-item dt { margin: 0; padding: 12px 0 0 10px; font-style: normal;border: 1px solid #434350; font-weight: 700; background-color: #72727f; color: #fff;}
    .form-item dd { flex-grow: 1;margin: 0 0 0 -1px; padding: 8px; font-style: normal; border: 1px solid #434350; }
    .form-item:not(:first-child) {margin-top: -1px}
    .list-box {display: inline-block;padding: 0; margin: 0; position: relative; width: 100%; }
    .list-box select {line-height: 1.5; font-size: 12px;height: auto; width: calc(100% - 1rem);font-weight: normal;padding: 4px .5rem;border-radius: 0;-webkit-appearance: none;-moz-appearance: none;appearance: none;outline: 0;position: relative;z-index: 1;min-width: 90px;}
    .list-box select::-ms-expand {display: none;}
    .list-box select:disabled {color: #666;background-color: #f0f0f0;text-shadow: 1px 1px rgba(255, 255, 255, 1);}
    .list-box::before,
    .list-box::after {content: '';position: absolute;right: 5px;border: 4px solid transparent;pointer-events: none;top: 50%;z-index: 101;}
    .list-box::before {border-bottom-color: #7a7a7a;margin-top: -9px;}
    .list-box::after {border-top-color: #7a7a7a;}
    .form-item .list-box {width: 100%;}
    .form-item .btn {height: auto;font-weight: normal;padding: 4px .5rem;line-height: 1.5;display: inline-block}
    /*--*/
    body.modal-open {padding-right: 0 !important;}
    .modal .modal-dialog {margin: 0 auto;height: 100%;width: 100%;display: flex;}
    .modal .modal-content {margin: auto;text-align: left;font-size: 11px;min-height: 438px;width: 100%;max-width: 700px;}
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
    .modal .list-container .table-list-item:hover {background-color: #f2f2f2;}
    .point-suffix::after {font-family: "Font Awesome 5 Brands";-webkit-font-smoothing: antialiased;display: inline-block;font-style: normal;font-variant: normal;text-rendering: auto;line-height: 1;font-weight: 400;content: "\f288";box-sizing: border-box;margin-left: 2px;font-size: xx-small;color: #3a3a48;}
    .table-content {width: 100%;overflow: hidden; overflow-x: auto;font-size: 13px;background-color: #fff}
    A.sort {position: relative;display: block;color: #333;}
    A.sort::after {content: '';position: absolute;right: .5rem;border: solid transparent;border-width: 0 3px 3px 0;display: inline-block;padding: 3px;}
    A.sort::after {border-color: #ccc; top: 4px;transform: rotate(45deg);-webkit-transform: rotate(45deg);}
    A.sort[data-order]::after {border-color: #0f70be;}
    A.sort[data-order="D"]::after {}
    A.sort[data-order="A"]::after {top: 7px;transform: rotate(-135deg);-webkit-transform: rotate(-135deg);}
    .toolbars {display: flex;align-content: stretch;}
    .toolbars button.toolbar-toggle {border: 1px solid #ccc; padding: .25rem .5rem;position: relative;z-index: 1; cursor: pointer}
    .toolbars button.toolbar-toggle:disabled {opacity: .5; cursor: not-allowed}
    .toolbars button.toolbar-toggle:not(:disabled):hover {background-color: #ccc; border-color: #aaa;}
    .toolbars button.toolbar-toggle:not(:first-child) {margin-left: -1px;}
    .toolbars button.toolbar-toggle:first-child {border-top-left-radius: .5rem !important; border-bottom-left-radius: .5rem !important }
    .toolbars button.toolbar-toggle:last-child {border-top-right-radius: .5rem !important; border-bottom-right-radius: .5rem !important;}
    .table-list {margin: 0;padding: 0;}
    .table-list LI {margin: -1px 0 0 0;padding: 0 15px;text-align: left;cursor: default;color: #666; flex-wrap: wrap;position: relative;border-top: 1px solid #e7e7e7;border-bottom: 1px solid #e7e7e7;transition: background-color .3s linear}
    .table-list LI:first-child {display: none;}
    .table-list LI:nth-child(2) {border-top-color: #777;margin-top: 0;}
    .table-list-item { display: inline-flex; flex-wrap: wrap;cursor: pointer;}
    .table-list-item > em {font-style: normal; display: inline-block; padding: .5rem .5rem;}
    .table-list-item > em:first-child {padding-left: 0}
    .table-list-item > em:last-child {padding-right: 0;border-right: 0}
    .table-list-item > em[data-value] {cursor: pointer;color: #000}
    .table-list-item > em[data-value]:hover {color: #f30;text-shadow: 1px 1px 2px rgba(0, 0, 0, .215)}
    .table-list-item > em[data-role="no"] {min-width: 60px;}
    .table-list-item > em[data-role="orderId"] {min-width: 120px;text-align: center;}
    .table-list-item > em[data-role="title"] {flex-basis: 100%;margin-top: auto;}
    .table-list-item > em[data-role="amount"] {min-width: 80px;text-align: left;}
    .table-list-item > em[data-role="status"] {min-width: 80px;text-align: center;}
    .transition-history {background-color: #f9f9f9;margin-left: -15px;margin-right: -15px;max-height: 0;overflow: hidden; }
    .transition-history DL, .transition-history DT, .transition-history DD {margin: 0;padding: 0;font-weight: normal;}
    .transition-history DL {display: flex;border: 1px solid #ccc;font-size: 11px;background-color: #f6f6f6;margin-top: -1px;}
    .transition-history DL:last-child {border-bottom: 0}
    .transition-history DT {width: 15%;max-width: 100px;text-align: center;padding: 4px 10px;background-color: #d8d8d8}
    .transition-history DD {width: 35%;padding: 4px 10px;}
    /**/
    .list-box {margin-bottom: 5px; }
    .form-item-group {display: flex;}
    .form-item-group .date-range-picker {flex-grow: 1}
    .form-item .form-control {font-size: 12px;margin-bottom: 5px;height: auto;font-weight: normal;padding: 4px 0.5rem;line-height: 1.5;display: inline-block;max-width: calc(100% - 10px)}
    .badge-status {min-width: 54px; }
    .badge-status[data-value="failure"] {background-color: #f0ad4e;color: #fff;}
    .badge-status[data-value="error"] {background-color: #d9534f; color: #fff;}
    .item-group .btn-group {margin-bottom: 5px; min-width: 156px;}
    .member-link {display: inline;margin-top: 5px;}
    .member-link::before {content: ' (';}
    .member-link::after {content: ')';}
    .badge.badge-success {color: #fff;background-color: #28a745}
    .badge.badge-failure {color: #fff;background-color: #dc3545}
    .pay-status {font-size: 11px;}
    .pay-dismiss {color: #dc3545; text-decoration: line-through;text-decoration-color: #28a745}
    .pay-warning {color: #f09725}
    .pay-danger {color: #dc3545}
    @media (min-width: 980px) {
        .item-group {display: flex;}
        .list-box, .form-item .form-control {margin-bottom: 0;}
        .list-box {max-width: 120px;}
        .form-item .form-control {max-width: 200px;}
        .form-item-group {margin-left: -1px; z-index: 1}
        .item-group .btn-group {margin-bottom: 0; margin-right: .75rem;}
        .table-list LI:first-child {display: block;font-weight: 700;background-color: #E8E9EC;border-top: 2px solid #777;}
        .table-list LI:first-child .table-list-item > em {border-right-color: #cdcdcd}
        .table-list-item {display: flex; flex-wrap: nowrap;}
        .table-list-item > em {min-width: 80px;display: inline-block;white-space: nowrap;overflow: hidden;text-overflow: ellipsis}
        .table-list-item > em {border-right: 1px solid #f0f0f0;}
        .table-list-item > em[data-role="no"] {text-align: center;}
        .table-list-item > em[data-role="orderId"] {text-align: center;}
        .table-list-item > em[data-role="user"] {width: 170px;min-width: 170px;}
        .table-list-item > em[data-role="title"] {flex-grow: 1;display: inline-block}
        .table-list-item > em[data-role="dateTime"] {min-width: 102px;text-align: center;}
        .member-link {display: inline;width: auto;overflow: visible;text-overflow: unset;margin-top: 0;}
    }
    .table-list LI.expanded {background-color: #7a7a7a;}
    .table-list LI.expanded .table-list-item A, .table-list LI.expanded .table-list-item > em {color: #f0f0f0;}
    .table-list LI.expanded .transition-history {display: block;max-height: 100vh;transition: max-height .6s ease-in-out;}
    .tx-cancel, .btn-transition-cancel {font-size: 11px;padding: .25rem .5rem;height: auto;float: right}
    .tx-cancel::after, .btn-transition-cancel::after {content: ''; display: block;clear: both;width: 100%;}
    .btn-transition-cancel:disabled {background-color: #d2d2d2;border-color: #d2d2d2;color: #888;text-shadow: 1px 1px 0 rgba(255, 255, 255, .5); }
    .tx-cancel {color:#0f70be}
</style>
<div class="admin-agent-list">
    <div class="adm-headline adm-headline-btn">
        <h3><?= $g5['title'] ?></h3>
    </div>

    <form name="frmSearch" action="<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?>" class="eyoom-form">
        <input type="hidden" name="dir" value="<?= $dir ?>" />
        <input type="hidden" name="pid" value="<?= $pid ?>" />
        <input type="hidden" name="sort" value="<?= $param['sort'] ?>" />
        <input type="hidden" name="order" value="<?= $param['order'] ?>" />

        <input type="hidden" name="fromDate" id="from-date" value="<?= $param['fromDate'] ?>">
        <input type="hidden" name="toDate" id="to-date" value="<?= $param['toDate'] ?>">

        <div class="adm-search-box">
            <dl class="form-item">
                <dt>검색</dt>
                <dd class="item-group">

                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-e-default<?= $param['status'] ? '' : ' active' ?>">
                            <input type="radio" name="status" value="" id="filterA" autocomplete="off"<?= $param['status'] ? '' : ' checked' ?>>
                            전체
                        </label>
                        <label class="btn btn-e-default<?= $param['status'] == 'F' ? ' active' : '' ?>">
                            <input type="radio" name="status" value="F" id="filterB" autocomplete="off"<?= $param['status'] == 'F' ? ' checked' : '' ?>>
                            결제실패
                        </label>
                        <label class="btn btn-e-default<?= $param['status'] == 'N' ? ' active' : '' ?>">
                            <input type="radio" name="status" value="N" id="filterC" autocomplete="off"<?= $param['status'] == 'N' ? ' checked' : '' ?>>
                            주문누락
                        </label>
                    </div>

                    <label class="list-box">
                        <select name="keyfield">
                            <option value="A">주문번호</option>
                            <option value="B"<?= $param['keyfield'] == 'B' ? ' selected' : '' ?>>회원아이디</option>
                        </select>
                    </label>

                    <input type="text" size="40" name="keyword" class="form-control" placeholder="검색어" value="<?= $keyword ?>" />

                    <div class="form-item-group">
                        <label class="date-range-picker" data-bind='#from-date,#to-date' data-start-date="<?= $param['fromDate'] ?>" data-end-date="<?= $param['toDate'] ?>" data-ranges="tpl"></label>
                        <button class="btn btn-e-dark" accesskey="s"><i class="fa fa-search"></i> 검색</button>
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
        <ul class="table-list" id="table-list">
            <li>
                <div class="table-list-item">
                    <!-- label class="checklist checklist-toggle"><input type="checkbox" value="checked" /><i class="checkmark"></i></label -->
                    <em data-role="no">No</em>
                    <em data-role="orderId">주문번호</em>
                    <em data-role="user"><a href="" class="sort" data-label="B">회원</a></em>
                    <em data-role="title">상품</em>
                    <em data-role="amount">결제금액</em>
                    <em data-role="status">결제상태</em>
                    <em data-role="status">주문상태</em>
                    <em data-role="dateTime"><a href="" class="sort" data-label="A">날짜</a></em>
                </div>
            </li>
            <?php foreach ($list as $row):
                if ($row['code'] != '0000') {
                    $order_badge = '<span class="pay-status pay-warning" data-value="failure">결제실패</span>';
                }
                else if (!$row['order_status']) {
                    $order_badge = '<span class="pay-status pay-danger" data-value="error">주문누락</span>';
                }
                else {
                    $order_badge = "<span class=\"pay-status\" data-value=\"default\">주문{$row['order_status']}</span>";
                }

                $tx_badge = $row['code'] == '0000' ? '성공' : "{$row['code']}";
                if($row['code'] !='000') {
                    $tx_badge = "<span class='badge badge-failure'>{$tx_badge}</span>";
                }
                else if($row['canceled']=='Y') {
                    $tx_badge = "<span class='badge badge-cancel'>취소</span>";
                }
                else {
                    $tx_badge = "<span class='badge badge-success'>{$tx_badge}</span>";
                }


                ////(new Datetime()->format('Y년 m월 d일 H:i')
                ?>
                <li>
                    <div class="table-list-item">
                        <!-- label class="checklist"><input type="checkbox" name="idx[]" value="<?= $row['agent'] ?>" /><i class="checkmark"></i></label -->
                        <em data-role="no"><?= $max_no-- ?></em>
                        <em data-role="orderId"><?= $row['ord_id'] ?></em>
                        <em data-role="user"><?= $row['member_name'] . '<a class="member-link">' . $row['mb_id'] . '</a>' ?></em>
                        <em data-role="title"><?= $row['request']['itemName'] ?></em>
                        <em data-role="amount"><strong><?= number_format($row['request']['amount']) ?></strong>원</em>
                        <em data-role="status"><?=$tx_badge?></em>
                        <em data-role="status"><?= $order_badge ?></em>
                        <em data-role="dateTime"><?= (new DateTime($row['created_at']))->format('Y-m-d H:i') ?></em>
                    </div>
                    <div class="transition-history">
                        <dl>
                            <dt>거래일시</dt>
                            <dd><?= preg_replace('/^([\d]{4})([\d]{2})([\d]{2})([\d]{2})([\d]{2})([\d]{2})/', '$1년 $2월 $3일 $4:$5', $row['response']['authNumber'] ? $row['response']['authDateTime'] : $row['request']['timestamp']); ?></dd>
                            <dt>할부개월</dt>
                            <dd><?= $row['request']['quota'] ?></dd>
                        </dl>
                        <dl>
                            <dt>승인번호</dt>
                            <dd><?php if ($row['response']['responseCode'] == '0000'): ?>
                                    <strong class="color-indigo"><?= $row['response']['authNumber'] ?></strong>
                                    <?php
                                    /*승인 취소 됨*/
                                    if ($row['canceled'] == 'Y') :?>
                                        <span class="tx-cancel">[<?=$row['canceled_at']?>] <?=$row['canceller']?> : <?=$row['canceled_to']?></span>


                                    <?php /*주문누락건인 경우*/
                                    elseif (empty($row['order_status']) === true): ?>
                                        <button data-id="<?= $row['idx'] ?>" data-tx="<?= $row['response']['transactionId'] ?>" class="btn btn-warning btn-transition-cancel">
                                            카드승인취소
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-warning btn-transition-cancel" disabled>
                                            카드승인취소
                                        </button>
                                    <?php endif ?>
                                <?php endif ?></dd>
                            <dt>메시지</dt>
                            <dd class="<?= $row['response']['responseCode'] == '0000' ? 'color-indigo' : 'color-orange' ?>"><?= $row['response']['responseMsg'] ?><?= $row['response']['responseCode'] ? "({$row['response']['responseCode']})" : '' ?></dd>
                        </dl>
                        <dl>
                            <dt>결제금액</dt>
                            <dd class=""><?= $row['request']['amount'] ?></dd>
                            <dt>결제카드</dt>
                            <dd><?= $row['response']['cardName'] ?></dd>
                        </dl>
                        <dl>
                            <dt>고객명</dt>
                            <dd><?= $row['request']['userName'] ?></dd>
                            <dt>상품명</dt>
                            <dd><?= $row['request']['itemName'] ?></dd>
                        </dl>
                        <dl>
                            <dt>이메일</dt>
                            <dd><?= $row['request']['userEmail'] ?></dd>
                            <dt>연락처</dt>
                            <dd><?= $row['request']['mobileNumber'] ?></dd>
                        </dl>


                    </div>

                </li>

            <?php endforeach; ?>
        </ul>
    </div>

    <!-- div class="toolbars margin-top-20">
        <button type="button" class="toolbar-toggle" disabled="disabled" data-label="withdraw" data-value="Y">
            <i class="fas fa-money-check-alt"></i> 출금 승인
        </button>

        <button type="button" class="toolbar-toggle" disabled="disabled" data-label="withdraw" data-value="N">
            <i class="fab fa-creative-commons-nc"></i> 출금 미승인
        </button>
    </div -->

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
                typeof(callback) === 'function' && callback();
            }).always(function () {
                setTimeout(function () {
                    $dialog.attr('data-loaded', true);
                }, 100);
            });
        }

        $('UL.table-list > LI.table-list-item:not(:first-child) > em[data-value]').on('click', function (event) {
            var $self = $(this);
            __get_history($self.attr('data-value'), 1, function () {
                $dialog.find('.modal-title .agent-label').html($self.text() + '<small>(' + moment($from.val()).format('YY.MM.DD') + '~' + moment($to.val()).format('YY.MM.DD') + ')</small>');
            });
        });
        // -----------------------------------------------------------------

        var $control = $('UL.table-list .table-list-item:first-child').find('input:checkbox'),
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

        var rows = $('#table-list LI:not(:first-child)');

        rows.find('.table-list-item').on('click', function (event) {
            event.preventDefault();
            var self = $(this).parent(), hasExpanded = self.hasClass('expanded');
            rows.filter('.expanded').removeClass('expanded');
            !hasExpanded && self.addClass('expanded');
        });

        // -----------------------------------------------------------------

        $('button.btn-transition-cancel').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            var note = prompt('카드 승인 취소 사유를 입력하세요.'), self = $(this);
            if (!note) return false;

            $.post('<?=G5_ADMIN_URL; ?>/ajax.payup.php', {
                'scope': 'cancel',
                'id': self.attr('data-id'),
                'tx': self.attr('data-tx'),
                'reason': note
            }, function (result) {
                result.message && alert(result.message);
                result.code == 200 && window.location.reload(true);
            });
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