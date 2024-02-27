<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if ($od['od_pg'] != 'payup') return;
include_once(G5_SHOP_PATH . '/settle_payup.inc.php');
/**
 * @type array $od
 * @type array $od
 * @type string $mod_memo
 */
$transaction_id = $od['od_tno'];
$cancel_amount = (int)$tax_mny + (int)$free_mny;
$reason = $mod_memo;

$response = $PayUp->PartialCancel($transaction_id, $cancel_amount, $reason);
if ($response['responseCode'] == "0000") {
    $tno = $c_PayPlus->mf_get_res_data("tno");  // KCP 거래 고유 번호
    $amount = $c_PayPlus->mf_get_res_data("amount"); // 원 거래금액
    $mod_mny = $c_PayPlus->mf_get_res_data("panc_mod_mny"); // 취소요청된 금액
    $rem_mny = $c_PayPlus->mf_get_res_data("panc_rem_mny"); // 취소요청후 잔액

    // 환불금액기록
    $sql = " update {$g5['g5_shop_order_table']}
                    set od_refund_price = od_refund_price + '$cancel_amount',
                        od_shop_memo = concat(od_shop_memo, \"$reason\")
                    where od_id = '{$od['od_id']}'
                      and od_tno = '$transaction_id' ";
    sql_query($sql);

    // 미수금 등의 정보 업데이트
    $info = get_order_info($od['od_id']);

    $sql = " update {$g5['g5_shop_order_table']}
                    set od_misu     = '{$info['od_misu']}',
                        od_tax_mny  = '{$info['od_tax_mny']}',
                        od_vat_mny  = '{$info['od_vat_mny']}',
                        od_free_mny = '{$info['od_free_mny']}'
                    where od_id = '{$od['od_id']}'";
    sql_query($sql);

    function_exists('add_order_post_log') && add_order_post_log('PayUp 결제부분취소', "Success: {$cancel_amount} {$response['cancelDateTime']}");
} // End of [res_cd = "0000"]
else {
    function_exists('add_order_post_log') && add_order_post_log('PayUp 결제부분취소', "Failure: {$response['responseMsg']}");
}