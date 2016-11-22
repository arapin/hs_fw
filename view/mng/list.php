<?
	$mng = new Mng();
	$rtnList = $mng->mngUserList();
?>
<table class="tlb">
	<thead>
		<tr>
			<th>순번</th>
			<th>관리자 ID</th>
			<th>관리자 이름</th>
			<th>등록일</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
		<?=$rtnList?>
	</tbody>
</table>