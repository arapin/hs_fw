<?
	$shaman = new Shaman();

	$SHId		= Request::get('SHId', Request::REQUEST | Request::XSS_CLEAR);
	$name		= Request::get('name', Request::POST | Request::XSS_CLEAR);
	$SHName		= Request::get('SHName', Request::POST | Request::XSS_CLEAR);
	$SHPwd		= Request::get('SHPwd', Request::POST | Request::XSS_CLEAR);
	$SHPwdU		= Request::get('SHPwdU', Request::POST | Request::XSS_CLEAR);
	$SHTel		= Request::get('SHTel', Request::POST | Request::XSS_CLEAR);
	$SHPhone	= Request::get('SHPhone', Request::POST | Request::XSS_CLEAR);
	$SHZipcode	= Request::get('SHZipcode', Request::POST | Request::XSS_CLEAR);
	$SHAddress	= Request::get('SHAddress', Request::POST | Request::XSS_CLEAR);
	$SHAddress2	= Request::get('SHAddress2', Request::POST | Request::XSS_CLEAR);
	$SHLng		= Request::get('SHLng', Request::POST | Request::XSS_CLEAR);
	$SHLat		= Request::get('SHLat', Request::POST | Request::XSS_CLEAR);
	$SHDesc		= Request::get('SHDesc', Request::POST | Request::XSS_CLEAR);
	$SHWord		= Request::get('SHWord', Request::POST | Request::XSS_CLEAR);
	$SHStartTime = Request::get('SHStartTime', Request::POST | Request::XSS_CLEAR);
	$SHRestSTime = Request::get('SHRestSTime', Request::POST | Request::XSS_CLEAR);
	$SHEndTime	= Request::get('SHEndTime', Request::POST | Request::XSS_CLEAR);
	$SHRestETime	= Request::get('SHRestETime', Request::POST | Request::XSS_CLEAR);
	$mode		= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);
	$idx		= Request::get('idx', Request::POST | Request::XSS_CLEAR);
	$sido		= Request::get('sido', Request::REQUEST | Request::XSS_CLEAR);
	$id			= Request::get('id', Request::REQUEST | Request::XSS_CLEAR);
	$fileTempNum = Request::get('fileTempNum', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "insert"){
		$shamanData = array($SHId, $name, $SHPwd, $SHName, $SHPhone, $SHAddress, $SHLng, $SHLat, "U", date("Y-m-d H:i:s"), $SHZipcode, $SHAddress2);
		$shaman->shamanInsertMng($shamanData);

	}else if($mode == "modify"){
		if($SHPwdU != ""){
			$SHPwd = $SHPwdU;
		}

		$shamanData = array($name, $SHName, $SHTel, $SHPhone, $SHAddress, $SHLng, $SHLat, $SHDesc, $SHStartTime, $SHEndTime, $SHPwd,$SHZipcode, $SHAddress2, $SHWord,$SHRestSTime,$SHRestETime);
		$whereData = array(":SHId" => $SHId);

		$shaman->shamanModifyMng($shamanData, $whereData, $_FILES["profile"]);

	}else if($mode == "delete"){
		$whereData = array(":SHId" => $SHId);
		$shaman->shamanDeleteMng($whereData);
	}else if($mode == "idCheck"){

		$checkCode = $shaman->shamanIdCheck($id);
		echo $checkCode;

	}else if($mode == "apply"){

		$whereData = array(":SHId" => $SHId);
		$shaman->shamanApply($whereData);

	}else if($mode == "apply2"){

		$whereData = array(":SHId" => $SHId);
		$shaman->shamanApply2($whereData);

	}else if($mode == "cancel"){

		$whereData = array(":SHId" => $SHId);
		$shaman->shamanCancel($whereData);

	}else if($mode == "cancel2"){

		$whereData = array(":SHId" => $SHId);
		$shaman->shamanCancel2($whereData);

	}
?>