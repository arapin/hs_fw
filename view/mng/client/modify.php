<script src="https://maps.googleapis.com/maps/api/js"></script>
<?
	$client = new Client();

	$SHId = Request::get('SHId', Request::GET | Request::XSS_CLEAR);

	$shamanData = array(":SHId" => $SHId);
	$rData = $client->clientModifyInfo($shamanData);
	
	$fileData = array(":parentId" => $SHId, ":type" => "shaman");
	$fileList = $client->getFileInfoListView($fileData);

	$fileData2 = array(":parentId" => $SHId, ":type" => "profile");
	$profileData = $client->getProfileInfoListView($fileData2);

	$sprData = array(":SHIdx" => $rData["idx"]);
	$sprList = $client->getSprInfoListView($sprData);

	$limitList = $client->getLimitDayInfoListView2($sprData);

?>            
			<div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>무속인 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>

            <form id="file-upload" class="upload" name="joinForm" method="post" action="?com=shaman&pro=shamaninfo&mng=Y" onsubmit="return form_chk();" enctype="multipart/form-data">
<input type="hidden" name="mode" value="modify" />
<input type="hidden" name="SHId" value="<?=$rData["SHId"]?>" />
<input type="hidden" name="SHPwd" value="<?=$rData["SHPwd"]?>" />
<input type="hidden" name="SHLng" value="<?=$rData["SHLng"]?>"/>
<input type="hidden" name="SHLat" value="<?=$rData["SHLat"]?>"/>

                <h3>무속인 정보 관리</h3>
                <div class="inner clearfix">
                    <fieldset class="error">
                        <label for="field1">아이디</label>
                        <div class="field">
                            <input type="text" placeholder="아이디" id="field1" class="transform_cancel" name="SHIdView" value="<?=$rData["SHId"]?>" readonly>
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">비밀번호</label>
                        <div class="field">
                            <input type="password" placeholder="비밀번호" id="field1" name="SHPwdU" value="">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">비밀번호 확인</label>
                        <div class="field">
                            <input type="password" placeholder="비밀번호" id="field1" name="SHPwdUConfirm" value="">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">대표자 성명</label>
                        <div class="field">
                            <input type="text" placeholder="명" id="field1" name="name" value="<?=$rData["name"]?>">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">상호명</label>
                        <div class="field">
                            <input type="text" placeholder="상호명" id="field1" name="SHName" value="<?=$rData["SHName"]?>">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">전화번호</label>
                        <div class="field">
                            <input type="text" placeholder="- 는 빼고 입력하여 주십시요" id="field1" name="SHTel" value="<?=$rData["SHTel"]?>">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">휴대폰</label>
                        <div class="field">
                            <input type="text" placeholder="- 는 빼고 입력하여 주십시요" id="field1" name="SHPhone" value="<?=$rData["SHPhone"]?>">
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">우편번호</label>
                        <div class="field" style="white-space:nowrap;">
                            <span><input type="text" placeholder="우편번호" name="SHZipcode" id="zipcode" value="<?=$rData["SHZipcode"]?>" style="width:100px;disply:inline;" readonly></span><span><input type="button" value="우편번호 찾기" class="hsBtnGreen" onclick="execDaumPostcode()"/></span>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">주소</label>
                        <div class="field" style="white-space:nowrap;">
                            <input type="text" placeholder="우편번호를 검색하여 주십시요" name="SHAddress" id="address" value="<?=$rData["SHAddress"]?>" readonly><br/>
							<input type="text" placeholder="상세주소" name="SHAddress2" id="address2" value="<?=$rData["SHAddress2"]?>">
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">상세 설명</label>
                        <div class="field" style="white-space:nowrap;">
							<textarea placeholder="점집 설명으로 200자 내외로 작성하여 주십시요" id="field13" name="SHDesc"><?=$rData["SHDesc"]?></textarea>
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">예약가능시간</label>
                        <div class="field">
							<select class="chosen-select" name="SHStartTime">
								<option value="">시작시간</option>
								<option value="08:00" <?if($rData["SHStartTime"] == "08:00"){?>selected<?}?>>08:00</option>
								<option value="08:30" <?if($rData["SHStartTime"] == "08:30"){?>selected<?}?>>08:30</option>
								<option value="09:00" <?if($rData["SHStartTime"] == "09:00"){?>selected<?}?>>09:00</option>
								<option value="09:30" <?if($rData["SHStartTime"] == "09:30"){?>selected<?}?>>09:30</option>
								<option value="10:00" <?if($rData["SHStartTime"] == "10:00"){?>selected<?}?>>10:00</option>
								<option value="10:30" <?if($rData["SHStartTime"] == "10:30"){?>selected<?}?>>10:30</option>
								<option value="11:00" <?if($rData["SHStartTime"] == "11:00"){?>selected<?}?>>11:00</option>
								<option value="11:30" <?if($rData["SHStartTime"] == "11:30"){?>selected<?}?>>11:30</option>
								<option value="12:00" <?if($rData["SHStartTime"] == "12:00"){?>selected<?}?>>12:00</option>
								<option value="12:30" <?if($rData["SHStartTime"] == "12:30"){?>selected<?}?>>12:30</option>
								<option value="13:00" <?if($rData["SHStartTime"] == "13:00"){?>selected<?}?>>13:00</option>
								<option value="13:30" <?if($rData["SHStartTime"] == "13:30"){?>selected<?}?>>13:30</option>
								<option value="14:00" <?if($rData["SHStartTime"] == "14:00"){?>selected<?}?>>14:00</option>
								<option value="14:30" <?if($rData["SHStartTime"] == "14:30"){?>selected<?}?>>14:30</option>
								<option value="15:00" <?if($rData["SHStartTime"] == "15:00"){?>selected<?}?>>15:00</option>
								<option value="15:30" <?if($rData["SHStartTime"] == "15:30"){?>selected<?}?>>15:30</option>
								<option value="16:00" <?if($rData["SHStartTime"] == "16:00"){?>selected<?}?>>16:00</option>
								<option value="16:30" <?if($rData["SHStartTime"] == "16:30"){?>selected<?}?>>16:30</option>
								<option value="17:00" <?if($rData["SHStartTime"] == "17:00"){?>selected<?}?>>17:00</option>
								<option value="17:30" <?if($rData["SHStartTime"] == "17:30"){?>selected<?}?>>17:30</option>
								<option value="18:00" <?if($rData["SHStartTime"] == "18:00"){?>selected<?}?>>18:00</option>
								<option value="18:30" <?if($rData["SHStartTime"] == "18:30"){?>selected<?}?>>18:30</option>
								<option value="19:00" <?if($rData["SHStartTime"] == "19:00"){?>selected<?}?>>19:00</option>
								<option value="19:30" <?if($rData["SHStartTime"] == "19:30"){?>selected<?}?>>19:30</option>
								<option value="20:00" <?if($rData["SHStartTime"] == "20:00"){?>selected<?}?>>20:00</option>
								<option value="20:30" <?if($rData["SHStartTime"] == "20:30"){?>selected<?}?>>20:30</option>
								<option value="21:00" <?if($rData["SHStartTime"] == "21:00"){?>selected<?}?>>21:00</option>
								<option value="21:30" <?if($rData["SHStartTime"] == "21:30"){?>selected<?}?>>21:30</option>
								<option value="22:00" <?if($rData["SHStartTime"] == "22:00"){?>selected<?}?>>22:00</option>
								<option value="22:30" <?if($rData["SHStartTime"] == "22:30"){?>selected<?}?>>22:30</option>
							</select>
							<br/>
								<select class="chosen-select" name="SHEndTime">
								<option value="">종료시간</option>
								<option value="08:00" <?if($rData["SHEndTime"] == "08:00"){?>selected<?}?>>08:00</option>
								<option value="08:30" <?if($rData["SHEndTime"] == "08:30"){?>selected<?}?>>08:30</option>
								<option value="09:00" <?if($rData["SHEndTime"] == "09:00"){?>selected<?}?>>09:00</option>
								<option value="09:30" <?if($rData["SHEndTime"] == "09:30"){?>selected<?}?>>09:30</option>
								<option value="10:00" <?if($rData["SHEndTime"] == "10:00"){?>selected<?}?>>10:00</option>
								<option value="10:30" <?if($rData["SHEndTime"] == "10:30"){?>selected<?}?>>10:30</option>
								<option value="11:00" <?if($rData["SHEndTime"] == "11:00"){?>selected<?}?>>11:00</option>
								<option value="11:30" <?if($rData["SHEndTime"] == "11:30"){?>selected<?}?>>11:30</option>
								<option value="12:00" <?if($rData["SHEndTime"] == "12:00"){?>selected<?}?>>12:00</option>
								<option value="12:30" <?if($rData["SHEndTime"] == "12:30"){?>selected<?}?>>12:30</option>
								<option value="13:00" <?if($rData["SHEndTime"] == "13:00"){?>selected<?}?>>13:00</option>
								<option value="13:30" <?if($rData["SHEndTime"] == "13:30"){?>selected<?}?>>13:30</option>
								<option value="14:00" <?if($rData["SHEndTime"] == "14:00"){?>selected<?}?>>14:00</option>
								<option value="14:30" <?if($rData["SHEndTime"] == "14:30"){?>selected<?}?>>14:30</option>
								<option value="15:00" <?if($rData["SHEndTime"] == "15:00"){?>selected<?}?>>15:00</option>
								<option value="15:30" <?if($rData["SHEndTime"] == "15:30"){?>selected<?}?>>15:30</option>
								<option value="16:00" <?if($rData["SHEndTime"] == "16:00"){?>selected<?}?>>16:00</option>
								<option value="16:30" <?if($rData["SHEndTime"] == "16:30"){?>selected<?}?>>16:30</option>
								<option value="17:00" <?if($rData["SHEndTime"] == "17:00"){?>selected<?}?>>17:00</option>
								<option value="17:30" <?if($rData["SHEndTime"] == "17:30"){?>selected<?}?>>17:30</option>
								<option value="18:00" <?if($rData["SHEndTime"] == "18:00"){?>selected<?}?>>18:00</option>
								<option value="18:30" <?if($rData["SHEndTime"] == "18:30"){?>selected<?}?>>18:30</option>
								<option value="19:00" <?if($rData["SHEndTime"] == "19:00"){?>selected<?}?>>19:00</option>
								<option value="19:30" <?if($rData["SHEndTime"] == "19:30"){?>selected<?}?>>19:30</option>
								<option value="20:00" <?if($rData["SHEndTime"] == "20:00"){?>selected<?}?>>20:00</option>
								<option value="20:30" <?if($rData["SHEndTime"] == "20:30"){?>selected<?}?>">20:30</option>
								<option value="21:00" <?if($rData["SHEndTime"] == "21:00"){?>selected<?}?>>21:00</option>
								<option value="21:30" <?if($rData["SHEndTime"] == "21:30"){?>selected<?}?>>21:30</option>
								<option value="22:00" <?if($rData["SHEndTime"] == "22:00"){?>selected<?}?>>22:00</option>
								<option value="22:30" <?if($rData["SHEndTime"] == "22:30"){?>selected<?}?>>22:30</option>
							</select>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">휴식시간</label>
                        <div class="field">
							<select class="chosen-select" name="SHRestSTime">
								<option value="">시작시간</option>
								<option value="08:00" <?if($rData["SHRestSTime"] == "08:00"){?>selected<?}?>>08:00</option>
								<option value="08:30" <?if($rData["SHRestSTime"] == "08:30"){?>selected<?}?>>08:30</option>
								<option value="09:00" <?if($rData["SHRestSTime"] == "09:00"){?>selected<?}?>>09:00</option>
								<option value="09:30" <?if($rData["SHRestSTime"] == "09:30"){?>selected<?}?>>09:30</option>
								<option value="10:00" <?if($rData["SHRestSTime"] == "10:00"){?>selected<?}?>>10:00</option>
								<option value="10:30" <?if($rData["SHRestSTime"] == "10:30"){?>selected<?}?>>10:30</option>
								<option value="11:00" <?if($rData["SHRestSTime"] == "11:00"){?>selected<?}?>>11:00</option>
								<option value="11:30" <?if($rData["SHRestSTime"] == "11:30"){?>selected<?}?>>11:30</option>
								<option value="12:00" <?if($rData["SHRestSTime"] == "12:00"){?>selected<?}?>>12:00</option>
								<option value="12:30" <?if($rData["SHRestSTime"] == "12:30"){?>selected<?}?>>12:30</option>
								<option value="13:00" <?if($rData["SHRestSTime"] == "13:00"){?>selected<?}?>>13:00</option>
								<option value="13:30" <?if($rData["SHRestSTime"] == "13:30"){?>selected<?}?>>13:30</option>
								<option value="14:00" <?if($rData["SHRestSTime"] == "14:00"){?>selected<?}?>>14:00</option>
								<option value="14:30" <?if($rData["SHRestSTime"] == "14:30"){?>selected<?}?>>14:30</option>
								<option value="15:00" <?if($rData["SHRestSTime"] == "15:00"){?>selected<?}?>>15:00</option>
								<option value="15:30" <?if($rData["SHRestSTime"] == "15:30"){?>selected<?}?>>15:30</option>
								<option value="16:00" <?if($rData["SHRestSTime"] == "16:00"){?>selected<?}?>>16:00</option>
								<option value="16:30" <?if($rData["SHRestSTime"] == "16:30"){?>selected<?}?>>16:30</option>
								<option value="17:00" <?if($rData["SHRestSTime"] == "17:00"){?>selected<?}?>>17:00</option>
								<option value="17:30" <?if($rData["SHRestSTime"] == "17:30"){?>selected<?}?>>17:30</option>
								<option value="18:00" <?if($rData["SHRestSTime"] == "18:00"){?>selected<?}?>>18:00</option>
								<option value="18:30" <?if($rData["SHRestSTime"] == "18:30"){?>selected<?}?>>18:30</option>
								<option value="19:00" <?if($rData["SHRestSTime"] == "19:00"){?>selected<?}?>>19:00</option>
								<option value="19:30" <?if($rData["SHRestSTime"] == "19:30"){?>selected<?}?>>19:30</option>
								<option value="20:00" <?if($rData["SHRestSTime"] == "20:00"){?>selected<?}?>>20:00</option>
								<option value="20:30  <?if($rData["SHRestSTime"] == "20:30"){?>selected<?}?>">20:30</option>
								<option value="21:00" <?if($rData["SHRestSTime"] == "21:00"){?>selected<?}?>>21:00</option>
								<option value="21:30" <?if($rData["SHRestSTime"] == "21:30"){?>selected<?}?>>21:30</option>
								<option value="22:00" <?if($rData["SHRestSTime"] == "22:00"){?>selected<?}?>>22:00</option>
								<option value="22:30" <?if($rData["SHRestSTime"] == "22:30"){?>selected<?}?>>22:30</option>
							</select>
							<br/>
								<select class="chosen-select" name="SHRestETime">
								<option value="">종료시간</option>
								<option value="08:00" <?if($rData["SHRestETime"] == "08:00"){?>selected<?}?>>08:00</option>
								<option value="08:30" <?if($rData["SHRestETime"] == "08:30"){?>selected<?}?>>08:30</option>
								<option value="09:00" <?if($rData["SHRestETime"] == "09:00"){?>selected<?}?>>09:00</option>
								<option value="09:30" <?if($rData["SHRestETime"] == "09:30"){?>selected<?}?>>09:30</option>
								<option value="10:00" <?if($rData["SHRestETime"] == "10:00"){?>selected<?}?>>10:00</option>
								<option value="10:30" <?if($rData["SHRestETime"] == "10:30"){?>selected<?}?>>10:30</option>
								<option value="11:00" <?if($rData["SHRestETime"] == "11:00"){?>selected<?}?>>11:00</option>
								<option value="11:30" <?if($rData["SHRestETime"] == "11:30"){?>selected<?}?>>11:30</option>
								<option value="12:00" <?if($rData["SHRestETime"] == "12:00"){?>selected<?}?>>12:00</option>
								<option value="12:30" <?if($rData["SHRestETime"] == "12:30"){?>selected<?}?>>12:30</option>
								<option value="13:00" <?if($rData["SHRestETime"] == "13:00"){?>selected<?}?>>13:00</option>
								<option value="13:30" <?if($rData["SHRestETime"] == "13:30"){?>selected<?}?>>13:30</option>
								<option value="14:00" <?if($rData["SHRestETime"] == "14:00"){?>selected<?}?>>14:00</option>
								<option value="14:30" <?if($rData["SHRestETime"] == "14:30"){?>selected<?}?>>14:30</option>
								<option value="15:00" <?if($rData["SHRestETime"] == "15:00"){?>selected<?}?>>15:00</option>
								<option value="15:30" <?if($rData["SHRestETime"] == "15:30"){?>selected<?}?>>15:30</option>
								<option value="16:00" <?if($rData["SHRestETime"] == "16:00"){?>selected<?}?>>16:00</option>
								<option value="16:30" <?if($rData["SHRestETime"] == "16:30"){?>selected<?}?>>16:30</option>
								<option value="17:00" <?if($rData["SHRestETime"] == "17:00"){?>selected<?}?>>17:00</option>
								<option value="17:30" <?if($rData["SHRestETime"] == "17:30"){?>selected<?}?>>17:30</option>
								<option value="18:00" <?if($rData["SHRestETime"] == "18:00"){?>selected<?}?>>18:00</option>
								<option value="18:30" <?if($rData["SHRestETime"] == "18:30"){?>selected<?}?>>18:30</option>
								<option value="19:00" <?if($rData["SHRestETime"] == "19:00"){?>selected<?}?>>19:00</option>
								<option value="19:30" <?if($rData["SHRestETime"] == "19:30"){?>selected<?}?>>19:30</option>
								<option value="20:00" <?if($rData["SHRestETime"] == "20:00"){?>selected<?}?>>20:00</option>
								<option value="20:30" <?if($rData["SHRestETime"] == "20:30"){?>selected<?}?>>20:30</option>
								<option value="21:00" <?if($rData["SHRestETime"] == "21:00"){?>selected<?}?>>21:00</option>
								<option value="21:30" <?if($rData["SHRestETime"] == "21:30"){?>selected<?}?>>21:30</option>
								<option value="22:00" <?if($rData["SHRestETime"] == "22:00"){?>selected<?}?>>22:00</option>
								<option value="22:30" <?if($rData["SHRestETime"] == "22:30"){?>selected<?}?>>22:30</option>  
							</select>
                        </div>
                    </fieldset>
                    <fieldset>
                        <label for="field7">상점 이미지</label>
                        <div class="field clearfix">
                            <div id="profile-preview">
<?if($profileData["saveName"] != ""){?>
                                <img src="/upload/shaman/<?=$profileData["saveName"]?>" alt="img">
<?}else{?>
                                <img src="images/avatar1.jpg" alt="img">
<?}?>
                            </div>
                            <input type="file" id="profile-inp" name="profile">
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">예약 제한 일자</label>
                        <div class="field">
							<div class="chkResult error-alert" id="limitResult" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:100px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$limitList?></div>
							<input type="button" value="예약제한일자 관리" class="hsBtnGreen" onclick="modifyLimit('<?=$rData["idx"]?>');"/>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">상점 대표사진</label>
                        <div class="field">
							<div class="chkResult error-alert" id="fileResult" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:100px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$fileList?></div>
							<input type="button" value="이미지 파일 관리" class="hsBtnGreen" onclick="modifyFile('<?=$rData["SHId"]?>');"/>
                        </div>
                    </fieldset>
<?if($rData["SHStatus"] == "U"){?>
                    <fieldset class="error">
                        <label for="field1">상점 상품</label>
                        <div class="field">
							<div class="chkResult error-alert" id="sprResult" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:100px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$sprList?></div>
							<input type="button" value="상품 관리" class="hsBtnGreen" onclick="modifyProduct('<?=$rData["idx"]?>');"/>
                        </div>
                    </fieldset>
<?}?>
                    <input type="submit" value="저장" class="right">
<?if($rData["SHApply"] != "Y"){?>
                    <a href="#" class="cancel right" onclick="applyShaman2('<?=$rData["SHId"]?>');">상점인증</a>
<?}else{?>
                    <a href="#" class="cancel right" onclick="cancelShaman2('<?=$rData["SHId"]?>');">상점인증취소</a>
<?}?>

<?if($rData["SHStatus"] != "U"){?>
                    <a href="#" class="cancel right" onclick="applyShaman('<?=$rData["SHId"]?>');">상점승인</a>
<?}?>
<?if($rData["SHStatus"] == "U"){?>

                    <a href="#" class="cancel right" onclick="cancelShaman('<?=$rData["SHId"]?>');">상점승인취소</a>
<?}?>

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

	function setSprname(fileName){
		$('#sprResult').html(fileName);
	}

	function setLimitName(fileName){
		$('#limitResult').html(fileName);
	}
</script>