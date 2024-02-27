<?php
if (!defined('_GNUBOARD_')) exit;
?>

<!-- autosize -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/autosize@4.0.2/dist/autosize.min.js"></script>

<!-- coolsms.functions.min.js -->
<script type="text/javascript" src="<?php echo G5_ADMIN_URL . '/coolsms/js/coolsms.functions.min.js?ver=' . filemtime(G5_ADMIN_PATH . '/coolsms/js/coolsms.functions.min.js'); ?>"></script>

<!-- coolsms.min.js -->
<script type="text/javascript" src="<?php echo G5_ADMIN_URL . '/coolsms/js/coolsms.min.js?ver=' . filemtime(G5_ADMIN_PATH . '/coolsms/js/coolsms.min.js'); ?>"></script>

<?php
require_once G5_ADMIN_PATH . '/admin.tail.php';