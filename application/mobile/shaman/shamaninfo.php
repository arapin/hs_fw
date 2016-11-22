<?
	$shaman = new Shaman();

	$SHId		= Request::get('SHId', Request::REQUEST | Request::XSS_CLEAR);
	$name		= Request::get('name', Request::POST | Request::XSS_CLEAR);
	$SHName		= Request::get('SHName', Request::POST | Request::XSS_CLEAR);
	$SHPwd		= Request::get('SHPwd', Request::POST | Request::XSS_CLEAR);
	$SHPhone	= Request::get('SHPhone', Request::POST | Request::XSS_CLEAR);
	$SHZipcode	= Request::get('SHZipcode', Request::POST | Request::XSS_CLEAR);
	$SHAddress	= Request::get('SHAddress', Request::POST | Request::XSS_CLEAR);
	$SHAddress2	= Request::get('SHAddress2', Request::POST | Request::XSS_CLEAR);
	$SHEmail		= Request::get('SHEmail', Request::POST | Request::XSS_CLEAR);
	$SHLng		= Request::get('SHLng', Request::POST | Request::XSS_CLEAR);
	$SHLat		= Request::get('SHLat', Request::POST | Request::XSS_CLEAR);

	$userId		= Request::get('userId', Request::POST | Request::XSS_CLEAR);
	$code		= Request::get('code', Request::POST | Request::XSS_CLEAR);
	$memo		= Request::get('memo', Request::POST | Request::XSS_CLEAR);

	$SHIdx		= Request::get('SHIdx', Request::REQUEST | Request::XSS_CLEAR);
	$proIdx		= Request::get('proIdx', Request::POST | Request::XSS_CLEAR);
	$price		= Request::get('price', Request::POST | Request::XSS_CLEAR);
	$totalPrice		= Request::get('totalPrice', Request::POST | Request::XSS_CLEAR);
	$memCnt		= Request::get('memCnt', Request::POST | Request::XSS_CLEAR);
	$resUserId		= Request::get('resUserId', Request::POST | Request::XSS_CLEAR);
	$resDate		= Request::get('resDate', Request::REQUEST | Request::XSS_CLEAR);
	$resStartTime		= Request::get('resStartTime', Request::POST | Request::XSS_CLEAR);
	$resEndTime		= Request::get('resEndTime', Request::POST | Request::XSS_CLEAR);

	$mode		= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);
	$idx		= Request::get('idx', Request::POST | Request::XSS_CLEAR);
	$memoIdx		= Request::get('memoIdx', Request::POST | Request::XSS_CLEAR);
	$sido		= Request::get('sido', Request::REQUEST | Request::XSS_CLEAR);
	$gugun		= Request::get('gugun', Request::REQUEST | Request::XSS_CLEAR);
	$id			= Request::get('id', Request::REQUEST | Request::XSS_CLEAR);

	$pointerP			= Request::get('pointerP', Request::POST | Request::XSS_CLEAR);
	$serviceP			= Request::get('serviceP', Request::POST | Request::XSS_CLEAR);
	$locationP			= Request::get('locationP', Request::POST | Request::XSS_CLEAR);
	$priceP			= Request::get('priceP', Request::POST | Request::XSS_CLEAR);

	if($mode == "join"){

		$shamanData = array(strtolower($SHId), $name, $SHPwd, $SHName, $SHPhone, $SHAddress, $SHLng, $SHLat, "U", date("Y-m-d H:i:s"), $SHZipcode, $SHAddress2, $SHEmail);
		$shaman->shamanInsert($shamanData);

	}else if($mode == "modify"){

		$shamanData = array($name, $SHName, $SHTel, $SHPhone, $SHAddress, $SHLng, $SHLat, $SHDesc, $SHStartTime, $SHEndTime);
		$whereData = array(":SHId" => $SHId);
		$shaman->shamanModify($shamanData, $whereData);

	}else if($mode == "outMember"){
	}else if($mode == "zipTwoSearch"){
		$zipData = array(":ds_sido" => $sido);
		echo $shaman->zipTwoAdress2($zipData, $gugun);
	}else if($mode == "idCheck"){

		$checkCode = $shaman->shamanIdCheck($id);
		echo $checkCode;

	}else if($mode == "afftermemoinsert"){
		$setBeen = array($code, $userId, $memo, $pointerP, $serviceP, $locationP, $priceP,  date("Y-m-d H:i:s"));
		$shaman->insertAffterMemoM($setBeen, $SHId);
	}else if($mode == "delMemo"){
		$whereBeen = array(":idx"=>$memoIdx);
		$shaman->deleteAffterMemoM($whereBeen, $SHId);
	}else if($mode == "modifyMemo"){
		$setBeen = array($memo);
		$whereBeen = array(":idx"=>$memoIdx);
		$shaman->modifyAffterMemoM($setBeen, $whereBeen, $SHId);
	}else if($mode == "reservation"){
		$shamanData = array($SHIdx, $proIdx, $price, $totalPrice, $memCnt, $resUserId, $resDate, $resStartTime, $resEndTime);
		$shaman->setReservationInfo($shamanData);
		echo "00";
	}else if($mode == "wish"){
		$shamanData = array($SHIdx, $resUserId, date("Y-m-d H:i:s"));
		$shaman->setWish($shamanData);
		echo "00";
	}else if($mode == "limitDayConfirm"){
		$whereBeen = array(":SHIdx" => $SHIdx);
		$limitBeen = array("resDate" => $resDate);
		$shaman->resLimitDayCnt($whereBeen, $limitBeen);
	}
?>