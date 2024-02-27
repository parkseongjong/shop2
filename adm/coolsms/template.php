<?php
if (!defined('_GNUBOARD_')) exit;

if (isset($sent['data']) && is_array($sent['data']) && count($sent['data']) > 0) {
	foreach ($sent['data'] as $row) { ?>
<div class="sms-data-wrap">
		<?php if ($row['status'] == 2) { ?>
	<table class="sms-data">
		<tbody>
			<tr>
				<th>발송 결과</th>
				<td>
					<span class="text-<?php echo $row['result_code'] == '00'?'true':'false'; ?>"><?php echo $row['result_message']; ?></span>
				</td>
			</tr>
			<tr>
				<th>발송 타입</th>
				<td><?php echo $row['type']; ?></td>
			</tr>
			<tr>
				<th>요청 일시</th>
				<td><?php echo $row['accepted_time']; ?></td>
			</tr>
			<tr>
				<th>발송 일시</th>
				<td><?php echo preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$/', '$1-$2-$3 $4:$5:$6', $row['sent_time']); ?></td>
			</tr>
			<tr>
				<th>수신 통신사</th>
				<td><?php echo $row['carrier']; ?></td>
			</tr>
			<tr>
				<th>수신 번호</th>
				<td><?php echo preg_replace('/^([0-9]{3})([0-9]{3,4})([0-9]{4})$/', '$1-$2-$3', $row['recipient_number']); ?></td>
			</tr>
			<tr>
				<td colspan="2"><?php echo nl2br($row['text']); ?></td>
			</tr>
			<tr>
				<td colspan="2">
					<form method="get" onsubmit="return confirm('재발송 하시겠습니까?\n기본 발신 번호로 재발송 됩니다.');">
						<input type="hidden" name="smsTo" value="<?php echo $row['recipient_number']; ?>">
						<input type="hidden" name="smsText" value="<?php echo $row['text']; ?>">

						<button type="submit" class="button button-submit form-w100">재발송</button>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
		<?php } else { ?>
	<table class="sms-data">
		<tbody>
			<tr>
				<th>발송 결과</th>
				<td>
					<span class="<?php echo $row['result_code'] == '99'?'':'text-' . ($row['result_code'] == '00'?'true':'false'); ?>">
						<?php echo $row['result_message']; ?>
					</span>
				</td>
			</tr>
			<tr>
				<th>발송 타입</th>
				<td><?php echo $row['type']; ?></td>
			</tr>
			<tr>
				<th>요청 일시</th>
				<td><?php echo $row['accepted_time']; ?></td>
			</tr>
			<tr>
				<th>발송 예약 일시</th>
				<td><?php echo $row['scheduled_time']; ?></td>
			</tr>
			<tr>
				<th>수신 번호</th>
				<td><?php echo preg_replace('/^([0-9]{3})([0-9]{3,4})([0-9]{4})$/', '$1-$2-$3', $row['recipient_number']); ?></td>
			</tr>
			<tr>
				<td colspan="2"><?php echo nl2br($row['text']); ?></td>
			</tr>
			<tr>
				<td colspan="2">
					<?php if ($row['result_code'] == '99') { ?>
					<form method="post" onsubmit="return confirm('예약 발송을 취소하시겠습니까?');">
						<input type="hidden" name="message_id" value="<?php echo $row['message_id']; ?>">
						<input type="hidden" name="group_id" value="<?php echo $row['group_id']; ?>">

						<button type="submit" class="button button-cancel form-w100">예약 취소</button>
					</form>
					<?php } else { ?>
					<form method="get" onsubmit="return confirm('재발송 하시겠습니까?\n기본 발신 번호로 재발송 됩니다.');">
						<input type="hidden" name="smsTo" value="<?php echo $row['recipient_number']; ?>">
						<input type="hidden" name="smsDatetime" value="<?php echo $row['scheduled_time']; ?>">
						<input type="hidden" name="smsText" value="<?php echo $row['text']; ?>">

						<button type="submit" class="button button-submit form-w100">재발송</button>
					</form>
					<?php } ?>
				</td>
			</tr>
		</tbody>
	</table>
		<?php } ?>
</div>
	<?php } ?>

	<?php
	if (isset($sent['total_count'], $sent['list_count'], $sent['page']) && $sent['total_count'] > $sent['list_count']) {
		parse_str($_SERVER['QUERY_STRING'], $arrQueryString);

		$paginationStart = floor($sent['page'] / 10) * 10 + 1;
		$paginationEnd = ceil($sent['total_count'] / $sent['list_count']);
		$paginationShowEnd = ($paginationStart + 9 <= $paginationEnd)?$paginationStart + 9:$paginationEnd;
	?>
<ul class="pagination">
	<?php if ($sent['page'] > 10) { ?>
	<li>
		<a href="?<?php echo http_build_query(array_merge($arrQueryString, array('page'=>1))); ?>">
			<i class="fa fa-angle-double-left fa-fw"></i>
		</a>
	</li>
	<li>
		<a href="?<?php echo http_build_query(array_merge($arrQueryString, array('page'=>$paginationStart - 10))); ?>">
			<i class="fa fa-angle-left fa-fw"></i>
		</a>
	</li>
	<?php } ?>

	<?php for ($i = $paginationStart; $i <= $paginationShowEnd; $i++) { ?>
	<li class="<?php echo $sent['page'] == $i?'active':''; ?>">
		<a href="?<?php echo http_build_query(array_merge($arrQueryString, array('page'=>$i))); ?>"><?php echo $i; ?></a>
	</li>
	<?php } ?>

	<?php if ($paginationEnd > 10 && $paginationEnd != $paginationShowEnd) { ?>
	<li>
		<a href="?<?php echo http_build_query(array_merge($arrQueryString, array('page'=>$paginationStart + 10))); ?>">
			<i class="fa fa-angle-right fa-fw"></i>
		</a>
	</li>
	<li>
		<a href="?<?php echo http_build_query(array_merge($arrQueryString, array('page'=>$paginationEnd))); ?>">
			<i class="fa fa-angle-double-right fa-fw"></i>
		</a>
	</li>
	<?php } ?>
</ul>
	<?php } ?>
<?php } else { ?>
<div class="no-data">데이터가 존재하지 않습니다.</div>
<?php } ?>