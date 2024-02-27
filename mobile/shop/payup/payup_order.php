<?php
include_once('./_common.php');
include_once(G5_MSHOP_PATH.'/settle_payup.inc.php');
	
	$postValue = $_POST;

	$reqData = [];
	$reqData['amount'] = strval(isset($postValue['amount']) ? (int) $postValue['amount'] : 0);
	$reqData['orderNumber'] = clean_xss_tags($postValue['orderNumber']);
	$reqData['birthday'] = clean_xss_tags($postValue['birthday']);
	$reqData['cardNo'] = clean_xss_tags($postValue['cardNo']);
	$reqData['expireMonth'] = clean_xss_tags($postValue['expireMonth']);
	$reqData['expireYear'] = clean_xss_tags($postValue['expireYear']);
	$reqData['cardPw'] = clean_xss_tags($postValue['cardPw']);
	$reqData['quota'] = clean_xss_tags($postValue['quota']);
	$reqData['itemName'] = clean_xss_tags($postValue['itemName']);
	$reqData['userName'] = clean_xss_tags($postValue['userName']);
	$reqData['kakaoSend'] = 'N';
	$reqData['userEmail'] = get_email_address($postValue['od_email']);
	$reqData['mobileNumber'] = clean_xss_tags($postValue['mobileNumber']);
	$reqData['timestamp'] = date('YmdHis');
    $reqData['signature'] = hash('sha256', trim("{$payup_merchant_id}|{$reqData['orderNumber']}|{$reqData['amount']}|{$payup_api_cert_key}|{$reqData['timestamp']}"),false);

	$data = array_merge($postValue, $reqData);

	try {
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $payup_js_url . $payup_settle_url,
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "gzip",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 3000,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => json_encode($reqData,JSON_UNESCAPED_UNICODE),
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_HTTPHEADER => array(
				'Accept: application/json',
				'Content-Type: application/json; charset=UTF-8',
				'Content-Length:'.strlen(json_encode($reqData,JSON_UNESCAPED_UNICODE)),
				"cache-control: no-cache"
			),
			CURLOPT_VERBOSE => false,
		));

		$result = @json_decode(curl_exec($ch), true);
		$curlInfo = curl_getinfo($ch);
		$err = curl_error($ch);
        curl_close($ch);
		
		if(empty($result['responseCode']) === false && $result['responseCode'] == '0000') {
			$data['transactionId'] = $result['transactionId'];
			$data['cardName'] = $result['cardName'];
			$data['authNumber'] = $result['authNumber'];
			$data['authDateTime'] = $result['authDateTime'];
		} else {
			throw new Exception('PG 사에 결제 요청을 실패 하였습니다.');
		}
	} catch(Exception $e) {
		alert($e->getMessage());
	}
?>

<html>
<head>
	<script type="text/javascript">
        function goResult()
        {
            document.pay_info.submit();
        }
	</script>
</head>
<body onload="goResult()">
<form name="pay_info" method="POST" action="<?=G5_HTTPS_MSHOP_URL?>/orderformupdate.php">
<?php
	foreach ($data as $key => $value) {
		if(is_array($value) === true) {
			foreach($value as $sKey => $sValue) {
				echo "<input type='hidden' name='{$sKey}' id='{$sKey}' value='{$sValue}'>";
			}
		} else {
			echo "<input type='hidden' name='{$key}' id='{$key}' value='{$value}'>";
		}
	}

	echo "<input type='hidden' name='transactionId' id='transactionId' value='{$data['transactionId']}'>";
	echo "<input type='hidden' name='cardName' id='cardName' value='{$data['cardName']}'>";
	echo "<input type='hidden' name='authNumber' id='authNumber' value='{$data['authNumber']}'>";
	echo "<input type='hidden' name='authDateTime' id='authDateTime' value='{$data['authDateTime']}'>";
?>
</form>
</body>
</html>