<?
	$calc = new Calc();

	$searchYear = Request::get('searchYear', Request::REQUEST | Request::XSS_CLEAR);
	$searchMonth = Request::get('searchMonth', Request::REQUEST | Request::XSS_CLEAR);

	//$rtnList = $user->userListMng($page,"idx DESC");
	$year = date("Y");
	$month = date("m");
	$nowDate = date("Y-m-d");
	$calcFristDay = $year.$month.CALCDAY;

	$newDate = date("Y-m-d", strtotime($calcFristDay)); 
	$time = strtotime($newDate); 
	$calcLastDay = date("Y-m-d", strtotime("+2 week", $time));
	$calcYear = date("Y", strtotime("-1 month", $time));
	$calcMonth = date("m", strtotime("-1 month", $time));

	if($searchYear == ""){
		$searchYear = $calcYear;
	}

	if($searchMonth == ""){
		$searchMonth = $calcMonth;
	}
	
	$getBeen = array(":year" => $searchYear, ":month" => $searchMonth);
	$rtnList = $calc->getCalcList($getBeen,"idx DESC");

	$calcCnt = $calc->getCalcResultInfo($getBeen);
?>
			<div class="breadcrumbs clearfix">
				<ul class="breadcrumbs left">
					<li><a href="#">SAN SIN GAK ADMIN</a></li>
					<li><i class="fa fa-angle-right"></i></li>
					<li>정산 관리</li>
				</ul>
				<?
					if($newDate <= $nowDate && $calcLastDay > $nowDate){
						if($calcCnt == 0){
				?>
					<a href="#" class="btn right" onclick="location.href='?com=calc&pro=calcinfo&mng=Y'"><i class="fa fa-caret-square-o-left"></i><?=$calcYear?>년 <?=$calcMonth?>월 정산</a>
				<?
						}else{
				?>
					<a href="#" class="btn right" ><i class="fa fa-caret-square-o-left"></i><?=$calcYear?>년 <?=$calcMonth?>월은 이미 정산이 끝났습니다.</a>
				<?
						}
					}
				?>
			</div>
			<div class="breadcrumbs clearfix">
<form name="searchForm" method="post" action="?com=calc&lnd=list&mng=Y">
				<select name="searchYear">
<?
	$limitYear = 2026;
	for($i="2015"; $i <= $limitYear; $i++){
		if($searchYear == $i) $selected = "selected=\"selected\"";
		else $selected = "";

		echo "<option value=\"".$i."\" ".$selected.">".$i."년</option>";
	}
?>
				</select><span style="color:#FFFFFF;font-weight:bold;">년</span> &nbsp;&nbsp;
				<select name="searchMonth">
					<option value="01" <?if($searchMonth == "01"){?>selected<?}?>>1</option>
					<option value="02" <?if($searchMonth == "02"){?>selected<?}?>>2</option>
					<option value="03" <?if($searchMonth == "03"){?>selected<?}?>>3</option>
					<option value="04" <?if($searchMonth == "04"){?>selected<?}?>>4</option>
					<option value="05" <?if($searchMonth == "05"){?>selected<?}?>>5</option>
					<option value="06" <?if($searchMonth == "06"){?>selected<?}?>>6</option>
					<option value="07" <?if($searchMonth == "07"){?>selected<?}?>>7</option>
					<option value="08" <?if($searchMonth == "08"){?>selected<?}?>>8</option>
					<option value="09" <?if($searchMonth == "09"){?>selected<?}?>>9</option>
					<option value="10" <?if($searchMonth == "10"){?>selected<?}?>>10</option>
					<option value="11" <?if($searchMonth == "11"){?>selected<?}?>>11</option>
					<option value="12" <?if($searchMonth == "12"){?>selected<?}?>>12</option>
				</select><span style="color:#FFFFFF;font-weight:bold;">월</span>
				<input type="button" value="정산내역 보기" onclick="searchForm.submit();"/>
</form>
			</div>
			<div class="tables clearfix">
				<table class="datatable adm-table">
					<thead>
						<tr>
							<th>순번</th>
							<th>년도</th>
							<th>월<span class="order"></span></th>
							<th>무속인명<span class="order"></span></th>
							<th>정산금액<span class="order"></span></th>
							<th>정산결제건수<span class="order"></span></th>
							<th>지급상태<span class="order"></span></th>
							<th>정산일<span class="order"></span></th>
							<th>지급체크<span class="order"></span></th>
						</tr>
					</thead>
					<tbody>
						<?=$rtnList?>
					</tbody>
				</table>
			</div>