<?
	$main = new Main();

	$seq		= Request::get('seq', Request::REQUEST | Request::XSS_CLEAR);
	$mode	= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);


	if($mode == "mainBig"){
		$getBeen = array(":seq" => $seq);

		echo $main->getMainBigImg($getBeen);
		//echo "111";
	}else if($mode == "mainMiddle"){
		$getBeen = array(":seq" => $seq);

		echo $main->getMainMiddleImg($getBeen);
		//echo "111";
	}
?>