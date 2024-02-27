<?php
include_once("./_common.php");
include_once(G5_LIB_PATH . "/register.lib.php");

$mb_recommend = isset($_POST["reg_mb_recommend"]) ? trim($_POST["reg_mb_recommend"]) : '';
$search = trim($_POST['recommend_type']);

/**
 * @changelog 2022.05.30
 * 추천인을 휴대폰 번호로 검색 가능하도록 수정
 *
 */
if ($search == 'phone') {
    $mobile_no = "010{$mb_recommend}";
    empty(valid_mb_hp($mobile_no)) !== true && die('통신망 번호(010)을 제외한 추천인의 휴대전화번호 8자리를 입력하세요.');
    empty($recommendee = find_id_by_phone($mobile_no)) === true && die('가입된 내역이 없거나, 탈퇴 또는 정지된 추천인 휴대전화번호 입니다.');
    empty($member['mb_recommend']) !== true && ($member['mb_recommend'] == $recommendee) && die('등록된 추천인과 변경하려는 추천인이 동일합니다.');
}
else {
    empty($msg = valid_mb_id($mb_recommend)) !== true && die("추천인의 아이디는 영문자, 숫자, _ 만 입력하세요.");
    empty($msg = exist_mb_id($mb_recommend)) === true && die("입력하신 추천인은 존재하지 않는 아이디 입니다.");
}


