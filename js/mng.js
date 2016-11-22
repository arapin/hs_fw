function form_chk(){
	var form = document.joinForm;

	if(form.mngId.value == ""){
		alert('아이디를 입력하여 주십시요');
		return false;
	}

	if(form.idChk.value != 'Y'){
		alert('사용하실수 있는 아이디를 입력하여 주십시요.');
		return false;
	}

	if(form.mngPwd.value == ""){
		alert('비밀번호를 입력하여 주십시요');
		return false;
	}

	if(form.mngName.value == ""){
		alert('이름을 입력하여 주십시요');
		return false;
	}

	form.submit();
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

function modifyMng(idx){
	location.href = '/?com=mng&lnd=modify&mng=Y&idx='+idx;
}

function deleteMng(idx){
	if(confirm('관리자 정보를 삭제 하시겠습니까?') == true){
		location.href = '/?com=mng&pro=mnginfo&mode=delete&mng=Y&idx='+idx;
	}
}

function checkIdString(){
	var idString = $('input[name=mngId]').val();
	$.ajax({
		url : '/?com=mng&pro=mnginfo&mode=idCheck&mng=Y',
		data : {'mngId':idString},
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