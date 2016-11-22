<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/shaman.php";

	$fileRndIdx	= Request::get('fileRndIdx', Request::GET | Request::XSS_CLEAR);

	$shaman = new Shaman();
	$sprData = array(":SHIdx" => $fileRndIdx);
	$limitList = $shaman->getLimitDayInfoListView($sprData);
	if($limitList == ""){
		$contentHeight = "310px";
	}else{
		$contentHeight = "210px";
	}
?>
<!DOCTYPE html>
<html>
	<title>::예약 제한 시간 관리::</title>
    <head>
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
				var elementCnt = ($('input[name="limitSDate[]"]').size() + 1);
				var addHtml = '<div id="divArea'+elementCnt+'"><input type="text" name="limitSDate[]" id="limitSDate'+elementCnt+'" value="" style="width:80px;" /> ~ <input type="text" name="limitEDate[]" id="limitEDate'+elementCnt+'" value="" style="width:80px;"/><input type="button" value="-" onclick="deleteRow(\''+elementCnt+'\');"/></div>';
				$('.content').append(addHtml);
				setCal('limitDate',elementCnt);

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

			function deleteLimit(idx){
				var form = document.sprDeleteForm;
				form.idx.value = idx;
				if(confirm('예약 제한 일자를 삭제 하시겠습니까?') == true){
					form.submit();
				}
			}

		</script>
	<script>

		function setCal(vType, idx){
			if(vType == 'limitDate'){
				$calObj1 = $('#limitSDate'+idx);
				$calObj2 = $('#limitEDate'+idx);
			}

			$calObj1.datepicker({
				dateFormat: 'yy-mm-dd',
				prevText: '이전 달',
				nextText: '다음 달',
				monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				dayNames: ['일','월','화','수','목','금','토'],
				dayNamesShort: ['일','월','화','수','목','금','토'],
				dayNamesMin: ['일','월','화','수','목','금','토'],
				showMonthAfterYear: true,
				yearSuffix: '년'
			});

			$calObj2.datepicker({
				dateFormat: 'yy-mm-dd',
				prevText: '이전 달',
				nextText: '다음 달',
				monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				dayNames: ['일','월','화','수','목','금','토'],
				dayNamesShort: ['일','월','화','수','목','금','토'],
				dayNamesMin: ['일','월','화','수','목','금','토'],
				showMonthAfterYear: true,
				yearSuffix: '년'
			});
			
		}
	</script>
	</head>
	<body>
		<form name="sprDeleteForm" method="post" action="/application/mng/deleteLimit.php">
			<input type="hidden" name="idx" value="" />
			<input type="hidden" name="fileRndIdx" value="<?=$fileRndIdx?>" />
		</form>
		<?if($limitList != ""){?>
		<div id="sprResult" class="result" style="height:100px;">
			<?=$limitList?>
		</div>
		<?}?>
		<form name="sprForm" action="/application/mng/addLimit.php" method="post">
		<input type="hidden" name="fileRndIdx" value="<?=$fileRndIdx?>"/>
		<input type="hidden" name="type" value="<?=$type?>"/>
		<div class="content" style="height:<?=$contentHeight?>;">
			<div><input type="text" name="limitSDate[]" id="limitSDate1" value="" style="width:80px;" /> ~ <input type="text" name="limitEDate[]" id="limitEDate1" value="" style="width:80px;"/></div>
			<script>setCal('limitDate','1')</script>
		</div>
		</form>
		<div style="margin-top:5px;text-align:center;">
			<input type="button" value="예약제한일자추가" class="hsBtnBlue" onclick="addRow();"/>
			<input type="button" value="저장" class="hsBtnGreen" onclick="formChk();"/>
			<input type="button" value="닫기" class="hsBtnGray" onclick="self.close();"/>
		</div>
	</body>
</html>
