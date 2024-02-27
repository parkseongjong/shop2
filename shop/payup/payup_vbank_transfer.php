<?php
/**
 * 페이업 가상계좌 입금 통지 URL
 */

require_once __DIR__ . '/_common.php';
require_once __DIR__ . '/../settle_payup.inc.php';

/*
 * RESULT: 응답성공코드
 * STATUS_CODE: 상태코드 (2001 = 입금, 2009 = 계좌발금 취소, 9001 = 입금취소)
 * TRANSACTION_ID : 거래번호
 * MERCHANT_ID: 가맹점아이디
 * ORDER_NUMBER: 주문번호
 * RESPONSE_MSG: 응답메세지
 * RESPONSE_CODE: 응답코드
 * DEPOSIT_DATETIME: 입금일자
 * DEPOSITOR: 입금자명
 * AMOUNT: 입금금액
 * ACCOUNT: 가상계좌번호
 * CASH_AUTH_NO: 현금영수증 승인번호
 */
$param = $_REQUEST;

switch ($param['STATUS_CODE']) {
    /*
     | -------------------------------------------------------------
     | 가상계좌 입금 확인
     | -------------------------------------------------------------
     */
    case 2001:
        {
            $order_no = $param['ORDER_NUMBER'];
            $tno = $param['TRANSACTION_ID'];
            $amount = $param['AMOUNT'];
            $timestamp = $param['DEPOSIT_DATETIME']; // YYYYMMDDHHMISS
            $date_time = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $timestamp);
            $is_cash_auth = !empty($param['CASH_AUTH_NO']);


            // 개인결제가 있는 지 체크
            $private = sql_fetch("SELECT * FROM {$g5['g5_shop_personalpay_table']} WHERE pp_id = '{$order_no}' AND pp_tno = '{$tno}'");

            $result = false;

            $where = "od_id = '{$order_no}' AND od_tno = '{$tno}'";
            $column = [
                "od_receipt_price = '{$amount}'",
                "od_receipt_time = '{$timestamp}'"
            ];


            if ($private['pp_id']) {
                // 개인결제 UPDATE
                sql_query("
                    UPDATE 
                        {$g5['g5_shop_personalpay_table']} 
                    SET 
                        pp_receipt_price='{$amount}'
                        , pp_receipt_time='{$timestamp}'
                        , pp_settle_case='가상계좌'
                        , pp_cash='{$is_cash_auth}'
                        , pp_cash_no='{$param['CASH_AUTH_NO']}'
                    WHERE 
                        pp_id='{$order_no}' AND pp_tno='{$tno}'", false);

                // 주문서 UPDATE
                if($private['od_id']) {
                    $column[0] = "od_receipt_price + od_receipt_price = '{$amount}'";
                    $column[] = "od_shop_memo=CONCAT(od_shop_memo, \"\\n개인결제 {$private['pp_id']} 로 결제완료 - {$date_time}\")";
                    $where = "od_id = '{$private['od_id']}'";
                }
            }



            $sql = implode(', ', $column);
            if (sql_query("UPDATE {$g5['g5_shop_order_table']} SET {$sql} WHERE {$where}")) {
                  $od_id = $private['od_id'] ? $private['od_id'] : $order_no;

                // 주문정보 체크
                $sql = "SELECT COUNT(0) FROM {$g5['g5_shop_order_table']} WHERE od_id = '{$od_id}' AND od_status = '주문'";

                if (fn_sql_row($sql) == 1) {
                    // 미수금 정보 업데이트
                    $info = get_order_info($od_id);
                    $sql = "UPDATE {$g5['g5_shop_order_table']} SET od_misu = '{$info['od_misu']}'";
                    $info['od_misu'] == 0 && ($sql .= " , od_status = '입금' ");

                    sql_query("{$sql} where od_id = '{$od_id}'", false);

                    // 장바구니 상태변경
                    $info['od_misu'] == 0 && sql_query("UPDATE {$g5['g5_shop_cart_table']} SET ct_status = '입금' WHERE od_id = '{$od_id}'", false);
                }
            }
            @header('Content-Type: text/plain');
            die($param['RESULT']);
            break;
        }
    case 2009:
        {

            break;
        }

    case 9001:
        {
            break;
        }
    default:

        break;
}
