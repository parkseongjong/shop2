<?php
include_once("./_common.php");
include_once(G5_LIB_PATH . "/register.lib.php");
$param = $_POST;
switch ($param['scope']) {
    /*
     |
     | 대리점 수정
     */
    case 'agent':
        {
            empty($member['mb_id']) === true && fn_ajax_output(['code' => 401, 'message' => '로그인 후 이용하세요.']);
            empty($param['agent']) === true && fn_ajax_output(['code' => 400, 'message' => '대리점을 선택하세요.']);
            // 소셜 회원이 아닌 경우 비밀번호 체크
            empty($member['mb_2']) == true && empty($param['passwd']) === true && fn_ajax_output(['code' => 401, 'message' => '비밀번호를 입력하세요.']);
            (empty($member['mb_2']) == true && !check_password($param['passwd'], $member['mb_password'])) && fn_ajax_output(['code' => 401, 'message' => '비밀번호가 일치하지 않습니다.']);


            $mb_1 = fn_sql_quote($param['agent']);
            $mb_id = fn_sql_quote($member['mb_id']);
            !sql_query("UPDATE {$g5['member_table']} SET mb_1={$mb_1} WHERE mb_id={$mb_id}") && fn_ajax_output(['code' => 500, 'message' => 'An error has occurred with database.']);
            fn_ajax_output(['code' => 200, 'message' => '저장되었습니다.']);
            break;
        }
    /*
     |
     | 추천인 수정
     */
    case 'mentor':
        {
            empty($member['mb_id']) === true && fn_ajax_output(['code' => 401, 'message' => '로그인 후 이용하세요.']);
            empty($param['mobileNo']) === true && fn_ajax_output(['code' => 400, 'message' => '휴대폰 번호를 입력하세요.']);
            // 소셜 회원이 아닌 경우 비밀번호 체크
            empty($member['mb_2']) == true && empty($param['passwd']) === true && fn_ajax_output(['code' => 401, 'message' => '비밀번호를 입력하세요.']);
            (empty($member['mb_2']) == true && !check_password($param['passwd'], $member['mb_password'])) && fn_ajax_output(['code' => 401, 'message' => '비밀번호가 일치하지 않습니다.']);

            $mobile_no = '010' . preg_replace('/^(010)/', '', $param['mobileNo']);

            empty(valid_mb_hp($mobile_no)) !== true && fn_ajax_output(['code' => 400, 'message' => '통신망 번호(010)을 제외한 추천인의 휴대전화번호 8자리를 입력하세요.']);

            empty($mentor = find_id_by_phone($mobile_no)) === true && fn_ajax_output(['code' => 400, 'message' => '가입된 내역이 없거나, 탈퇴 또는 정지된 추천인 휴대전화번호 입니다.']);

            $mb_recommend = fn_sql_quote($mentor);
            $mb_id = fn_sql_quote($member['mb_id']);
            $exist_id = $member['mb_recommend'] ? '\'\'' : fn_sql_quote($member['mb_recommend']);
            !sql_query("UPDATE {$g5['member_table']} SET mb_recommend={$mb_recommend}, mb_3={$exist_id}  WHERE mb_id={$mb_id}") && fn_ajax_output(['code' => 500, 'message' => 'An error has occurred with database.']);
            $config['cf_use_recommend'] && fn_reward_nominee($mentor, $member['mb_id'], $config['cf_recommend_point'], $member['mb_dupinfo']);
            fn_ajax_output(['code' => 200, 'message' => '저장되었습니다.']);
            break;
        }
    /*
     |
     | 본인확인
     */
    case 'identification':
        {
            empty($member['mb_id']) === true && fn_ajax_output(['code' => 401, 'message' => '로그인 후 이용하세요.']);
            // 소셜 회원이 아닌 경우 비밀번호 체크
            empty($member['mb_2']) == true && empty($param['passwd']) === true && fn_ajax_output(['code' => 401, 'message' => '비밀번호를 입력하세요.']);
            (empty($member['mb_2']) == true && !check_password($param['passwd'], $member['mb_password'])) && fn_ajax_output(['code' => 401, 'message' => '비밀번호가 일치하지 않습니다.']);
            // 세션정보
            $storage = [
                'type' => get_session('ss_cert_type')
                , 'no' => get_session('ss_cert_no')
                , 'dupinfo' => get_session('ss_cert_dupinfo')


                , 'hash' => get_session('ss_cert_hash')
                , 'adult' => get_session('ss_cert_adult')
                , 'birth' => get_session('ss_cert_birth')
                , 'sex' => get_session('ss_cert_sex')
            ];

            (!$config['cf_cert_use'] || empty($storage['type']) === true || empty($storage['dupinfo']) === true) && fn_ajax_output(['code' => 400, 'message' => '본인확인 인증정보가 누락되었습니다.']);


            // $hash_data   = md5($user_name.$cert_type.$birth_day.$md5_cert_no);
            $plain_text = $param['mb_name'] . $storage['type'] . $storage['birth'] . $storage['no'];

            $hash_data = md5($plain_text);
            ($storage['hash'] != $hash_data) && fn_ajax_output(['code' => 400, 'message' => '본인확인 인증정보가 유효하지 않습니다.']);


            $mobileNo = hyphen_hp_number($param['mb_hp']);

            $mb_hp = fn_sql_quote($mobileNo);
            $mb_certify = fn_sql_quote($storage['type']);
            $mb_adult = fn_sql_quote($storage['adult']);
            $mb_birth = fn_sql_quote($storage['birth']);
            $mb_sex = fn_sql_quote($storage['sex']);
            $mb_name = fn_sql_quote($param['mb_name']);
            $mb_dupinfo = fn_sql_quote($storage['dupinfo']);

            // -- DI And 휴대폰 동일(다른 휴대폰일 경우 인정함)
            $exists = fn_sql_row("SELECT mb_id FROM {$g5['member_table']} WHERE mb_dupinfo={$mb_dupinfo} AND mb_hp={$mb_hp}");
            empty($exists) !== true && fn_ajax_output(['code' => 409, 'message' => "입력한 개인정보로 가입된 내역(아이디: {$exists})이 존재합니다."]);

            $sql = "
            UPDATE
                {$g5['member_table']}
            SET
                mb_hp = {$mb_hp}
                , mb_certify = {$mb_certify}
                , mb_adult = {$mb_adult}
                , mb_birth = {$mb_birth}
                , mb_sex = {$mb_sex}
                , mb_dupinfo = {$mb_dupinfo}
                , mb_name = {$mb_name}
            WHERE
                mb_no='{$member['mb_no']}'    
            ";

            !sql_query($sql) && fn_ajax_output(['code' => 500, 'message' => 'An error has occurred with database.']);
            fn_ajax_output(['code' => 200, 'message' => '저장되었습니다.']);
            break;
        }

}