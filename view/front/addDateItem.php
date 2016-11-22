<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";

	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
?>
								<div id="limitArea<?=$idx?>"><input type="text" name="limitSDate[]" id="limitSDate<?=$idx?>" value="" /> ~ <input type="text" name="limitEDate[]" id="limitEDate<?=$idx?>" value="" /> <input type="button" value="삭제" class="sj_btn2" onclick="delDateItem('<?=$idx?>');"/></div><script>setCal('limitDate','<?=$idx?>')</script>

