<?
	$reservation = new Reservation();

	$searchPayState = Request::get('searchPayState', Request::REQUEST | Request::XSS_CLEAR);
	$startDate = Request::get('startDate', Request::REQUEST | Request::XSS_CLEAR);
	$endDate = Request::get('endDate', Request::REQUEST | Request::XSS_CLEAR);
	$searchWord = Request::get('searchWord', Request::REQUEST | Request::XSS_CLEAR);

	$search = array();

	if($searchPayState != ""){
		$search["searchPayState"] = $searchPayState;
	}

	if($startDate != ""){
		$search["startDate"] = $startDate;
	}

	if($endDate != ""){
		$search["endDate"] = $endDate;
	}

	if($searchWord != ""){
		$search["searchWord"] = $searchWord;
	}

	if($SHIdx != ""){
		$search["SHIdx"] = $SHIdx;
	}

	$rtnList = $reservation->reservationMngList($page,"idx DESC", $search);
?>
<script>
	$(function() {
		$( "#startDate" ).datepicker({
			dateFormat: 'yy-mm-dd',
			prevText: '이전 달',
			nextText: '다음 달',
			monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			dayNames: ['일','월','화','수','목','금','토'],
			dayNamesShort: ['일','월','화','수','목','금','토'],
			dayNamesMin: ['일','월','화','수','목','금','토'],
			showMonthAfterYear: true,
			yearSuffix: '년'
		});

		$( "#endDate" ).datepicker({
			dateFormat: 'yy-mm-dd',
			prevText: '이전 달',
			nextText: '다음 달',
			monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			dayNames: ['일','월','화','수','목','금','토'],
			dayNamesShort: ['일','월','화','수','목','금','토'],
			dayNamesMin: ['일','월','화','수','목','금','토'],
			showMonthAfterYear: true,
			yearSuffix: '년'
		});
	});
</script>
			<div class="breadcrumbs clearfix">
				<ul class="breadcrumbs left">
					<li><a href="#">SAN SIN GAK ADMIN</a></li>
					<li><i class="fa fa-angle-right"></i></li>
					<li>예약 관리</li>
				</ul>
				<!--<a href="#" class="btn right" onclick="location.href='?com=shaman&lnd=write&mng=Y'"><i class="fa fa-caret-square-o-left"></i>등록</a>-->
			</div>

<form name="searchForm" method="post" action="?com=reservation&lnd=list&mng=Y">
			<div class="breadcrumbs clearfix">
				<span style="color:#FFFFFF;">예약상태 : </span>
				<select name="searchPayState">
					<option value="">선택</option>
					<option value="W" <?if($searchPayState == "W"){?>selected<?}?>>예약대기</option>
					<option value="U" <?if($searchPayState == "U"){?>selected<?}?>>예약완료</option>
					<option value="C" <?if($searchPayState == "C"){?>selected<?}?>>예약취소</option>
				</select>
				<span style="color:#FFFFFF;">예약일 : </span>
				<input type="text" id="startDate" name="startDate" value="<?=$startDate?>" style="width:80px;"/> <span style="color:#FFFFFF;">~</span> 
				<input type="text" id="endDate" name="endDate" value="<?=$endDate?>" style="width:80px;"/>
				<span style="color:#FFFFFF;">예약자 : </span>
				<input type="text" value="<?=$searchWord?>" name="searchWord"/>
				<input type="button" value="검색" onclick="searchChk();"/>
			</div>
</form>

			<div class="tables clearfix">
				<table class="datatable adm-table">
					<thead>
						<tr>
							<th>순번</th>
							<th>예약자<span class="order"></span></th>
							<th>상품명<span class="order"></span></th>
							<th>점집이름<span class="order"></span></th>
							<th>예약일<span class="order"></span></th>
							<th>예약시간</th>
							<th>등록일<span class="order"></span></th>
							<th>상태</th>
							<th>ACTIONS</th>
						</tr>
					</thead>
					<tbody>
						<?=$rtnList?>
					</tbody>
				</table>
			</div>