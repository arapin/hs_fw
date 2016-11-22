<?
	$calc = new Calc();

	$mode = Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);
	$idx = Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$year = Request::get('year', Request::REQUEST | Request::XSS_CLEAR);
	$month = Request::get('month', Request::REQUEST | Request::XSS_CLEAR);
	
	if($mode == ""){
		$year = date("Y");
		$month = date("m");
		$nowDate = date("Y-m-d");
		$calcFristDay = $year.$month.CALCDAY;

		$newDate = date("Y-m-d", strtotime($calcFristDay)); 
		$time = strtotime($newDate); 
		$calcLastDay = date("Y-m-d", strtotime("+2 week", $time));
		$calcYear = date("Y", strtotime("-1 month", $time));
		$calcMonth = date("m", strtotime("-1 month", $time));

		if($newDate <= $nowDate && $calcLastDay > $nowDate){
			$setBeen = array(":year" => $calcYear, ":month" => $calcMonth);
			$calc->setCalcInfo($setBeen);
		}
	}else if($mode == "calcCheck"){
		$getBeen = array(":idx"=>$idx);
		$setBeen = array("Y");
		$calc->setCalcUpdate($getBeen, $setBeen, $year, $month);
	}
?>