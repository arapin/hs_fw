<?
	$mng = new Mng();
	$rtnList = $mng->mngUserList("","idx DESC");
?>
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="?mng=Y">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">관리자 관리</a></li>
			</ul>

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Admins</h2>
						<div class="box-icon">
							<a href="?com=mng&lnd=write&mng=Y"><i class="icon-edit"></i></a>
							<!--<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>순번</th>
								  <th>관리자 ID</th>
								  <th>관리자 이름</th>
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

