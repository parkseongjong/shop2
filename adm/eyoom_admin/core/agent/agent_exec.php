<?php
/**
 *
 * User: Lee, Namdu
 * Date: 2022-06-07
 * Time: 오전 9:33
 */


!function_exists('json_encode') && include_once(G5_LIB_PATH . '/json.lib.php');
!function_exists('empty_mb_id') && include_once(G5_LIB_PATH . '/register.lib.php');

ob_end_clean();

$smode = true;
$param = array_merge($_GET, $_POST);
switch ($param['scope']) {
    // 회원 존재여부 체크
    case 'existsMember' :
        {
            ($error_message = admin_referer_check(true)) && fn_ajax_output(['code' => 403, 'message' => $error_message]);
            ($error_message = empty_mb_id($param['mb_id'])) && fn_ajax_output(['code' => 400, 'message' => $error_message]);
            fn_ajax_output(exist_mb_id($param['mb_id']) ? ['code' => 200, 'message' => 'OK'] : ['code' => 404, 'message' => '등록되어 있지 않거나 잘 못된 아이디입니다.']);
            break;
        }
    // 대리점 추가
    case 'set':
        {
            $district = getDistrictStringify(true);
            $bindValue = [
                'ag_code' => $param['ag_code']
                , 'ag_name' => null
                , 'ag_mb_id' => $param['ag_mb_id']
                , 'ag_bank_name' => $param['ag_bank_name']
                , 'ag_bank_account' => $param['ag_bank_account']
                , 'ag_bank_owner' => $param['ag_bank_owner']
                , 'ag_type' => $param['ag_type']
                , 'ag_parent' => $param['ag_parent']
                , 'ag_margin_rate' => $param['ag_margin_rate']
                , 'ag_phone' => $param['ag_phone']
                , 'ag_email' => $param['ag_email']
                , 'ag_status' => $param['ag_status']
            ];

            !is_array($param['district']) === true && ($param['district'] = []);
            foreach ($param['district'] as $code){
                if(empty($code) == true) break;
                $bindValue['ag_code'] = $code;
            }

            // 신규일때 - 지역 코드 체크
            (empty($param['ag_id']) === true && empty($bindValue['ag_code']) === true) && fn_ajax_output(['code' => 400, 'message' => '지역을 선택하세요.']);
            //
            (empty($param['ag_type']) === true && empty($bindValue['ag_code']) === true) && fn_ajax_output(['code' => 400, 'message' => '계약 선택하세요.']);
            // 대리점 담당 ID가 있을 경우 등록여부 검사
            empty($param['ag_mb_id']) !== true && !exist_mb_id($param['ag_mb_id']) && fn_ajax_output(['code' => 400, 'message' => '등록되어 있지 않은 회원 입니다.']);

            // 이름
            $state = substr($bindValue['ag_code'], 0, 2);
            $city = substr($bindValue['ag_code'], 0, 5);

            $bindValue['ag_name'] = $district['city'][$state][$city] ;
            empty($bindValue['ag_name']) === true && ($bindValue['ag_name'] = getDistrictStateAbbr($state));

            $bindValue['ag_name']  = trim($bindValue['ag_name'] . ' ' . $param['ag_suffix']);

            // 자리 수 채우기
            $bindValue['ag_code'] = str_pad($bindValue['ag_code'], 5, '0');

            // 신규일때 동일한 지역코드가 있는 지 확인
            if (empty($param['ag_id']) === true && empty($bindValue['ag_code']) !== true) {
                $keyword = fn_sql_quote($bindValue['ag_code'] . '%');
                $sibling = fn_sql_row("SELECT MAX(ag_code) FROM `{$g5['tb_agents']}` WHERE ag_code LIKE {$keyword}");

                if (empty($sibling) !== true) {
                    empty($param['ag_suffix']) === true && fn_ajax_output(['code' => 400, 'message' => '동일 지역의 타 대리점과 구분 가능한 세부 명칭을 입력하세요.']);
                    fn_sql_row("SELECT count(0) FROM `{$g5['tb_agents']}` WHERE ag_code LIKE {$keyword} AND ag_name=" . fn_sql_quote($bindValue['ag_name'])) > 0 && fn_ajax_output(['code' => 400, 'message' => '이미 동일 지역에 등록된 대리점 이름 입니다.']);
                    // A : 65
                    $suffix = 0;
                    strlen($sibling) > 5 && ($suffix = ord(substr($sibling, 5)) - 64);
                    //1 : 1234 + CHR(65 + 0) 1234A
                    //2 : 1234 + CHR(65 + 1) 1234B
                    $bindValue['ag_code'] .= chr(65 + $suffix);
                }
                else if($param['ag_type'] == 'S'){
                    $bindValue['ag_code'] .='A';
                }
            }

            foreach ($bindValue as $key => &$val) $bindValue[$key] = fn_sql_quote($val);

            $data_set = [
                "ag_name = {$bindValue['ag_name']}"
                , "ag_mb_id = {$bindValue['ag_mb_id']}"
                , "ag_bank_name = {$bindValue['ag_bank_name']}"
                , "ag_bank_account = {$bindValue['ag_bank_account']}"
                , "ag_bank_owner = {$bindValue['ag_bank_owner']}"
                , "ag_type = {$bindValue['ag_type']}"
                , "ag_phone = {$bindValue['ag_phone']}"
                , "ag_email = {$bindValue['ag_email']}"
                , "ag_status = {$bindValue['ag_status']}"
                , "ag_margin_rate = {$bindValue['ag_margin_rate']}"
            ];
            empty($bindValue['ag_parent']) !== true && ($data_set = ["ag_parent = {$bindValue['ag_parent']}"]);

            // Update
            if ($param['ag_id'] > 0) {
                unset($data_set['ag_code'], $data_set['ag_created_at']);
                $data_set = implode(', ', $data_set);

                $sql = "UPDATE `{$g5['tb_agents']}` SET {$data_set} WHERE ag_id = {$param['ag_id']}";
            }
            else {
                $data_set[] = "ag_code = {$bindValue['ag_code']}";
                $data_set[] = "ag_created_at = NOW()";

                $data_set = implode(', ', $data_set);
                $sql = "INSERT INTO `{$g5['tb_agents']}` SET {$data_set}";
            }

            $response = sql_query($sql, true) ? ['code' => 200, 'message' => 'OK'] : ['code' => 500, 'message' => 'An error has occurred with database.'];
            fn_ajax_output($response);


            break;
        }
    case 'profile':
        {
            empty($param['id']) === true && fn_ajax_output(['code' => 400, 'message' => '고유 식별 번호가 누락되었습니다.']);
            empty($agent = getAgentByPk($param['id'])) === true && fn_ajax_output(['code' => 404, 'message' => '해당 식별번호와 일치하는 정보를 찾을 수가 없습니다.']);
            fn_ajax_output(['code' => 200, 'message' => 'OK', 'profile' => $agent]);
            break;
        }

    case 'attribute':
        {

            empty($param['target']) === true && fn_ajax_output(['code' => 400, 'message' => '수정할 대상 정보 주체가 누락되었습니다.']);
            empty($param['attribute']) === true && fn_ajax_output(['code' => 400, 'message' => '수정할 필드 정보가 누락되었습니다.']);
            isset($param['value']) !== true && fn_ajax_output(['code' => 400, 'message' => '수정할 필드 값이 지정되지 않았습니다.']);
            !in_array($param['attribute'], ['status', 'manager', 'district', 'parent']) && fn_ajax_output(['code' => 400, 'message' => '요청한 필드 정보 수정은 허가되지 않았습니다.']);

            is_string($param['target']) === true && ($param['target'] = explode(',', $param['target']));
            $idx = implode(', ', fn_sql_quote($param['target']));
            $value = fn_sql_quote($param['value']);


            $sql = "UPDATE `{$g5['tb_agents']}` SET `ag_{$param['attribute']}` = {$value} WHERE ag_id IN({$idx})";
            $param['attribute'] == 'parent' && ($sql .=' AND ag_type=\'A\'');

            $response = sql_query($sql, true) ? ['code' => 200, 'message' => 'OK'] : ['code' => 500, 'message' => 'An error has occurred with database.'];
            fn_ajax_output($response);
            break;
        }
    case 'invoice':
        {
            empty($param['target']) === true && fn_ajax_output(['code' => 400, 'message' => '수정할 대상 정보 주체가 누락되었습니다.']);
            empty($param['attribute']) === true && fn_ajax_output(['code' => 400, 'message' => '수정할 필드 정보가 누락되었습니다.']);
            isset($param['value']) !== true && fn_ajax_output(['code' => 400, 'message' => '수정할 필드 값이 지정되지 않았습니다.']);
            isset($param['from']) !== true && fn_ajax_output(['code' => 400, 'message' => '수정할 시작 날짜 값이 지정되지 않았습니다.']);
            ($from = (new DateTime($param['from']))->format('Y-m-d')) != $param['from'] && fn_ajax_output(['code' => 400, 'message' => '유효하지 않은 시작 날짜 형식입니다.']);

            isset($param['to']) !== true && fn_ajax_output(['code' => 400, 'message' => '수정할 종료 날짜 값이 지정되지 않았습니다.']);
            ($to = (new DateTime($param['to']))->format('Y-m-d')) != $param['to'] && fn_ajax_output(['code' => 400, 'message' => '유효하지 않은 종료 날짜 형식입니다.']);
            
            !in_array($param['attribute'], ['withdraw']) && fn_ajax_output(['code' => 400, 'message' => '요청한 필드 정보 수정은 허가되지 않았습니다.']);

            is_string($param['target']) === true && ($param['target'] = explode(',', $param['target']));
            $idx = implode(', ', fn_sql_quote($param['target']));
            $value = fn_sql_quote($param['value']);

            $sql = "UPDATE `{$g5['tb_agent_point']}` SET `ap_{$param['attribute']}` = {$value}, ap_invoice_at=NOW(), ap_stamper='{$member['mb_id']}' WHERE (ap_created_at BETWEEN '{$from} 00:00:00' AND '{$to} 23:59:59') AND ap_agent IN({$idx})";
            $response = sql_query($sql, true) ? ['code' => 200, 'message' => 'OK'] : ['code' => 500, 'message' => 'An error has occurred with database.'];
            fn_ajax_output($response);
            break;
        }
    case 'suspended': {
        empty($param['target']) === true && fn_ajax_output(['code' => 400, 'message' => '수정할 대상 정보 주체가 누락되었습니다.']);
        $idx = is_array($param['target']) ? $param['target'] : [$param['target']];
        $idx = implode(', ', fn_sql_quote($idx));

        $sql = "UPDATE `{$g5['tb_agent_point']}` SET ap_withdraw='N' WHERE ap_idx IN({$idx}) AND ap_withdraw='Y'";
        $response = sql_query($sql, true) ? ['code' => 200, 'message' => $sql] : ['code' => 500, 'message' => 'An error has occurred with database.'];
        fn_ajax_output($response);
        break;
    }

    default:
        {
            fn_ajax_output(['code' => 403, 'message' => 'Invalid access, does not contain scope.']);
            break;
        }
}



