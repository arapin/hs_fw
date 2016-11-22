<?
	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$reservation = new Reservation();

	$getBeen = array(":idx" => $idx);
	$rtnData = $reservation->reservationInfo($getBeen);
?>
            <div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>예약 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>
            <form id="file-upload" class="upload"  name="joinForm" method="post" action="?com=user&pro=userinfo&mng=Y" onsubmit="return form_chk_mng();">
                <h3>예약 내용</h3>
                <div class="inner clearfix">
                    <fieldset class="error">
                        <label for="field1">무속인</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["SName"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">점집명</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["SHName"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">예약자</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["resUserId"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">상품명</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["proName"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">예약일</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["resDate"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">예약시간</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["resStartTime"]?> ~ <?=$rtnData["resEndTime"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">신청일</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["regDate"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">예약상태</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["resState"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">결제방법</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["payType"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">결제상태</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["payState"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">결제금액</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["payPrice"]?></div>
                        </div>
                    </fieldset>
                    <a href="#" class="cancel right" onclick="location.href='/?com=reservation&lnd=list&mng=Y'">목록으로</a>
                </div>
			</form>