<?
	$mng = new Mng();

	$mngId		= Request::get('mngId', Request::REQUEST | Request::XSS_CLEAR);
	$mngPwd		= Request::get('mngPwd', Request::POST | Request::XSS_CLEAR);
	$mngName	= Request::get('mngName', Request::POST | Request::XSS_CLEAR);
	$mngLevel	= Request::get('mngLevel', Request::POST | Request::XSS_CLEAR);
	$mode		= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);
	$idx		= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "join"){

		$mngData = array($mngId, $mngPwd, $mngName, date("Y-m-d H:i:s"), $mngLevel);
		$mng->mngInsert($mngData);

	}else if($mode == "modify"){

		$mngData = array($mngId, $mngPwd, $mngName, $mngLevel);
		$whereData = array(":idx" => $idx);

		$mng->mngModify($mngData,$whereData );

	}else if($mode == "delete"){

		$whereData = array(":idx" => $idx);
		$mng->mngInfoDelete($whereData );

	}else if($mode == "idCheck"){

		$checkCode = $mng->mngIdCheck($mngId);
		echo $checkCode;

	}
?>