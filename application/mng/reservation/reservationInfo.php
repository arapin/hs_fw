<?
	$reservation = new Reservation();

	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$mode	= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "join"){

	}else if($mode == "modify"){

	}else if($mode == "cancel"){
		$whereData = array(":idx" => $idx);
		$reservation->reservationInfoCancel($whereData);
	}
?>