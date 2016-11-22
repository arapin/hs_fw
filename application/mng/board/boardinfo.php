<?
	$board = new Board();

	$headWord	= Request::get('headWord', Request::POST | Request::XSS_CLEAR);
	$title		= Request::get('title', Request::POST | Request::XSS_CLEAR);
	$content	= Request::get('content', Request::POST);
	$userId		= Request::get('userId', Request::POST | Request::XSS_CLEAR);
	$code		= Request::get('code', Request::REQUEST | Request::XSS_CLEAR);
	$idx		= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$mode		= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);
	$page		= Request::get('page', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "insert"){
		$boardData = array($title, $content, $userId, $code, date("Y-m-d H:i:s"), $headWord);
		$board->boardInsertMng($boardData);
	}else if($mode == "modify"){
		$boardData = array($title, $content, $code, $headWord);
		$whereData = array(":idx" => $idx);
		$board->boardUpadteBoardMng($boardData, $whereData);
	}else if($mode == "delete"){
		$whereData = array(":idx" => $idx);
		$board->boardDeleteMng($whereData, $code);
	}else if($mode == "getMoreList"){
	}
?>