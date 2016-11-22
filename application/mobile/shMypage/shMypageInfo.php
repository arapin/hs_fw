<?
	$shmypage = new SHMypage();

	$id		= Request::get('id', Request::REQUEST | Request::XSS_CLEAR);
	$pwd	= Request::get('pwd', Request::POST | Request::XSS_CLEAR);
	$email	= Request::get('email', Request::REQUEST | Request::XSS_CLEAR);
	$name	= Request::get('name', Request::REQUEST | Request::XSS_CLEAR);
	$nameCH	= Request::get('nameCH', Request::POST | Request::XSS_CLEAR);

	$birthdayM	= Request::get('birthdayM', Request::POST | Request::XSS_CLEAR);
	$birthdayD	= Request::get('birthdayD', Request::POST | Request::XSS_CLEAR);
	$birthdayY	= Request::get('birthdayY', Request::POST | Request::XSS_CLEAR);
	$birthday = $birthdayY."-".$birthdayM."-".$birthdayD;

	$birthdayType	= Request::get('birthdayType', Request::POST | Request::XSS_CLEAR);

	$birthdayTime	= Request::get('birthdayTime', Request::POST | Request::XSS_CLEAR);

	$zipcode	= Request::get('zipcode', Request::POST | Request::XSS_CLEAR);
	$address	= Request::get('address', Request::POST | Request::XSS_CLEAR);
	$address2	= Request::get('address2', Request::POST | Request::XSS_CLEAR);

	$phone	= Request::get('phone', Request::POST | Request::XSS_CLEAR);
	$setAuthNum	= Request::get('setAuthNum', Request::POST | Request::XSS_CLEAR);

	$outType	= Request::get('outType', Request::POST | Request::XSS_CLEAR);
	$outTypeEtc	= Request::get('outTypeEtc', Request::POST | Request::XSS_CLEAR);

	$mode	= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);

	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$lidx	= Request::get('lidx', Request::REQUEST | Request::XSS_CLEAR);
	$fidx	= Request::get('fidx', Request::REQUEST | Request::XSS_CLEAR);
	$sidx	= Request::get('sidx', Request::REQUEST | Request::XSS_CLEAR);
	$answerIdx		= Request::get('answerIdx', Request::REQUEST | Request::XSS_CLEAR);
	$title		= Request::get('title', Request::POST | Request::XSS_CLEAR);
	$content	= Request::get('content', Request::POST | Request::XSS_CLEAR);

	$memo	= Request::get('memo', Request::POST | Request::XSS_CLEAR);

	$headWord	= Request::get('headWord', Request::POST | Request::XSS_CLEAR);
	$userId		= Request::get('userId', Request::POST | Request::XSS_CLEAR);
	$parentIdx	= Request::get('parentIdx', Request::REQUEST | Request::XSS_CLEAR);
	$memoIdx	= Request::get('memoIdx', Request::POST | Request::XSS_CLEAR);

	$checkIdx	= Request::get('checkIdx', Request::POST | Request::XSS_CLEAR);

	$SHId		= Request::get('SHId', Request::REQUEST | Request::XSS_CLEAR);
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
	$SHEndTime	= Request::get('SHEndTime', Request::POST | Request::XSS_CLEAR);
	$sido		= Request::get('sido', Request::REQUEST | Request::XSS_CLEAR);
	$SHIdx		= Request::get('SHIdx', Request::REQUEST | Request::XSS_CLEAR);
	$SHRestSTime	= Request::get('SHRestSTime', Request::REQUEST | Request::XSS_CLEAR);
	$SHRestETime	= Request::get('SHRestETime', Request::REQUEST | Request::XSS_CLEAR);

	$proIdx		= Request::get('proIdx', Request::NPOST | Request::XSS_CLEAR);
	$proIdxM		= Request::get('proIdxM', Request::NPOST | Request::XSS_CLEAR);
	$proTime		= Request::get('proTime', Request::NPOST | Request::XSS_CLEAR);
	$proTimeM		= Request::get('proTimeM', Request::NPOST | Request::XSS_CLEAR);

	$limitSDate		= Request::get('limitSDate', Request::NPOST | Request::XSS_CLEAR);
	$limitSDateM		= Request::get('limitSDateM', Request::NPOST | Request::XSS_CLEAR);
	$limitEDate		= Request::get('limitEDate', Request::NPOST | Request::XSS_CLEAR);
	$limitEDateM		= Request::get('limitEDateM', Request::NPOST | Request::XSS_CLEAR);
	$price		= Request::get('price', Request::NPOST | Request::XSS_CLEAR);
	$priceM		= Request::get('priceM', Request::NPOST | Request::XSS_CLEAR);
	$fileRndIdx		= Request::get('fileRndIdx', Request::NPOST | Request::XSS_CLEAR);


	if($mode == "modify"){
		$userData = array($email, $birthday, $birthdayType, $birthdayTime, $zipcode, $address, $address2, $name, $nameCH, $phone);
		$whereData = array(":id" => $id);

		$shmypage->userModify($userData,$whereData );

	}else if($mode == "cancel"){
		$whereData = array(":idx" => $idx);
		$shmypage->reservationInfoCancel($whereData);
	}else if($mode == "wishDel"){
		$whereData = array(":idx" => $idx);
		$shmypage->wishDel($whereData);
		echo "00";
	}else if($mode == "choice"){
		$shmypage->aqBoardChoice($idx, $answerIdx);
	}else if($mode == "deleteAnswer"){
		$whereBeen = array(":idx"=>$answerIdx);
		$shmypage->aqBoardAnswerDelete($whereBeen, $idx);
	}else if($mode == "modifyAnswer"){
		$setBeen = array("",$content);
		$whereBeen = array(":idx" => $answerIdx);
		$shmypage->aqBoardAnswerUpdate($setBeen, $whereBeen, $idx);
	}else if($mode == "boardModify"){
		$boardData = array("title"=>$title, "content"=>$content, "headWord"=>$headWord, "code"=>$code);
		$whereData = array(":idx" => $idx);
		$shmypage->boardUpadteBoardFront($boardData, $whereData);
	}else if($mode == "boardDelete"){
		$whereData = array(":idx" => $idx);
		$shmypage->boardDeleteFront($whereData, $code);
	}else if($mode == "memoInsert"){
		$memoBeen = array($parentIdx, $userId, $content, date("Y-m-d H:i:s"));
		$shmypage->setBoardMemoInfo($memoBeen, $code);
	}else if($mode == "memoModify"){
		$whereData = array(":idx" => $memoIdx);
		$memoBeen = array($content);
		$shmypage->updateBoardMemoInfo($memoBeen, $whereData, $code, $parentIdx);
	}else if($mode == "memoDelete"){
		$whereData = array(":idx" => $memoIdx);
		$shmypage->deleteBoardMemoInfo($whereData, $code, $parentIdx);
	}else if($mode == "rescancel"){
		$whereData = array(":idx" => $idx);
		$shmypage->reservationInfoCancel($whereData);
	}else if($mode == "mainImgCheck"){
		$whereData = array(":idx" => $idx);
		$fileBeen = array("Y");
		$shmypage->setMainImgChk($fileBeen, $whereData);
	}else if($mode == "checkDel"){
		$checkDelIdx = explode(",", $checkIdx);
		$loopCnt = sizeof($checkDelIdx);

		for($i=0; $i < $loopCnt; $i++){
			if($checkDelIdx[$i] != ""){
				$whereData = array(":idx" => $checkDelIdx[$i]);
				$fileData = array("deletePath" => uploadPath."/shaman");
				$shmypage->deleteImgFile($whereData, $fileData);
			}
		}
	}else if($mode == "saveFile"){
		$fileData = array($_FILES["imgFile"], "shaman", $SHId, uploadPath."/shaman");
		$shmypage->addImgFileM($fileData);
	}else if($mode == "saveProfile"){
		$whereData = array(":SHId" => $SHId);
		$shmypage->addImgFile2($_FILES["profile"],$whereData);
?>
	<script>
		parent.reLoad();
	</script>
<?
	}else if($mode == "shamanModify"){
		if($SHPwdU != ""){
			$SHPwd = $SHPwdU;
		}

		$shamanData = array($name, $SHName, $SHTel, $SHPhone, $SHAddress, $SHLng, $SHLat, $SHDesc, $SHStartTime, $SHEndTime, $SHPwd,$SHZipcode, $SHAddress2, $SHWord, $SHRestSTime, $SHRestETime);
		$whereData = array(":SHId" => $SHId);

		$shmypage->shamanModifyMngM($shamanData, $whereData);
	}else if($mode == "resInfo"){
		$whereBeen = array(":idx"=>$idx);
		$rtnResult = $shmypage->getResUserInfo($whereBeen);
		echo $rtnResult;
	}else if($mode == "limitDel"){
		$whereData = array(":idx" => $lidx);
		$shmypage->deleteLimitDayInfo($whereData, $fileRndIdx);
	}else if($mode == "addLimitDay"){
		$shmypage->setLimitDayInfo($limitSDateM, $limitEDateM, $SHIdx);
	}else if($mode == "delFile"){
		$whereData = array(":idx" => $fidx);
		$fileData = array("deletePath" => uploadPath."/shaman");
		$shmypage->deleteImgFileM($whereData, $fileData);
	}else if($mode == "addSpr"){
		$setBeenData = array($SHIdx, $proIdxM, $proTimeM, $priceM,date("Y-m-d H:i:s"));
		$shmypage->addProduct($setBeenData);
	}else if($mode == "delSpr"){
		$whereData = array(":idx" => $sidx);
		$shmypage->deleteProduct($whereData, $SHIdx);
	}

	
?>