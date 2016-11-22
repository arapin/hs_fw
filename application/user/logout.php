<?
	//session_unregister($_SESSION["USER_ID"]);
	$_SESSION = array();
	session_destroy();
?>
<script>
	alert('로그아웃 되었습니다.');
	location.href = "/?com=index";
</script>