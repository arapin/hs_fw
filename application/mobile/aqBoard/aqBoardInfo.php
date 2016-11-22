<?
	$aqBoard = new AqBoard();

	$title		= Request::get('title', Request::POST | Request::XSS_CLEAR);
	$content	= Request::get('content', Request::POST | Request::XSS_CLEAR);
	$userId		= Request::get('userId', Request::POST | Request::XSS_CLEAR);
	$proCate	= Request::get('proCate', Request::POST | Request::XSS_CLEAR);
	$proPrice	= Request::get('proPrice', Request::POST | Request::XSS_CLEAR);
	$idx		= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$answerIdx		= Request::get('answerIdx', Request::REQUEST | Request::XSS_CLEAR);
	$parentIdx		= Request::get('parentIdx', Request::REQUEST | Request::XSS_CLEAR);
	$mode		= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);
	$page		= Request::get('page', Request::REQUEST | Request::XSS_CLEAR);

	$answerStartDate	= Request::get('answerStartDate', Request::POST | Request::XSS_CLEAR);
	$answerEndDate		= Request::get('answerEndDate', Request::POST | Request::XSS_CLEAR);

	if($mode == "insert"){
		$setBeen = array($title, $content, $userId, $proCate, $proPrice, $answerStartDate, $answerEndDate);
		$aqBoard->setAqBoardInfo($setBeen);
	}else if($mode == "modify"){
		$setBeen = array($title, $content);
		$whereBeen = array(":idx" => $idx);
		$aqBoard->updateAqBoardInfo($setBeen, $whereBeen);
	}else if($mode == "delete"){
	}else if($mode == "answer"){
		$setBeen = array("A", $content, $parentIdx, date("Y-m-d H:i:s"), $userId);
		$aqBoard->aqBoardAnswer($setBeen);
	}else if($mode == "modifyAnswer"){
		$setBeen = array("", $content);
		$whereBeen = array(":idx"=>$answerIdx);
		$aqBoard->aqBoardAnswerUpdate($setBeen, $whereBeen, $parentIdx);
	}else if($mode == "deleteAnswer"){
		$whereBeen = array(":idx"=>$answerIdx);
		$aqBoard->aqBoardAnswerDelete($whereBeen, $parentIdx);
	}else if($mode == "choice"){
		$aqBoard->aqBoardChoice($idx, $answerIdx);
	}
?>