<?php
include_once('../../common.php');
###$member['mb_id'] != 'devper' &&  alert_close('현재 점검 중입니다. 빠른 시간내에 정상화가 될 수 있도록 최선을 다하겠습니다. 서비스 이용에 불편을 드려 죄송합니다.');
// certify_count_check($member['mb_id'], 'hp');

setlocale(LC_CTYPE, 'ko_KR.euc-kr');
// kcp 휴대폰인증파일
include_once(G5_KCPCERT_PATH.'/kcpcert_config.php');

$ordr_idxx = get_session('ss_uniqid');
if(!$ordr_idxx)
    $ordr_idxx = get_uniqid();

$ct_cert = new C_CT_CLI;
$ct_cert->mf_clear();

$year          = "00";
$month         = "00";
$day           = "00";
$user_name     = "";
$sex_code      = "";
$local_code    = "";

$sbParam = "";

// !!up_hash 데이터 생성시 주의 사항
// year , month , day 가 비어 있는 경우 "00" , "00" , "00" 으로 설정이 됩니다
// 그외의 값은 없을 경우 ""(null) 로 세팅하시면 됩니다.
// up_hash 데이터 생성시 site_cd 와 ordr_idxx 는 필수 값입니다.
$hash_data = $site_cd   .
             $ordr_idxx .
             $web_siteid .
             $user_name .
             $year      .
             $month     .
             $day       .
             $sex_code  .
             $local_code;

$up_hash = $ct_cert->make_hash_data( $home_dir, $enc_key ,$hash_data );

// KCP 본인확인 라이브러리 버전 정보
$sbParam .= "<input type='hidden' name='kcp_cert_lib_ver' value='" . $ct_cert->get_kcp_lib_ver( $home_dir ) . "'/>";

$ct_cert->mf_clear();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php if(is_mobile()) { ?>
<meta name="viewport" content="user-scalable=yes, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width, target-densitydpi=medium-dpi" >
<?php } ?>
</head>

<body oncontextmenu="return false;" ondragstart="return false;" onselectstart="return false;">
<form name="form_auth" method="post" action="<?php echo $cert_url ?>">
<!-- 유저네임 -->
<input type="hidden" name="user_name"    value="" />
<!-- 주문번호 -->
<input type="hidden" name="ordr_idxx"    value="<?php echo $ordr_idxx ?>">
<!-- 요청종류 -->
<input type="hidden" name="req_tx"       value="cert"/>
<!-- 요청구분 -->
<input type="hidden" name="cert_method"  value="01"/>
<!-- 웹사이트아이디 -->
<input type="hidden" name="web_siteid"   value="<?php echo $web_siteid ?>"/>
<!-- 노출 통신사 default 처리시 아래의 주석을 해제하고 사용하십시요
     SKT : SKT , KT : KTF , LGU+ : LGT
<input type="hidden" name="fix_commid"      value="KTF"/>
-->
<!-- 사이트코드 -->
<input type="hidden" name="site_cd"      value="<?php echo $site_cd; ?>" />
<!-- Ret_URL : 인증결과 리턴 페이지 ( 가맹점 URL 로 설정해 주셔야 합니다. ) -->
<input type="hidden" name="Ret_URL"      value="<?php echo G5_KCPCERT_URL; ?>/kcpcert_result.php" />
<!-- cert_otp_use 필수 ( 메뉴얼 참고)
     Y : 실명 확인 + OTP 점유 확인 , N : 실명 확인 only
-->
<input type="hidden" name="cert_otp_use" value="Y"/>
<!-- cert_enc_use 필수 (고정값 : 메뉴얼 참고) -->
<input type="hidden" name="cert_enc_use_ext" value="Y"/>
<input type="hidden" name="cert_able_yn" value=""/>

<input type="hidden" name="res_cd"       value=""/>
<input type="hidden" name="res_msg"      value=""/>

<input type="hidden" name="up_hash" value="<?php echo $up_hash; ?>"/>

<!-- up_hash 검증 을 위한 필드 -->
<input type="hidden" name="veri_up_hash" value=""/>

<!-- web_siteid 을 위한 필드 -->
<input type="hidden" name="web_siteid_hashYN" value="Y"/>

<!-- 가맹점 사용 필드 (인증완료시 리턴)-->
<input type="hidden" name="param_opt_1"  value="opt1"/>
<input type="hidden" name="param_opt_2"  value="opt2"/>
<input type="hidden" name="param_opt_3"  value="opt3"/>

<?= $sbParam ?>

</form>

<script>
window.onload = function() {
    cert_page();
}

// 인증 요청 시 호출 함수
function cert_page()
{
    var frm = document.form_auth;

    if ( ( frm.req_tx.value == "auth" || frm.req_tx.value == "otp_auth" ) )
    {
        frm.action="./kcpcert_result.php";

       // MOBILE
        if( ( navigator.userAgent.indexOf("Android") > - 1 || navigator.userAgent.indexOf("iPhone") > - 1 ) )
        {
            self.name="kcp_cert";
        }
        // PC
        else
        {
            frm.target="kcp_cert";
        }

        frm.submit();

        window.close();
    }

    else if ( frm.req_tx.value == "cert" )
    {
        if( ( navigator.userAgent.indexOf("Android") > - 1 || navigator.userAgent.indexOf("iPhone") > - 1 ) ) // 스마트폰인 경우
        {
            window.parent.$("input[name=veri_up_hash]").val(frm.up_hash.value); // up_hash 데이터 검증을 위한 필드
            self.name="auth_popup";
        }
        else // 스마트폰 아닐때
        {
            window.opener.$("input[name=veri_up_hash]").val(frm.up_hash.value); // up_hash 데이터 검증을 위한 필드
            frm.target = "auth_popup";
        }

        frm.action="<?php echo $cert_url; ?>";
        frm.submit();
    }
}
</script>

</body>
</html>