<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/file.php";

	$idx		= Request::get('idx', Request::POST | Request::XSS_CLEAR);
	$fileRndIdx	= Request::get('fileRndIdx', Request::POST | Request::XSS_CLEAR);
	$type		= Request::get('type', Request::POST | Request::XSS_CLEAR);

	$file = new File();
	$whereData = array(":idx" => $idx);
	$fileData = array("deletePath" => uploadPath."/shaman");
	$file->deleteImgFile($whereData, $fileData);

	$fileData = array(":parentId" => $fileRndIdx, ":type" => $type);
	$fileList = $file->getFileInfoListView($fileData);
?>
<script>
	var fileNameList = '<?=$fileList?>';
	opener.setFilename(fileNameList);
	alert('파일이 정상적으로 삭제 되었습니다.');
	location.href = '/mngView/popup/addFile.php?fileRndIdx=<?=$fileRndIdx?>&type=<?=$type?>';
</script>