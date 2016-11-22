<?
	$shaman = new Shaman();
	$shamanProductList = $shaman->getProductInfoList();

	$searchSido = Request::get('searchSido', Request::GET | Request::XSS_CLEAR);
	$searchDate = Request::get('searchDate', Request::GET | Request::XSS_CLEAR);

	if($searchWord == ""){
		if($searchSido == ""){
			$searchSido = "서울특별시";
		}
	}
?>
<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=<?=MAPAPINUM?>&libraries=services"></script>
<style type="text/css">
   .makerTitle { background-color:#d1d1d1; font-family: Arial; font-size: 12px; font-weight: bold; text-align: center;}
   .makerContent { background-color:#e7d2ff; font-family: Arial; font-size: 11px;}
	a:link     {color:#000000;text-decoration:none}
	a:visited  {color:#000000;text-decoration:none}
	a:active   {color:#000000;text-decoration:none}
	a:hover    {color:#000000;text-decoration:none}
</style>
<script type="text/javascript">
	$(function() {
		$( "#bookingDate" ).datepicker({
			changeMonth: true,
			changeYear: true,
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
			beforeShow: function() {
				setTimeout(function(){
					$('.ui-datepicker').css('z-index', 99999999999999);
				}, 0);
			}
		});

		$( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: 200000,
			values: [ 0, 100000 ],
			slide: function( event, ui ) {
				$( "#amount" ).val( "￦" + number_format(ui.values[ 0 ]) + " - ￦ " + number_format(ui.values[ 1 ] ));
				document.searchForm.sPrice.value = ui.values[ 0 ];
				document.searchForm.ePrice.value = ui.values[ 1 ];
			}
		});
		$( "#amount" ).val( " ￦ " + number_format($( "#slider-range" ).slider( "values", 0 )) +
		" - ￦ " + number_format($( "#slider-range" ).slider( "values", 1 )) );

		setDepthTwoAddress();
		getList();

<?if($searchSido != "" || $searchWord != ""){?>
		setTimeout(function() {
			setDaumMap();
		}, 500);
<?}else{?>
		setTimeout(function() {
			setDaumMap();
		}, 500);
<?}?>

	});

function getList(){
	var param = $("#searchForm").serialize();
	//console.log( document.searchForm.searchSido.value );
	//console.log( document.searchForm.searchGun.value );

	$.ajax({
		url : '/view/searchList.php',
		data : param,
		type : 'post',
		async:false,
		success : function(data){
			$('#searchValue').html(data);
		},
		error : function(){
			alert('통신 에러 입니다.');
		}
	});
}

function getMarkers(){
	var param = $("#searchForm").serialize().replace(/%/g,'%25');
	var returnData = "";
	$.ajax({
		url : '?com=shaman&pro=searchMarker',
		data : param,
		type : 'post',
		async:false,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
		dataType: "text",
		success : function(data){
			returnData = data;
		},
		error : function(){
			alert('통신 에러 입니다.');
		}
	});

	return returnData;
}

function getGeoLocationTranse(address){
	var latLng = '';
	$.ajax({
		url : '?com=shaman&pro=getGeoAddress',
		type : 'post',
		async:false,
		data : {'address':address},
		success : function(data){
			latLng = trim(data);
		}
	});

	return latLng;
}

var map;

function setDaumMap(){
	var address = $('select[name=depthOneArea] > option:selected').val() + ' ' + $('select[name=depthTwoArea] > option:selected').val();
	var latLng = getGeoLocationTranse(address);
	var latLngArry = latLng.split('|');

	var mapContainer = document.getElementById('dvMap'), // 지도를 표시할 div 
    mapOption = { 
        center: new daum.maps.LatLng(latLngArry[0], latLngArry[1]), // 지도의 중심좌표
        level: 5 // 지도의 확대 레벨
    };

	map = new daum.maps.Map(mapContainer, mapOption); //지도 생성 및 객체 리턴

	// 일반 지도와 스카이뷰로 지도 타입을 전환할 수 있는 지도타입 컨트롤을 생성합니다
	var mapTypeControl = new daum.maps.MapTypeControl();

	// 지도에 컨트롤을 추가해야 지도위에 표시됩니다
	// daum.maps.ControlPosition은 컨트롤이 표시될 위치를 정의하는데 TOPRIGHT는 오른쪽 위를 의미합니다
	map.addControl(mapTypeControl, daum.maps.ControlPosition.TOPRIGHT);

	// 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
	var zoomControl = new daum.maps.ZoomControl();
	map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);

	setMarkers();

	// 현재 지도 중심좌표로 주소를 검색해서 셀렉트박스를 선택합니다.
	searchAddrFromCoords(map.getCenter(), setCenterChange);

	// 중심 좌표나 확대 수준이 변경됐을 때 지도 중심 좌표에 대한 주소 정보를 표시하도록 이벤트를 등록합니다
	daum.maps.event.addListener(map, 'idle', function() {
		searchAddrFromCoords(map.getCenter(), setCenterChange);

	});
}

function searchAddrFromCoords(coords, callback) {
	// 주소-좌표 변환 객체를 생성합니다
	var geocoder = new daum.maps.services.Geocoder();

	// 좌표로 행정동 주소 정보를 요청합니다
	geocoder.coord2addr(coords, callback);         
}

function setCenterChange(status, result){
    if (status === daum.maps.services.Status.OK) {
		var arrayAddress = result[0].fullName.split(' ');
		var selectedBol = false;
		$('select[name=depthOneArea] > option').each(function () {
			if ($.trim($(this).text()) == $.trim(arrayAddress[0])) {
				$(this).prop('selected', true);
			}
		});

		setDepthTwoAddress(function () {		
			setArea = arrayAddress[1];
			var Objs = $('select[name=depthTwoArea] option');
			for(i=0;i<Objs.length;i++){
				if(Objs.eq(i).val() == setArea){
					selectedBol = true;
				}
			}
			
			if(!selectedBol){
				setArea = arrayAddress[1] + ' ' + arrayAddress[2];
				for(i=0;i<Objs.length;i++){
					if(Objs.eq(i).val() == setArea){
					}
				}
			}
		});

		document.searchForm.searchSido.value = arrayAddress[0];
		document.searchForm.searchGun.value = setArea;

		getList();
		setMarkers();
		//console.log( "getList, setMarkers" );
    }
}

function setDepthTwoAddress(callback){
	var address = $('select[name=depthOneArea] > option:selected').val();
	$.ajax({
		url : '/?com=shaman&pro=shamaninfo&mode=zipTwoSearch',
		data : {'sido':address},
		type : 'post',
		async:false,
		success : function(data){
			//alert(data);
			$('#depth2').html(data);

			if (callback != undefined) {
				callback();
			}

		},
		error : function(){
			alert('통신 에러 입니다.');
		}
	});
}

function setSearchWord(){
	document.searchForm.searchWord.value = $('#searchWord2').val();
	//console.log( document.searchForm.searchWord.value );

}

function setSelectAddress(){
	var getSido = $('select[name=depthOneArea] option:selected').val();
	var getGugun = $('select[name=depthTwoArea] option:selected').val();

	document.searchForm.searchSido.value = getSido;
	document.searchForm.searchGun.value = getGugun;
	document.searchForm.searchWord.value = $('#searchWord2').val();

	/*console.log( document.searchForm.searchSido.value );
	console.log( document.searchForm.searchGun.value );
	console.log( document.searchForm.searchWord.value );*/

	getList();
	setDaumMap();

}

function setMarkers(){
	// 마커를 표시할 위치와 title 객체 배열입니다 
	var positions = getMarkers();
	positions = eval(positions);

	// 마커 이미지의 이미지 주소입니다
	//var imageSrc = "http://i1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png"; 
		
	for (var i = 0; i < positions.length; i ++) {
		
		// 마커 이미지의 이미지 크기 입니다
		//var imageSize = new daum.maps.Size(24, 35); 
		
		// 마커 이미지를 생성합니다    
		//var markerImage = new daum.maps.MarkerImage(imageSrc, imageSize); 
		
		// 마커를 생성합니다
		var marker = new daum.maps.Marker({
			map: map, // 마커를 표시할 지도
			position: new daum.maps.LatLng(positions[i].lat, positions[i].lng), // 마커를 표시할 위치
			title : positions[i].title // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
		});
		//			image : markerImage // 마커 이미지 

		marker.setMap(map);
		//인포 윈도우
		daum.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				var infowindow = new daum.maps.InfoWindow({
					content: '<div style="padding:5px;min-height:120px"><a href="?com=shaman&lnd=shamanHomeDaum&SHId='+positions[i].shId+'">' + positions[i].title + '</a><br/><a href="?com=shaman&lnd=shamanHomeDaum&SHId='+positions[i].shId+'"><img src="/upload/shaman/'+positions[i].img+'" style="width:150px;height:100px;" /></a></div>',
					removable : true
				});
			  infowindow.open(map, marker);
			}
		})(marker, i));
	}

	/*if(positions[0].lat != ''){
		map.setCenter(new daum.maps.LatLng(positions[0].lat, positions[0].lng));
	}*/

}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setMapOnAll(null);
}

function searchFilterGo(){
	var form = document.searchFilterForm;
	form.submit();
}
</script>
	<form name="searchForm" id="searchForm" method="post">
		<input type="hidden" name="searchDate" value="<?=$searchDate?>" />
		<input type="hidden" name="searchWord" value="<?=$searchWord?>" />
		<input type="hidden" name="searchTime" value="" />
		<input type="hidden" name="productType" value="" />
		<input type="hidden" name="sPrice" value="" />
		<input type="hidden" name="ePrice" value="" />
		<input type="hidden" name="searchSido" value="<?=$searchSido?>" />
		<input type="hidden" name="searchGun" value="" />
		<input type="hidden" name="page" value="1" />
		<input type="hidden" name="orderType" value="" />
	</form>
	<form name="wishForm" id="wishForm" method="post">
		<input type="hidden" name="SHIdx" value="" />
		<input type="hidden" name="resUserId" value="<?=$_SESSION["USER_ID"]?>" />
		<input type="hidden" name="mode" value="wish" />
	</form>
    <div class="search_content_wrap">
        <div class="sc_left">
            <!-- 검색옵션 시작 -->
            <div style="width:100%;padding:0px 20px;box-sizing:border-box;overflow-x:hidden;">
                <ul class="l_style_none search_option">
                    <li>
                        <div class="sc_opt_title">
                            <img src="/images/li3.gif" alt="" />날짜
                        </div>
                        <div class="sc_opt_ctl">
                            <input type="text" id="bookingDate" <?if($searchDate == ""){?>value="예약일"<?}else{?>value="<?=$searchDate?>"<?}?> name="searchDate" />
                            <select name="bookingTime" onchange="setBookingDate()">
                                <option value="">예약 시간</option>
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="12:00">12:00</option>
                                <option value="12:30">12:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                                <option value="14:30">14:30</option>
                                <option value="15:00">15:00</option>
                                <option value="15:30">15:30</option>
                                <option value="16:00">16:00</option>
                                <option value="16:30">16:30</option>
                                <option value="17:00">17:00</option>
                                <option value="17:30">17:30</option>
                                <option value="18:00">18:00</option>
                                <option value="18:30">18:30</option>
                                <option value="19:00">19:00</option>
                                <option value="19:30">19:30</option>
                                <option value="20:00">20:00</option>
                                <option value="20:30">20:30</option>
                                <option value="21:00">21:00</option>
                                <option value="21:30">21:30</option>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="sc_opt_title">
                            <img src="/images/li3.gif" alt="" />신점종류
                        </div>
                        <div class="sc_opt_ctl">
                            <select id="productType" onchange="setProduct();">
                                <option value="">선택하세요</option>
								<?=$shamanProductList?>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="sc_opt_title">
                            <img src="/images/li3.gif" alt="" />가격범위
                        </div>

                        <div class="sc_opt_ctl" style="padding-top:24px; padding-bottom:20px;">
							<div id="slider-range"></div>
							<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                        </div>
                    </li>
                    <li>
                        <div class="sc_opt_title">
                            <img src="/images/li3.gif" alt="" />지역명
                        </div>
                        <div class="sc_opt_ctl" style="padding-top: 18px; padding-bottom: 18px;">
							<span id="depth1">
								<select name="depthOneArea" onchange="setDepthTwoAddress();">
									<option value="">선택</option>
									<option value="서울" <?if($searchSido == "서울특별시"){?>selected<?}?>>서울특별시</option>
									<option value="경기" <?if($searchSido == "경기도"){?>selected<?}?>>경기도</option>
									<option value="강원" <?if($searchSido == "강원도"){?>selected<?}?>>강원도</option>
									<option value="경북" <?if($searchSido == "경상북도"){?>selected<?}?>>경상북도</option>
									<option value="경남" <?if($searchSido == "경상남도"){?>selected<?}?>>경상남도</option>
									<option value="충북" <?if($searchSido == "충청북도"){?>selected<?}?>>충청북도</option>
									<option value="충남" <?if($searchSido == "충청남도"){?>selected<?}?>>충청남도</option>
									<option value="전북" <?if($searchSido == "전라북도"){?>selected<?}?>>전라북도</option>
									<option value="전남" <?if($searchSido == "전라남도"){?>selected<?}?>>전라남도</option>
									<option value="제주특별자치도" <?if($searchSido == "제주특별자치도"){?>selected<?}?>>제주특별자치도</option>
									<option value="인천" <?if($searchSido == "인천"){?>selected<?}?>>인천광역시</option>
									<option value="울산" <?if($searchSido == "울산"){?>selected<?}?>>울산광역시</option>
									<option value="대전" <?if($searchSido == "대전"){?>selected<?}?>>대전광역시</option>
									<option value="대구" <?if($searchSido == "대구"){?>selected<?}?>>대구광역시</option>
									<option value="부산" <?if($searchSido == "부산"){?>selected<?}?>>부산광역시</option>
									<option value="광주" <?if($searchSido == "광주"){?>selected<?}?>>광주광역시</option>
								</select>
							</span>
							<span id="depth2">
                            </span>
                        </div>
                    </li>
                    <li>
                        <div class="sc_opt_title">
                            <img src="/images/li3.gif" alt="" />검색 키워드
                        </div>
                        <div class="sc_opt_ctl">
                            <input type="text" id="searchWord2" style="width:450px;" name="searchWord2" value="<?=$searchWord2?>" onkeyup="setSearchWord()"/>
                        </div>
                    </li>
                    <li>
                        <div class="sc_opt_title">
                            <img src="/images/li3.gif" alt="" />정렬순서
                        </div>
                        <div class="sc_opt_ctl sc_sort">
                            <label><input type="radio" name="orderType" value="" onclick="setOrderType('H');"/>인기도</label>
                            <label><input type="radio" name="orderType" value="" onclick="setOrderType('P');"/>가격</label>
                            <label><input type="radio" name="orderType" value="" onclick="setOrderType('N');"/>신규 점집</label>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- 검색옵션 끝 -->

            <div class="search_list">
                <!--<input type="button" class="search_btn float_left" value="필터 추가하기" />
                <input type="button" class="search_btn float_left" value="취소" />-->
                <input type="button" class="search_btn float_left" value="검색필터적용" onclick="getList();setDaumMap();"/>

				<div id="searchValue"></div>
            </div>
        </div>
        <div class="sc_right">
			<div id="dvMap" style="width:100%;height:100%;"></div>
        </div>

