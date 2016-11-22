<?
error_reporting(E_ALL);
ini_set("display_errors", 1);
	$mng = new Mng();

	$id = Request::get('id', Request::POST | Request::XSS_CLEAR);
	$pwd = Request::get('pwd', Request::POST | Request::XSS_CLEAR);

	$mngData = array(":mngId" => $id);
	$loginData = array("mngId" => $id, "mngPwd" => $pwd);
	//echo $id;
	$mng->mngLogin($mngData, $loginData);
?>