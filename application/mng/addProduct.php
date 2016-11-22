<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/spr.php";

	$SHIdx	= Request::get('fileRndIdx', Request::POST | Request::XSS_CLEAR);
	$proIdx	= Request::get('proIdx', Request::NPOST | Request::XSS_CLEAR);
	$price	= Request::get('price', Request::NPOST | Request::XSS_CLEAR);

	$spr = new Spr();
	$sprData = array($SHIdx, $proIdx, $price);
	$aprArray = $spr->addProduct($sprData);
	$sprData = array(":SHIdx" => $SHIdx);
	$sprList = $spr->getSprInfoListView($sprData);
?>
<script>
	var sprNameList = '<?=$sprList?>';
	opener.setSprname(sprNameList);
	alert('상품이 정상적으로 등록 되었습니다.');
	self.close();
</script>