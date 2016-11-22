<?
	$user = new User();

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

	if($mode == "join"){
		$userData = array(strtolower($id), $pwd, $email, date("Y-m-d H:i:s"),$birthday, $birthdayType, $birthdayTime, $zipcode, $address, $address2, $name, $nameCH, $phone);
		$user->userInsert($userData);

	}else if($mode == "modify"){
		$userData = array($email, $birthday, $birthdayType, $birthdayTime, $zipcode, $address, $address2, $name, $nameCH, $phone);
		$whereData = array(":id" => $id);

		$user->userModify($userData,$whereData );

	}else if($mode == "outMember"){
		$userData = array($id, $name, $outType, $outTypeEtc, date("Y-m-d H:i:s"));
		$whereData = array(":id" => $id);

		$user->userDelete($userData, $whereData);
	}else if($mode == "idCheck"){

		$checkCode = $user->userIdCheck($id);
		echo $checkCode;

	}else if($mode == "auth"){
		if($setAuthNum == $_COOKIE["authNum"]){
			echo "00";
		}else{
			echo "99";
		}
	}else if($mode == "idSearch"){
		$whereBeen = array(":name" => $name, ":email" => $email);
		echo $user->userIdSearch($whereBeen);
	}else if($mode == "pwdSearch"){
		$whereBeen = array(":name" => $name, ":email" => $email, ":id"=>$id);
		echo $user->userPwdSearch($whereBeen);
	}
?>