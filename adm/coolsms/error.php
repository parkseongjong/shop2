<?php
$sub_menu = '955002';
require_once './_common.php';

/**
 * @var array $auth
 */
auth_check($auth[$sub_menu], "r");

$g5['title'] = '발송 에러 - coolsms';

require_once __DIR__ . '/head.sub.php';

/**
 * @var \Coolsms\Coolsms $coolsms
 */
$sent = $coolsms->getSent(array_merge($smsSearchData, array('notin_resultcode'=>'00,99,60')));
?>

<div id="coolsms-wrap">
	<div class="sms-search">
		<form method="get">
			<div class="form-group">
				<label for="smsSearchTo">수신 번호</label>

				<div class="form-float">
					<input
						type="text" name="smsSearchTo" id="smsSearchTo" placeholder="010-0000-0000"
						value="<?php echo isset($smsSearchData['s_rcpt'])?$smsSearchData['s_rcpt']:''; ?>"
					>
					<i class="form-helper"></i>
				</div>
			</div>

			<div class="form-group m-l-40">
				<label for="smsSearchStartDate">시작 일시</label>

				<div class="form-float">
					<input
						type="text" name="smsSearchStartDate" id="smsSearchStartDate"
						placeholder="<?php echo date('Y-m-d 00:00:00', strtotime('-20 day')); ?>"
						value="<?php echo isset($smsSearchData['start'])?$smsSearchData['start']:''; ?>"
					>
					<i class="form-helper"></i>
				</div>
			</div>

			<span class="m-r-5 m-l-10">~</span>

			<div class="form-group">
				<label for="smsSearchEndDate">종료 일시</label>

				<div class="form-float">
					<input
						type="text" name="smsSearchEndDate" id="smsSearchEndDate"
						placeholder="<?php echo date('Y-m-d 23:59:59'); ?>"
						value="<?php echo isset($smsSearchData['end'])?$smsSearchData['end']:''; ?>"
					>
					<i class="form-helper"></i>
				</div>
			</div>

			<div class="form-group m-l-40">
				<label for="smsSearchCount">게시글 수</label>

				<div class="form-float">
					<input
						type="number" name="smsSearchCount" id="smsSearchCount" placeholder="20"
						value="<?php echo isset($smsSearchData['count'])?$smsSearchData['count']:20; ?>"
					>
					<i class="form-helper"></i>
				</div>
			</div>

			<button type="submit" class="button button-search m-l-10">
				<i class="fa fa-search fa-fw"></i>
			</button>
		</form>
	</div>

	<div class="sms-box sms-list">
		<dl>
			<dt>발송 에러 리스트</dt>
			<dd class="colspan-3"><?php require_once __DIR__ . '/template.php'; ?></dd>
		</dl>
	</div>
</div>

<?php
require_once __DIR__ . '/tail.sub.php';