			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="?mng=Y">Home</a>
					<i class="icon-angle-right"></i> 
				</li>
				<li>
					<i class="icon-edit"></i>
					<a href="#">관리자 관리</a>
				</li>
			</ul>

			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>관리자 정보</h2>
					</div>
            <form id="file-upload" class="upload"  name="joinForm" method="post" action="?com=mng&pro=mnginfo&mng=Y">
<input type="hidden" name="mode" value="join" />
<input type="hidden" name="idChk" value="N" />
					<div class="box-content">
						<fieldset>
						  <div class="control-group success">
							<label class="control-label" for="inputSuccess">아이디</label>
							<div class="controls">
							<input type="text" id="inputSuccess" name="mngId" value="" onkeyup="checkIdString();" class="input-xlarge focused">
							<span class="help-inline chkResult" id="00" style="display:none;color:blue;font-size:9pt;font-weight:bold;">사용 하실수 있는 아이디 입니다.</span>
							<span class="help-inline chkResult" id="01" style="display:none;color:red;font-size:9pt;font-weight:bold;">아이디는 4글자 이상으로 입력하여 주십시요.</span>
							<span class="help-inline chkResult" id="02" style="display:none;color:red;font-size:9pt;font-weight:bold;">아이디의 첫글자는 영문이어야 합니다.</span>
							<span class="help-inline chkResult" id="03" style="display:none;color:red;font-size:9pt;font-weight:bold;">아이디는 영문, 숫자, -, _ 만 사용할 수 있습니다.</span>
							<span class="help-inline chkResult" id="04" style="display:none;color:red;font-size:9pt;font-weight:bold;">이미 존재하는 아이디 입니다.</span>
							</div>
						  </div>
						  <div class="control-group success">
							<label class="control-label" for="inputSuccess">비밀번호</label>
							<div class="controls">
							<input type="password" id="inputSuccess" id="field1" name="mngPwd" value="" class="input-xlarge focused">
							</div>
						  </div>
						  <div class="control-group">
							<label class="control-label">관리자 레벨</label>
							<div class="controls">
							  <label class="radio">
								<input type="radio" name="mngLevel" id="optionsRadios1" value="SA" checked="">
								총괄 관리자
							  </label>
							  <div style="clear:both"></div>
							  <label class="radio">
								<input type="radio" name="mngLevel" id="optionsRadios2" value="NA">
								일반 관리자
							  </label>
							</div>
						  </div>
						  <div class="control-group success">
							<label class="control-label" for="inputSuccess">관리자 이름</label>
							<div class="controls">
							<input type="text" id="inputSuccess" name="mngName" id="email" value="" class="input-xlarge uneditable-input">
							</div>
						  </div>
						  <div class="form-actions">
							<button type="submit" class="btn btn-primary">Save changes</button>
							<input type="button" class="btn" onclick="location.href='?com=mng&lnd=list&mng=Y'" value="Cancel" />
						  </div>
						</fieldset>
					</div>
			</form>
				</div><!--/span-->

			</div><!--/row-->
    

	</div><!--/.fluid-container-->