<?php
$sub_menu = '955004';
require_once './_common.php';

/**
 * @var array $auth
 */
auth_check($auth[$sub_menu], "r");

$g5['title'] = '레벨별 발송 - coolsms';

// 각 회원별 통계를 가져옴
$levelData = array();
$query = '
	SELECT COUNT(`mb_no`) AS `count`, `mb_level`
	FROM `' . $g5['member_table'] . '`
	WHERE `mb_sms` = 1
		AND `mb_hp` != ""
		AND `mb_hp` IS NOT NULL
	GROUP BY `mb_level`
	ORDER BY `mb_level` DESC
';
$result = sql_query($query);
while ($row = sql_fetch_array($result)) {
	$levelData[$row['mb_level']] = $row['count'];
}

if (isset($smsLevel) && is_array($smsLevel) && count($smsLevel) > 0) {
	// 레벨별 문자 발송을 해야할때, 받는 사람 데이터를 생성해서 넘겨줌..
	$smsMbHps = array();

	$query = '
		SELECT `mb_hp`
		FROM `' . $g5['member_table'] . '`
		WHERE `mb_sms` = 1
			AND `mb_hp` != ""
			AND `mb_hp` IS NOT NULL
			AND `mb_level` IN ("' . implode('","', $smsLevel) . '")
		GROUP BY `mb_hp`
	';
	$result = sql_query($query);
	while ($row = sql_fetch_array($result)) {
		if (isset($row['mb_hp'])) {
			$row['mb_hp'] = preg_replace('/[^0-9]/', '', $row['mb_hp']);
			if (empty($row['mb_hp'])) {
				continue;
			}

			$smsMbHps[] = $row['mb_hp'];
		}
	}

	if (count($smsMbHps) > 0) {
		$smsTo = implode(',', $smsMbHps);
	}
}

require_once __DIR__ . '/head.sub.php';

/**
 * @var \Coolsms\Coolsms $coolsms
 */
$defaultInformation = $coolsms->getData();
?>

<div id="coolsms-wrap">
	<div class="sms-box sms-send">
		<dl>
			<dt>레벨별 문자 발송</dt>
			<dd>
				<form method="post">
					<div class="form-group form-w50">
						<label for="smsFrom">발신 번호</label>

						<div class="form-float">
							<select class="form-w100" name="smsFrom" id="smsFrom" required>
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

					<div class="form-group form-w50">
						<label>예약 일시</label>

						<div class="form-float">
							<input
								type="text" class="form-w100" name="smsDatetime" id="smsDatetime" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"
								value="<?php /** @var string $smsDatetime */ echo isset($smsDatetime)?$smsDatetime:''; ?>"
							>
							<i class="form-helper"></i>
						</div>
					</div>

					<div class="form-group">
						<label>수신 레벨</label>

						<ul>
							<li>
								<label>
									<input type="checkbox" onclick="checkLevelAll(this.checked);">
									Level 전체 (<?php echo number_format(array_sum($levelData)); ?>)
								</label>
							</li>
							<?php foreach ($levelData as $level => $total) { ?>
							<li>
								<label>
									<input
										type="checkbox" name="smsLevel[]" value="<?php echo $level; ?>" required
										<?php echo isset($smsLevel) && is_array($smsLevel)?(in_array($level, $smsLevel)?'checked':''):''; ?>
									>
									Level <?php echo $level; ?> (<?php echo number_format($total); ?>)
								</label>
							</li>
							<?php } ?>
						</ul>
					</div>

					<div class="form-group">
						<div class="form-float form-w100">
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
</div>

<?php
require_once __DIR__ . '/tail.sub.php';