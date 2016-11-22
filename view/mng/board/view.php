<?
	$board = new Board();

	$idx = Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$code = Request::get('code', Request::REQUEST | Request::XSS_CLEAR);

	$getBeen = array(":idx" => $idx);
	$rtnData = $board->boardModifyInfo($getBeen);


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

			<!-- start: Content -->
			<div id="content" class="span10">
			
						
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">게시판 관리</a></li>
			</ul>

			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon font"></i><span class="break"></span><?=$viewTitle?> 상세보기</h2>
					</div>
					<div class="box-content">
						<h3><?=$rtnData["title"]?></h3>
						<div class="tooltip-demo well">
						  <p class="muted" style="margin-bottom: 0;">
						  <?=str_replace("src=\"upload","src=\"/se2/upload",$rtnData["content"])?>		  </p>
						</div>   

						<div class="form-actions">
							<input type="button" class="btn btn-primary" onclick="location.href='?com=board&lnd=modify&mng=Y&code=<?=$code?>&idx=<?=$idx?>'" value="Change"/>
							<input type="button" class="btn" onclick="location.href='?com=board&lnd=list&mng=Y&code=<?=$code?>'" value="Cancel" />
						</div>
					</div>
				</div><!--/span-->

			</div>
