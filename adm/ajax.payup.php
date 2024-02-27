<?php
include_once('./_common.php');
include_once(G5_SHOP_PATH . '/settle_payup.inc.php');

$param = $_POST;
array_walk($param, function (&$value, &$key) {
    $value = clean_xss_tags($value);
});


//$transaction_id = clean_xss_tags($_POST['transactionId']);
///$cancel_reason = clean_xss_tags($_POST['reason']);
switch ($param['scope']) {
    default:
        {
            fn_ajax_output(['code' => 403, 'message' => 'Invalid access, does not contain scope.']);
            break;
        }
    case 'cancel':
        {
            empty($param['id']) == true && fn_ajax_output(['code' => 400, 'message' => '결제 로그 ID가 누락되었습니다.']);
            empty($param['tx']) == true && fn_ajax_output(['code' => 400, 'message' => 'PG 거래번호가 누락되었습니다.']);
            empty($param['reason']) == true && fn_ajax_output(['code' => 400, 'message' => '취소 사유를 입력하세요']);

            $idx = fn_sql_quote($param['id']);
            $mb_id = fn_sql_quote($member['mb_id']);
            $reason = fn_sql_quote($param['reason']);

            // 결제 정보 가져오기
            $exists = sql_fetch("SELECT 
                canceled, code, 
                (SELECT COUNT(0) FROM `{$g5['g5_shop_order_table']}` TS WHERE TS.od_id = TM.ord_id) is_order
            FROM 
                {$g5['tb_payout']} TM WHERE idx={$idx}");

            //
            empty($exists) === true && fn_ajax_output(['code' => 404, 'message' => $idx . '결제 로그 정보를 찾을 수 없습니다.']);
            $exists['is_order'] > 0 && fn_ajax_output(['code' => 409, 'message' => "주문 데이터가 생성되어 있어 승인취소가 불가능합니다."]);
            $exists['code'] != '0000' && fn_ajax_output(['code' => 409, 'message' => "결제실패로 승인취소가 불가능합니다."]);
            $exists['canceled'] == 'Y' && fn_ajax_output(['code' => 409, 'message' => "이미 승인취소된 결제건입니다."]);


            $response = $PayUp->Cancel($param['tx']);

            if ($response['responseCode'] == '0000') {
                $sql = "UPDATE {$g5['tb_payout']} SET canceled='Y', canceled_at=NOW(), canceled_to={$reason}, canceller={$mb_id} WHERE idx={$idx}";
                sql_query($sql);
                fn_ajax_output(['code' => 200, 'message' => '결제 승인 취소되었습니다.']);
            }
            else {
                fn_ajax_output(['code' => 502, 'message' => "취소실패: {$response['responseMsg']}"]);
            }

            break;

        }
}
