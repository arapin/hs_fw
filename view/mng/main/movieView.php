<?
	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$main = new Main();

	$getBeen = array(":idx" => $idx);
	$rtnData = $main->mainMovieInfo($getBeen);

?>
            <div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>메인 동영상 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>
            <form id="file-upload" class="upload"  name="writeForm" method="post" action="?com=main&pro=maininfo&mng=Y" enctype="multipart/form-data">
			<input type="hidden" name="idx" value="<?=$idx?>"  />
			<input type="hidden" name="mode" value="mainMovie"  />
                <h3>동영상 내용</h3>
                <div class="inner clearfix">
                    <fieldset class="error">
                        <label for="field1">순서</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["seq"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">동영상 경로</label>
                        <div class="field">
                            <input type="text" placeholder="동영상 경로" id="field1" class="transform_cancel" name="url" value="<?=$rtnData["url"]?>" >
                    </fieldset>
                    <input type="submit" value="저장" class="right">
                    <a href="#" class="cancel right" onclick="location.href='/?com=main&lnd=movie&mng=Y'">목록으로</a>
                </div>
			</form>