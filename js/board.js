function writeChk(){
	var form = document.writeForm;

	if(form.headWord.value == ""){
		alert('구분을 선택하여 주십시요.');
		return false;
	}

	if(form.title.value == ""){
		alert('제목을 입력하여 주십시요.');
		return false;
	}

	oEditors.getById["txtContent"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
	
	// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
	if($('textarea[name=content]').val() == "" || $('textarea[name=content]').val() == "<p>&nbsp;</p>"){
		alert('내용을 입력하여 주십시요.');
		return false;
	}

	/*if(form.content.value == ""){
		alert('내용을 입력하여 주십시요.');
		return false;
	}*/

	form.submit();
}

function modifyChk(){
	var form = document.writeForm;

	if(form.headWord.value == ""){
		alert('구분을 선택하여 주십시요.');
		return false;
	}

	if(form.title.value == ""){
		alert('제목을 입력하여 주십시요.');
		return false;
	}

	if(form.content.value == ""){
		alert('내용을 입력하여 주십시요.');
		return false;
	}
	form.mode.value = 'modify';
	form.submit();
}

function memoWrite(){
	var form = document.memoForm;

	if(form.content.value == ""){
		alert('내용을 입력하여 주십시요.');
		return false;
	}
	form.submit();
}

function deleteBoard(){
	var form = document.writeForm;
	form.mode.value = 'delete';
	if(confirm('삭제 하시려는 글의 댓글도 같이 삭제 됩니다. 삭제 하시겠습니까?') == true){
		form.submit();
	}
}

function writeChkMng(){
	var form = document.writeForm;

	if(form.title.value == ""){
		alert('제목을 입력하여 주십시요.');
		return false;
	}

	oEditors.getById["field3"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
	
	// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
	if($('textarea[name=content]').val() == "" || $('textarea[name=content]').val() == "<p>&nbsp;</p>"){
		alert('내용을 입력하여 주십시요.');
		return false;
	}

	form.submit();
}

function getMoreList(){
	var page = $('.board_list_1').attr('rel');
	
}

function hiddenMoreBtn(){
	$('#morBtn').hidden();
}

function modifyMng(idx, code){
	location.href = '/?com=board&lnd=modify&mng=Y&idx='+idx+'&code='+code;
}

function deleteMng(idx, code){
	if(confirm('게시물을 삭제 하시겠습니까?') == true){
		location.href = '/?com=board&pro=boardinfo&mode=delete&mng=Y&idx='+idx+'&code='+code;
	}
}

function viewMng(idx, code){
	location.href = '/?com=board&lnd=view&mng=Y&idx='+idx+'&code='+code;
}

function memoModify(idx){
	var form = document.memoForm;
	var content = $('#content'+idx).val();
	
	form.content.value = content;
	form.memoIdx.value = idx;
	form.mode.value = 'memoModify';
}

function memoDelete(idx){
	var form = document.memoForm;
	form.memoIdx.value = idx;
	form.mode.value = 'memoDelete';

	if(confirm('댓글을 삭제 하시겠습니까?') == true){
		form.submit();
	}
}

function setSearchCode(){
	var form = document.searchFrom;
	var headWord = $('select[name=selectHead] > option:selected').val();
	form.searchHead.value = headWord;
	form.submit();
}

function setOrder(val){
	var form = document.searchFrom;
	form.setOrder.value = val;
	form.submit();
}

function goSearch(){
	document.searchFrom.submit();
}

function searchChk(){
	var form = document.searchFrom;

	if(form.searchWord.value == ""){
		alert('검색어를 선택하여 주십시요.');
		return false;
	}

	form.submit();
}