<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/shaman.php";

	$idx		= Request::get('idx', Request::POST | Request::XSS_CLEAR);
	$fileRndIdx	= Request::get('fileRndIdx', Request::POST | Request::XSS_CLEAR);

	$shaman = new Shaman();
	$whereData = array(":idx" => $idx);
	$shaman->deleteLimitDayInfo($whereData);

	$sprData = array(":SHIdx" => $fileRndIdx);
	$limitList = $shaman->getLimitDayInfoListView2($sprData);
?>
<script>
	var sprList = '<?=$limitList?>';
	opener.setLimitName(sprList);
	alert('상품이 정상적으로 삭제 되었습니다.');
	location.href = '/mngView/popup/addLimit.php?fileRndIdx=<?=$fileRndIdx?>';
</script>