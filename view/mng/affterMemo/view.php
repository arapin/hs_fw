<?
	$affterMemo = new AffterMemo();

	$idx = Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);

	$getBeen = array(":idx" => $idx);
	$rtnData = $affterMemo->affterMemoInfo($getBeen);
?>
			<script type="text/javascript" src="/se2/js/HuskyEZCreator.js" charset="utf-8"></script>
			<div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>후기 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>
            <form id="file-upload" class="upload"  name="joinForm" method="post">
                <h3>게시물 내용</h3>
                <div class="inner clearfix">
                    <fieldset class="error">
                        <label for="field1">상점명</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["SHName"]?></div>
						</div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">등록자</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["userId"]?></div>
						</div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">등록일</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["writeDate"]?></div>
						</div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">별점</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;">
							정확성 : <?=$rtnData["pointerP"]?>점 <br/><br/>
							친절도 : <?=$rtnData["serviceP"]?>점 <br/><br/>
							위치 : <?=$rtnData["locationP"]?>점 <br/><br/>
							가격 : <?=$rtnData["priceP"]?>점
							</div>
						</div>
                    </fieldset>
					<fieldset class="error">
						<label for="field13">내용</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:auto;margin-bottom:5px;padding:5px;line-height: 10px;"><?=nl2br($rtnData["memo"])?></div>
						</div>
                    </fieldset>
                    <a href="#" class="cancel right" onclick="deleteMng('<?=$idx?>')">삭제하기</a>
                    <a href="#" class="cancel right" onclick="location.href='?com=affterMemo&lnd=list&mng=Y'">목록으로</a>
                </div>
            </form>
