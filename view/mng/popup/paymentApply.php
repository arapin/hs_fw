<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/payment.php";

	$idx	= Request::get('idx', Request::GET | Request::XSS_CLEAR);
?>
<!DOCTYPE html>
<html>
	<title>::결제 승인::</title>
    <head>
		<style>
			body {padding:0px;margin:0px;}
			.title {background-color:#5e5e5e;color:#ffffff;font-weight:bold;height:40px;padding-top:10px;}
			table {border-collapse:collapse;}
			table th {background-color:#d9d9d9;height:30px;padding-top:0px;text-align:left;width:80px;}
			.hsBtnGray {height: 46px;padding: 0px 20px;font-size: 12px;font-family: 'nswbold';color: #e7e7e7;text-align: center;text-transform: uppercase;background:#c1c1c1 none repeat scroll 0% 0%;transition: all 0.2s ease-in-out 0s;font-weight:bold;}
			.hsBtnGreen {height: 46px;padding: 0px 20px;font-size: 12px;font-family: 'nswbold';color: #727272;text-align: center;text-transform: uppercase;background: #DDEBA9 none repeat scroll 0% 0%;transition: all 0.2s ease-in-out 0s;font-weight:bold;}
		</style>
		<script>
			function formChk(){
				var form =document.paymentForm;

				if(form.inBank.value == ""){
					alert('입금 은행명을 입력 하여 주십시요.');
					return false;
				}

				if(form.inName.value == ""){
					alert('입금자를 입력 하여 주십시요.');
					return false;
				}

				if(form.payPrice.value == ""){
					alert('입금액을 입력 하여 주십시요.');
					return false;
				}

				form.submit();
			}
		</script>
	</head>
	<body>
		<div class="title">결제 정보</div>
<form name="paymentForm" method="post" action="/?com=payment&pro=paymentInfo&mng=Y" >
<input type="hidden" name="mode" value="payment" />
<input type="hidden" name="idx" value="<?=$idx?>" />
		<table>
			<tbody>
				<tr>
					<th>입금 은행</th>
					<td><input type="text" name="inBank" /></td>
				</tr>
				<tr>
					<th>입금자</th>
					<td><input type="text" name="inName" /></td>
				</tr>
				<tr>
					<th>입금액</th>
					<td><input type="text" name="payPrice" /></td>
				</tr>
			</tbody>
		</table>
		<div style="margin-top:5px;text-align:center;">
			<input type="button" value="저장" class="hsBtnGreen" onclick="formChk();"/>
			<input type="button" value="닫기" class="hsBtnGray" onclick="self.close();"/>
		</div>
</form>
	</body>
</html>