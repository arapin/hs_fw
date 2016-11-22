<?
	$main = new Main();
	$rtnList = $main->mainLogcationList("","idx DESC");
?>
            <div class="breadcrumbs clearfix">
                <ul class="breadcrumbs left">
                    <li><a href="#">SAN SIN GAK ADMIN</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>메인 지역 이미지 관리</li>
                </ul>
                <!--<a href="#" class="btn right" onclick="location.href='?com=mng&lnd=write&mng=Y'"><i class="fa fa-caret-square-o-left"></i>등록</a>-->
            </div>

            <div class="tables clearfix">
                <table class="datatable adm-table">
                    <thead>
                        <tr>
                            <th>순번</th>
                            <th>순서<span class="order"></span></th>
                            <th>지역<span class="order"></span></th>
                            <th>등록일<span class="order"></span></th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
						<?=$rtnList?>
                    </tbody>
                </table>
            </div>

