<?
	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$payment = new Payment();

	$getBeen = array(":idx" => $idx);
	$rtnData = $payment->getPaymentInfo($getBeen);
?>
            <div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>결제 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>
            <form id="file-upload" class="upload"  name="joinForm" method="post" action="?com=user&pro=userinfo&mng=Y" onsubmit="return form_chk_mng();">
                <h3>결제 내용</h3>
                <div class="inner clearfix">
                    <fieldset class="error">
                        <label for="field1">상품정보</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:95px;margin-bottom:5px;padding:5px;line-height: 20px;"><?=$rtnData["proType"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">결제방법</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["payType"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">금액</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["price"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">결제금액</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["payPrice"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">결제상태</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["payState"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">결제일</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["payDate"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">결제정보</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["payInfo"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">취소일</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["cancelDate"]?></div>
                        </div>
                    </fieldset>
                    <fieldset class="error">
                        <label for="field1">취소정보</label>
                        <div class="field">
							<div class="error-alert" style="display:;color:#828282;font-size:9pt;background-color:#F4F4F4;height:30px;margin-bottom:5px;padding:5px;line-height: 10px;"><?=$rtnData["cancelInfo"]?></div>
                        </div>
                    </fieldset>
                    <a href="#" class="cancel right" onclick="location.href='/?com=payment&lnd=list&mng=Y'">목록으로</a>
                </div>
			</form>