<?php
/**
 * Eyoom Admin Skin File
 * @file    ~/theme/basic/skin/member/member_list.html.php
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/moment.min.js"></script>');
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/moment-locale.ko.js"></script>');
add_javascript('<script type="text/javascript" src="' . G5_JS_URL . '/daterangepicker/js/daterangepicker-3.14.1.min.js"></script>');
add_stylesheet('<link rel="stylesheet" href="' . G5_JS_URL . '/daterangepicker/css/daterangepicker.css" type="text/css" media="screen" />', 0);

add_stylesheet('<link rel="stylesheet" href="' . EYOOM_ADMIN_THEME_URL . '/plugins/jsgrid/jsgrid.min.css" type="text/css" media="screen">', 0);
add_stylesheet('<link rel="stylesheet" href="' . EYOOM_ADMIN_THEME_URL . '/plugins/jsgrid/jsgrid-theme.min.css" type="text/css" media="screen">', 0);


$Sheet = [
    'header' => [
        ['name' => 'photo', 'title' => '포토', 'type' => 'text', 'align' => 'center', 'width' => '60']
        , ['name' => 'mb_id', 'title' => '아이디', 'type' => 'text', 'width' => '150']
        , ['name' => 'mb_name', 'title' => '이름', 'type' => 'text', 'width' => '']
    ]
    , 'data' => []
];

if (!$wmode) {
    $Sheet['header'] = array_merge([
        ['name' => 'check', 'title' => '<label for="chkall" class="checkbox"><input type="checkbox" name="chkall" id="chkall" value="1" onclick="check_all(this.form)"><i></i></label>', 'type' => 'text', 'width' => '40']
        , ['name' => 'manage', 'title' => '관리', 'type' => 'text', 'align' => 'center', 'width' => '110', 'headercss' => "set-btn-header", 'css' => "set-btn-field"]

    ], $Sheet['header'], [
        ['name' => 'mb_level', 'title' => '레벨', 'type' => 'text', 'align' => 'center', 'width' => '80']
        , ['name' => 'mb_point', 'title' => '포인트', 'type' => 'text', 'align' => 'center', 'width' => '80']
        , ['name' => 'certificate', 'title' => '인증', 'type' => 'text', 'align' => 'center', 'width' => '80']
        , ['name' => 'mb_hp', 'title' => '휴대전화', 'type' => 'text', 'align' => 'center', 'width' => '100']
        , ['name' => 'mb_recommend', 'title' => '추천인', 'type' => 'text', 'width' => '120']
        , ['name' => 'mb_agent', 'title' => '대리점', 'type' => 'text', 'align' => '', 'width' => '']

        ## , ['name' => 'deny', 'title' => '접근차단', 'type' => 'text', 'align' => 'center', 'width' => '80']
        , ['name' => 'status', 'title' => '상태', 'type' => 'text', 'align' => 'center', 'width' => '80']
        , ['name' => 'signUp', 'title' => '가입일', 'type' => 'text', 'align' => 'center', 'width' => '80']
        , ['name' => 'lastedAt', 'title' => '최근로그인', 'type' => 'text', 'align' => 'center', 'width' => '115']
    ]);
}
else {
    $Sheet['header'][] = ['name' => 'mb_level', 'title' => '레벨', 'type' => 'text', 'align' => 'center', 'width' => '80'];
    $Sheet['header'][] = ['name' => 'view', 'title' => '선택하기', 'type' => 'text', 'align' => 'center', 'width' => '80'];
}

$_admin_url = G5_ADMIN_URL;
$certifyLabel = [
    'hp' => '휴대전화'
    , 'ipin' => 'I-PIN'
    , 'admin' => '관리자'
    , '' => '미인증'
];

if (empty($rows) !== true && is_array($rows)) {
    foreach ($rows as $i => $row) {

        $user_href = !(G5_IS_MOBILE || $wmode) ? "{$_admin_url}/?dir=member&pid=member_form&mb_id={$row['mb_id']}&w=u&wmode=1" : "#";
        $mobile_no = $row['mb_hp'];
        !in_array($is_admin, ['super']) && empty($mobile_no) !== true && ($mobile_no = preg_replace('/^010-(\d)\d{3}-(\d+)$/', '010-$1***-$2', $mobile_no));

        $line = [
            'mb_id' => "<span class=\"ellipsis\"><a href=\"{$user_href}\" class='eb-modal'><i class=\"fas fa-external-link-alt color-light-grey margin-right-5 hidden-xs\"></i><strong>{$row['mb_id']}</strong></a></span>"
            , 'mb_name' => "<a href=\"{$user_href}\" class='eb-modal'><i class=\"fas fa-external-link-alt color-light-grey margin-right-5 hidden-xs\"></i><strong>" . gettext($row['mb_name']) . "</strong></a>"
            , 'mb_level' => "{$row['mb_level']}"
            , 'view' => "<a href=\"\" data-mb-id=\"{$row['mb_id']}\" data-dismiss=\"modal\" class=\"set_mbid btn-e btn-e-xs btn-e-indigo\">선택하기</a>"
            , 'manage' => ''
            ##-- , 'deny' => ''
            , 'photo' => '<i class=\'fas fa-user\'></i>'
            , 'status' => '정상'
            , 'signUp' => (new DateTime($row['mb_datetime']))->format('Y.m.d')
            , 'lastedAt' => (new DateTime($row['mb_today_login']))->format('Y.m.d H:i')
        ];

        if ($row['mb_leave_date']) {

            $line['status'] = "<span class='mb_leave_msg color-red'>탈퇴</span>";
        }
        else if ($row['mb_intercept_date']) {
            $line['status'] = "<span class='mb_intercept_msg color-orange'>차단</span>";
        }

        empty($photo_url = mb_photo_url($row['mb_id'])) !== true && ($line['photo'] = "<img src=\"{$photo_url}\" class=\"img-responsive\" />");
        $line['photo'] = "<div class='new-member-photo'>{$line['photo']}</div>";

        if (!$wmode) {
            $line['check'] = "<input type=\"hidden\" name=\"mb_id[{$i}]\" value=\"{$row['mb_id']}\" id=\"mb_id_{$i}\"><label for=\"chk_{$i}\" class=\"checkbox\"><input type=\"checkbox\" name=\"chk[]\" id=\"chk_{$i}\" value=\"{$i}\"><i></i></label>";
            $line['mb_point'] = "<a href=\"{$_admin_url}/?dir=member&pid=point_list&sfl=mb_id&stx={$row['mb_id']}&wmode=2\" class='eb-modal'>{$row['mb_point']}</a> <i class=\"fas fa-external-link-alt color-light-grey margin-right-5 hidden-xs\"></i>";
            $line['certificate'] = '<span class="' . ($row['mb_certify'] ? 'color-red' : 'color-dark') . '">' . ($certifyLabel[$row['mb_certify']]) . '</span>';
            $line['mb_hp'] = '<span>' . $mobile_no . '</span>';
            $line['mb_recommend'] = "<a href=\"" . (!(G5_IS_MOBILE || $wmode) ? "{$_admin_url}/?dir=member&pid=member_form&mb_id={$row['mb_recommend']}&w=u&wmode=1" : "#") . "\" class='eb-modal'>{$row['mb_recommend']}</a>";

            empty($row['mb_1']) !== true && ($line['mb_agent'] = getDistrictNameByCode($row['mb_1']));

            ($is_admin != 'group') && ($line['manage'] .= "<a href=\"{$_admin_url}/?dir=member&pid=member_form&mb_id={$row['mb_id']}&w=u&{$qstr}\"><u>수정</u></a>");
            ($config['cf_admin'] != $row['mb_id']) && ($line['manage'] .= "<a href=\"{$_admin_url}/?dir=board&pid=boardgroupmember_form&mb_id={$row['mb_id']}\" class='margin-left-10'><u>그룹</u></a>");
            ##-- empty($row['mb_leave_date']) === true && ($line['deny'] = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"mb_intercept_date[{$i}]\" value=\"{$row['mb_intercept_date']}\" " . ($row['mb_intercept_date'] ? 'checked' : '') . "/><i></i></label>");
        }
        $Sheet['data'][] = $line;
    }
}

$filter = $param;
unset($filter['dir'], $filter['pid']);
?>

<style type="text/css">
    .admin-member-list .new-member-photo {position: relative;overflow: hidden;width: 26px;height: 26px;border: 1px solid #c5c5c5;background: #fff;padding: 1px;margin: 0 auto;text-align: center;-webkit-border-radius: 50% !important;-moz-border-radius: 50% !important;border-radius: 50% !important}
    .admin-member-list .new-member-photo i {width: 22px;height: 22px;font-size: 12px;line-height: 22px;background: #b5b5b5;color: #fff;-webkit-border-radius: 50% !important;-moz-border-radius: 50% !important;border-radius: 50% !important}
    .admin-member-list .new-member-photo img {-webkit-border-radius: 50% !important;-moz-border-radius: 50% !important;border-radius: 50% !important}
    /**
     */
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
    /**
     */
    .form-control {padding: 4px .5rem;height: auto;}
    .form-section {border: 1px solid #434350;margin-bottom: 2.125rem;}
    .form-section DL, .form-section DT, .form-section DD {margin: 0; padding: 0;}
    .form-section DL {display: flex;flex-wrap: nowrap;width: 100%;align-content: center}
    .form-section DT {width: 120px;min-width: 120px;background: #72727f;color: #fff;display: flex; align-items: center;padding-left: .5rem;}
    .form-section DT > label {margin: 0;padding: 0; font-weight: normal;}
    .form-section DD {padding: .5rem;}
    .form-section .d-flex {align-items: center}
    .form-section DL:not(:first-child) {border-top: 1px solid #666}
    .form-section .list-box select {width: 100%;}
    .form-section .list-box + .list-box {margin-left: -1px;}
    .form-section .checkbox {position: relative;margin: 0;padding-left: 26px;margin-left: -1px;text-align: left}
    .form-section .checkbox-text {display: inline-block;padding: 2px 1.375rem;font-weight: normal;line-height: 1.5;text-align: center;white-space: nowrap;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;background-image: none;border: 1px solid transparent;margin-left: -.75rem; }
    .form-section .checkbox-text {color: #fff;margin-left: -30px;padding-left: 30px;border-color: rgba(0, 0, 0, .1)}
    .form-section .checkbox-text.btn-e-default {color: #333}
    .form-section .checkbox input[type=radio],
    .form-section .checkbox input[type=checkbox] {position: absolute;margin-top: 6px;border: 0;border-radius: 0;background-color: #fff; left: 6px;}
    .form-section .checkbox input:checked + .checkbox-text {border-color: rgba(0, 0, 0, .25);box-shadow: inset 0 2px 4px rgba(0, 0, 0, .25)}
    .form-section .date-range-picker {margin-left: -1px;}
    .form-section .date-range-picker .date-range-picker-toggle {padding-top: 0;padding-bottom: 0;line-height: 1.32857143;font-weight: normal;font-size: 12px;}
    .form-section .deactivate {opacity: 1}
    .form-section .deactivate + .checkbox-text {opacity: .75}
    .inline-block {display: inline-block}
    .export-group {position: relative; padding-left: .5rem;}
    .jsgrid-header-row > .jsgrid-header-cell {padding: 0 .5rem;}
    .jsgrid-table label.checkbox {top: 50%;left: 50%}
    .jsgrid-table label.checkbox input[type="checkbox"] { position: static;}
    .page-summary {margin: 0 0 5px 0;display: flex}
    .page-summary > div:first-child {flex: 1 1 auto}
</style>
<div class="adm-headline adm-headline-btn">
    <h3>회원 리스트</h3>
    <?php if (!$wmode) { ?>
        <a href="<?php echo G5_ADMIN_URL; ?>/?dir=member&pid=member_form" class="btn-e btn-e-red btn-e-lg"><i class="fas fa-plus"></i>
            회원 추가</a>
    <?php } ?>
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
                        <select name="level">
                            <option value="">전체 레벨</option>
                            <?php foreach (range(1, 10) as $value) {
                                print sprintf('<option value="%d"%s>%d 레벨</option>', $value, $value == $param['level'] ? ' selected' : '', $value);
                            } ?>
                        </select>
                    </label>

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
            <dt><label for="search-keyword">추가 검색</label></dt>
            <dd>
                <div class="d-flex" style="margin-left:.5rem;">


                    <div class="d-flex">
                        <label class="checkbox">
                            <input type="radio" name="cert" value="" <?= $param['cert'] ? '' : ' checked' ?>/>
                            <span class="checkbox-text btn-e-dark">전체</span>
                        </label>
                        <?php foreach ($PageConfig['cert'] as $value => $label) { ?>
                            <label class="checkbox">
                            <input type="radio" name="cert" value="<?= $value ?>"<?= $value == $param['cert'] ? ' checked' : '' ?> />
                            <span class="checkbox-text btn-e-<?= $value == 'Y' ? 'teal' : 'default' ?>">휴대전화 <?= $label ?></span>
                            </label><?php } ?>
                    </div>

                    <div class="d-flex margin-left-10">
                        <label class="checkbox">
                            <input type="radio" name="status" value="" <?= $param['status'] ? '' : ' checked' ?>/>
                            <span class="checkbox-text btn-e-dark">전체 회원</span>
                        </label>
                        <?php foreach ($PageConfig['statusLabel'] as $value => $label) { ?>
                            <label class="checkbox">
                            <input type="radio" name="status" value="<?= $value ?>"<?= $value == $param['status'] ? ' checked' : '' ?> />
                            <span class="checkbox-text btn-e-default"><?= $label ?>회원</span>
                            </label><?php } ?>
                    </div>

                </div>


            </dd>
        </dl>
        <dl>
            <dt><label for="search-keyword">날짜 검색</label></dt>
            <dd>
                <div class="d-flex">
                    <label class="list-box" style="max-width: 120px">
                        <select name="term">
                            <?php foreach ($PageConfig['termLabel'] as $value => $label) {
                                print sprintf('<option value="%s"%s>%s</option>', $value, $value == $param['search'] ? ' selected' : '', $label);
                            } ?>
                        </select>
                    </label>
                    <label class="date-range-picker allow-empty" data-bind='#from-date,#to-date' data-start-date="<?= $param['fromDate'] ?? 'null' ?>" data-end-date="<?= $param['toDate'] ?? 'null' ?>" data-ranges="monthly"></label>
                    <button type="submit" class="margin-left-10 btn-e btn-e-lg btn-e-dark" accesskey="s">
                        <i class="fa fa-search"></i> 검색
                    </button>


                </div>
            </dd>
        </dl>

    </section>
</form>


<div class="admin-member-list">
    <div class="page-summary">

        <div>검색결과: <strong><?= number_format($totals) ?></strong>명</div>
        <div class="export-group">
            <button type="button" class="btn-e btn-e-lg btn-e-green btn-export" data-filter="<?= rtrim('dir=export&pid=member_export&' . http_build_query($filter), '&') ?>">
                <i class="far fa-file-excel"></i> 검색결과 엑셀 다운로드
            </button>
            <!-- div>
                아이디, 이름, 휴대전화, 이메일, 상태, 추천인, 대리점, 가입일, 최근로그인
            </div -->
        </div>

    </div>

    <?php if (G5_IS_MOBILE) : ?><p class="font-size-11 color-grey text-right margin-bottom-5">
        <i class="fas fa-info-circle"></i> Note! 좌우스크롤 가능 (<i class="fas fa-arrows-alt-h"></i>)</p><?php endif; ?>
    <div id="member-list"></div>
    <?php if (!$wmode) { ?>
        <div class="margin-top-20">
            <input type="submit" name="act_button" value="선택수정" class="btn-e btn-e-xs btn-e-red" onclick="document.pressed=this.value">
            <input type="submit" name="act_button" value="선택삭제" class="btn-e btn-e-xs btn-e-dark" onclick="document.pressed=this.value">
        </div>
    <?php } ?>
</div>

<?php /* 페이지 */ ?>
<?php echo eb_paging($eyoom['paging_skin']); ?>
<div class="margin-bottom-20"></div>

<div class="modal fade admin-iframe-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">회원 정보 수정</h4>
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

<?php if (!$wmode) { ?>
    <div class="margin_top_20">
        <div class="cont-text-bg">
            <p class="bg-info font-size-12"><i class="fas fa-info-circle"></i> 회원자료 삭제 시 다른 회원이 기존 회원아이디를 사용하지 못하도록
                회원아이디, 이름, 닉네임은 삭제하지 않고 영구 보관합니다.</p>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
    $(function () {


    });
</script>


<script src="<?php echo EYOOM_ADMIN_THEME_URL; ?>/plugins/jsgrid/jsgrid.min.js"></script>
<script src="<?php echo EYOOM_ADMIN_THEME_URL; ?>/js/jsgrid.js"></script>


<script>
    <?php if (!(G5_IS_MOBILE || $wmode)) { ?>
    function eb_modal(href) {
        $('.admin-iframe-modal').modal('show').on('hide.bs.modal', function () {
            $("#modal-iframe").attr("src", "");
            $('html').css({overflow: ''});
        });
        $('.admin-iframe-modal').modal('show').on('show.bs.modal', function () {
            $("#modal-iframe").attr("src", href);
            $('#modal-iframe').height(parseInt($(window).height() * 0.85));
            $('html').css({overflow: 'hidden'});
        });
        return false;
    }

    window.closeModal = function () {
        $('.admin-iframe-modal').modal('hide');
    };
    <?php } ?>

    $(function () {
        $("#member-list").jsGrid({
            filtering: false,
            editing: false,
            sorting: false,
            paging: true,
            autoload: true,
            controller: {
                deleteItem: function (deletingClient) {
                    var clientIndex = $.inArray(deletingClient, this.clients);
                    this.clients.splice(clientIndex, 1)
                },
                insertItem: function (insertingClient) {
                    this.clients.push(insertingClient)
                },
                loadData: function (filter) {
                    return $.grep(this.clients, function (client) {
                        return !(filter.체크 && !(client.체크.indexOf(filter.체크) > -1) || filter.아이디 && !(client.아이디.indexOf(filter.아이디) > -1) || filter.이름 && !(client.이름.indexOf(filter.이름) > -1))
                    })
                },
                updateItem: function (updatingClient) {
                },
                'clients': <?=json_encode($Sheet['data'])?>
            },
            deleteConfirm: "정말로 삭제하시겠습니까?\n한번 삭제된 데이터는 복구할수 없습니다.",
            pageButtonCount: 5,
            pageSize: <?php echo $config['cf_page_rows']; ?>,
            width: "100%",
            height: "auto",
            fields: <?=json_encode($Sheet['header'])?>
        });

        <?php if ($wmode) { ?>
        $(".set_mbid").click(function () {
            var mb_id = $(this).attr('data-mb-id');
            $('#mb_id', parent.document).val(mb_id);
            window.parent.closeModal();
        });
        <?php } ?>
        $('A.eb-modal').on('click', function (event) {
            event.preventDefault();
            eb_modal($(this).attr('href'));
        });


    });
</script>