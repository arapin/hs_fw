<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/file.php";

	$fileRndIdx	= Request::get('fileRndIdx', Request::POST | Request::XSS_CLEAR);
	$type		= Request::get('type', Request::POST | Request::XSS_CLEAR);

	$file = new File();
	$fileData = array($_FILES["file"], $type, $fileRndIdx, uploadPath."/shaman", "/mngView/popup/addFile.php?fileRndIdx=".$fileRndIdx);
	$fileArray = $file->addImgFile($fileData);
	$fileData = array(":parentId" => $fileRndIdx, ":type" => $type);
	$fileList = $file->getFileInfoListView($fileData);
?>
<script>
	var fileNameList = '<?=$fileList?>';
	opener.setFilename(fileNameList);
	alert('파일이 정상적으로 등록 되었습니다.');
	self.close();
</script>