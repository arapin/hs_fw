<?
	$product = new Product();

	$idx = Request::get('idx', Request::GET | Request::XSS_CLEAR);

	$setBeen = array(":idx" => $idx);
	$rData = $product->getProductInfoListView($setBeen);

?>            
			<div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>상품 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>

            <form id="file-upload" class="upload"  name="modifyForm" method="post" action="?com=product&pro=productInfo&mng=Y" onsubmit="return form_chk_mng();">
<input type="hidden" name="mode" value="modify" />
<input type="hidden" name="idx" value="<?=$idx?>" />

                <h3>상품 수정</h3>
                <div class="inner clearfix">
                     <fieldset class="error">
                        <label for="field1">상품명</label>
                        <div class="field">
                            <input type="text" placeholder="상품명" id="field1" name="proName" value="<?=$rData["proName"]?>">
                        </div>
                    </fieldset>

                     <fieldset class="error">
                        <label for="field1">상품가격</label>
                        <div class="field">
                            <input type="text" placeholder="상품가격" id="name" name="proPrice" value="<?=$rData["proPrice"]?>">
                        </div>
                    </fieldset>
                    <input type="submit" value="수정" class="right">
                    <a href="#" class="cancel right" onclick="location.href='?com=product&lnd=list&mng=Y'">목록으로</a>
                </div>
            </form>
