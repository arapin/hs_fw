function form_chk(){
	var form = document.joinForm;
	var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;   
	 
	if(form.id.value == ""){
		alert('아이디를 입력하여 주십시요');
		return false;
	}

	if(form.idChk.value != 'Y'){
		alert('사용하실수 있는 아이디를 입력하여 주십시요.');
		return false;
	}

	if(form.pwd.value == ""){
		alert('비밀번호를 입력하여 주십시요');
		return false;
	}

	if(form.nick.value == ""){
		alert('닉네임을 입력하여 주십시요');
		return false;
	}

	if(form.email.value == ""){
		alert('이메일을 입력하여 주십시요');
		return false;
	}

	if(regex.test(form.email.value) === false) {  
		alert("잘못된 이메일 형식입니다.");  
		return false;  
	}

	form.submit();
}

function form_chk_mng(){
	var form = document.joinForm;
	var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;   
	var rgEx = /(01[016789])(\d{4}|\d{3})\d{4}$/g;

	if(form.id.value == ""){
		alert('아이디를 입력하여 주십시요');
		return false;
	}

	if(form.idChk.value != 'Y'){
		alert('사용하실수 있는 아이디를 입력하여 주십시요.');
		return false;
	}

	if(form.pwd.value == ""){
		alert('비밀번호를 입력하여 주십시요');
		return false;
	}

	if(form.pwdConfirm.value == ""){
		alert('비밀번호 확인란을 입력하여 주십시요');
		return false;
	}

	if(form.pwd.value != form.pwdConfirm.value){
		alert('비밀번호와 비밀번호 확인이 다릅니다. 다시 확인하여 주십시요.');
		return false;
	}

	/*if(form.name.value == ""){
		alert('이름을 입력하여 주십시요');
		return false;
	}*/

	if(form.birthdayY.value == ""){
		alert('탄생년도를 선택하여 주십시요');
		return false;
	}

	if(form.birthdayM.value == ""){
		alert('탄생월을 선택하여 주십시요');
		return false;
	}

	if(form.birthdayD.value == ""){
		alert('탄생일을 선택하여 주십시요');
		return false;
	}

	if(form.birthdayH.value == ""){
		alert('탄생시간을 선택하여 주십시요');
		return false;
	}

	if(form.birthdayMI.value == ""){
		alert('탄생분을 선택하여 주십시요');
		return false;
	}

	if(form.phone.value == ""){
		alert('휴대전화 번호를 입력하여 주십시요');
		return false;
	}

	if(rgEx.test(form.phone.value) === false) {  
		alert("잘못된 휴대전화 번호 형식입니다.");  
		return false;  
	}

	if(form.zipcode.value == ""){
		alert('우편번호를 입력하여 주십시요');
		return false;
	}

	if(form.address2.value == ""){
		alert('상세주소를 입력하여 주십시요');
		return false;
	}

	if(form.email.value == ""){
		alert('이메일을 입력하여 주십시요');
		return false;
	}

	if(regex.test(form.email.value) === false) {  
		alert("잘못된 이메일 형식입니다.");  
		return false;  
	}

	return true;
}

function login_chk(){
	var form = document.loginForm;

	if(form.id.value == ""){
		alert('아이디를 입력하여 주십시요');
		return false;
	}

	if(form.pwd.value == ""){
		alert('비밀번호를 입력하여 주십시요');
		return false;
	}

	form.submit();
}

function form_chk_update(){
	var form = document.joinForm;

	if(form.nick.value == ""){
		alert('닉네임을 입력하여 주십시요');
		return false;
	}

	if(form.email.value == ""){
		alert('이메일을 입력하여 주십시요');
		return false;
	}

	form.submit();
}

function modifyMng(id){
	location.href = '/?com=user&lnd=modify&mng=Y&id='+id;
}

function deleteMng(id){
	if(confirm('유저 정보를 삭제 하시겠습니까?') == true){
		location.href = '/?com=user&pro=userinfo&mode=delete&mng=Y&id='+id;
	}
}

function checkIdString(){
	var idString = $('input[name=id]').val();

	$.ajax({
		url : '/?com=user&pro=userinfo&mode=idCheck&mng=Y',
		data : {'id':idString},
		type : 'post',
		success : function(data){
			var getCode = trim(data);
			$('.chkResult').each(function(){
				$(this).hide();
			});
			$('.chkResult').each(function(){
				var rtnData = trim($(this).attr('id'));
				if(rtnData == getCode){
					$(this).show();
				}
			});

			if(getCode == '00'){
				$('input[name=idChk]').val('Y');
			}else{
				$('input[name=idChk]').val('N');
			}
		},
		error : function(){
			alert('통신 오류 입니다.');
		}
	});
}

function checkIdStringFront(){
	var idString = $('input[name=id]').val();

	$.ajax({
		url : '/?com=user&pro=userinfo&mode=idCheck',
		data : {'id':idString},
		type : 'post',
		success : function(data){
			var getCode = trim(data);
			$('.chkResult').each(function(){
				$(this).hide();
			});
			$('.chkResult').each(function(){
				var rtnData = trim($(this).attr('id'));

				if(rtnData == getCode){
					$(this).show();
				}
			});

			if(getCode == '00'){
				$('input[name=idChk]').val('Y');
			}else{
				$('input[name=idChk]').val('N');
			}
		},
		error : function(){
			alert('통신 오류 입니다.');
		}
	});
}