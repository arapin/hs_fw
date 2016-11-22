<?
	mt_srand((double)microtime()*1000000);
	$random_num = mt_rand(1, 100000);
?>            
			<div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>무속인 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>

            <form id="file-upload" class="upload" name="joinForm" method="post" action="?com=shaman&pro=shamaninfo&mng=Y" onsubmit="return form_chk();">
<input type="hidden" name="mode" value="insert" />
<input type="hidden" name="idChk" value="N" />
<input type="hidden" name="SHLng" value=""/>
<input type="hidden" name="SHLat" value=""/>
<input type="hidden" name="fileTempNum" value="<?=$random_num?>"/>

                <h3>무속인 등록</h3>
                <div class="inner clearfix">
                    <fieldset class="error">
                        <label for="field1">아이디</label>
                        <div class="field">
                            <input type="text" placeholder="아이디" id="field1" class="transform_cancel" name="SHId" value="" onkeyup="checkIdStringMng();">
							<span class="chkResult error-alert" id="00" style="display:none;color:blue;font-size:9pt;font-weight:bold;">사용 하실수 있는 아이디 입니다.</span>
							<span class="chkResult error-alert" id="01" style="display:none;color:red;font-size:9pt;font-weight:bold;">아이디는 4글자 이상으로 입력하여 주십시요.</span>
							<span class="chkResult error-alert" id="02" style="display:none;color:red;font-size:9pt;font-weight:bold;">아이디의 첫글자는 영문이어야 합니다.</span>
							<span class="chkResult error-alert" id="03" style="display:none;color:red;font-size:9pt;font-weight:bold;">아이디는 영문, 숫자, -, _ 만 사용할 수 있습니다.</span>
							<span class="chkResult error-alert" id="04" style="display:none;color:red;font-size:9pt;font-weight:bold;">이미 존재하는 아이디 입니다.</span>
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">비밀번호</label>
                        <div class="field">
                            <input type="password" placeholder="비밀번호" id="field1" name="SHPwd" value="">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">비밀번호 확인</label>
                        <div class="field">
                            <input type="password" placeholder="비밀번호" id="field1" name="SHPwdConfirm" value="">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">무속인명</label>
                        <div class="field">
                            <input type="text" placeholder="무속인명" id="field1" name="name" value="">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">상호명</label>
                        <div class="field">
                            <input type="text" placeholder="상호명" id="field1" name="SHName" value="">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">휴대폰</label>
                        <div class="field">
                            <input type="text" placeholder="- 는 빼고 입력하여 주십시요" id="field1" name="SHPhone" value="">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">이메일</label>
                        <div class="field">
                            <input type="text" placeholder="" id="field1" name="SHEmail" value="">
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">우편번호</label>
                        <div class="field" style="white-space:nowrap;">
                            <span><input type="text" placeholder="우편번호" name="SHZipcode" id="zipcode" value="" style="width:100px;disply:inline;" readonly></span><span><input type="button" value="우편번호 찾기" class="hsBtnGreen" onclick="execDaumPostcode()"/></span>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">주소</label>
                        <div class="field" style="white-space:nowrap;">
                            <input type="text" placeholder="우편번호를 검색하여 주십시요" name="SHAddress" id="address" value="" readonly><br/>
							<input type="text" placeholder="상세주소" name="SHAddress2" id="address2" value="">
                        </div>
                    </fieldset>
                    <input type="submit" value="저장" class="right">
                    <a href="#" class="cancel right" onclick="location.href='/?com=shaman&lnd=list&mng=Y'">목록으로</a>
                </div>
            </form>

<div>
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
				codeAddress();
			}
		}).open();
	}

	function setFilename(fileName){
		$('#fileResult').html(fileName);
	}
</script>