<?
	session_start();
	setcookie('APP', 'Y', time()+(60*60*24));
	Header("Location:http://m.jeomhouse.com");
?>