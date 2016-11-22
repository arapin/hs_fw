<?
	$aqBoard = new AqBoard();
	$rtnList = $aqBoard->aqBoardListMng($page,"idx DESC");
?>
			<div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>신점 문의 관리</li>
                </ul>
				<!--<a href="#" class="btn right" onclick="location.href='?com=board&lnd=write&code=<?=$code?>&mng=Y'"><i class="fa fa-caret-square-o-left"></i>등록</a>-->
            </div>
			<div class="tables clearfix">
				<table class="datatable adm-table">
					<thead>
						<tr>
							<th>순번</th>
							<th>제목<span class="order"></span></th>
							<th>등록자<span class="order"></span></th>
							<th>상태<span class="order"></span></th>
							<th>등록일<span class="order"></span></th>
						</tr>
					</thead>
					<tbody>
						<?=$rtnList?>
					</tbody>
				</table>
			</div>