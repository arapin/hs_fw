<?
	$user = new User();

	$id = Request::get('id', Request::POST | Request::XSS_CLEAR);
	$pwd = Request::get('pwd', Request::POST | Request::XSS_CLEAR);
	$SHId = Request::get('SHId', Request::POST | Request::XSS_CLEAR);

	$userData = array(":id" => $id);
	$loginData = array("id" => $id, "pwd" => $pwd);

	$user->userLogin($userData, $loginData, $SHId);
?>