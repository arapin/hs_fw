<?
	$board = new Board();

	$searchHead = Request::get('searchHead', Request::REQUEST | Request::XSS_CLEAR);
	$searchWord = Request::get('searchWord', Request::REQUEST | Request::XSS_CLEAR);

	$search = array();

	if($searchHead != ""){
		$search["searchHead"] = $searchHead;
	}

	if($searchWord != ""){
		$search["searchValue"] = $searchWord;
	}

	$rtnList = $board->boardMngList($page,"idx DESC",$code, $search);

	 switch($code){
		 case "community" : $viewTitle = "커뮤니티"; break;
		 case "oq" : $viewTitle = "조합원 가입문의"; break;
		 case "travel" : $viewTitle = "기도여행"; break;
		 case "area" : $viewTitle = "추천 기도터 굿당"; break;
		 case "join" : $viewTitle = "점집등록 방법"; break;
		 case "notice" : $viewTitle = "공지사항"; break;
		 case "search" : $viewTitle = "용한 점집 찾아보기"; break;
		 case "booking" : $viewTitle = "예약하기"; break;
		 case "con" : $viewTitle = "상담"; break;
	 }
?>
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="?mng=Y">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">게시판 관리</a></li>
			</ul>

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"><?=$viewTitle?></span></h2>
						<div class="box-icon">
							<a href="?com=board&lnd=write&mng=Y&code=<?=$code?>"><i class="icon-edit"></i></a>
							<!--<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>순번</th>
								  <th>제목</th>
								  <th>등록자</th>
								  <th>조회수</th>
								  <th>등록일</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?=$rtnList?>
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

