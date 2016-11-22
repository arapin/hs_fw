<?
	$user = new User();

	$id = Request::get('id', Request::GET | Request::XSS_CLEAR);

	$setBeen = array(":id" => $id);
	$rData = $user->userModifyInfo($setBeen);
	$birthdayArray = explode("-",$rData["birthday"]);

?>

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
						<h2><i class="halflings-icon edit"></i><span class="break"></span>회원정보 수정</h2>
					</div>
            <form id="file-upload" class="upload"  name="joinForm" method="post" action="?com=user&pro=userinfo&mng=Y" onsubmit="return form_chk_modify();">
<input type="hidden" name="mode" value="modify" />
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" value="<?=$rData["nameCH"]?>" name="nameCH" />

					<div class="box-content">
							<fieldset>
							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">아이디</label>
								<div class="controls">
								<input type="text" name="id" value="<?=$rData["id"]?>" class="input-xlarge disabled">
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
								<input type="text" name="name" value="<?=$rData["name"]?>" class="input-xlarge focused">
								</div>
							  </div>

							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">생년월일</label>
								<div class="controls">
								<input type="text" name="birthdayY" value="<?=$birthdayArray[0]?>" class="input-small focused">년 - 
								<input type="text" name="birthdayM" value="<?=$birthdayArray[1]?>" class="input-small focused">월 - 
								<input type="text" name="birthdayD" value="<?=$birthdayArray[2]?>" class="input-small focused">일
								</div>
							  </div>

							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">휴대폰 번호</label>
								<div class="controls">
								<input type="text" placeholder="- 는 빼고 입력하여 주십시요" id="phone" name="phone" value="<?=$rData["phone"]?>" class="input-xlarge focused">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="appendedInputButtons">우편번호</label>
								<div class="controls">
								  <div class="input-append">
									<input size="16" type="text" name="zipcode" id="zipcode" value="<?=$rData["zipcode"]?>"><button class="btn" type="button" onclick="execDaumPostcode()">Search</button>
								  </div>
								</div>
							  </div>

							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">주소</label>
								<div class="controls">
								<input type="text" placeholder="우편번호를 검색하여 주십시요" name="address" id="address" value="<?=$rData["address"]?>" class="input-xlarge uneditable-input">
								<input type="text" placeholder="" name="address2" id="address2" value="<?=$rData["address2"]?>" class="input-xlarge focused">

								</div>
							  </div>

							  <div class="control-group success">
								<label class="control-label" for="inputSuccess">이메일</label>
								<div class="controls">
								<input type="text" name="email" id="email" value="<?=$rData["email"]?>" class="input-xlarge uneditable-input">
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



