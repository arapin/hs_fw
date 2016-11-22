<?
	$affterMemo = new AffterMemo();

	$idx		= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$mode		= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "insert"){
		$boardData = array($title, $content, $userId, $code, date("Y-m-d H:i:s"));
		$board->boardInsertMng($boardData);
	}else if($mode == "modify"){
		$boardData = array($title, $content, $code);
		$whereData = array(":idx" => $idx);
		$board->boardUpadteBoardMng($boardData, $whereData);
	}else if($mode == "delete"){
		$whereData = array(":idx" => $idx);
		$affterMemo->affterMemoDelete($whereData);
	}else if($mode == "getMoreList"){
	}
?>