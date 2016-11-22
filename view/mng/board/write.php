<?
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
			<script type="text/javascript" src="/se2/js/HuskyEZCreator.js" charset="utf-8"></script>


			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="?mng=Y">Home</a>
					<i class="icon-angle-right"></i> 
				</li>
				<li>
					<i class="icon-edit"></i>
					<a href="#">게시판 관리</a>
				</li>
			</ul>

			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span><?=$viewTitle?> 등록</h2>
					</div>
            <form id="file-upload" class="upload"  name="writeForm" method="post" action="?com=board&pro=boardinfo&mng=Y" onsubmit="return writeChkMng(this);">
<input type="hidden" name="mode" value="insert" />
<input type="hidden" name="code" value="<?=$code?>" />
<input type="hidden" name="userId" value="<?=$_SESSION["ADMIN_ID"]?>" />
<input type="hidden" name="headWord" value="" />

					<div class="box-content">
							<fieldset>
								<div class="control-group success">
								<label class="control-label" for="inputSuccess">제목</label>
									<div class="controls">
										<input type="text" name="title" value="" class="input-xlarge focused">
									</div>
								</div>

								<div class="control-group hidden-phone">
								<label class="control-label" for="textarea2">내용</label>
								<div class="controls">
									<textarea id="field3" name="content" style="width:100%;"></textarea>
									<script type="text/javascript">
									var oEditors = [];
									nhn.husky.EZCreator.createInIFrame({
										oAppRef: oEditors,
										elPlaceHolder: "field3",
										sSkinURI: "/se2/SmartEditor2Skin.html",
										fCreator: "createSEditor2"
									});
									</script>
								</div>
								</div>

								<div class="form-actions">
									<button type="submit" class="btn btn-primary">Save changes</button>
									<input type="button" class="btn" onclick="location.href='?com=board&lnd=list&mng=Y&code=<?=$code?>'" value="Cancel" />
								</div>
							</fieldset>
					</div>
			</form>
				</div><!--/span-->

			</div><!--/row-->
