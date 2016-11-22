<?
	$client = new Client();

	$searchType = Request::get('searchType', Request::REQUEST | Request::XSS_CLEAR);
	$searchWord = Request::get('searchWord', Request::REQUEST | Request::XSS_CLEAR);

	if($searchType != ""){
		$search["searchType"] = $searchType;
	}

	if($searchWord != ""){
		$search["searchWord"] = $searchWord;
	}

	$rtnList = $client->clientListMng($page,"idx DESC", $search);
?>
			<div class="breadcrumbs clearfix">
				<ul class="breadcrumbs left">
					<li><a href="#">SAN SIN GAK ADMIN</a></li>
					<li><i class="fa fa-angle-right"></i></li>
					<li>무속인 관리</li>
				</ul>
				<a href="#" class="btn right" onclick="location.href='?com=shaman&lnd=write&mng=Y'"><i class="fa fa-caret-square-o-left"></i>등록</a>
			</div>
			<div class="breadcrumbs clearfix">
<form name="searchForm" method="post" action="?com=shaman&lnd=list&mng=Y">
				<select name="searchType">
					<option value="">선택</option>
					<option value="name" <?if($searchType == "name"){?>selected<?}?>> 대표자 이름</option>
					<option value="id" <?if($searchType == "id"){?>selected<?}?>>상점 아이디</option>
					<option value="SHName" <?if($searchType == "SHName"){?>selected<?}?>>상호명</option>
				</select>
				<input type="text" value="<?=$searchWord?>" name="searchWord"/>
				<input type="button" value="검색" onclick="searchChk();"/>
</form>
			</div>
			<div class="tables clearfix">
				<table class="datatable adm-table">
					<thead>
						<tr>
							<th>순번</th>
							<th>ID<span class="order"></span></th>
							<th>이름<span class="order"></span></th>
							<th>전화번호<span class="order"></span></th>
							<th>등록일<span class="order"></span></th>
							<th>상태</th>
							<th>ACTIONS</th>
						</tr>
					</thead>
					<tbody>
						<?=$rtnList?>
					</tbody>
				</table>
			</div>