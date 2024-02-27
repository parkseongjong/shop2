<?php
$sub_menu = '955001';
require_once './_common.php';

/**
 * @var array $auth
 */
auth_check($auth[$sub_menu], "r");

$g5['title'] = "대시보드 - coolsms";

require_once __DIR__ . '/head.sub.php';

/**
 * @var \Coolsms\Coolsms $coolsms
 */
$defaultInformation = $coolsms->getData();
$balance = $coolsms->getBalance();
$status = $coolsms->getStatus();
$sent = $coolsms->getSent($smsSearchData);
?>

<div id="coolsms-wrap">
	<ul class="status-bar">
		<li class="title">서버 상태 (<?php echo $status[0]['registdate']; ?>)</li>
		<li>SMS : <?php echo $status[0]['sms_average']; ?>초</li>
		<li>SK : <?php echo $status[0]['sms_sk_average']; ?>초</li>
		<li>KT : <?php echo $status[0]['sms_kt_average']; ?>초</li>
		<li>LG : <?php echo $status[0]['sms_lg_average']; ?>초</li>
	</ul>

	<div class="status-box">
		<dl>
			<dt>글자수 제한</dt>
			<?php foreach ($defaultInformation['byte'] as $type => $byte) { ?>
			<dd>
				<p>
					<?php echo number_format($byte); ?>
					Byte
				</p>
				<small><?php echo strtoupper($type); ?></small>
			</dd>
			<?php } ?>
		</dl>

		<dl>
			<dt>발송 비용</dt>
			<?php foreach ($defaultInformation['charge'] as $type => $money) { ?>
			<dd>
				<p>
					<?php echo number_format($money); ?>
					원
				</p>
				<small><?php echo strtoupper($type); ?></small>
			</dd>
			<?php } ?>
		</dl>

		<dl>
			<dt>
				잔여 금액
				(<?php echo $balance['deferred_payment'] == 'N'?'선':'후'; ?>불회원)
				<a href="https://www.coolsms.co.kr/" target="_blank">
					<i class="fa fa-link fa-fw"></i>
				</a>
			</dt>

			<dd>
				<p>
					<?php echo number_format($balance['cash']); ?>
					원
				</p>
				<small>Cash</small>
			</dd>

			<dd>
				<p>
					<?php echo number_format($balance['point']); ?>
					원
				</p>
				<small>Point</small>
			</dd>
		</dl>

		<dl>
			<dt>잔여 건수</dt>

			<dd>
				<p>
					<?php echo number_format(floor(($balance['cash'] + $balance['point']) / $defaultInformation['charge']['sms'])); ?>
					건
				</p>
				<small>SMS</small>
			</dd>

			<dd>
				<p>
					<?php echo number_format(floor(($balance['cash'] + $balance['point']) / $defaultInformation['charge']['lms'])); ?>
					건
				</p>
				<small>LMS</small>
			</dd>
		</dl>
	</div>

	<div class="sms-box-wrap">
		<div class="sms-box sms-send">
			<dl>
				<dt>문자 보내기</dt>
				<dd>
					<form method="post">
						<div class="form-group form-inline">
							<label for="smsFrom">발신 번호</label>

							<div class="form-float">
								<select name="smsFrom" id="smsFrom" required>
									<?php if (
										isset($defaultInformation['senderid']['list']) &&
										is_array($defaultInformation['senderid']['list']) &&
										count($defaultInformation['senderid']['list']) > 0
									) {
										foreach ($defaultInformation['senderid']['list'] as $row) { ?>
									<option
										value="<?php echo $row['phone_number']; ?>"
										<?php /** @var string $smsForm */ echo isset($smsForm)?($smsForm == $row['phone_number']?'selected':''):($row['flag_default'] == 'Y'?'selected':''); ?>
									><?php echo preg_replace('/^(01[0-9]{1})([0-9]{3,4})([0-9]{4})$/', '$1-$2-$3', $row['phone_number']); ?></option>
										<?php }
									} else { ?>
									<option value="">발신 번호를 등록해주세요.</option>
									<?php } ?>
								</select>
								<i class="form-helper"></i>
							</div>
						</div>

						<div class="form-group form-inline">
							<label for="smsTo">수신 번호</label>

							<div class="form-float">
								<input
									type="text" name="smsTo" id="smsTo" placeholder="010-0000-0000" required
									value="<?php /** @var string $smsTo */ echo isset($smsTo)?$smsTo:''; ?>"
								>
								<i class="form-helper"></i>
							</div>
						</div>

						<div class="form-group form-inline">
							<label for="smsDatetime">예약 일시</label>

							<div class="form-float">
								<input
									type="text" name="smsDatetime" id="smsDatetime" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"
									value="<?php /** @var string $smsDatetime */ echo isset($smsDatetime)?$smsDatetime:''; ?>"
								>
								<i class="form-helper"></i>
							</div>
						</div>

						<div class="form-group">
							<div class="form-float">
								<textarea
									name="smsText" id="smsText" title="" placeholder="문자 내용" required
									onkeyup="setSmsByte(this.value, document.getElementById('sms-byte'));"
								><?php /** @var string $smsText */ echo isset($smsText)?$smsText:''; ?></textarea>
								<i class="form-helper"></i>
							</div>

							<small class="sms-byte" id="sms-byte">0 Byte</small>
						</div>

						<button type="submit" class="button button-submit button-large form-w100">문자 발송</button>
					</form>
				</dd>
			</dl>
		</div>

		<div class="sms-box sms-list">
			<dl>
				<dt>
					최근 발송 20건
					<small>(<?php echo date('Y-m-d', strtotime('-20 day'));  ?> ~ <?php echo date('Y-m-d'); ?>)</small>

					<a href="<?php echo G5_ADMIN_URL . '/coolsms/search.php'; ?>">
						<i class="fa fa-search fa-fw"></i>
					</a>
				</dt>
				<dd class="colspan-2"><?php require __DIR__ . '/template.php'; ?></dd>
			</dl>
		</div>
	</div>
</div>

<?php
require_once __DIR__ . '/tail.sub.php';