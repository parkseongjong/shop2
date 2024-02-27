<?php
if (!defined('_GNUBOARD_')) exit;

// coolsms.min.css
add_stylesheet('<link href="' . G5_ADMIN_URL . '/coolsms/css/coolsms.min.css?ver=' . filemtime(G5_ADMIN_PATH . '/coolsms/css/coolsms.min.css') . '" rel="stylesheet" type="text/css">');

/**
 * @var \Coolsms\Coolsms $coolsms
 */
// SMS Send Data
$smsSendData = array(
	'from'=>isset($smsFrom)?$smsFrom:'',
	'to'=>isset($smsTo)?$smsTo:'',
	'datetime'=>isset($smsDatetime)?$smsDatetime:'',
	'text'=>isset($smsText)?$smsText:''
);

if ($smsSendData['to'] && $smsSendData['text']) {
	// SMS Send
	$smsSendResult = $coolsms->send($smsSendData);

	if (isset($smsSendResult['status'], $smsSendResult['message'])) {
		// Error
		?>
<script type="text/javascript">
alert('<?php echo $smsSendResult['message']; ?>');
</script>
		<?php
	} else if (isset($smsSendResult['success_count'], $smsSendResult['error_count'])) {
		?>
<script type="text/javascript">
let smsSendAlert = '';
smsSendAlert += '총 <?php echo number_format($smsSendResult['success_count'] + $smsSendResult['error_count']); ?>건중';
smsSendAlert += ' 성공 <?php echo number_format($smsSendResult['success_count']); ?>건';
smsSendAlert += ' 실패 <?php echo number_format($smsSendResult['error_count']); ?>건 했습니다.';
alert(smsSendAlert);

let smsSendHref = window.location.href;
window.location.href = smsSendHref;
</script>
		<?php
		exit;
	}
}

// SMS cancel
if (
	(isset($message_id) && $message_id) ||
	(isset($group_id) && $group_id)
) {
	$smsCancelData = array();

	if (isset($message_id)) {
		$smsCancelData['mid'] = $message_id;
	}

	if (isset($group_id)) {
		$smsCancelData['gid'] = $group_id;
	}

	$smsCancelResult = $coolsms->cancel($smsCancelData);
	?>
<script type="text/javascript">
alert('<?php echo $smsCancelResult?'예약문자 발송이 취소되었습니다.':'예약문자 발송 취소에 실패하였습니다.'; ?>');

let smsCancelHref = window.location.href;
window.location.href = smsCancelHref;
</script>
	<?php
	exit;
}

// search data
$smsSearchData = array(
	// Page
	'page'=>isset($page)?$page:1,
	// 수신 번호 검색
	's_rcpt'=>isset($smsSearchTo)?preg_replace('/[^0-9]/', '', $smsSearchTo):'',
	// 검색 시작 일시
	'start'=>isset($smsSearchStartDate)?$smsSearchStartDate:date('Y-m-d 00:00:00', strtotime('-20 day')),
	// 검색 종료 일시
	'end'=>isset($smsSearchEndDate)?$smsSearchEndDate:date('Y-m-d 23:59:59'),
	// 한 페이지당 보여줄 게시글 수
	'count'=>isset($smsSearchCount)?$smsSearchCount:20
);

require_once G5_ADMIN_PATH . '/admin.head.php';