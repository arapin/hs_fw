<?
	$payment = new Payment();

	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$mode	= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);
	$inBank	= Request::get('inBank', Request::REQUEST | Request::XSS_CLEAR);
	$inName	= Request::get('inName', Request::REQUEST | Request::XSS_CLEAR);
	$payPrice	= Request::get('payPrice', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "payment"){
		$whereBeen = array(":idx" => $idx);
		$payInfo = $inBank."|".$inName;
		$setBeen = array("I", $payInfo, $payPrice, date("Y-m-d H:i:s"));
		$payment->paymentApply($setBeen, $whereBeen);

?>
		<script>
			alert('결제 처리 되었습니다.');
			opener.location.reload();
			self.close();
		</script>
<?
	}else if($mode == "modify"){

	}else if($mode == "cancel"){
		$whereData = array(":idx" => $idx);
		$payment->paymentCancel($whereData);
	}
?>