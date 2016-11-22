<?
	$user = new User();

	$id		= Request::get('id', Request::REQUEST | Request::XSS_CLEAR);
	$pwd	= Request::get('pwd', Request::POST | Request::XSS_CLEAR);
	$email	= Request::get('email', Request::POST | Request::XSS_CLEAR);
	$name	= Request::get('name', Request::POST | Request::XSS_CLEAR);
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

	$mode	= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "join"){

		$userData = array($id, $pwd, $email, date("Y-m-d H:i:s"),$birthday, $birthdayType, $birthdayTime, $zipcode, $address, $address2, $name, $nameCH, $phone);
		$user->userInsertMng($userData);

	}else if($mode == "modify"){

		$userData = array($email, $birthday, $birthdayType, $birthdayTime, $zipcode, $address, $address2, $name, $nameCH, $phone);
		$whereData = array(":id" => $id);

		$user->userModifyMng($userData,$whereData );

	}else if($mode == "delete"){

		$whereData = array(":id" => $id);

		$user->userDeleteMng($whereData );

	}else if($mode == "idCheck"){

		$checkCode = $user->userIdCheck($id);
		echo $checkCode;

	}
?>