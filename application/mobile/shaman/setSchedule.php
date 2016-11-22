<?	
	$shaman = new Shaman();

	$proIdx = Request::get('proIdx', Request::REQUEST | Request::XSS_CLEAR);
	$resDate = Request::get('resDate', Request::REQUEST | Request::XSS_CLEAR);
	$SHId = Request::get('SHId', Request::REQUEST | Request::XSS_CLEAR);
	$SHIdx = Request::get('SHIdx', Request::REQUEST | Request::XSS_CLEAR);

	$rtnRadio = "<select name=\"bookingTime\" style=\"width:100%;\" onchange=\"setBookingTime()\"><option value=\"\">예약시간 선택</option>";

	if($resDate != "" && $proIdx != ""){
		$shamanData = array(":SHId" => $SHId);
		$rData = $shaman->shamanModifyInfo($shamanData);
		
		$sTimeArray = explode(":", $rData["SHStartTime"]);
		$eTimeArray = explode(":", $rData["SHEndTime"]);
		$SHRestSTime = $rData["SHRestSTime"];
		$SHRestETime = $rData["SHRestETime"];

		$startTime = $sTimeArray[0];
		$startMin = $sTimeArray[1];
		$endTime = $eTimeArray[0];
		$endMin = $eTimeArray[1];

		//$defaultSTime = "10:30";
		//$defaultETime = "11:30";
		
		$sprBeen = array(":idx" => $proIdx);
		$sprData = $shaman->getSprInfoListView2($sprBeen);
		$timeTerm = $sprData["time"];
		$loopTerm = "0";

		$loopCnt = (((strtotime($resDate." ".$endTime.":".$endMin.':59') - strtotime($resDate." ".$startTime.":".$startMin.':00')) / 60) / $timeTerm);
		

		for($i=0; $i < $loopCnt; $i++){
			
			$printStartTime = date("H:i",mktime($startTime,"00"+$loopTerm,date("s"),date("m"),date("d"),date("y")));

			if($i == 0){
				$printEndTime = date("H:i",mktime($startTime,"00"+($timeTerm),date("s"),date("m"),date("d"),date("y")));
			}else{
				$printEndTime = date("H:i",mktime($startTime,"00"+($loopTerm+$timeTerm),date("s"),date("m"),date("d"),date("y")));
			}

			if($printEndTime != "00:00"){
				$limitQuery = "AND (resStartTime < '".$printEndTime."' AND resEndTime >  '".$printStartTime."')";
				$whereBeen = array(":resDate" => $resDate, ":SHIdx" => $SHIdx);
				$resCnt = $shaman->getResCntInfo($whereBeen, $limitQuery);

				if($resCnt == 0){
					if($timeTerm < 180){
						if($SHRestSTime < $printEndTime && $SHRestETime > $printStartTime){
							
						}else{
							$rtnRadio .= "<option value=\"".$printStartTime."|".$printEndTime."\">".$printStartTime."-".$printEndTime."</option>";
						}
					}else{
						$rtnRadio .= "<option value=\"".$printStartTime."|".$printEndTime."\">".$printStartTime."-".$printEndTime."</option>";
					}
				}
			}

			$loopTerm = $loopTerm + $timeTerm;
		}

	}

	$rtnRadio .= "</select>";

	echo $rtnRadio;
?>