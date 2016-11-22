<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/shaman.php";

	$searchSido = Request::get('searchSido', Request::POST | Request::XSS_CLEAR);
	$searchGun = Request::get('searchGun', Request::POST | Request::XSS_CLEAR);
	$productType = Request::get('productType', Request::POST | Request::XSS_CLEAR);
	$sPrice = Request::get('sPrice', Request::POST | Request::XSS_CLEAR);
	$ePrice = Request::get('ePrice', Request::POST | Request::XSS_CLEAR);
	$searchDate = Request::get('searchDate', Request::POST | Request::XSS_CLEAR);
	$searchTime = Request::get('searchTime', Request::POST | Request::XSS_CLEAR);
	$searchWord = Request::get('searchWord', Request::POST | Request::XSS_CLEAR);
	$orderType = Request::get('orderType', Request::POST | Request::XSS_CLEAR);
	$page = Request::get('page', Request::POST | Request::XSS_CLEAR);

	$shaman = new Shaman();
	$searchSido = str_replace("광역시","",$searchSido);
	//$searchSido = str_replace("특별자치도","",$searchSido);
	switch($searchSido){
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
			$getSido = $searchSido;
			break;
	}

	$searchWord = str_replace("undefined","",$searchWord);
	$searchWord = str_replace("광역시","",$searchWord);
	//$searchWord = str_replace("특별자치도","",$searchWord);
	switch($searchWord){
		case "서울특별시" : 
			$searchWord = "서울";
			break;
		case "경기도" : 
			$searchWord = "경기";
			break;
		case "강원도" : 
			$searchWord = "강원";
			break;
		case "충청북도" : 
			$searchWord = "충북";
			break;
		case "충청남도" : 
			$searchWord = "충남";
			break;
		case "경상북도" : 
			$searchWord = "경북";
			break;
		case "경상남도" : 
			$searchWord = "경남";
			break;
		case "전라북도" : 
			$searchWord = "전북";
			break;
		case "전라남도" : 
			$searchWord = "전남";
			break;
		case "제주도" : 
			$searchWord = "제주특별자치도";
			break;

		default : 
			$searchWord = $searchWord;
			break;
	}

	switch ($orderType){
		case "H" : 
			$searchOrderType = "a.idx DESC";
			break;
		case "P" : 
			$searchOrderType = "b.price DESC";
			break;
		case "N" : 
			$searchOrderType = "a.writeDate DESC";
			break;
		default :
			$searchOrderType = "a.idx DESC";
			break;
	}

			if($_SERVER["REMOTE_ADDR"] == "61.77.73.196"){
				echo $searchGun;
			}

	$searchArray = array("searchSido" => $getSido, "searchGun" => $searchGun, "productType" => $productType, "searchDate" => $searchDate, "searchTime" => $searchTime, "searchWord" => $searchWord);
	$rtnList = $shaman->getSearchSHList($page,$searchOrderType, $searchArray);
	//AND b.price BETWEEN  '10000' AND  '50000' AND a.SHAddress LIKE '경기 성남시%'
	if($shaman->resultSIdo == ""){
		$shaman->resultSIdo = $getSido." ".$searchGun;
	}
?>
			  <span class="float_right search_cnt">
                    예약가능 점집 <?=$shaman->searchTotalCnt?> 개 · <span id="resultArea"><?=$shaman->resultSIdo?></span>
                </span>

                <ul class="l_style_inline search_plist">
					<?
						if($rtnList != ""){
							echo $rtnList;
						}else{
							echo "<li style=\"margin:50px 0 0 0;text-align:center;\">검색된 점집이 없습니다.</li>";
						}
					?>

                </ul>

                <div class="search_bottom">
                    <!--300+ 점집 중 1-18-->
                    <div class="paging_wrap">
						<?=$shaman->pageView?>
                    </div>
                </div>

                <!--<div class="search_more_link">
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
                    <a style="color:#333;" href="">한국</a> ·<a href="">서울</a> ·<a href="">제주</a> ·<a href="">부산</a> ·<a href="">광주</a>-->
                </div>
				<script>
					function setSelectArea(){
						var rtn = $('#resultArea').text();
						var rtnArray = rtn.split(' ');
						var setArea = '';
						var selectedBol = false;
						var selectedBol2 = false;
						setArea = rtnArray[1];

						$('select[name=depthOneArea] > option').each(function () {
							if ($.trim($(this).val()) == $.trim(rtnArray[0])) {
								$(this).prop('selected', true);
								selectedBol2 = true;
							}

							if(!selectedBol2){
								if ($.trim($(this).text()) == $.trim(rtnArray[0])) {
									$(this).prop('selected', true);
									selectedBol2 = true;
								}
							}
						});

						setDepthTwoAddress(function () {
						
							setArea = rtnArray[1];


							var Objs = $('select[name=depthTwoArea] option');
							for(i=0;i<Objs.length;i++){
								if(Objs.eq(i).val() == setArea){
									Objs.eq(i).prop('selected', true);
									selectedBol = true;
								}
							}
							
							if(!selectedBol){
								setArea = rtnArray[1] + ' ' + rtnArray[2];

								for(i=0;i<Objs.length;i++){
									if(Objs.eq(i).val() == setArea){
										Objs.eq(i).prop('selected', true);


									//console.log( $(this).prop('selected') );
									//console.log( $('select[name=depthTwoArea]').html() );

									}
								}
							}

									//console.log("setSelectArea : " + setArea);


						});

						/*$('select[name=depthOneArea] > option[value=\''+rtnArray[0]+'\']').attr('selected', 'selected');
						setDepthTwoAddress();

						
						var Objs = $('select[name=depthTwoArea] option');
						for(i=0;i<Objs.length;i++){
							if(Objs.eq(i).text() == setArea){
								$('select[name=depthTwoArea] > option[value=\''+setArea+'\']').prop('selected', true);
								selectedBol = true;
							}
						}
						
						if(!selectedBol){
							setArea = rtnArray[1] + ' ' + rtnArray[2];

							for(i=0;i<Objs.length;i++){
								if(Objs.eq(i).text() == setArea){
									$('select[name=depthTwoArea] > option[value=\''+setArea+'\']').prop('selected', true);
									selectedBol = true;
								}
							}
						}*/
						//getList();
						//setGoogleMap('search');
<?if($getSido == "" && $rtnList == ""){?>
						//setGoogleMap('search');
						//getList();

<?}?>
					}

					/*function setSelectArea(){
						var rtn = $('#resultArea').text();
						var rtnArray = rtn.split(' ');
						var setArea = '';
						if(typeof rtnArray[2] != 'undefined'){
							setArea = rtnArray[1] + ' ' +rtnArray[2];
							//alert(setArea);
						}else{
							setArea = rtnArray[1];
							//alert(rtnArray[1]);
						}
						//
						$('select[name=depthOneArea] > option[value=\''+rtnArray[0]+'\']').attr('selected', 'selected');
						setDepthTwoAddress();
						$('select[name=depthTwoArea] > option[value=\''+setArea+'\']').attr('selected', 'selected');
					}*/
					setSelectArea();
				</script>
