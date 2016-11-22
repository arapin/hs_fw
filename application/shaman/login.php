<?
	$shaman = new Shaman();

	$id = Request::get('id', Request::POST | Request::XSS_CLEAR);
	$pwd = Request::get('pwd', Request::POST | Request::XSS_CLEAR);

	$shamanData = array(":SHId" => $id);
	$loginData = array("id" => $id, "pwd" => $pwd);
	$shaman->shamanLogin($shamanData, $loginData);
?>