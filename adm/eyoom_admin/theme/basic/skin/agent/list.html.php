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

##, "al_label" => "<span class='ellipsis'><a href=\"{$user_link}\" class=\"modal-toggle\"><i class=\"fas fa-external-link-alt color-light-grey margin-right-5 hidden-xs\"></i><strong>{$row['mb_id']}</strong></a></span>"
## , "mb_name" => "<a href=\"{$user_link}\" class=\"modal-toggle\">" . get_text($row['mb_name']) . "</a>"

$DistrictStringify = getDistrictStringify();
add_stylesheet('<link rel="stylesheet" href="' . EYOOM_ADMIN_THEME_URL . '/plugins/jsgrid/jsgrid.min.css" type="text/css" media="screen" />', 0);
add_stylesheet('<link rel="stylesheet" href="' . EYOOM_ADMIN_THEME_URL . '/plugins/jsgrid/jsgrid-theme.min.css" type="text/css" media="screen" />', 0);

add_javascript('<script type="text/javascript" src="' . EYOOM_ADMIN_THEME_URL . '/plugins/jsgrid/jsgrid.min.js?ver=' . G5_JS_VER . '"></script>', 0);
add_javascript('<script type="text/javascript" src="' . EYOOM_ADMIN_THEME_URL . '/js/jsgrid.js?ver=' . G5_JS_VER . '"></script>', 0);

?>
<style type="text/css">
    body.modal-open {padding-right: 0 !important;}
    .form-item {display: flex;margin: 0; padding: 0; max-width: 100%; }
    .form-item dt {width: 15%;max-width: 150px;}
    .form-item dt { margin: 0; padding: 12px 0 0 10px; font-style: normal;border: 1px solid #434350; font-weight: 700; background-color: #72727f; color: #fff;}
    .form-item dd { flex-grow: 1;margin: 0 0 0 -1px; padding: 8px; font-style: normal; border: 1px solid #434350; }
    .form-item:not(:first-child) {margin-top: -1px}
    .form-item .input input[type="text"] {}
    .list-box {display: inline-block;padding: 0;position: relative;margin-bottom: .25rem; width: 100%; }
    .list-box select {height: auto; width: calc(100% - 1rem);font-weight: normal;padding: 4px .5rem;line-height: 1.5;border-radius: 0;-webkit-appearance: none;-moz-appearance: none;appearance: none;outline: 0;position: relative;z-index: 1;min-width: 90px;}
    .list-box select::-ms-expand {display: none;}
    .list-box select:disabled {color: #666;background-color: #f0f0f0;text-shadow: 1px 1px rgba(255, 255, 255, 1);}
    .list-box::before,
    .list-box::after {content: '';position: absolute;right: 5px;border: 4px solid transparent;pointer-events: none;top: 50%;z-index: 101;}
    .list-box::before {border-bottom-color: #7a7a7a;margin-top: -9px;}
    .list-box::after {border-top-color: #7a7a7a;}
    .list-box + .form-control + .form-control {margin-left: -1px;width: auto}
    form dl.form-group .form-control {padding: .25rem .5rem;height: auto;font-size: 12px;margin-bottom: .5rem}
    form dl.form-group .form-control.inline {width: auto;}
    form dl.form-group .checkbox {display: inline-block;margin: 0;cursor: pointer;}
    form dl.form-group .checkbox + .checkbox {margin: 0 0 0 10px;}
    form dl.form-group .checkbox INPUT {vertical-align: middle;margin: 0;}
    form dl.form-group > dd {padding-left: .75rem; padding-right: 1.25rem;}
    ol.d-breadcrumb, ol.d-breadcrumb > li {margin: 0; padding: 0; list-style: none}
    ol.d-breadcrumb {display: flex; flex-wrap: wrap; align-items: center}
    ol.d-breadcrumb > li:not(:last-child)::after { content: '\003E'; display: inline-block;font-size: .75rem;padding-left: .075rem; padding-right: .075rem;opacity: .6375}
    form dl.form-group .input-group {display: inline-flex}
    form dl.form-group .input-group > .form-control,
    form dl.form-group .input-group > .input-group-addon {display: inline-block}
    form dl.form-group .input-group-addon {color: #555 !important;background-color: #eee !important;min-width: 20px;padding: 6px 0; text-align: center}
    @media (min-width: 768px) {
        .list-box {width: auto; margin-right: .5rem; margin-bottom: 0}
        .list-box select {line-height: 16px}
        form dl.form-group {display: flex;align-items: stretch;margin: -1px 0 0 0;width: 100%;}
        form dl.form-group > dt, form dl.form-group > dd {margin: 0;padding: .75rem;border: 1px solid #ddd;}
        form dl.form-group dt {width: 25%;max-width: 150px;display: flex;flex-direction: row;align-items: center;background-color: #f5f6f8;}
        form dl.form-group dd {flex-grow: 1;margin-left: -1px;}
        form dl.form-group dt label {padding: 0;margin: 0;color: #093289;font-weight: 600;display: inline-block;}
        form dl.form-group dd label {padding: 0; margin: 0;}
        form dl.form-group .form-control {margin-bottom: 0}
        form dl.form-group .list-box + .form-control {margin-left: -1px}
        .modal-dialog .list-box select {width: auto; min-width: 120px;}
        ol.d-breadcrumb > li::after {font-size: .5rem;}
    }
    .checklist {margin-left: 6px;}
    .toolbars {display: flex;align-content: stretch;}
    .toolbars button.toolbar-toggle {border: 1px solid #ccc !important; padding: .25rem .5rem !important;position: relative;z-index: 1; cursor: pointer}
    .toolbars button.toolbar-toggle:disabled {opacity: .5; cursor: not-allowed}
    .toolbars button.toolbar-toggle:not(:disabled):hover {background-color: #ccc; border-color: #aaa;}
    .toolbars button.toolbar-toggle:not(:first-child) {margin-left: -1px;}
    .toolbars .btn-group {display: inline-flex;position: relative;margin-left: -1px;}
    /*
    .toolbars button.toolbar-toggle:first-child {border-top-left-radius: .5rem !important; border-bottom-left-radius: .5rem !important }
    .toolbars button.toolbar-toggle:last-child {border-top-right-radius: .5rem !important; border-bottom-right-radius: .5rem !important;}
    */
    .admin-iframe-modal INPUT::placeholder, .admin-iframe-modal INPUT::-webkit-input-placeholder {font-weight: normal; color: #00aced;font-size: 1.1375rem}
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
    .list-group-item > em[data-role="status"] {min-width: 60px;text-align: center;}
    .list-group-item > em[data-role="code"] {min-width: 120px;text-align: center;}
    .list-group-item > em[data-role="name"] {min-width: 110px;width: 100%;flex-grow: 1;text-align: left;}
    .list-group-item > em[data-role="users"] {min-width: 100px;text-align: right;}
    .list-group-item > em[data-role="point"] {min-width: 200px;font-weight: 900;}
    .list-group-item > em[data-role="point"] .point-history {display: flex}
    .list-group-item > em[data-role="point"] .point-history I {margin-left: .5rem;padding-top: .375rem;font-size: 11px;color:#999}
    .list-group-item > em[data-role="point"] .withdrawal-completed {flex-grow: 1;text-align: right;color: #3c763d}
    .list-group-item > em[data-role="point"] .withdrawal-prepare {width: 50%;text-align: right;color: #f06795}
    .list-group-item > em[data-role="point"] small {font-weight: normal;}
    .list-group-item > em[data-role="bankAccount"] {min-width: 110px;max-width: 230px; width: 100%;text-align: left;}
    .list-group-item > em[data-role="dateTime"] {min-width: 100px;width: 100px;text-align: center;}
    /**/
    .list-group-item > em[data-role="source"] {min-width: 160px;}
    .list-group-item > em[data-role="note"] {flex-grow: 1; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;}
    .list-group-item > em[data-role="isWithdraw"] {min-width: 60px;text-align: center;}
    .list-group-item > em[data-role="isWithdraw"] .btn {font-size: 11px;padding:.175rem .25rem;height: auto}
    /**/
    .list-group-item:first-child > em {text-align: center}
    .list-group-item A.sort {position: relative;display: block;color: #333;}
    .list-group-item A.sort::after {content: '';position: absolute;right: .5rem;border: solid transparent;border-width: 0 3px 3px 0;display: inline-block;padding: 3px;}
    .list-group-item A.sort::after {border-color: #ccc; top: 2px;transform: rotate(45deg);-webkit-transform: rotate(45deg);}
    .list-group-item A.sort[data-order]::after {border-color: #0f70be;}
    .list-group-item A.sort[data-order="D"]::after {top: 2px;transform: rotate(45deg);-webkit-transform: rotate(45deg);}
    .list-group-item A.sort[data-order="A"]::after {top: 6px;transform: rotate(-135deg);-webkit-transform: rotate(-135deg);}
    .list-group-item sub {margin-bottom: 0;bottom: -.075em;padding-left: .25rem;}
    .list-group-item.item-subtotal {background-color: #ecece8}
    .list-group-item.item-subtotal em[data-role="point"]{display: flex}
    .list-group-item.item-subtotal em[data-role="point"] .withdrawal-prepare {margin-right:18px;}


    .modal-dialog .list-box select {width: 100%;}
    .agent-label {padding-left: 10px;}
    .adm-headline {display: flex;margin-bottom: 30px;}
    .adm-headline h3 {margin-bottom: 10px;flex: 1 1 auto}
    .adm-headline .btn-side {align-self: flex-end;}
    .adm-headline .btn-e-lg {position: static;}
    .adm-headline .btn-side form {display: inline-block;}
    .adm-headline select { height: auto;padding: 5px 15px;font-size: 13px !important;line-height: 1;}
    .adm-headline .adm-export {display: flex;}
    .adm-headline .adm-export select {margin-left: -1px;position: relative; z-index: 1;outline: 0;}
    .adm-headline .adm-export select:focus, .adm-headline .adm-export select:active {z-index: 2;}
    .admin-iframe-modal sub {margin: 0; font-weight: 400;color: #666}
    .agent-sole {background-color: #5bc0de; color: #fff;padding: 1px;font-size: 10px;}
    .eyoom-form .input .btn-group input {height: auto;width: auto;padding: 0;margin: 0;font-size: 12px;line-height: 1.5;}
    .adm-search-box .btn-group .btn {padding: .257rem 1rem; vertical-align: middle;line-height: 1.5}
    .adm-search-box .btn-group .btn input {opacity: 0;}
    /**/
    .d-agt-s [data-control], .d-agt-a [data-control] {}
    .d-agt-s .checkbox, .d-agt-a .checkbox {min-height: 28px;line-height: 28px;}
    .d-agt-s {line-height: 1.5}
    @media (min-width: 768px) {
        .d-agt-a {margin-left: 5px;}
        #agent-point-history .modal-dialog {width: 96%; max-width: 1200px;}
    }
</style>
<div class="admin-agent-list">
    <div class="adm-headline adm-headline-btn">
        <h3><?= $g5['title'] ?></h3>
        <div class="btn-side">
            <form name="frmExport">
                <div class="adm-export">
                    <input type="hidden" name="keyword" value="<?= $keyword ?>" />
                    <?php
                    foreach ($district as $val) print "<input type=\"hidden\" name=\"district[]\" value=\"{$val}\" />";
                    $dtExport = new DateTime('-1 month');
                    $tYear = $dtExport->format('Y');
                    $tMonth = $dtExport->format('m');
                    ?>
                    <!--
                    <select name="fy" ><?php foreach (range(2022, date('Y')) as $val) print sprintf('<option value="%s"%s>%s 년</option>', $val, $tYear == $val ? ' selected' : '', $val); ?></select>
                    <select name="fm" ><?php foreach (range(1, 12) as $val) print sprintf('<option value="%02d"%s>%02d 월</option>', $val, $tMonth == $val ? ' selected' : '', $val); ?></select>
                    <button type="submit" class="btn-e btn-e-dark btn-e-lg" ><i class="fas fa-file-excel"></i> 엑셀
                    </button>
                    -->
                </div>
            </form>
            <?php if (!$wmode) { ?>
                <a href="" class="btn-e btn-e-red btn-e-lg" id="agent-add"><i class="fas fa-plus"></i>
                    대리점추가</a><?php } ?>
        </div>
    </div>

    <form name="frmSearch" action="<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?>" class="eyoom-form">
        <input type="hidden" name="dir" value="<?= $dir ?>" />
        <input type="hidden" name="pid" value="<?= $pid ?>" />
        <input type="hidden" name="sort" value="<?= $param['sort'] ?>" />
        <input type="hidden" name="order" value="<?= $param['order'] ?>" />

        <div class="adm-table-form-wrap adm-search-box">
            <dl class="form-item">
                <dt>검색어</dt>
                <dd class="input inline">
                    <div class="d-md-flex">
                        <label class="list-box">
                            <select name="district[]" data-label="state" class="district">
                                <option value="">시/도 전체</option>
                            </select>
                        </label>
                        <!-- label class="list-box">
                            <select name="district[]" data-label="city" class="district">
                                <option value="">구/군 전체</option>
                            </select>
                        </label -->
                        <div class="btn-group" role="group" data-toggle="buttons">
                            <label class="btn btn-info<?= !$param['type'] ? ' active' : '' ?>">
                                <input type="radio" name="type" value=""<?= !$param['type'] ? ' checked' : '' ?> />
                                전체</label>
                            <label class="btn btn-info<?= $param['type'] == 'S' ? ' active' : '' ?>">
                                <input type="radio" name="type" value="S"<?= $param['type'] == 'S' ? ' checked' : '' ?> />
                                총판</label>
                            <label class="btn btn-info<?= $param['type'] == 'A' ? ' active' : '' ?>">
                                <input type="radio" name="type" value="A"<?= $param['type'] == 'A' ? ' checked' : '' ?> />
                                대리점</label>
                        </div>
                        <div class="d-flex flex-nowrap">
                            <input type="text" size="40" name="keyword" placeholder="이름 검색" value="<?= $keyword ?>" />
                            <button class="btn-e btn-e-dark" accesskey="s">
                                검색
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
        <ul class="list-group table-list" id="agent-list">
            <li class="list-group-item">
                <label class="checklist checklist-toggle"><input type="checkbox" value="checked" /><i class="checkmark"></i></label>
                <em data-role="no">No.</em>
                <em data-role="status">상태</em>
                <em data-role="code"><a href="" class="sort" data-label="C">코드</a></em>
                <em data-role="name"><a href="" class="sort" data-label="B">이름</a></em>
                <em data-role="users"><a href="" class="sort" data-label="D">회원수</a></em>
                <em data-role="point"><a href="" class="sort" data-label="E">정산/미정산<sub>P</sub></a></em>
                <em data-role="bankAccount">계좌</em>
                <em data-role="dateTime"><a href="" class="sort" data-label="A">등록일</a></em>
            </li>
            <?php $subtotal = [];foreach ($list as $row):
                //  $States[substr($row['agent'], 0, 2)]
                $user_link = G5_ADMIN_URL . '/?dir=member&pid=member_form&mb_id=' . $row['ag_mb_id'] . '&w=u&wmode=1';
                $agent_link = G5_ADMIN_URL . '/?dir=agent&pid=agent_exec&scope=profile&id=' . $row['ag_id'];

                $label = "<strong>" . get_text($row['ag_name']) . '</strong>';
                $point = '';
                $subtotal['mentee'] += $row['mentee'];
                $subtotal['settlement'] += $row['settlement'];
                $subtotal['not_settlement'] += $row['not_settlement'];

                if ($row['ag_type'] != 'S') {
                    if ($row['settlement'] > 0 || $row['not_settlement'] > 0) {
                        $point = '<a href="" class="point-history" data-label="' . strip_tags($label) . '"  data-value="' . $row['ag_code'] . '">';
                        $point .= '<span class="withdrawal-completed">' . number_format($row['settlement']) . '</span>';
                        $point .= '<span class="withdrawal-prepare">' . number_format($row['not_settlement']) . '</span>';
                        $point .= '<i class="fas fa-external-link-alt"></i></a>';
                    }

                    $parent_name = $row['parent_name'] ? $row['parent_name'] : '본사';
                    $label = "<i class=\"fas fa-user ag-type-a\"></i> {$parent_name} &gt; {$label}";
                }
                else {
                    if ($row['sub_settlement'] > 0 || $row['sub_not_settlement'] > 0) {
                        $pv1 = floor(($row['sub_settlement'] * ($row['ag_margin_rate'] / 100)) / 100) * 100;
                        $pv2 = floor(($row['sub_not_settlement'] * ($row['ag_margin_rate'] / 100)) / 100) * 100;

                        $point = '<a href=""  title="' . $ptip . '" class="point-history" data-own="parent" data-label="' . strip_tags($label) . '"  data-value="' . $row['ag_code'] . '">';
                        $point .= '<span class="withdrawal-completed">' . number_format($pv1) . '</span>';
                        $point .= '<span class="withdrawal-prepare">' . number_format($pv2) . '</span>';
                        $point .= '<i class="fas fa-external-link-alt"></i></a>';
                    }


                    //
                    $label = "<i class=\"fas fa-users ag-type-s\"></i> {$label} <sup class='agent-sole'>{$row['ag_margin_rate']}%</sup>";
                }

                ?>
                <li class="list-group-item">
                    <label class="checklist"><input type="checkbox" name="idx[]" value="<?= $row['ag_id'] ?>" /><i class="checkmark"></i></label>
                    <em data-role="no"><?= $max_no-- ?></em>
                    <em data-role="status"><?= $row['ag_status'] == 'active' ? '노출' : '숨김' ?></em>
                    <em data-role="code"><a href="<?= $agent_link ?>" class="modal-toggle"><?= $row['ag_code'] ?></a></em>
                    <em data-role="name"><a href="<?= $agent_link ?>" class="modal-toggle"><?= $label ?></a></em>
                    <em data-role="users"><?= $row['mentee'] > 0 ? number_format($row['mentee']) . '<sub>명</sub>' : '' ?></em>
                    <em data-role="point"><?= $point ?></em>
                    <em data-role="bankAccount"><?= str_replace('은행', '', $row['ag_bank_name']) ?> <?= $row['ag_bank_account'] ?> <?= $row['ag_bank_owner'] ?></em>
                    <em data-role="dateTime"><?= (new DateTime($row['ag_created_at']))->format('Y-m-d H:i') ?></em>
                </li>
            <?php endforeach; ?>
            <li class="list-group-item item-subtotal">
                <label class="checklist"></label>
                <em data-role="no"></em>
                <em data-role="status"></em>
                <em data-role="code"></em>
                <em data-role="name"></em>
                <em data-role="users"><?= $subtotal['mentee'] > 0 ? number_format($subtotal['mentee']) . '<sub>명</sub>' : '' ?></em>
                <em data-role="point"><span class="withdrawal-completed"><?= number_format($subtotal['settlement']) ?></span><span class="withdrawal-prepare"><?= number_format($subtotal['not_settlement']) ?></span></em>
                <em data-role="bankAccount"></em>
                <em data-role="dateTime"></em>
            </li>
        </ul>

    </div>

    <div class="toolbars margin-top-20">
        <button type="button" class="toolbar-toggle" disabled="disabled" data-label="status" data-value="active">
            <i class="fa fa-eye"></i> 노출
        </button>

        <button type="button" class="toolbar-toggle" disabled="disabled" data-label="status" data-value="inactive">
            <i class="fa fa-eye-slash"></i> 숨김
        </button>

        <div class="btn-group dropup" id="parent-move">
            <button type="button" class="toolbar-toggle dropdown-value" disabled="disabled" data-label="parent" data-value="">
                <i class="fas fa-users ag-type-s"></i> <span class="dropdown-label">총판 선택</span>
            </button>
            <button type="button" class="toolbar-toggle dropdown-toggle" disabled="disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
            </button>

            <ul class="dropdown-menu">
                <li><a href="" data-parent="">총판 선택</a></li>
                <?php foreach ($SoleDistributor as $row) {
                    $label = get_text($row['ag_name']);
                    print "<li><a href='' data-parent='{$row['ag_code']}' data-label='{$label}'>{$label}</a></li>";
                } ?>
            </ul>
        </div>

    </div>


    <?= eb_paging($eyoom['paging_skin']); ?>
    <div class="margin-bottom-20"></div>
</div>


<div class="modal fade admin-iframe-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <form name="frmWrite">

        <input type="hidden" name="scope" value="set" />
        <input type="hidden" name="ag_id" value="" />
        <input type="hidden" name="ag_code" value="" />

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title"><i class="fa fa-handshake"></i> 대리점 관리</h4>
                </div>
                <div class="modal-body">

                    <dl class="form-group">
                        <dt><label for="w-agent-district">대리점 명</label></dt>
                        <dd>
                            <div class="d-md-flex flex-nowrap">
                                <label class="list-box">
                                    <select name="district[]" data-label="state" class="district" id="w-agent-district">
                                        <option value="">시/도 선택</option>
                                    </select>
                                </label>
                                <label class="list-box">
                                    <select name="district[]" data-label="city" class="district">
                                        <option value="">구/군 선택</option>
                                    </select>
                                </label>
                                <input type="text" name="ag_suffix" class="form-control" size="40" maxlength="40" placeholder="세부 명칭(예: 동부, 서부)" />
                            </div>
                        </dd>
                    </dl>
                    <dl class="form-group">
                        <dt><label>계약 형태</label></dt>
                        <dd class="d-flex">
                            <div class="d-agt-s">
                                <label class="checkbox">
                                    <input type="radio" name="ag_type" value="S" /> 총판
                                </label>
                                <label class="input-group" data-control="S">
                                    <input type="number" name="ag_margin_rate" value="" class="form-control inline" size="3" maxlength="6" placeholder="마진율(%)" style="width: 80px;" />
                                    <span class="input-group-addon">%</span>
                                </label>
                            </div>

                            <div class="d-agt-a">
                                <label class="checkbox"><input type="radio" name="ag_type" value="A" /> 대리점</label>
                                <label class="list-box" data-control="A">
                                    <select name="ag_parent">
                                        <option value="">본사</option>
                                        <?php foreach ($SoleDistributor as $row) {
                                            $label = get_text($row['ag_name']);
                                            print "<option value=\"{$row['ag_code']}\">{$label}</option>";
                                        } ?>

                                    </select>
                                </label>
                            </div>

                        </dd>
                    </dl>
                    <dl class="form-group">
                        <dt><label for="w-agent-manager">회원 아이디<sub>(선택)</sub></label></dt>
                        <dd class="d-flex">
                            <input type="text" name="ag_mb_id" id="w-agent-manager" class="form-control inline" size="20" maxlength="20" placeholder="대리점 연결 회원 아이디" />
                            <button class="btn-e btn-e-dark" id="exists-member" type="button">조회</button>
                        </dd>
                    </dl>
                    <dl class="form-group">
                        <dt><label for="w-bank-name">지급 계좌<sub>(선택)</sub></label></dt>
                        <dd class="d-md-flex">
                            <label class="list-box">
                                <select name="ag_bank_name" id="w-bank-name">
                                    <option value="">은행명
                                    </option><?php foreach ($BankList as $text) print "<option value=\"{$text}\">{$text}</option>"; ?>
                                </select>
                            </label>
                            <input type="text" name="ag_bank_account" class="form-control" size="40" maxlength="40" placeholder="계좌 번호를 입력하세요" />
                            <input type="text" name="ag_bank_owner" class="form-control" size="20" maxlength="40" placeholder="예금주 이름" />
                        </dd>
                    </dl>
                    <dl class="form-group">
                        <dt><label>연락처<sub>(선택)</sub></label></dt>
                        <dd>
                            <input type="tel" name="ag_phone" class="form-control inline" size="24" maxlength="24" placeholder="연락처(선택)" />
                        </dd>
                    </dl>
                    <dl class="form-group">
                        <dt><label>이메일 주소<sub>(선택)</sub></label></dt>
                        <dd>
                            <input type="email" name="ag_email" class="form-control" size="40" maxlength="40" placeholder="이메일 주소(선택)" />
                        </dd>
                    </dl>
                    <dl class="form-group">
                        <dt><label>노출 여부</label></dt>
                        <dd>
                            <label class="checkbox"><input type="radio" name="ag_status" value="active" /> 노출</label>
                            <label class="checkbox"><input type="radio" name="ag_status" value="inactive" checked /> 숨김</label>
                        </dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button class="btn-e btn-e-lg btn-e-red" type="submit">
                        <i class="fa fa-save"></i> 저장
                    </button>
                    <button data-dismiss="modal" class="btn-e btn-e-lg btn-e-dark" type="button">
                        <i class="fas fa-times"></i> 닫기
                    </button>
                </div>
            </div>
        </div>
    </form>
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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" id="agent-export-progress">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title"><i class="fas fa-file-excel"></i> 엑셀 내보내기</h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        0%
                    </div>
                </div>
                <div class="progress-message"></div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        var container = $("#agent-list"), form = $('form[name="frmWrite"]'),
            $dialog = $('DIV.admin-iframe-modal:eq(0)');


        // -----------------------------------------------------------------

        form.submit(function (event) {
            event.preventDefault();
            var manager = form.find('INPUT[name="ag_mb_id"]');

            if (!form.find('SELECT[name="district[]"]').eq(0).val()) {
                alert('지역(시/도)를 선택하세요.');
                return false;
            }
            else if (form.find('INPUT[name="ag_type"]').val() == 'A' && !form.find('SELECT[name="district[]"]').eq(1).val()) {
                alert('지역(구/군)을 선택하세요.');
                return false;
            }
            else if (form.find('INPUT[name="ag_type"]').val() == 'A' && !form.find('INPUT[name="ag_id"]').val() && !form.find('INPUT[name="ag_suffix"]').val()) {
                alert('동일 지역의 타 대리점과 구분 가능한 세부 명칭을 입력하세요.');
                form.find('INPUT[name="ag_suffix"]').focus();
                return false;
            }
            else if (!form.find('INPUT[name="ag_type"]:checked').val()) {
                alert('계약형태를 확인 후 선택하세요.');
                return false;
            }
            else if ($.trim(manager.val() || '') != '' && manager.val() != manager.attr('data-value')) {
                alert('회원 등록 여부를 확인하세요.');
                manager.focus();
                return false;
            }
            else if (form.find('SELECT[name="ag_bank_name"]').val() && !form.find('INPUT[name="ag_bank_account"]').val()) {
                alert('은행 계좌 번호를 입력하세요.');
                form.find('INPUT[name="ag_bank_account"]').focus();
                return false;
            }
            else if (!form.find('SELECT[name="ag_bank_name"]').val() && form.find('INPUT[name="ag_bank_account"]').val()) {
                alert('은행명을 선택하세요.');
                return false;
            }
            else if (!form.find('INPUT[name="ag_status"]:checked').length) {
                alert('상태 값을 선택하세요.');
                return false;
            }
            else if (!confirm('저장하시겠습니까?')) return false;

            var is_new = (form.find('input[name="ag_id"]').val() || '') * 1;

            $.post(g5_admin_url + '/?dir=agent&pid=agent_exec', form.serialize(), function (result) {
                if (result.code != 200) {
                    alert(result.message);
                    return false;
                }
                alert('저장되었습니다.');
                window.location.reload(true);
            });
        });

        function get_agent_profile(href) {
            if (!href) return false;

            $.post(href, function (result) {
                if (result.code != 200) {
                    alert(result.message);
                    return false;
                }
                else if (!result.hasOwnProperty('profile')) {
                    alert('An error has occurred with API.');
                    return false;
                }

                var col, val, input, i = 0;
                for (col in result.profile) {
                    if (!result.profile.hasOwnProperty(col) || !(input = form.find('INPUT[name="' + col + '"]')).length) continue;
                    val = result.profile[col];
                    if (input.is(':radio')) {
                        input.filter('[value="' + val + '"]').prop('checked', true);
                    }
                    else {
                        input.val(val);
                    }
                }

                if (result.profile.hasOwnProperty('ag_code')) {
                    input = form.find('SELECT[name="district[]"]');

                    col = [result.profile.ag_code.substr(0, 2)];// 시도
                    col.push(result.profile.ag_code.substr(0, 5)); // 구군

                    do {
                        input.eq(i++).val(col.shift()).change();
                    }
                    while (col.length);

                    var a = result.profile.ag_name.split(' ');
                    a.shift();
                    form.find('INPUT[name="ag_suffix"]').val(a.join(' '));
                    input.attr('disabled', true);
                    //result.profile.ag_name.replace(input.eq(1).find(':selected').text(), '')
                }

                input = form.find('SELECT[name="ag_parent"]');
                result.profile.hasOwnProperty('ag_type') && form.find('INPUT[name="ag_type"]').change();


                result.profile.hasOwnProperty('ag_parent') && input.val(result.profile.ag_parent);
                result.profile.hasOwnProperty('ag_bank_name') && form.find('SELECT[name="ag_bank_name"]').val(result.profile.ag_bank_name);
                //form.find('INPUT[name="ag_type"]').attr('disabled', true);

                $dialog.modal('show');
            });
        }


        form.find('INPUT[name="ag_type"]').on('change', function () {

            if (form.find('input[name="ag_type"]:checked').val() == 'A') {
                form.find('select[name="ag_parent"]').removeAttr('disabled');
                form.find('input[name="ag_margin_rate"]').attr('disabled', true);
            }
            else {
                form.find('select[name="ag_parent"]').attr('disabled', true);
                form.find('input[name="ag_margin_rate"]').removeAttr('disabled');
            }

        });

        // -----------------------------------------------------------------

        $dialog.on('hidden.bs.modal', function () {
            // 폼값 리셋
            form.get(0).reset();
            form.find('input[name="ag_id"],input[name="ag_code"]').val('');

            form.find('INPUT[name="ag_type"]').removeAttr('disabled', true);
            form.find('select').val('');

            form.find('select.district').each(function () {
                $(this).val('').change();
            }).eq(0).removeAttr('disabled', true);
        });

        $('A.modal-toggle').click(function (event) {
            event.preventDefault();
            get_agent_profile($(this).attr('href'));
        });


        // -----------------------------------------------------------------
        // 지역 검색
        /**
         *
         * @param {jQuery} targetForm
         * @param {string} [selected]
         */
        function districtRender(targetForm, selected) {
            var entries = <?=$DistrictStringify?>
                , els = targetForm.find('select.district');

            function fnl_render() {
                try {
                    var current = $(this).attr('data-label'), index = ['state', 'city', 'town'].indexOf(current) + 1,
                        target = els.eq(index), rows, code, i = 0;
                    if (index > 2) return true;

                    rows = entries[['state', 'city', 'town'][index]];
                    for (; i < index; i++) rows = rows[els.eq(i).val()];
                    for (i = index + 1; i < 3; i++) els.eq(i).attr('disabled', true).children().not(':eq(0)').remove();

                    target.children().not(':eq(0)').remove();
                    for (code in rows) {
                        if (!rows.hasOwnProperty(code)) continue;
                        target.append('<option value="' + code + '">' + rows[code] + '</option>');
                    }
                    target.children().length > 1 ? target.removeAttr('disabled') : target.attr('disabled', true);
                }
                catch (e) {

                }
                return true;
            }

            els.on('change', fnl_render);
            fnl_render();
            // 지역 선택 값이 있을 경우
            if (!selected) return true;
            var tm_recursive, index = 0, codes = (selected || '').split(',');

            function inherit() {
                tm_recursive && clearTimeout(tm_recursive);
                tm_recursive = null;
                var el = els.eq(index);
                if (!codes.length || el.children().length <= 1) return true;

                el.val(codes.shift()).change();
                ++index;
                tm_recursive = setTimeout(inherit, 0);
            }

            inherit();
        }

        districtRender($('form[name="frmSearch"]'), '<?=rtrim(implode(',', $district), ',')?>');
        setTimeout(function () {
            districtRender(form)
        }, 0);

        // -----------------------------------------------------------------
        // 버튼들 이벤트 처리
        // 
        $('#agent-add').on('click', function (event) {
            event.preventDefault();
            $dialog.modal('show');
        });

        $('#exists-member').on('click', function () {
            var manager = form.find('INPUT[name="al_manager"]'), mb_id = manager.val();
            manager.attr('data-value', '');
            if (!mb_id) {
                alert('아이디를 입력하세요.');
                manager.focus();
                return false;
            }
            $.post(g5_admin_url + '/?dir=agent&pid=agent_exec', {
                'scope': 'existsMember',
                'mb_id': mb_id
            }, function (result) {
                if (result.code == 200) {
                    manager.attr('data-value', mb_id);
                    alert('등록되어 있는 회원 아이디입니다.');
                    return true;
                }
                alert(result.message);
            });

        });

        /*if (btn.hasClass('dropdown-toggle')) {
            btn.parent().find('.dropdown-menu').show();
            return false;
        }*/

        //aria-expanded="false"
        (function () {
            var p = $('#parent-move'), btn = p.find('button.dropdown-value');
            p.find('.dropdown-menu A').on('click', function (event) {
                event.preventDefault();
                var self = $(this);
                btn.attr('data-value', self.attr('data-parent'));
                btn.find('.dropdown-label').html('<strong>' + self.attr('data-label') + '</strong> 소속으로 변경');
            });
        })();


        $('.toolbars button.toolbar-toggle').not('.dropdown-toggle').click(function (event) {
            event.preventDefault();
            var btn = $(this), attr_name = btn.attr('data-label'), attr_val = btn.attr('data-value'),
                target = container.find('LABEL.checklist:not(.checklist-toggle) > INPUT:checkbox:checked').map(function () {
                    return this.value;
                }).get();

            if (!target.length) {
                alert('하나 이상의 항목을 선택하세요.');
                return false;
            }
            else if (attr_name == 'parent' && !attr_val) {
                alert('변경하려는 총판을 선택하세요.');
                return false;
            }
            else if (!confirm('수정하시겠습니까?')) {
                return false;
            }

            $.post(g5_admin_url + '/?dir=agent&pid=agent_exec', {
                'scope': 'attribute',
                'target': target,
                'attribute': attr_name,
                'value': attr_val
            }, function (result) {
                if (result.code != 200) {
                    alert(result.message);
                    return false;
                }
                alert('수정되었습니다.');
                window.location.reload(true);
            });
        });

        // -----------------------------------------------------------------
        //
        // 체크 박스 처리


        var $th = container.find('.list-group-item:first-child');
        var $control = $th.find('input:checkbox'), $bind = container.find('LABEL.checklist > INPUT:checkbox').not($control),
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


        $th.find('A.sort').on('click', function (event) {
            event.preventDefault();
            var el = $(this), $form = $('form[name="frmSearch"]');
            if (el.attr('data-label') == '<?=$param['sort']?>') {
                $form.find('INPUT[name="order"]').val('<?=$param['order'] != 'D' ? 'D' : 'A'?>');
            }
            else {
                $form.find('INPUT[name="sort"]').val(el.attr('data-label'));
                $form.find('INPUT[name="order"]').val('D');
            }
            $form.submit();
        }).filter('[data-label="<?=$param['sort']?>"]').attr('data-order', '<?=$param['order']?>');

        // -----------------------------------------------------------------

        (function () {
            var $modal = $('#agent-point-history');

            function __get_history(agentCode, own, pageNo, callback) {
                var query = '?dir=agent&pid=point_history&agent=' + agentCode;
                query += '&own=' + own + '&period=all&page=' + pageNo;

                $modal.removeAttr('data-loaded');

                $.get(g5_admin_url + query, function (data) {
                    $modal.modal('show');
                    $modal.find('.list-container').html(data).find('.eb-pagination A').one('click', function (event) {
                        event.preventDefault();
                        var matches = (/&page=(\d+)/gi).exec($(this).attr('href'));
                        if (!matches || matches.length != 2) return false;
                        __get_history(agentCode, own, matches[1], callback)
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
                        $modal.attr('data-loaded', true);
                    }, 100);
                });


            }

            $('A.point-history').on('click', function (event) {
                event.preventDefault();
                var $self = $(this);
                __get_history($self.attr('data-value'), $self.attr('data-own') || 'self', 1, function () {
                    $modal.find('.modal-title .agent-label').html($self.attr('data-label'));
                });

            });
        })();


        // -----------------------------------------------------------------

        window.EventSource ? (function () {
            var source;
            var $modal = $('#agent-export-progress'), $progress = $modal.find('DIV.progress-bar').eq(0), $message = $modal.find('DIV.progress-message').eq(0);

            function __processMessage(percent, message) {
                var p = (percent * 1) + '%';
                $message.html(message || '');
                $progress.width(p).text(p);
            }

            function __destory() {
                (source && (source instanceof EventSource)) && source.close();
                //(source instanceof EventSource) && (source = null);
                source = null;
            }

            function __event_parse(event) {
                var result = JSON.parse(event.data);
                switch (event.type) {
                    case 'walk': {
                        __processMessage(result.message, (result.progress || 0) * 1);
                        break;
                    }
                    case 'completed': {
                        __processMessage(result.message, 100);
                        __destory();
                        break;
                    }

                    default:
                        source && source.close();
                        console.info("Event::NotAllow");
                        break;
                }
            }

            $('form[name="frmExport"]').on('submit', function (e) {
                e.preventDefault();
                alert('준비 중 입니다.');

                return;
                __destory();

                source = new EventSource('<?=G5_ADMIN_URL?>/?dir=agent&pid=export&' + $(this).serialize());

                // -- Connection was opened.
                source.addEventListener('open', function () {
                    console.info("Event::Connection.");
                }, false);
                source.addEventListener('error', function (event) {
                    if (event.readyState == EventSource.CLOSED) {
                        console.warn("Event::Closed.");
                        // Connection was closed.
                    }
                }, false);
                source.addEventListener('walk', __event_parse, false);
                source.addEventListener('completed', __event_parse, false);
                source.addEventListener('warn', __event_parse, false);
            });

        })() : (function () {


        })();
    });


</script>