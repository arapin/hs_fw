<?
	$shaman = new Shaman();
	$SHId = Request::get('SHId', Request::GET | Request::XSS_CLEAR);

	$shamanData = array(":SHId" => $SHId);
	$rData = $shaman->shamanHomeInfoDaum($shamanData);

	$addressArray = explode(" ",$rData["SHAddress"]);

	$memoList = $shaman->affterMemoList($memoPage, $SHId."_affter", $SHId);

	$scoreData = $shaman->getAffterScore($SHId."_affter");

	$wishBeen = array(":SHIdx" => $rData["idx"], ":userId"=>$_SESSION["USER_ID"]);
	$wishCnt = $shaman->getWishCnt($wishBeen);
	switch($addressArray[0]){
		case "서울특별시" : 
			$getSido = "서울";
			break;
		case "경기도" : 
			$getSido = "경기";
			break;
		case "강원도" : 
			$getSido = "강원";
			break;
		case "충청북도" : 
			$getSido = "충북";
			break;
		case "충청남도" : 
			$getSido = "충남";
			break;
		case "경상북도" : 
			$getSido = "경북";
			break;
		case "경상남도" : 
			$getSido = "경남";
			break;
		case "전라북도" : 
			$getSido = "전북";
			break;
		case "전라남도" : 
			$getSido = "전남";
			break;
		case "제주도" : 
			$getSido = "제주특별자치도";
			break;
		default :
			$getSido = $addressArray[0];
			break;
	}

	$searchArray = array("searchSido" => $getSido, "searchGun" => $addressArray[1]);
	//print_r($searchArray);
	$approachList = $shaman->getApproachSHList($approachPage,"a.idx DESC", $searchArray, $rData["idx"]);

    $profileImage = new Image(".".$rData["viewProfile"]);
    $newWidth = 60;
    $newHeight = 60;
    $profileImage->resize($newWidth, $newHeight, 'crop', 'l', 't');
    $profileImage->save('./tempImg/tempProfileImg_'.$SHId);

    $profileImage2 = new Image(".".$rData["viewProfile"]);
    $newWidth = 100;
    $newHeight = 100;
    $profileImage2->resize($newWidth, $newHeight, 'crop', 'l', 't');
    $profileImage2->save('./tempImg/tempProfileImgBig_'.$SHId);	
?>
<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=<?=MAPAPINUM?>&libraries=services"></script>
<script>
	$(function() {
		$( "#bookingDate" ).datepicker({
			dateFormat: 'yy-mm-dd',
			prevText: '이전 달',
			nextText: '다음 달',
			monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			dayNames: ['일','월','화','수','목','금','토'],
			dayNamesShort: ['일','월','화','수','목','금','토'],
			dayNamesMin: ['일','월','화','수','목','금','토'],
			showMonthAfterYear: true,
			yearSuffix: '년',
			onSelect  : function(dateText){
				getLimitDay(dateText);
				setBookingDate();
			}
		});
		/*
			changeMonth: true,
			changeYear: true,

		*/
		setDaumMap();
		/*$('.slider').sss({
			slideShow : true, // Set to false to prevent SSS from automatically animating.
			startOn : 0, // Slide to display first. Uses array notation (0 = first slide).
			transition : 400, // Length (in milliseconds) of the fade transition.
			speed : 3500, // Slideshow speed in milliseconds.
			showNav : true // Set to false to hide navigation arrows.
		});*/
	});
	
	function viewAffterMemo(){
		document.memoForm.memo.value = '';
		$('#writeAffterMemo').show();
	}

	function closeAffterMemo(){
		$('#writeAffterMemo').hide();
	}

	function memoChk(){
		var form = document.memoForm;

		if(form.memo.value == ""){
			alert('내용을 입력하여 주십시요.');
			return false;
		}

		form.submit();
	}

	function deleteMemo(idx){
		var form = document.memoForm;
		form.mode.value = 'delMemo';
		form.memoIdx.value = idx;
		if(confirm('후기를 삭제 하시겠습니까?')==true){
			form.submit();
		}
	}

	function modifyMemo(idx){
		var form = document.memoForm;
		form.mode.value = 'modifyMemo';
		form.memoIdx.value = idx;
		viewAffterMemo();
		form.memo.value = $('#memo'+idx).val();
	}

	function setProductInfo(){
		var info = $('select[name=proinfo] > option:selected').val();
		var infoArray = info.split('-');
		var bookingPriceText = '￦' + number_format(infoArray[1]);
		var bookingMemCntText = document.reservationForm.memCnt.value + '인';
		var bookingText = bookingPriceText	+ ' X ' + bookingMemCntText;

		document.reservationForm.proIdx.value = infoArray[0];
		document.reservationForm.price.value = infoArray[1];
		document.reservationForm.totalPrice.value = infoArray[1] * document.reservationForm.memCnt.value;
		
		var bookingTotalPriceText = '￦' + number_format(document.reservationForm.price.value * document.reservationForm.memCnt.value);

		$('#bookingInfo').text(bookingText);
		$('#bookingPrice').text(bookingPriceText);
		$('#bookingTotal').text(bookingTotalPriceText);

		setBookingDate()
	}

	function setBookingMem(){
		var info = $('select[name=bookingMem] > option:selected').val();
		document.reservationForm.memCnt.value = info;

		var bookingPriceText = '￦' + number_format(document.reservationForm.price.value);
		var bookingMemCntText = document.reservationForm.memCnt.value + '인';
		var bookingText = bookingPriceText	+ ' X ' + bookingMemCntText;
		
		var bookingTotalPriceText = '￦' + number_format(document.reservationForm.price.value * document.reservationForm.memCnt.value);
		document.reservationForm.totalPrice.value = document.reservationForm.price.value * document.reservationForm.memCnt.value;

		$('#bookingInfo').text(bookingText);
		$('#bookingPrice').text(bookingPriceText);
		$('#bookingMem').text(bookingMemCntText);
		$('#bookingTotal').text(bookingTotalPriceText);
	}

	function setBookingDate(){
		var bookingDate = $('#bookingDate').val();
		//alert(bookingDate);
		document.reservationForm.resDate.value = bookingDate;
		var param =  $("#reservationForm").serialize();
		$.ajax({
			url : '?com=shaman&pro=setSchedule',
			data : param,
			type : 'post',
			success : function(data){
				$('#bookingTime').empty();
				$('#bookingTime').html(data);
			},
			error : function(){
				alert('통신 에러 입니다.');
			}
		});
	}

	function setBookingTime(){
		var info = $('select[name=bookingTime] > option:selected').val();
		var infoArray = info.split('|');
		document.reservationForm.resStartTime.value = infoArray[0];
		document.reservationForm.resEndTime.value = infoArray[1];
	}

	function setReservation(){
		var form = document.reservationForm;

		if(form.proIdx.value == ""){
			alert('상품을 선택하여 주세요.');
			return false;
		}

		if(form.resDate.value == ""){
			alert('예약일자를 선택하여 주세요.');
			return false;
		}

		if(form.resStartTime.value == ""){
			alert('예약시간을 선택하여 주세요.');
			return false;
		}
		
		if(confirm('결제 하시겠습니까?') == true){
			var param =  $("#reservationForm").serialize();
			$.ajax({
				url : '?com=shaman&pro=shamaninfo',
				data : param,
				type : 'post',
				success : function(data){
					var getCode = trim(data);
					if(getCode == "00"){
						alert('예약 되었습니다.');
						location.reload();
					}
				},
				error : function(){
					alert('통신 에러 입니다.');
				}
			});
		}

		//form.submit();
	}

	function setWish(){
		var form = document.wishForm;

		var param =  $("#wishForm").serialize();
		$.ajax({
			url : '?com=shaman&pro=shamaninfo',
			data : param,
			type : 'post',
			success : function(data){
				var getCode = trim(data);
				if(getCode == "00"){
					alert('위시 리스트에 담았습니다.');
					location.reload();
				}
			},
			error : function(){
				alert('통신 에러 입니다.');
			}
		});

		//form.submit();
	}

	function getLimitDay(date){
		var SHIdx = document.reservationForm.SHIdx.value;
		$.ajax({
			url : '?com=shaman&pro=shamaninfo',
			data : {'mode':'limitDayConfirm','SHIdx':SHIdx, 'resDate':date},
			type : 'post',
			success : function(data){
				var getCode = trim(data);
				if(getCode == "L"){
					alert('예약이 불가능 합니다.');
					location.reload();
				}
			},
			error : function(){
				alert('통신 에러 입니다.');
			}
		});
	}

	function goLogin(SHId){
		alert('로그인후 이용하여 주십시요.');
		location.href = '?com=user&lnd=login&SHId='+SHId;
	}

	var map;

	function setDaumMap(){
		var mapContainer = document.getElementById('dvMap'), // 지도를 표시할 div 
		mapOption = { 
			center: new daum.maps.LatLng(<?=$rData["SHLng"]?>,<?=$rData["SHLat"]?>), // 지도의 중심좌표
			level: 5 // 지도의 확대 레벨
		};

		map = new daum.maps.Map(mapContainer, mapOption); //지도 생성 및 객체 리턴

		// 마커가 표시될 위치입니다 
		var markerPosition  = new daum.maps.LatLng(<?=$rData["SHLng"]?>, <?=$rData["SHLat"]?>); 

		// 마커를 생성합니다
		var marker = new daum.maps.Marker({
			position: markerPosition
		});

		// 마커가 지도 위에 표시되도록 설정합니다
		marker.setMap(map);

		// 일반 지도와 스카이뷰로 지도 타입을 전환할 수 있는 지도타입 컨트롤을 생성합니다
		var mapTypeControl = new daum.maps.MapTypeControl();

		// 지도에 컨트롤을 추가해야 지도위에 표시됩니다
		// daum.maps.ControlPosition은 컨트롤이 표시될 위치를 정의하는데 TOPRIGHT는 오른쪽 위를 의미합니다
		map.addControl(mapTypeControl, daum.maps.ControlPosition.TOPRIGHT);

		// 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
		var zoomControl = new daum.maps.ZoomControl();
		map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);

	}
</script>
<style>
.shamanHomeCover {
	cursor: pointer;
    width: 100%;
    height: 700px;
    filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=$rData["shamanMainImg"]?>', sizingMethod='scale');
    background: url(<?=$rData["shamanMainImg"]?>) no-repeat;
    background-size: cover;
    background-position: center;
}
</style>
<form name="reservationForm" id="reservationForm" method="post">
	<input type="hidden" name="SHId" value="<?=$SHId?>" />
	<input type="hidden" name="SHIdx" value="<?=$rData["idx"]?>" />
	<input type="hidden" name="proIdx" value="" />
	<input type="hidden" name="price" value="" />
	<input type="hidden" name="totalPrice" value="" />
	<input type="hidden" name="memCnt" value="1" />
	<input type="hidden" name="resUserId" value="<?=$_SESSION["USER_ID"]?>" />
	<input type="hidden" name="resDate" value="" />
	<input type="hidden" name="resStartTime" value="" />
	<input type="hidden" name="resEndTime" value="" />
	<input type="hidden" name="mode" value="reservation" />
</form>

<form name="wishForm" id="wishForm" method="post">
	<input type="hidden" name="SHIdx" value="<?=$rData["idx"]?>" />
	<input type="hidden" name="resUserId" value="<?=$_SESSION["USER_ID"]?>" />
	<input type="hidden" name="mode" value="wish" />
</form>

	<div class="sview_content_wrap">

        <div class="shamanHomeCover" onclick="showPop()"></div>

        <div id="map1" style="height:210px;">
            <div class="shop_view_content">
                <div class="sv_pic_wrap">
                    <!--<img src="<?=$rData["viewProfile"]?>" alt="" style="width:60px;height:60px;"/>--><?$profileImage->displayHTML()?><br />
                    <?=$rData["name"]?>
                </div>
                <div class="sv_title_wrap">
                    <?=$rData["SHDesc"]?> - <?=$rData["SHName"]?><img src="/images/new.gif" style="margin-left:10px;" alt="new" />

                    <ul class="sv_title_list">
                        <li>
                            <img src="/images/li3.gif" alt="" /><span class="sv_title_txt1">지역명 :</span> <?=$addressArray[1]?>, <?=$addressArray[0]?>, 한국
                        </li>
                        <li>
                            <img src="/images/li3.gif" alt="" /><span class="sv_title_txt1">대표신점 :</span> <?=$rData["productNameInfo"]?>
                        </li>
                        <li>
                            <img src="/images/li3.gif" alt="" /><span class="sv_title_txt1">별점 :</span> <img src="/images/star3.gif" style="margin:0px 4px 0px 2px" alt="" /> <?=$scoreData["totalScore"]?>
                            <img src="/images/li3.gif" style="margin-left:25px;" alt="" /><span class="sv_title_txt1">후기 :</span> <?=$shaman->amTotalCnt?>개
                        </li>
                    </ul>
                </div>
            </div> 
            <div class="sv_book_form">
                <div class="sv_book_cost">
                    <span class="float_left" style="font-size:19px; padding-top:2px;" id="bookingPrice">\0</span>
                    <span class="float_right" style="font-size:14px;" id="bookingMem">1인</span>
                </div>

                <div class="sv_book_wrap">
                    <label>
                        <span style="display:inline-block;width:67px;">신점종류</span>
                        <select style="width:190px;" name="proinfo" onchange="setProductInfo();">
							<option value="">선택</option>
							<?=$rData["productSelect"]?>
						</select>
                    </label>
                    <br />

                    <label>
                        날짜<br />
                        <input type="text" style="width:90px;"  value="" id="bookingDate" name="bookingDate"/>
                        <!--onfocus="$('#calendar').show()" onblur="$('#calendar').hide()" <div id="calendar" style="padding-top:5px; position:absolute; display:none;">
                            <div class="cld_wrap" style=" height:340px;">
                                <img src="/images/box_arrow.gif" style="position: absolute; margin: -21px 0px 0px 20px;" alt="" />

                                <div style="position:absolute;width:280px;">
                                    <input type="image" class="cld_btn float_left" src="/images/cld_prev.gif" alt="이전달" />
                                    <input type="image" class="cld_btn float_right" src="/images/cld_next.gif" alt="다음달" />
                                </div>

                                <table class="cld_skin">
                                    <caption>2015년 10월</caption>
                                    <thead>
                                        <tr>
                                            <th scope="col">일</th>
                                            <th scope="col">월</th>
                                            <th scope="col">화</th>
                                            <th scope="col">수</th>
                                            <th scope="col">목</th>
                                            <th scope="col">금</th>
                                            <th scope="col">토</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href=""></a></td>
                                            <td><a href=""></a></td>
                                            <td><a href=""></a></td>
                                            <td><a href=""></a></td>
                                            <td class="cld_nday cld_yday"><a href="">1</a></td>
                                            <td class="cld_nday cld_yday"><a href="">2</a></td>
                                            <td class="cld_nday cld_yday"><a href="">3</a></td>
                                        </tr>
                                        <tr>
                                            <td class="cld_nday cld_yday"><a href="">4</a></td>
                                            <td class="cld_nday cld_yday"><a href="">5</a></td>
                                            <td class="cld_nday cld_yday"><a href="">6</a></td>
                                            <td class="cld_nday cld_yday"><a href="">7</a></td>
                                            <td class="cld_nday cld_yday"><a href="">8</a></td>
                                            <td class="cld_nday cld_yday"><a href="">9</a></td>
                                            <td class="cld_nday cld_yday"><a href="">10</a></td>
                                        </tr>
                                        <tr>
                                            <td class="cld_nday cld_yday"><a href="">11</a></td>
                                            <td class="cld_nday cld_yday"><a href="">12</a></td>
                                            <td class="cld_nday cld_yday"><a href="">13</a></td>
                                            <td class="cld_nday cld_yday"><a href="">14</a></td>
                                            <td class="cld_nday cld_yday"><a href="">15</a></td>
                                            <td class="cld_nday cld_yday"><a href="">16</a></td>
                                            <td class="cld_nday cld_yday"><a href="">17</a></td>
                                        </tr>
                                        <tr>
                                            <td class="cld_nday cld_yday"><a href="">18</a></td>
                                            <td class="cld_nday cld_yday"><a href="">19</a></td>
                                            <td class="cld_nday"><a href="">20</a></td>
                                            <td class="cld_bday"><a href="">21</a></td>
                                            <td class="cld_normal"><a href="">22</a></td>
                                            <td class="cld_nday"><a href="">23</a></td>
                                            <td class="cld_nday"><a href="">24</a></td>
                                        </tr>
                                        <tr>
                                            <td class="cld_normal"><a href="">25</a></td>
                                            <td class="cld_normal"><a href="">26</a></td>
                                            <td class="cld_normal"><a href="">27</a></td>
                                            <td class="cld_normal"><a href="">28</a></td>
                                            <td class="cld_normal"><a href="">29</a></td>
                                            <td class="cld_normal"><a href="">30</a></td>
                                            <td class="cld_normal"><a href="">31</a></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div style="color:#777; font-size:12px;">
                                    <input type="button" class="cld_btn1 float_left" value="날짜 선택 지우기" />
                                    <span class="float_right" style="padding-top:15px;">2일 전에 어데이트 됨</span>
                                </div>
                            </div>
                        </div>-->
                    </label>

                    <label>
                        시간<br />
						<div id="bookingTime">
                        <select style="width:90px;" name="bookingTime">
                            <option value="">선택</option>
                        </select>
						</div>
                    </label>
                    <label>
                        인원<br />
                        <select style="width:60px;" name="bookingMem" onchange="setBookingMem();">
                            <option value="1">1명</option>
                            <option value="2">2명</option>
                            <option value="3">3명</option>
                        </select>
                    </label>
                    <br />

                    <div class="sv_book_sum" style="width:160px;" id="bookingInfo">
                        \0 X 1인
                    </div><div class="sv_book_sum" style="border-left:none;width:100px; text-align:right;color:#f55;" id="bookingTotal">
                        \0
                    </div>
					<?if($_SESSION["USER_ID"] == ""){?>
                    <button type="button" class="sv_book_btn1" onclick="goLogin('<?=$SHId?>')">예약 하기</button>
                    <button type="button" class="sv_book_btn2" onclick="goLogin('<?=$SHId?>')"><img src="/images/heart_off2.gif" alt="" /> 위시리스트 담기</button>
					<?}else{?>
                    <button type="button" class="sv_book_btn1" onclick="setReservation();">예약 하기</button>
<?if($wishCnt == 0){?>
                    <button type="button" class="sv_book_btn2" onclick="setWish();"><img src="/images/heart_off2.gif" alt=""/> 위시리스트 담기</button>
<?}?>
					<?}?>
                </div>
            </div>
        </div>

        <div id="map2" class="sv_detail_wrap">
            <div class="shop_view_content">
                <h2>상세 설명</h2>
                <?=$rData["SHDesc"]?>
                <dl class="sv_info">
                    <dt>가격</dt>
                    <dd>
                        <ul>
							<?=$rData["productInfo"]?>
                        </ul>
                    </dd>
                    <dt>예약 조건</dt>
                    <dd>
                        <ul>
                            <li>예약수단 : <span class="sv_txt1">인터넷, 모바일</span></li>
                            <li>예약가능시간 : <span class="sv_txt1"><?=$rData["viewOpenTime"]?></span></li>
                        </ul>
                    </dd>
                    <!--<dt>예약 가능 여부</dt>
                    <dd>
                        최소 1일
                    </dd>-->
                </dl>

                <!--<input type="button" onclick="$('#calendar2').toggle()" class="btn_cld" value="달력 보기" />

                <div id="calendar2" style="position:absolute; display:none;margin-left:420px; z-index:999;margin-top:-20px;">
                    <div class="cld_wrap" style=" height:340px;">
                        <img src="/images/box_arrow.gif" style="position: absolute; margin: -21px 0px 0px 240px;" alt="" />

                        <div style="position:absolute;width:280px;">
                            <input type="image" class="cld_btn float_left" src="/images/cld_prev.gif" alt="이전달" />
                            <input type="image" class="cld_btn float_right" src="/images/cld_next.gif" alt="다음달" />
                        </div>

                        <table class="cld_skin">
                            <caption>2015년 10월</caption>
                            <thead>
                                <tr>
                                    <th scope="col">일</th>
                                    <th scope="col">월</th>
                                    <th scope="col">화</th>
                                    <th scope="col">수</th>
                                    <th scope="col">목</th>
                                    <th scope="col">금</th>
                                    <th scope="col">토</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href=""></a></td>
                                    <td><a href=""></a></td>
                                    <td><a href=""></a></td>
                                    <td><a href=""></a></td>
                                    <td class="cld_nday cld_yday"><a href="">1</a></td>
                                    <td class="cld_nday cld_yday"><a href="">2</a></td>
                                    <td class="cld_nday cld_yday"><a href="">3</a></td>
                                </tr>
                                <tr>
                                    <td class="cld_nday cld_yday"><a href="">4</a></td>
                                    <td class="cld_nday cld_yday"><a href="">5</a></td>
                                    <td class="cld_nday cld_yday"><a href="">6</a></td>
                                    <td class="cld_nday cld_yday"><a href="">7</a></td>
                                    <td class="cld_nday cld_yday"><a href="">8</a></td>
                                    <td class="cld_nday cld_yday"><a href="">9</a></td>
                                    <td class="cld_nday cld_yday"><a href="">10</a></td>
                                </tr>
                                <tr>
                                    <td class="cld_nday cld_yday"><a href="">11</a></td>
                                    <td class="cld_nday cld_yday"><a href="">12</a></td>
                                    <td class="cld_nday cld_yday"><a href="">13</a></td>
                                    <td class="cld_nday cld_yday"><a href="">14</a></td>
                                    <td class="cld_nday cld_yday"><a href="">15</a></td>
                                    <td class="cld_nday cld_yday"><a href="">16</a></td>
                                    <td class="cld_nday cld_yday"><a href="">17</a></td>
                                </tr>
                                <tr>
                                    <td class="cld_nday cld_yday"><a href="">18</a></td>
                                    <td class="cld_nday cld_yday"><a href="">19</a></td>
                                    <td class="cld_nday"><a href="">20</a></td>
                                    <td class="cld_bday"><a href="">21</a></td>
                                    <td class="cld_normal"><a href="">22</a></td>
                                    <td class="cld_nday"><a href="">23</a></td>
                                    <td class="cld_nday"><a href="">24</a></td>
                                </tr>
                                <tr>
                                    <td class="cld_normal"><a href="">25</a></td>
                                    <td class="cld_normal"><a href="">26</a></td>
                                    <td class="cld_normal"><a href="">27</a></td>
                                    <td class="cld_normal"><a href="">28</a></td>
                                    <td class="cld_normal"><a href="">29</a></td>
                                    <td class="cld_normal"><a href="">30</a></td>
                                    <td class="cld_normal"><a href="">31</a></td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="color:#777; font-size:12px;">
                            <input type="button" class="cld_btn1 float_left" value="날짜 선택 지우기" />
                            <span class="float_right" style="padding-top:15px;">2일 전에 어데이트 됨</span>
                        </div>
                    </div>
                </div>-->

                <div class="sv_photo_list">
				<?
					$imgCnt = sizeof($rData["shamanImg"]);

					for($i=0; $i < $imgCnt; $i++){

						if($i < 2){
							$mainImg = new Image(".".$rData["shamanImg"][$i]);
							$newWidth = 359;
							$newHeight = 239;
							$mainImg->resize($newWidth, $newHeight, 'crop', 'l', 't');
							$mainImg->save('./tempImg/tempMainImg359_'.$i."_".$SHId);
							$mainImg->displayHTML("","","","","onclick='showPop()'");
							//echo "<img src=\"".$rData["shamanImg"][$i]."\" width=\"359\" height=\"239\" alt=\"\" />";
						}else if($i >= 2 && $i < 4){
							$mainImg = new Image(".".$rData["shamanImg"][$i]);
							$newWidth = 239;
							$newHeight = 159;
							$mainImg->resize($newWidth, $newHeight, 'crop', 'l', 't');
							$mainImg->save('./tempImg/tempMainImg239_'.$i."_".$SHId);
							$mainImg->displayHTML("","","","","onclick='showPop()'");
						}else if($i == 4){
							$mainImg = new Image(".".$rData["shamanImg"][$i]);
							$newWidth = 239;
							$newHeight = 159;
							$mainImg->resize($newWidth, $newHeight, 'crop', 'l', 't');
							$mainImg->save('./tempImg/tempMainImg239_'.$i."_".$SHId);

							echo "
							<div class=\"svp_lst_overlap\">
								";
							$mainImg->displayHTML();
							echo "
								<a href=\"javascript:showPop()\">사진 ".$imgCnt."개 모두보기</a>
							</div>
							";
						}
					}
				?>
                    

                </div>
            </div>
        </div>

        <div id="map3" class="shop_view_content">
            <h2 class="float_left" style="width:182px;margin-top:40px;">후기</h2>

            <div class="float_left review_cnt">
                <span><?=$scoreData["totalScore"]?></span> <img src="/images/star<?=$scoreData["totalScore"]?>.gif" alt="" /> 후기 <?=$shaman->amTotalCnt?>개
            </div>

            <table class="sv_score">
                <tbody>
                    <tr>
                        <th scope="row">정확성</th>
                        <td><?=$scoreData["ppTotalScore"]?> <img src="/images/star<?=$scoreData["ppTotalScore"]?>.gif" alt="" /></td>
                        <th scope="row">위치</th>
                        <td><?=$scoreData["lpTotalScore"]?> <img src="/images/star<?=$scoreData["lpTotalScore"]?>.gif" alt="" /></td>
                    </tr>
                    <tr>
                        <th scope="row">친절도</th>
                        <td><?=$scoreData["spTotalScore"]?> <img src="/images/star<?=$scoreData["spTotalScore"]?>.gif" alt="" /></td>
                        <th scope="row">가격</th>
                        <td><?=$scoreData["prpTotalScore"]?> <img src="/images/star<?=$scoreData["prpTotalScore"]?>.gif" alt="" /></td>
                    </tr>
                </tbody>
            </table>

            <!--<input type="button" class="btn_change_kor" value="후기 한국어로 번역하기" />-->

            <ul class="l_style_none sv_review_list">
				<?=$memoList;?>
                <!--<li>
                    <div class="sv_review_pic">
                        <img src="/html/sample/svp1.jpg" alt="" /><br />영희
                    </div>
                    <div class="sv_review_txt">
                        <p class="sv_review_txt2">
                            점집 분위기는 아늑하고 아주 깔끔해서 좋았습니다.<br />
                            질문을 하면 답변을 상세하고 조목조목 알려주셨고 예방하는 방법까지 알려주셨습니다.<br />
                            다음에는 지인과 다시한번 방문해보고 싶어요~
                        </p>
                        <div class="sv_review_date">2015년 10월</div>
                        <div class="float_right">
                            <button type="button" class="btn_review"><img src="/images/recommend.gif" alt="" />추천</button>
                            <button type="button" class="btn_review">수정</button>
                            <button type="button" class="btn_review">삭제</button>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="sv_review_pic">
                        <img src="/html/sample/svp2.jpg" alt="" /><br />철수
                    </div>
                    <div class="sv_review_txt">
                        <p class="sv_review_txt2">
                            점 잘보고 갑니다.
                        </p>
                        <div class="sv_review_date">2015년 09월</div>
                        <div class="float_right">
                            <button type="button" class="btn_review"><img src="/images/recommend.gif" alt="" />추천</button>
                            <button type="button" class="btn_review">수정</button>
                            <button type="button" class="btn_review">삭제</button>
                        </div>
                    </div>
                </li>-->
            </ul>
			<?if($_SESSION["USER_ID"] != ""){?>
            <input type="button" class="btn_review_write float_right" value="후기 쓰기" onclick="viewAffterMemo();"/>
			
			<div id="writeAffterMemo" style="display:none;">
				<form name="memoForm" method="post" action="?com=shaman&pro=shamaninfo">
				<input type="hidden" name="mode" value="afftermemoinsert"/>
				<input type="hidden" name="userId" value="<?=$_SESSION["USER_ID"]?>"/>
				<input type="hidden" name="code" value="<?=$SHId?>_affter"/>
				<input type="hidden" name="SHId" value="<?=$SHId?>"/>
				<input type="hidden" name="memoIdx" value=""/>

				<ul class="score_list">
					<li>
						<span>정확성</span>
						<label><input type="radio" name="pointerP" value="5"/><img src="/images/score5.gif" alt="5점" /></label>
						<label><input type="radio" name="pointerP" value="4" /><img src="/images/score4.gif" alt="4점" /></label>
						<label><input type="radio" name="pointerP" value="3" /><img src="/images/score3.gif" alt="3점" /></label>
						<label><input type="radio" name="pointerP" value="2" /><img src="/images/score2.gif" alt="2점" /></label>
						<label><input type="radio" name="pointerP" value="1" /><img src="/images/score1.gif" alt="1점" /></label>
					</li>
					<li>
						<span>친절도</span>
						<label><input type="radio" name="serviceP" value="5" /><img src="/images/score5.gif" alt="5점" /></label>
						<label><input type="radio" name="serviceP" value="4" /><img src="/images/score4.gif" alt="4점" /></label>
						<label><input type="radio" name="serviceP" value="3" /><img src="/images/score3.gif" alt="3점" /></label>
						<label><input type="radio" name="serviceP" value="2" /><img src="/images/score2.gif" alt="2점" /></label>
						<label><input type="radio" name="serviceP" value="1" /><img src="/images/score1.gif" alt="1점" /></label>
					</li>
					<li>
						<span>위치</span>
						<label><input type="radio" name="locationP" value="5" /><img src="/images/score5.gif" alt="5점" /></label>
						<label><input type="radio" name="locationP" value="4" /><img src="/images/score4.gif" alt="4점" /></label>
						<label><input type="radio" name="locationP" value="3" /><img src="/images/score3.gif" alt="3점" /></label>
						<label><input type="radio" name="locationP" value="2" /><img src="/images/score2.gif" alt="2점" /></label>
						<label><input type="radio" name="locationP" value="1" /><img src="/images/score1.gif" alt="1점" /></label>
					</li>
					<li>
						<span>가격</span>
						<label><input type="radio" name="priceP" value="5" /><img src="/images/score5.gif" alt="5점" /></label>
						<label><input type="radio" name="priceP" value="4" /><img src="/images/score4.gif" alt="4점" /></label>
						<label><input type="radio" name="priceP" value="3" /><img src="/images/score3.gif" alt="3점" /></label>
						<label><input type="radio" name="priceP" value="2" /><img src="/images/score2.gif" alt="2점" /></label>
						<label><input type="radio" name="priceP" value="1" /><img src="/images/score1.gif" alt="1점" /></label>
					</li>
				</ul>

				<textarea class="sv_textarea" name="memo"></textarea>

				<div style="text-align:center;border-bottom:1px solid #ddd">
					<input type="button" class="sv_btn1" value="작성 완료" onclick="memoChk();"/><input type="button" class="sv_btn2" value="취소" onclick="closeAffterMemo()"/>
				</div>
				</form>
			</div>
			<?}?>

			<div class="paging_wrap" style="text-align:center;padding:5px 0px 35px 0px;">
				<?=$shaman->memoPageView?>
			</div>
        </div>

        <div id="map4" class="sv_detail_wrap" style="padding-top:10px; padding-bottom:29px;">
            <div class="shop_view_content" style="border-bottom:1px solid #ccc; padding-bottom:15px;">
                <h2 style="margin-bottom:24px;"><?=$rData["name"]?> 선생님 알림장</h2>

                <div class="sv_review_pic" style="margin:0px;padding:0px;text-align:center; width:155px;">
                    <!--<img src="<?=$rData["viewProfile"]?>" style="width:100px; height:100px; border-radius:50px;" alt="" />--><?$profileImage2->displayHTML()?>
                </div>
                <div class="sv_review_txt">
                    <?=nl2br($rData["SHWord"])?>

                    <div style="color:#888;margin:30px 0px 3px 0px; overflow:auto;">
                        <div class="float_left" style="width:240px;">
                            지역 : <?=$addressArray[1]?>, <?=$addressArray[0]?>, 한국<br />
                            회원가입 : <?=$rData["viewRegDate"]?>
                        </div>
                        <div class="float_right" style="width:240px;">
                            응답률 : 100%<br />
                            응답 시간 : 1시간 이내
                        </div>
                    </div>

                    <!--<input type="button" class="btn_review_write" style="height:30px; line-height:30px; padding:0px 20px;"  value="선생님에게 연락하기" />-->
                </div>
            </div>

            <div class="shop_view_content sv_mark">
                <div style="width: 175px; color:#888;">신뢰도</div>
                <div style="width: 195px;"><img style="margin:0px 4px 3px 0px;" src="/images/star<?=$scoreData["totalScore"]?>.gif" alt="" /> 후기 <?=$shaman->amTotalCnt?>개</div>
                <div>
					<?if($rData["SHApply"] == "Y"){?>
					<img style="margin-right:20px;" src="/images/certify.gif" alt="" />인증완료
					<?}?>
				</div>
            </div>

            <div id="map5" style="margin-top:50px;">
                <!-- 지도 -->
				<div id="dvMap" style="width:100%; height:650px;"></div>
            </div>

            <div id="map6" class="shop_view_content2">
                <h2>비슷한 점집</h2>
                <ul class=" l_style_inline search_plist" style="width:1080px;">
					<?=$approachList?>
                </ul>

                <!--

	                <input type="button" class="btn_shop_more" value="점집 더보기" />
					<div class="search_more_link" style="border-color:#ccc;">
                    <h2 style="margin:5px 0px 22px 0px;">다른 옵션 살펴보기</h2>
                    <div style="position:absolute;">신점 유형 더보기 :</div>
                    <div style="padding:0px 0px 15px 105px;width:100%;box-sizing:border-box;">
                        <a href="">애정</a> ·
                        <a href="">궁합</a> ·
                        <a href="">사업</a> ·
                        <a href="">재물</a> ·
                        <a href="">사주</a> ·
                        <a href="">취업</a> ·
                        <a href="">해몽</a> ·
                        <a href="">이사</a> ·
                        <a href="">풍수</a> ·
                        <a href="">결혼</a> ·
                        <a href="">택일</a> ·
                        <a href="">작명</a> ·
                        <a href="">개명</a> ·
                        <a href="">시험</a> ·
                        <a href="">가족</a> ·
                        <a href="">건강</a>
                    </div>
                    <a style="color:#333;" href="">한국</a> ·<a href="">서울</a> ·<a href="">제주</a> ·<a href="">부산</a> ·<a href="">광주</a>
                </div>-->

            </div>
			<div class="paging_wrap">
				<?=$shaman->pageView?>
			</div>
        </div>

    </div>
