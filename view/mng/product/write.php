            <div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>상품 관리</li>
                </ul>
                <!--<a href="#" class="btn right"><i class="fa fa-caret-square-o-left"></i>EXPORT</a>-->
            </div>

            <form id="file-upload" class="upload"  name="writeForm" method="post" action="?com=product&pro=productInfo&mng=Y" onsubmit="return form_chk_mng();">
<input type="hidden" name="mode" value="insert" />

                <h3>상품 등록</h3>
                <div class="inner clearfix">
                     <fieldset class="error">
                        <label for="field1">상품명</label>
                        <div class="field">
                            <input type="text" placeholder="상품명" id="field1" name="proName" value="">
                        </div>
                    </fieldset>

                     <fieldset class="error">
                        <label for="field1">상품가격</label>
                        <div class="field">
                            <input type="text" placeholder="상품가격" id="name" name="proPrice" value="">
                        </div>
                    </fieldset>
                    <input type="submit" value="저장" class="right">
                    <a href="#" class="cancel right" onclick="location.href='?com=user&lnd=list&mng=Y'">목록으로</a>
                </div>
            </form>
