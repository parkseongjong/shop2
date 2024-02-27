<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return;

$menu['menu400'] = [
    ['400000', '쇼핑몰관리', G5_ADMIN_URL . '/shop_admin/', 'shop_config'],
    ['400010', '쇼핑몰현황', G5_ADMIN_URL . '/shop_admin/', 'shop_index'],
    ['400400', '전체 주문내역', G5_ADMIN_URL . '/shop_admin/orderlist.php', 'scf_order', 1],

    ['400470', '미  입금 주문', G5_ADMIN_URL . "/shop_admin/orderlist.php?od_status=주문&scope=status", 'scf_order_1', 1],
    ['400480', '결제완료 주문', G5_ADMIN_URL . '/shop_admin/orderlist.php?od_status=입금&scope=status', 'scf_order_2', 1],
    ['400490', '발송대기 주문', G5_ADMIN_URL . '/shop_admin/orderlist.php?od_status=준비&scope=status', 'scf_order_3', 1],

    ['400420', '카드결제내역', G5_ADMIN_URL . '/shop_admin/transaction_history.php', 'scf_transaction_history', 1],
    ['400440', '개인결제관리', G5_ADMIN_URL . '/shop_admin/personalpaylist.php', 'scf_personalpay', 1],

    ['400200', '분류관리', G5_ADMIN_URL . '/shop_admin/categorylist.php', 'scf_cate'],
    ['400300', '상품관리', G5_ADMIN_URL . '/shop_admin/itemlist.php', 'scf_item'],
    ['400660', '상품문의', G5_ADMIN_URL . '/shop_admin/itemqalist.php', 'scf_item_qna'],
    ['400650', '사용후기', G5_ADMIN_URL . '/shop_admin/itemuselist.php', 'scf_ps'],
    ['400620', '상품재고관리', G5_ADMIN_URL . '/shop_admin/itemstocklist.php', 'scf_item_stock'],
    ['400610', '상품유형관리', G5_ADMIN_URL . '/shop_admin/itemtypelist.php', 'scf_item_type'],
    ['400500', '상품옵션재고관리', G5_ADMIN_URL . '/shop_admin/optionstocklist.php', 'scf_item_option'],
    ['400800', '쿠폰관리', G5_ADMIN_URL . '/shop_admin/couponlist.php', 'scf_coupon'],
    ['400810', '쿠폰존관리', G5_ADMIN_URL . '/shop_admin/couponzonelist.php', 'scf_coupon_zone'],
    ['400750', '추가배송비관리', G5_ADMIN_URL . '/shop_admin/sendcostlist.php', 'scf_sendcost', 1],
    ['400410', '임시저장주문', G5_ADMIN_URL . '/shop_admin/inorderlist.php', 'scf_inorder', 1],
    ['400100', '쇼핑몰설정', G5_ADMIN_URL . '/shop_admin/configform.php', 'scf_config'],
];