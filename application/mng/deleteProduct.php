<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/spr.php";

	$idx		= Request::get('idx', Request::POST | Request::XSS_CLEAR);
	$fileRndIdx	= Request::get('fileRndIdx', Request::POST | Request::XSS_CLEAR);

	$spr = new Spr();
	$whereData = array(":idx" => $idx);
	$spr->deleteProduct($whereData);

	$sprData = array(":SHIdx" => $fileRndIdx);
	$sprList = $spr->getSprInfoListView($sprData);
?>
<script>
	var sprList = '<?=$sprList?>';
	opener.setSprname(sprList);
	alert('상품이 정상적으로 삭제 되었습니다.');
	location.href = '/mngView/popup/addProduct.php?fileRndIdx=<?=$fileRndIdx?>';
</script>