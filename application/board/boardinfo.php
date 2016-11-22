<?
	$board = new Board();

	$headWord	= Request::get('headWord', Request::POST | Request::XSS_CLEAR);
	$title		= Request::get('title', Request::POST | Request::XSS_CLEAR);
	$content	= Request::get('content', Request::POST);
	$userId		= Request::get('userId', Request::POST | Request::XSS_CLEAR);
	$code		= Request::get('code', Request::POST | Request::XSS_CLEAR);
	$idx		= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$parentIdx	= Request::get('parentIdx', Request::REQUEST | Request::XSS_CLEAR);
	$memoIdx	= Request::get('memoIdx', Request::POST | Request::XSS_CLEAR);
	$mode		= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);
	$page		= Request::get('page', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "insert"){
		$boardData = array($title, $content, $userId, $code, date("Y-m-d H:i:s"), $headWord);
		$board->boardInsert($boardData);
	}else if($mode == "modify"){
		$boardData = array("title"=>$title, "content"=>$content, "headWord"=>$headWord, "code"=>$code);
		$whereData = array(":idx" => $idx);
		$board->boardUpadteBoardFront($boardData, $whereData);
	}else if($mode == "delete"){
		$whereData = array(":idx" => $idx);
		$board->boardDeleteFront($whereData, $code);
	}else if($mode == "memoInsert"){
		$memoBeen = array($parentIdx, $userId, $content, date("Y-m-d H:i:s"));
		$board->setBoardMemoInfo($memoBeen, $code);
	}else if($mode == "memoModify"){
		$whereData = array(":idx" => $memoIdx);
		$memoBeen = array($content);
		$board->updateBoardMemoInfo($memoBeen, $whereData, $code, $parentIdx);
	}else if($mode == "memoDelete"){
		$whereData = array(":idx" => $memoIdx);
		$board->deleteBoardMemoInfo($whereData, $code, $parentIdx);
	}
?>