<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/shaman.php";

	$searchSido = Request::get('searchSido', Request::REQUEST | Request::XSS_CLEAR);
	$searchGun = Request::get('searchGun', Request::REQUEST | Request::XSS_CLEAR);
	$productType = Request::get('productType', Request::REQUEST | Request::XSS_CLEAR);
	$sPrice = Request::get('sPrice', Request::REQUEST | Request::XSS_CLEAR);
	$ePrice = Request::get('ePrice', Request::REQUEST | Request::XSS_CLEAR);
	$searchDate = Request::get('searchDate', Request::REQUEST | Request::XSS_CLEAR);
	$searchTime = Request::get('searchTime', Request::REQUEST | Request::XSS_CLEAR);
	$searchWord = Request::get('searchWord', Request::REQUEST | Request::XSS_CLEAR);

	$searchSido = urldecode($searchSido);
	$searchGun = urldecode($searchGun);
	$searchWord = urldecode($searchWord);
	//echo $searchSido;

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

	$searchArray = array("searchSido" => $getSido, "searchGun" => $searchGun, "productType" => $productType, "searchDate" => $searchDate, "searchTime" => $searchTime, "searchWord" => $searchWord);

	$shaman = new Shaman();
	$shamanHomeListData = $shaman->shamanHomeList($searchArray);
	echo $shamanHomeListData;
?>