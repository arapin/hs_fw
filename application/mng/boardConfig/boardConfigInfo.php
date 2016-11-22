<?
	$bc = new BoardConfig();

	$idx			= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$boardCode	= Request::get('boardCode', Request::REQUEST | Request::XSS_CLEAR);
	$boardName	= Request::get('boardName', Request::REQUEST | Request::XSS_CLEAR);
	$boardType	= Request::get('boardType', Request::REQUEST | Request::XSS_CLEAR);
	$depthType	= Request::get('depthType', Request::REQUEST | Request::XSS_CLEAR);
	$payType		= Request::get('payType', Request::REQUEST | Request::XSS_CLEAR);
	$useType		= Request::get('useType', Request::REQUEST | Request::XSS_CLEAR);
	$ownerId		= Request::get('ownerId', Request::REQUEST | Request::XSS_CLEAR);
	$mode		= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "insert"){
		$setBeen = array ($boardCode, $boardName, $boardType, $depthType, $payType,$ownerId,	$useType, date("Y-m-d H:i:s"));
		$bc->bcInsertBoard($setBeen);
	}else if($mode == "modify"){
		$whereBeen = array(":idx" => $idx);
		$setBeen = array ($boardName, $boardType, $depthType, $payType,$ownerId,	$useType);
		$bc->bcUpadteBoard($setBeen, $whereBeen);
	}else if($mode == "delete"){
		$whereData = array(":idx" => $idx);
		$reservation->reservationInfoCancel($whereData);
	}else if($mode == "idCheck"){

		$checkCode = $bc->ownerIdCheck($ownerId);
		echo $checkCode;

	}
?>