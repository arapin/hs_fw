<?
	session_cache_limiter("pulbic");
	session_start();

	header("Cache-Control: no-cache, max-age=0, must-revalidate, proxy-revalidate");
	header("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Content-Type: text/html; charset=UTF-8");

	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/Request.php";

	/**** 공통변수 ****/
	define("uploadPath",$_SERVER["DOCUMENT_ROOT"]."/upload");
	define("MAPAPINUM","8346266cea69dec6443f1c2177b5d574");
	define("CALCDAY","01");
	define("PGID","aoddudgh");
	define("SHOPNAME","샘플SHOP");
	define("SHOPENAME","SAMPLE SHOP");
	

	$hostname=$_SERVER["HTTP_HOST"];

	if($hostname == "m.jeomhouse.com"){

		define("MOBILE","Y");

	}else{

		/*$mobile_agent = array("Ipone","Ipod","Android","Blackberry","SymbianOS|SCH-M\d+","Opera Mini", "Windows ce", "Nokia", "sony" );
		$check_mobile = false;
		for($i=0; $i<sizeof($mobile_agent); $i++){
			if(stripos( $_SERVER['HTTP_USER_AGENT'], $mobile_agent[$i] )){
				$check_mobile = true;
				break;
			}
		}

		if($check_mobile){
			header("Location: http://m.jeomhouse.com");
			exit;
		}*/

		define("MOBILE","N");
	}

	$com = Request::get('com', Request::GET | Request::XSS_CLEAR);
	$lnd = Request::get('lnd', Request::GET | Request::XSS_CLEAR);
	$mng = Request::get('mng', Request::GET | Request::XSS_CLEAR);
	$pro = Request::get('pro', Request::GET | Request::XSS_CLEAR);
	$mode = Request::get('mode', Request::POST | Request::XSS_CLEAR);
	$page = Request::get('page', Request::REQUEST | Request::XSS_CLEAR);
	$memoPage = Request::get('memoPage', Request::REQUEST | Request::XSS_CLEAR);
	$approachPage = Request::get('approachPage', Request::REQUEST | Request::XSS_CLEAR);
	$code = Request::get('code', Request::REQUEST | Request::XSS_CLEAR);
	$searchWord = Request::get('searchWord', Request::REQUEST | Request::XSS_CLEAR);

	if($com == ""){
		$com = "index";
	}
	if($lnd == ""){
		$lnd = "index";
	}
	if($page == ""){
		$page = "1";
	}
	if($memoPage == ""){
		$memoPage = "1";
	}
	if($approachPage == ""){
		$approachPage = "1";
	}
	/**** 공통변수 ****/
?>