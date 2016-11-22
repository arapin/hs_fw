<?
	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$main = new Main();

	$getBeen = array(":idx" => $idx);
	$rtnData = $main->mainBigInfo($getBeen);

	$fileData = array(":parentId" => $idx, ":type" => "mainBig");
	$fileList = $main->getFileInfoListView($fileData);

?>
            <div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>메인 대표 이미지 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>
            <form id="file-upload" class="upload"  name="writeForm" method="post" action="?com=main&pro=maininfo&mng=Y" enctype="multipart/form-data">
			<input type="hidden" name="idx" value="<?=$idx?>"  />
			<input type="hidden" name="mode" value="mainBig"  />
                <h3>이미지 내용</h3>
                <div class="inner clearfix">
                    <fieldset class="error">
                        <label for="field1">순서</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["seq"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">이미지 명</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["imgName"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">메인 대표 이미지<br/>(추천 이미지 사이즈 1280 X 600)</label>
                        <div class="field clearfix">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:130px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$fileList?></div>

                            <!--<div id="profile-preview">
                                <img src="images/avatar1.jpg" alt="img">
                            </div>
                            <input type="checkbox" data-label="Delete uploaded file?">-->
                            <input type="file" id="profile-inp" name="mainImg">
                            <!--<div id="drop">
                                <p><i class="fa fa-chevron-down"></i>Drag and drop the file here to upload it</p>
                            </div>
                            <input type="file" name="mainImg" id="file-inp" class="inp-drag">-->
                        </div>
                    </fieldset>
                    <input type="submit" value="저장" class="right">
                    <a href="#" class="cancel right" onclick="location.href='/?com=main&lnd=big&mng=Y'">목록으로</a>
                </div>
			</form>