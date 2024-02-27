<?php
/**
 * @file    /adm/eyoom_admin/core/shop/itemlistupdate.php
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;

$sub_menu = "400300";

check_demo();

check_admin_token();

$idx = $_POST['idx'];
$rows = $_POST['item'];
$scope = isset($_POST['act_button']) ? $_POST['act_button'] : '';
empty($idx) == true && alert(str_replace('선택', '', $scope) . '하려는 상품을 하나 이상 선택하세요');
($scope == '선택삭제' && $is_admin != 'super' && $is_admin != 'operator') && alert('상품 삭제는 최고관리자만 가능합니다.');

// query string
$qstr .= $sdt ? '&amp;sdt=' . $sdt : '';
$qstr .= $fr_date ? '&amp;fr_date=' . $fr_date : '';
$qstr .= $to_date ? '&amp;to_date=' . $to_date : '';
$qstr .= $cate_a ? '&amp;cate_a=' . $cate_a : '';
$qstr .= $cate_b ? '&amp;cate_b=' . $cate_b : '';
$qstr .= $cate_c ? '&amp;cate_c=' . $cate_c : '';
$qstr .= $cate_d ? '&amp;cate_d=' . $cate_d : '';


switch ($scope) {
    case '선택삭제':
        {
            auth_check_menu($auth, $sub_menu, 'd');
            // _ITEM_DELETE_ 상수를 선언해야 itemdelete.inc.php 가 정상 작동함
            define('_ITEM_DELETE_', true);

            foreach ($idx as $it_id) {
                $it_id = preg_replace('/[^a-z0-9_\-]/i', '', $it_id);
                include G5_ADMIN_PATH . '/shop_admin/itemdelete.inc.php';
            }
            alert('선택한 상품을 삭제하였습니다.', G5_ADMIN_URL . "/?dir=shop&amp;pid=itemlist&amp;{$qstr}");
            break;
        }
    case '선택수정':
        {
           auth_check_menu($auth, $sub_menu, 'w');

            !sql_query('START TRANSACTION', true) && alert('An error has occurred with database.');

            foreach ($idx as $it_id) {
                $item_id = fn_sql_quote($it_id);
                $item = $rows[$it_id];

                if (empty($item) === true) {
                    continue;
                }
                // 최고관리자가 아니면 체크
                else if ($is_admin != 'super' && $is_admin != 'operator') {
                    $own = sql_fetch("SELECT a.it_id, b.ca_mb_id FROM {$g5['g5_shop_item_table']} a , {$g5['g5_shop_category_table']} b WHERE (a.ca_id = b.ca_id) AND a.it_id = {$item_id}");
                    if(!$own['ca_mb_id'] || $own['ca_mb_id'] != $member['mb_id']) continue;
                }

                foreach(['it_name', 'it_cust_price', 'it_price', 'it_use', 'it_soldout', 'it_order', 'it_type1', 'it_type2', 'it_type3', 'it_type4', 'it_type5'] as $col) {
                    $item[$col] = empty( $item[$col]) === true ? "''" : fn_sql_quote( strip_tags(clean_xss_tags( $item[$col])) );
                }

                $sql = "
                UPDATE 
                    {$g5['g5_shop_item_table']}
                SET 
                    it_name        = {$item['it_name']},
                    it_cust_price  = {$item['it_cust_price']},
                    it_price       = {$item['it_price']},
                    -- it_stock_qty   = 
                    it_use         = {$item['it_use']},
                    it_soldout     = {$item['it_soldout']},
                    it_order       = {$item['it_order']},
                    it_type1       = {$item['it_type1']},
                    it_type2       = {$item['it_type2']},
                    it_type3       = {$item['it_type3']},
                    it_type4       = {$item['it_type4']},
                    it_type5       = {$item['it_type5']},
                    it_update_time =  NOW()
                 WHERE 
                    it_id   = {$item_id}";
                if( !sql_query($sql, true) ) {
                    sql_query('ROLLBACK');
                    alert('An error has occurred with database.');
                    return ;
                }
                function_exists('shop_seo_title_update') && shop_seo_title_update($it_id, true);
            }

            !sql_query('COMMIT', true) && alert('An error has occurred with database.');
            alert('선택한 상품을 수정하였습니다.', G5_ADMIN_URL . "/?dir=shop&amp;pid=itemlist&amp;{$qstr}");
            break;
        }
}
