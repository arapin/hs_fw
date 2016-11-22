<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/reservation.php";

	$idx	= Request::get('idx', Request::GET | Request::XSS_CLEAR);

	$reservation = new Reservation();
	$getBeen = array(":idx" => $idx);
	$rtnData = $reservation->reservationSubInfo($getBeen);
?>
<!DOCTYPE html>
<html>
	<title>::예약 부가 정보::</title>
    <head>
		<style>
			body {padding:0px;margin:0px;}
			.title {background-color:#5e5e5e;color:#ffffff;font-weight:bold;height:40px;padding-top:10px;}
			table {border-collapse:collapse;}
			table th {background-color:#d9d9d9;height:30px;padding-top:0px;text-align:left;width:80px;}
			.hsBtnGray {height: 46px;padding: 0px 20px;font-size: 12px;font-family: 'nswbold';color: #e7e7e7;text-align: center;text-transform: uppercase;background:#c1c1c1 none repeat scroll 0% 0%;transition: all 0.2s ease-in-out 0s;font-weight:bold;}
		</style>
	</head>
	<body>
		<div class="title">상품정보</div>
		<table>
			<tbody>
				<tr>
					<th>상품명</th>
					<td><?=$rtnData["proName"]?></td>
				</tr>
				<tr>
					<th>상품가격</th>
					<td><?=$rtnData["price"]?></td>
				</tr>
				<tr>
					<th>시간</th>
					<td><?=$rtnData["proTime"]?></td>
				</tr>
			</tbody>
		</table>
		<br/>
		<div class="title">결제정보</div>
		<table>
			<tbody>
				<tr>
					<th>결제방법</th>
					<td><?=$rtnData["payType"]?></td>
				</tr>
				<tr>
					<th>금액</th>
					<td><?=$rtnData["price"]?></td>
				</tr>
				<tr>
					<th>결제금액</th>
					<td><?=$rtnData["payPrice"]?></td>
				</tr>
				<tr>
					<th>결제상태</th>
					<td><?=$rtnData["payState"]?></td>
				</tr>
				<tr>
					<th>결제일</th>
					<td><?=$rtnData["payDate"]?></td>
				</tr>
				<tr>
					<th>결제정보</th>
					<td><?=$rtnData["payInfo"]?></td>
				</tr>
				<tr>
					<th>취소일</th>
					<td><?=$rtnData["cancelDate"]?></td>
				</tr>
				<tr>
					<th>취소정보</th>
					<td><?=$rtnData["cancelInfo"]?></td>
				</tr>
			</tbody>
		</table>
		<div style="margin-top:5px;text-align:center;">
			<input type="button" value="닫기" class="hsBtnGray" onclick="self.close();"/>
		</div>
	</body>
</html>