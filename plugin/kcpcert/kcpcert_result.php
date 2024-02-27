<?php
include_once('../../common.php');
include_once(G5_KCPCERT_PATH . '/kcpcert_config.php');

$site_cd = "";
$ordr_idxx = "";

$cert_no = "";
$enc_info = "";
$enc_data = "";
$req_tx = "";

$enc_cert_data2 = "";
$cert_info = "";

$tran_cd = "";
$res_cd = "";
$res_msg = "";

$dn_hash = "";

/*------------------------------------------------------------------------*/
/*  :: 전체 파라미터 남기기                                               */
/*------------------------------------------------------------------------*/

// request 로 넘어온 값 처리
$key = array_keys($_POST);
$sbParam = "";

for ($i = 0; $i < count($key); $i++) {
    $nmParam = $key[$i];
    $valParam = $_POST[$nmParam];

    if ($nmParam == "site_cd") {
        $site_cd = f_get_parm_str($valParam);
    }

    if ($nmParam == "ordr_idxx") {
        $ordr_idxx = f_get_parm_str($valParam);
    }

    if ($nmParam == "res_cd") {
        $res_cd = f_get_parm_str($valParam);
    }

    if ($nmParam == "cert_enc_use_ext") {
        $cert_enc_use_ext = f_get_parm_str($valParam);
    }

    if ($nmParam == "req_tx") {
        $req_tx = f_get_parm_str($valParam);
    }

    if ($nmParam == "cert_no") {
        $cert_no = f_get_parm_str($valParam);
    }

    if ($nmParam == "enc_cert_data2") {
        $enc_cert_data2 = f_get_parm_str($valParam);
    }

    if ($nmParam == "dn_hash") {
        $dn_hash = f_get_parm_str($valParam);
    }

    // 부모창으로 넘기는 form 데이터 생성 필드
    $sbParam .= "<input type='hidden' name='" . $nmParam . "' value='" . f_get_parm_str($valParam) . "'/>";
}

$ct_cert = new C_CT_CLI;
$ct_cert->mf_clear();

// 인증내역기록
@insert_cert_history($member['mb_id'], 'kcp', 'hp');

$g5['title'] = '휴대폰인증 결과';
include_once(G5_PATH . '/head.sub.php');

/*
 | ------------------------------------------------------------------
 | 인증 실패
 | ------------------------------------------------------------------
 */
$res_cd != "0000" && f_alert_close("인증 실패({$_POST['res_cd']}): " . urldecode($_POST['res_msg']));

/*
 | ------------------------------------------------------------------
 | 인증 성공 처리
 | ------------------------------------------------------------------
 */
// dn_hash 검증
// KCP 가 리턴해 드리는 dn_hash 와 사이트 코드, 주문번호 , 인증번호를 검증하여
// 해당 데이터의 위변조를 방지합니다
$veri_str = $site_cd . $ordr_idxx . $cert_no; // 사이트 코드 + 주문번호 + 인증거래번호

if ($ct_cert->check_valid_hash($home_dir, $enc_key, $dn_hash, $veri_str) != "1") {
    strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' && f_alert_close('DN 해시값이 유효하지 않습니다. 실행 파일(.exe)의 권한을 확인하세요.');
    PHP_INT_MAX == 2147483647 && f_alert_close('DN 해시값이 유효하지 않습니다. 검증 파일(x86)의 실행권한을 확인하세요.');
    f_alert_close('DN 해시값이 유효하지 않습니다. 검증 파일의 실행권한을 확인하세요.');
}

// 가맹점 DB 처리 페이지 영역

// 인증데이터 복호화 함수
// 해당 함수는 암호화된 enc_cert_data2 를
// site_cd 와 cert_no 를 가지고 복화화 하는 함수 입니다.
// 정상적으로 복호화 된경우에만 인증데이터를 가져올수 있습니다.
$opt = "1"; // 복호화 인코딩 옵션 ( UTF - 8 사용시 "1" )
$ct_cert->decrypt_enc_cert($home_dir, $enc_key, $site_cd, $cert_no, $enc_cert_data2, $opt);

$comm_id = $ct_cert->mf_get_key_value("comm_id");                // 이동통신사 코드
$phone_no = $ct_cert->mf_get_key_value("phone_no");                // 전화번호
$user_name = $ct_cert->mf_get_key_value("user_name");                // 이름
$birth_day = $ct_cert->mf_get_key_value("birth_day");                // 생년월일
$sex_code = $ct_cert->mf_get_key_value("sex_code");                // 성별코드
$local_code = $ct_cert->mf_get_key_value("local_code");                // 내/외국인 정보
$ci = $ct_cert->mf_get_key_value("ci");                // CI
$di = $ct_cert->mf_get_key_value("di");                // DI 중복가입 확인값
$ci_url = urldecode($ct_cert->mf_get_key_value("ci"));   // CI
$di_url = urldecode($ct_cert->mf_get_key_value("di"));   // DI 중복가입 확인값
$dec_res_cd = $ct_cert->mf_get_key_value("res_cd");                // 암호화된 결과코드
$dec_mes_msg = $ct_cert->mf_get_key_value("res_msg");                // 암호화된 결과메시지

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && function_exists('mb_detect_encoding')) {
    if (mb_detect_encoding($user_name, 'EUC-KR') === 'EUC-KR') {
        $user_name = iconv_utf8($user_name);
        $dec_mes_msg = iconv_utf8($dec_mes_msg);
    }
}

// 정상인증인지 체크
!$phone_no && f_alert_close('정상적인 인증방식이 아닙니다.\n다시 시도하시거나 관리자에게 문의하세요. 유효한 인증 절차로 다시 시도하세요.');

$phone_no = hyphen_hp_number($phone_no);
$mb_dupinfo = $di;

/**
 * @changelog 2022.07.19 by Lee, Namdu
 * 기존 소스
 * $sql = " select mb_id from {$g5['member_table']} where mb_id <> '{$member['mb_id']}' and mb_dupinfo = '{$mb_dupinfo}' ";
 * $row = sql_fetch($sql);
 * if ($row['mb_id']) {
 * alert_close("입력하신 본인확인 정보로 가입된 내역이 존재합니다.\\n회원아이디 : ".$row['mb_id']);
 * }*/


// -- 로그인한 회원의 전화번호와 동일한 경우
###($member && $member['mb_id'] && $member['mb_hp'] == $phone_no) && f_alert_close('현재 등록되어 있는 휴대전화번호 입니다.');

// -- DI And 휴대폰 동일(다른 휴대폰일 경우 인정함)
$exists = fn_sql_row("SELECT mb_id FROM {$g5['member_table']} WHERE mb_dupinfo='{$mb_dupinfo}' AND mb_hp='{$phone_no}'");
empty($exists) !== true && f_alert_close("입력한 개인정보로 가입된 내역(아이디: {$exists})이 존재합니다.");


// hash 데이터
$cert_type = 'hp';
$md5_cert_no = md5($cert_no);
$hash_data = md5($user_name . $cert_type . $birth_day . $md5_cert_no);

// 성인인증결과
$adult_day = date("Ymd", strtotime("-19 years", G5_SERVER_TIME));
$adult = ((int)$birth_day <= (int)$adult_day) ? 1 : 0;

set_session("ss_cert_type", $cert_type);
set_session("ss_cert_no", $md5_cert_no);
set_session("ss_cert_hash", $hash_data);
set_session("ss_cert_adult", $adult);
set_session("ss_cert_birth", $birth_day);
set_session("ss_cert_sex", ($sex_code == "01" ? "M" : "F"));
set_session('ss_cert_dupinfo', $mb_dupinfo);

$ct_cert->mf_clear();
?>
    <form name="form_auth" method="post"><?php echo $sbParam; ?></form>
    <script type="text/javascript">
        $(function () {
            var $owner = window.opener || window.parent, feed;
            // up_hash 검증
            if (document.forms['form_auth'].up_hash.value != $owner.$("input[name=veri_up_hash]").val()) {
                $owner.alert("해시 데이터 변조 위험이 있습니다.\n다시 시도하시거나 관리자에게 문의하세요.");
            }
            // 인증정보
            else {
                $owner.$("input[name=cert_type]").val("<?php echo $cert_type; ?>");
                $owner.$("input[name=mb_name]").val("<?php echo $user_name; ?>").attr("readonly", true);
                $owner.$("input[name=mb_hp]").val("<?php echo $phone_no; ?>").attr("readonly", true);
                $owner.$("input[name=cert_no]").val("<?php echo $md5_cert_no; ?>");
                typeof((feed = $owner.$('FORM.form-cert-hp').data('feed'))) === 'function' && feed();
                $owner.alert("정상적으로 인증되었습니다.");
            }
            $owner.$('#kcp-identify-verify-frame').remove();
            window.close();
        });
    </script>

<?php
include_once(G5_PATH . '/tail.sub.php');