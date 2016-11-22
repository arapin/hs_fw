<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/config.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/CONTROL/spr.php";

	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);

	$spr = new Spr();
	$productSelect = $spr->getProductSelect2();
?>
                                    <li id="proArea<?=$idx?>">
										<select name="proIdx[]">
										<?=$productSelect?>
										</select>
										<select name="proTime[]">
											<option value="30">30분</option>
											<option value="60">1시간</option>
											<option value="90">1시간30분</option>
											<option value="120">2시간</option>
											<option value="150">2시간30분</option>
											<option value="180">3시간</option>
											<option value="210">3시간30분</option>
											<option value="240">4시간</option>
											<option value="270">4시간30분</option>
											<option value="300">5시간</option>
											<option value="330">5시간30분</option>
											<option value="360">6시간</option>
											<option value="390">6시간30분</option>
											<option value="420">7시간</option>
											<option value="450">7시간30분</option>
											<option value="480">8시간</option>
										</select>

                                        <input type="text" value="0" name="price[]"/><span>원/1명</span>
                                        <input type="button" value="삭제" class="sj_btn2" onclick="delRow('<?=$idx?>');"//>
                                    </li>