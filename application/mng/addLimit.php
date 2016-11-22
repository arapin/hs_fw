<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/shaman.php";

	$SHIdx	= Request::get('fileRndIdx', Request::POST | Request::XSS_CLEAR);
	$limitSDate	= Request::get('limitSDate', Request::NPOST | Request::XSS_CLEAR);
	$limitEDate	= Request::get('limitEDate', Request::NPOST | Request::XSS_CLEAR);

	$shaman = new Shaman();


	$shaman->setLimitDayInfo($limitSDate, $limitEDate, $SHIdx);
	$sprData = array(":SHIdx" => $SHIdx);
	$limitList = $shaman->getLimitDayInfoListView2($sprData);
?>
<script>
	var sprNameList = '<?=$limitList?>';
	opener.setLimitName(sprNameList);
	alert('예약 제한 시간이이 정상적으로 등록 되었습니다.');
	self.close();
</script>