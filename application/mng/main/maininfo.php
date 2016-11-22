<?
	$main = new Main();

	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$mode	= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);
	$url	= Request::get('url', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "mainLocation"){
		$main->mainLocationImg($idx, $_FILES["mainImg"]);
	}else if($mode == "mainBig"){
		$main->mainBigImg($idx, $_FILES["mainImg"]);
	}else if($mode == "mainMiddle"){
		$main->mainMiddleImg($idx, $_FILES["mainMiddle"]);
	}else if($mode == "mainMovie"){
		$setBeen = array($url);
		$whereBeen = array(":idx" => $idx);
		$main->mainMovieUpdate($setBeen, $whereBeen);
	}
?>