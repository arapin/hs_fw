<?
	//session_unregister($_SESSION["ADMIN_ID"]);
	session_destroy();
?>
<script>
	alert('로그아웃 되었습니다.');
	location.href = "?com=index&mng=Y";
</script>