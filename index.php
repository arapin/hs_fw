<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/class.Images.php";
	if($com != ""){
		include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/".$com.".php";
		//관리자.
		if($mng == "Y"){

			if($_SESSION["ADMIN_ID"] == ""){
				if($lnd != "login" && $pro != "login"){
					header("Location:?com=mng&lnd=login&mng=Y");
				}
			}   

			if($pro == ""){
				include $_SERVER["DOCUMENT_ROOT"]."/inc/headMng.php";
				include $_SERVER["DOCUMENT_ROOT"]."/view/mng/".$com."/".$lnd.".php";


				include $_SERVER["DOCUMENT_ROOT"]."/inc/footerMng.php";
			}else{
				include $_SERVER["DOCUMENT_ROOT"]."/application/mng/".$com."/".$pro.".php";
			}
		}else{
			if($pro == ""){
				if($com == "mypage"){
					if($_SESSION["USER_ID"] == ""){
						header('Location: ?com=user&lnd=login');
					}
				}
				/*상단*/
				include $_SERVER["DOCUMENT_ROOT"]."/inc/headFront.php";
				/*본문*/
				include $_SERVER["DOCUMENT_ROOT"]."/view/front/".$com."/".$lnd.".php";
				/*하단*/
				include $_SERVER["DOCUMENT_ROOT"]."/inc/footerFront.php";

			}else{
				include $_SERVER["DOCUMENT_ROOT"]."/application/".$com."/".$pro.".php";
			}
		}
	}


	/*****/
	//create by Michael jung
	/*****/
?>
