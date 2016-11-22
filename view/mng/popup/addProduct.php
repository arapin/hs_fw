<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/spr.php";

	$fileRndIdx	= Request::get('fileRndIdx', Request::GET | Request::XSS_CLEAR);

	$spr = new Spr();
	$sprData = array(":SHIdx" => $fileRndIdx);
	$sprList = $spr->getSprInfoList($sprData);
	$productSelect = $spr->getProductSelect();
	if($sprList == ""){
		$contentHeight = "310px";
	}else{
		$contentHeight = "210px";
	}
?>
<!DOCTYPE html>
<html>
	<title>::상품 관리::</title>
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
			var addSelect = '<?=$productSelect?>';
			function addRow(){
				var elementCnt = $('input[type=text]').size();
				var addHtml = '<div id="divArea'+elementCnt+'">'+addSelect+'<input type="text" name="price[]" /><input type="button" value="-" onclick="deleteRow(\''+elementCnt+'\');"/></div>';
				$('.content').append(addHtml);
			}

			function deleteRow(idx){
				$('#divArea'+idx).remove();
			}

			function formChk(){
				var form = document.sprForm;
				var error = 0;
				$('input[name*="price[]"]').each(function(){
					if($(this).val() == ''){
						error++;
					}
				});

				if(error > 0){
					alert('가격을 모두 등록하여 주십시요.');
					return false;
				}

				form.submit();
			}

			function deleteSpr(idx){
				var form = document.sprDeleteForm;
				form.idx.value = idx;
				if(confirm('상품을 삭제 하시겠습니까?') == true){
					form.submit();
				}
			}
		</script>
	</head>
	<body>
		<form name="sprDeleteForm" method="post" action="/application/mng/deleteProduct.php">
			<input type="hidden" name="idx" value="" />
			<input type="hidden" name="fileRndIdx" value="<?=$fileRndIdx?>" />
		</form>
		<?if($sprList != ""){?>
		<div id="sprResult" class="result" style="height:100px;">
			<?=$sprList?>
		</div>
		<?}?>
		<form name="sprForm" action="/application/mng/addProduct.php" method="post"  enctype="multipart/form-data">
		<input type="hidden" name="fileRndIdx" value="<?=$fileRndIdx?>"/>
		<input type="hidden" name="type" value="<?=$type?>"/>
		<div class="content" style="height:<?=$contentHeight?>;">
			<?=$productSelect?> <input type="text" name="price[]" />
		</div>
		</form>
		<div style="margin-top:5px;text-align:center;">
			<input type="button" value="상품추가" class="hsBtnBlue" onclick="addRow();"/>
			<input type="button" value="저장" class="hsBtnGreen" onclick="formChk();"/>
			<input type="button" value="닫기" class="hsBtnGray" onclick="self.close();"/>
		</div>
	</body>
</html>
