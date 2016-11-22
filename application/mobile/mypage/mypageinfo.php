<?
	$mypage = new Mypage();

	$id		= Request::get('id', Request::REQUEST | Request::XSS_CLEAR);
	$pwd	= Request::get('pwd', Request::POST | Request::XSS_CLEAR);
	$pwdU	= Request::get('pwdU', Request::POST | Request::XSS_CLEAR);
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
	$answerIdx		= Request::get('answerIdx', Request::REQUEST | Request::XSS_CLEAR);
	$title		= Request::get('title', Request::POST | Request::XSS_CLEAR);
	$content	= Request::get('content', Request::POST | Request::XSS_CLEAR);

	$memo	= Request::get('memo', Request::POST | Request::XSS_CLEAR);

	$headWord	= Request::get('headWord', Request::POST | Request::XSS_CLEAR);
	$userId		= Request::get('userId', Request::POST | Request::XSS_CLEAR);
	$parentIdx	= Request::get('parentIdx', Request::REQUEST | Request::XSS_CLEAR);
	$memoIdx	= Request::get('memoIdx', Request::POST | Request::XSS_CLEAR);


	if($mode == "modify"){
		if($pwdU != ""){
			$pwd = $pwdU;
		}

		$userData = array($email, $birthday, $birthdayType, $birthdayTime, $zipcode, $address, $address2, $name, $nameCH, $phone, $pwd);
		$whereData = array(":id" => $id);

		$mypage->userModify($userData,$whereData);

	}else if($mode == "cancel"){
		$whereData = array(":idx" => $idx);
		$mypage->reservationInfoCancel($whereData);
	}else if($mode == "wishDel"){
		$whereData = array(":idx" => $idx);
		$mypage->wishDel($whereData);
		echo "00";
	}else if($mode == "choice"){
		$mypage->aqBoardChoice($idx, $answerIdx);
	}else if($mode == "aqModify"){
		$setBeen = array($title, $content);
		$whereBeen = array(":idx" => $idx);
		$mypage->updateAqBoardInfo($setBeen, $whereBeen);
	}else if($mode == "memoModify"){
		$setBeen = array($memo);
		$whereBeen = array(":idx" => $idx);
		$mypage->modifyAffterMemo($setBeen, $whereBeen);
	}else if($mode == "boardModify"){
		$boardData = array("title"=>$title, "content"=>$content, "headWord"=>$headWord, "code"=>$code);
		$whereData = array(":idx" => $idx);
		$mypage->boardUpadteBoardFront($boardData, $whereData);
	}else if($mode == "boardDelete"){
		$whereData = array(":idx" => $idx);
		$mypage->boardDeleteFront($whereData, $code);
	}else if($mode == "memoInsert"){
		$memoBeen = array($parentIdx, $userId, $content, date("Y-m-d H:i:s"));
		$mypage->setBoardMemoInfo($memoBeen, $code);
	}else if($mode == "memoModify"){
		$whereData = array(":idx" => $memoIdx);
		$memoBeen = array($content);
		$mypage->updateBoardMemoInfo($memoBeen, $whereData, $code, $parentIdx);
	}else if($mode == "memoDelete"){
		$whereData = array(":idx" => $memoIdx);
		$mypage->deleteBoardMemoInfo($whereData, $code, $parentIdx);
	}
?>