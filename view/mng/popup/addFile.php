<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/file.php";

	$fileRndIdx	= Request::get('fileRndIdx', Request::GET | Request::XSS_CLEAR);
	$type		= Request::get('type', Request::GET | Request::XSS_CLEAR);

	$file = new File();
	$fileData = array(":parentId" => $fileRndIdx, ":type" => $type);
	$fileList = $file->getFileInfoList($fileData);
	if($fileList == ""){
		$contentHeight = "310px";
	}else{
		$contentHeight = "210px";
	}
?>
<!DOCTYPE html>
<html>
	<title>::파일 관리::</title>
    <head>
		<script type="text/javascript" src="/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="/js/common.js"></script>
		<style>
			.content {overflow:scroll;border:solid 1px #585858;padding:5px;}
			.result {overflow:scroll;background-color:#d8d8d8;padding:5px;margin-bottom:5px;}
			.hsBtnGreen {height: 46px;padding: 0px 20px;font-size: 12px;font-family: 'nswbold';color: #727272;text-align: center;text-transform: uppercase;background: #DDEBA9 none repeat scroll 0% 0%;transition: all 0.2s ease-in-out 0s;font-weight:bold;}
			.hsBtnGray {height: 46px;padding: 0px 20px;font-size: 12px;font-family: 'nswbold';color: #e7e7e7;text-align: center;text-transform: uppercase;background:#c1c1c1 none repeat scroll 0% 0%;transition: all 0.2s ease-in-out 0s;font-weight:bold;}
			.hsBtnBlue {height: 46px;padding: 0px 20px;font-size: 12px;font-family: 'nswbold';color: #727272;text-align: center;text-transform: uppercase;background:#b5d8ff none repeat scroll 0% 0%;transition: all 0.2s ease-in-out 0s;font-weight:bold;}
			.fileItem {font-size:8pt;font-weight:bold;color:#5f657a;}
			.deleteFile {color:red;font-weight:bold;cursor:pointer;}
		</style>
		<script>
			function addRow(){
				var elementCnt = $('input[type=file]').size();
				var addHtml = '<div id="divArea'+elementCnt+'"><input type="file" name="file[]" /><input type="button" value="-" onclick="deleteRow(\''+elementCnt+'\');"/></div>';
				$('.content').append(addHtml);
			}

			function deleteRow(idx){
				$('#divArea'+idx).remove();
			}

			function formChk(){
				var form = document.fileForm;
				var error = 0;
				$('input[name*="file[]"]').each(function(){
					if($(this).val() == ''){
						error++;
					}
				});

				if(error > 0){
					alert('파일을 모두 등록하여 주십시요.');
					return false;
				}

				form.submit();
			}

			function deleteFile(idx){
				var form = document.fileDeleteForm;
				form.idx.value = idx;
				if(confirm('파일을 삭제 하시겠습니까?') == true){
					form.submit();
				}
			}
		</script>
	</head>
	<body>
		<form name="fileDeleteForm" method="post" action="/application/mng/deleteFile.php">
			<input type="hidden" name="idx" value="" />
			<input type="hidden" name="fileRndIdx" value="<?=$fileRndIdx?>" />
			<input type="hidden" name="type" value="<?=$type?>" />
		</form>
		<?if($fileList != ""){?>
		<div id="fileResult" class="result" style="height:100px;">
			<?=$fileList?>
		</div>
		<?}?>
		<form name="fileForm" action="/application/mng/addFile.php" method="post"  enctype="multipart/form-data">
		<input type="hidden" name="fileRndIdx" value="<?=$fileRndIdx?>"/>
		<input type="hidden" name="type" value="<?=$type?>"/>
		<div class="content" style="height:<?=$contentHeight?>;">
			<input type="file" name="file[]" />	
		</div>
		</form>
		<div style="margin-top:5px;text-align:center;">
			<input type="button" value="파일추가" class="hsBtnBlue" onclick="addRow();"/>
			<input type="button" value="저장" class="hsBtnGreen" onclick="formChk();"/>
			<input type="button" value="닫기" class="hsBtnGray" onclick="self.close();"/>
		</div>
	</body>
</html>
