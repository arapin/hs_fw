<?
	$aqBoard = new AqBoard();

	$idx = Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);

	$getBeen = array(":idx" => $idx);
	$rtnData = $aqBoard->getAqBoardInfoMng($getBeen);
?>
			<script type="text/javascript" src="/se2/js/HuskyEZCreator.js" charset="utf-8"></script>
			<div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>신점 문의 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>
            <form id="file-upload" class="upload"  name="joinForm" method="post">
                <h3>신점 문의 내용</h3>
                <div class="inner clearfix">

                    <fieldset class="error">
                        <label for="field1">제목</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["title"]?></div>
						</div>
                    </fieldset>

                    <fieldset class="error">
                        <label for="field1">상담 분야</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["productName"]?></div>
						</div>
                    </fieldset>

                    <fieldset class="error">
                        <label for="field1">상담자</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["userId"]?></div>
						</div>
                    </fieldset>

                    <fieldset class="error">
                        <label for="field1">상태</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["state"]?></div>
						</div>
                    </fieldset>

                    <fieldset class="error">
                        <label for="field1">결제상태</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["payStatus"]?></div>
						</div>
                    </fieldset>

                    <!--<fieldset class="error">
                        <label for="field1">답변 기간</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"></div>
						</div>
                    </fieldset>-->

					<fieldset class="error">
						<label for="field13">내용</label>
                        <div class="field">

							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["content"]?></div>
						</div>
                    </fieldset>

					<fieldset class="error">
						<label for="field13">답변</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;">
								답변자 : <br/>
								답변 제목 : <br/>
								답변 내용 : <br/>
							</div>
						</div>
                    </fieldset>
                    <a href="#" class="cancel right" onclick="location.href='?com=aqBoard&lnd=list&mng=Y'">목록으로</a>
                </div>
            </form>
