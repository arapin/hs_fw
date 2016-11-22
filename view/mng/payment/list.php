<?
	$payment = new Payment();

	$searchPayState = Request::get('searchPayState', Request::REQUEST | Request::XSS_CLEAR);
	$searchPayType = Request::get('searchPayType', Request::REQUEST | Request::XSS_CLEAR);
	$startDate = Request::get('startDate', Request::REQUEST | Request::XSS_CLEAR);
	$endDate = Request::get('endDate', Request::REQUEST | Request::XSS_CLEAR);
	$searchWord = Request::get('searchWord', Request::REQUEST | Request::XSS_CLEAR);
	$SHIdx = Request::get('SHIdx', Request::REQUEST | Request::XSS_CLEAR);
	
	$search = array();

	if($searchPayState != ""){
		$search["searchPayState"] = $searchPayState;
	}

	if($searchPayType != ""){
		$search["searchPayType"] = $searchPayType;
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

	$rtnList = $payment->paymentMngList($page,"a.idx DESC", $search);
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
					<li>결제 관리</li>
				</ul>
				<!--<a href="#" class="btn right" onclick="location.href='?com=shaman&lnd=write&mng=Y'"><i class="fa fa-caret-square-o-left"></i>등록</a>-->
			</div>
<form name="searchForm" method="post" action="?com=payment&lnd=list&mng=Y">
			<div class="breadcrumbs clearfix">
				<span style="color:#FFFFFF;">결제상태 : </span>
				<select name="searchPayState">
					<option value="">선택</option>
					<option value="W" <?if($searchPayState == "W"){?>selected<?}?>>결제대기</option>
					<option value="I" <?if($searchPayState == "I"){?>selected<?}?>>결제완료</option>
					<option value="C" <?if($searchPayState == "C"){?>selected<?}?>>결제취소</option>
				</select>
				<span style="color:#FFFFFF;">결제구분 : </span>
				<select name="searchPayType">
					<option value="">선택</option>
					<option value="C" <?if($searchPayType == "C"){?>selected<?}?>>신용카드</option>
					<option value="O" <?if($searchPayType == "O"){?>selected<?}?>>실시간 계좌이체</option>
					<option value="M" <?if($searchPayType == "M"){?>selected<?}?>>휴대폰</option>
					<option value="B" <?if($searchPayType == "B"){?>selected<?}?>>무통장</option>
				</select>
				<span style="color:#FFFFFF;">결제일 : </span>
				<input type="text" id="startDate" name="startDate" value="<?=$startDate?>" style="width:80px;"/> <span style="color:#FFFFFF;">~</span> 
				<input type="text" id="endDate" name="endDate" value="<?=$endDate?>" style="width:80px;"/>
				<span style="color:#FFFFFF;">결제자 : </span>
				<input type="text" value="<?=$searchWord?>" name="searchWord"/>
				<input type="button" value="검색" onclick="searchChk();"/>
			</div>
</form>
			<div class="tables clearfix">
				<table class="datatable adm-table">
					<thead>
						<tr>
							<th>순번</th>
							<th>결제상품<span class="order"></span></th>
							<th>결제구분<span class="order"></span></th>
							<th>결제자<span class="order"></span></th>
							<th>결제일</th>
							<th>등록일<span class="order"></span></th>
							<th>결제상태</th>
							<th>ACTIONS</th>
						</tr>
					</thead>
					<tbody>
						<?=$rtnList?>
					</tbody>
				</table>
			</div>