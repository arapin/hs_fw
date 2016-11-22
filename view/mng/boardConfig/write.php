            <div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>게시판 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>

            <form id="file-upload" class="upload"  name="writeForm" method="post" action="?com=boardConfig&pro=boardConfigInfo&mng=Y" onsubmit="return form_chk();">
<input type="hidden" name="mode" value="insert" />
<input type="hidden" name="idChk" value="N" />

                <h3>게시판 등록</h3>
                <div class="inner clearfix">
                     <fieldset class="error">
                        <label for="field1">게시판코드</label>
                        <div class="field">
                            <input type="text" placeholder="게시판코드" id="boardCode" name="boardCode" value="">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">게시판 명</label>
                        <div class="field">
                            <input type="text" placeholder="게시판명" id="boardName" name="boardName" value="">
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">게시판 종류</label>
                        <div class="field">
                            <select class="chosen-select" id="boardType" name="boardType" style="margin: 0 0 10px 0;">
                                <option value="board">게시판</option>
                                <option value="answer">후기</option>
                            </select>
                        </div>
                    </fieldset>
                     <fieldset class="error">
                        <label for="field1">답글</label>
                        <div class="field">
                            <input type="radio" data-label="예" name="depthType" value="Y">
                            <input type="radio" data-label="아니오" name="depthType" value="N" checked>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">게시판 관리자</label>
                        <div class="field">
                            <input type="text" placeholder="점집 게시판이 아닐경우 free를 입력 하여 주십시요." id="ownerId" class="transform_cancel" name="ownerId" value="" onkeyup="checkIdString();">
							<span class="chkResult error-alert" id="00" style="display:none;color:blue;font-size:9pt;font-weight:bold;">사용 하실수 있는 아이디 입니다.</span>
							<span class="chkResult error-alert" id="01" style="display:none;color:red;font-size:9pt;font-weight:bold;">등록되지 않은 아이디 입니다.</span>
							<span class="chkResult error-alert" id="02" style="display:none;color:blue;font-size:9pt;font-weight:bold;">점집 게시판이 아닌 공용 게시판 입니다.</span>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">사용유무</label>
                        <div class="field">
                            <input type="radio" data-label="사용" name="useType" value="Y" checked>
                            <input type="radio" data-label="미사용" name="useType" value="N">
                        </div>
                    </fieldset>												

                    <input type="submit" value="저장" class="right">
                    <a href="#" class="cancel right" onclick="location.href='?com=boardConfig&lnd=list&mng=Y'">목록으로</a>
                </div>
            </form>
