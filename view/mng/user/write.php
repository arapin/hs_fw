			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="?mng=Y">Home</a>
					<i class="icon-angle-right"></i> 
				</li>
				<li>
					<i class="icon-edit"></i>
					<a href="#">회원 관리</a>
				</li>
			</ul>

			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>회원정보</h2>
					</div>
            <form id="file-upload" class="upload"  name="joinForm" method="post" action="?com=user&pro=userinfo&mng=Y" onsubmit="return form_chk_mng();">
<input type="hidden" name="mode" value="join" />
<input type="hidden" name="idChk" value="N" />

					<div class="box-content">
							<fieldset>
							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">아이디</label>
								<div class="controls">
								<input type="text" name="id" value="" onkeyup="checkIdString();" class="input-xlarge focused">
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
								<input type="password" name="pwd" value="" class="input-xlarge focused">
								</div>
							  </div>

							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">비밀번호 확인</label>
								<div class="controls">
								<input type="password" name="pwdConfirm" value="" class="input-xlarge focused">
								</div>
							  </div>

							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">이름</label>
								<div class="controls">
								<input type="text" name="name" value="" class="input-xlarge focused">
								</div>
							  </div>

							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">생년월일</label>
								<div class="controls">
								<input type="text" name="birthdayY" value="" class="input-small focused">년 - 
								<input type="text" name="birthdayM" value="" class="input-small focused">월 - 
								<input type="text" name="birthdayD" value="" class="input-small focused">일
								</div>
							  </div>

							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">휴대폰 번호</label>
								<div class="controls">
								<input type="text" placeholder="- 는 빼고 입력하여 주십시요" id="phone" name="phone" value="" class="input-xlarge focused">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="appendedInputButtons">우편번호</label>
								<div class="controls">
								  <div class="input-append">
									<input size="16" type="text" name="zipcode" id="zipcode"><button class="btn" type="button" onclick="execDaumPostcode()">Search</button>
								  </div>
								</div>
							  </div>

							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">주소</label>
								<div class="controls">
								<input type="text" placeholder="우편번호를 검색하여 주십시요" name="address" id="address" value="" class="input-xlarge uneditable-input">
								<input type="text" placeholder="" name="address2" id="address2" value="" class="input-xlarge focused">

								</div>
							  </div>

							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">이메일</label>
								<div class="controls">
								<input type="text" name="email" id="email" value="" class="input-xlarge uneditable-input">
								</div>
							  </div>
							  <div class="form-actions">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<input type="button" class="btn" onclick="location.href='?com=user&lnd=list&mng=Y'" value="Cancel" />
							  </div>
							</fieldset>
						  </form>
					</div>
				</div><!--/span-->

			</div><!--/row-->
    

	</div><!--/.fluid-container-->
			<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
			<script>
				function execDaumPostcode() {
					new daum.Postcode({
						oncomplete: function(data) {
							// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

							// 각 주소의 노출 규칙에 따라 주소를 조합한다.
							// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
							var fullAddr = ''; // 최종 주소 변수
							var extraAddr = ''; // 조합형 주소 변수

							// 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
							if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
								fullAddr = data.roadAddress;

							} else { // 사용자가 지번 주소를 선택했을 경우(J)
								fullAddr = data.jibunAddress;
							}

							// 사용자가 선택한 주소가 도로명 타입일때 조합한다.
							if(data.userSelectedType === 'R'){
								//법정동명이 있을 경우 추가한다.
								if(data.bname !== ''){
									extraAddr += data.bname;
								}
								// 건물명이 있을 경우 추가한다.
								if(data.buildingName !== ''){
									extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
								}
								// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
								fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
							}

							// 우편번호와 주소 정보를 해당 필드에 넣는다.
							$('#zipcode').val(data.zonecode);
							$('#address').val(fullAddr);
							$('#address2').focus();
						}
					}).open();
				}
			</script>