<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/mypageMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class Mypage extends MypageMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $amTotalCnt;
		public $memoTotalCnt;
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("sample");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}

		/*회원수정 정보 추출*/
		public function userModifyInfo($userData){
			try{
				$userResult = parent::modifyUserInfo($userData);
				$returnData = array();
				while (list($key, $val) = each($userResult)){
					$returnData["id"] = $userResult[$key]["id"];
					$returnData["pwd"] = $userResult[$key]["pwd"] != "" ? trim($this->cipher->getDecrypt($userResult[$key]["pwd"])) : $userResult[$key]["pwd"];
					$returnData["birthday"] = $userResult[$key]["birthday"];
					$returnData["birthdayType"] = $userResult[$key]["birthdayType"];
					$returnData["birthdayTime"] = $userResult[$key]["birthdayTime"];

					$returnData["zipcode"] = $userResult[$key]["zipcode"] != "" ? trim($this->cipher->getDecrypt($userResult[$key]["zipcode"])) : $userResult[$key]["zipcode"];

					$returnData["address"] = $userResult[$key]["address"] != "" ? trim($this->cipher->getDecrypt($userResult[$key]["address"])) : $userResult[$key]["address"];

					$returnData["address2"] = $userResult[$key]["address2"] != "" ? trim($this->cipher->getDecrypt($userResult[$key]["address2"])) : $userResult[$key]["address2"];

					$returnData["name"] = $userResult[$key]["name"] != "" ? trim($this->cipher->getDecrypt($userResult[$key]["name"])) : $userResult[$key]["name"];
					$returnData["nameCH"] = $userResult[$key]["nameCH"] != "" ? trim($this->cipher->getDecrypt($userResult[$key]["nameCH"])) : $userResult[$key]["nameCH"];

					$returnData["phone"] = $userResult[$key]["phone"] != "" ? trim($this->cipher->getDecrypt($userResult[$key]["phone"])) : $userResult[$key]["phone"];

					$returnData["email"] = trim($this->cipher->getDecrypt($userResult[$key]["email"]));
				}
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
			}

			return $returnData;
		}

		/*회원정보 수정*/
		public function userModify($userData, $whereData){
			try{
				$userData[0] = $this->cipher->getEncrypt($userData[0]);
				$userData[4] = $this->cipher->getEncrypt($userData[4]);
				$userData[5] = $this->cipher->getEncrypt($userData[5]);
				$userData[6] = $this->cipher->getEncrypt($userData[6]);
				$userData[7] = $this->cipher->getEncrypt($userData[7]);
				$userData[8] = $this->cipher->getEncrypt($userData[8]);
				$userData[9] = $this->cipher->getEncrypt($userData[9]);
				$userData[10] = $this->cipher->getEncrypt($userData[10]);

				parent::modifyUser($userData,$whereData);
				$logData = array("M", $_SERVER["REMOTE_ADDR"], $whereData[":id"]."-회원정보 수정", date("Y-m-d H:i:s"), $whereData[":id"]);
				parent::logInsert($logData);
				$this->common->finalMove("lnd","회원정보가 수정 되셨습니다.","mypage","modify");
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","mypage","modify");
			}
		}
		
		/**유저 예약 목록**/
		public function getUserReservationList($page="", $setOrder=""){
			$returnVal = "";

			$startNum = ($page - 1) * $this->link;
			$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":userId" => $_SESSION["USER_ID"]);
				$resTotalCntResult = parent::getMyReservationCntMOL($whereBeen);
				while (list($key, $val) = each($resTotalCntResult)){
					$resCnt = $resTotalCntResult[$key]["resCnt"];
				}

				$this->totalCnt = $resCnt;
				$this->totalPage = ($link / $resCnt) == 0 ? "1" : ($link / $resCnt);
				$record = $resCnt;
				$url_file = "/";
				$url_parameter = "com=mypage&lnd=resList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$resResult = parent::getMyReservationListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($resResult)){
					$idx				=  $resResult[$key]["idx"];
					$resDate			=  substr($resResult[$key]["resDate"],2);
					$resStartTime	=  $resResult[$key]["resStartTime"];
					$resEndTime	    =  $resResult[$key]["resEndTime"];

					$clientBeen = array(":SHIdx" => $resResult[$key]["SHIdx"]);
					$clientResult = parent::clientSelectInfoMOL($clientBeen);
					while (list($key_s, $val_s) = each($clientResult)){
						$name = $clientResult[$key_s]["name"];
						$SHName = $clientResult[$key_s]["SHName"];
					}

					$proBeen = array(":proIdx" => $resResult[$key]["proIdx"], ":SHIdx" => $resResult[$key]["SHIdx"]);
					$productResult = parent::productSelectInfoMOL($proBeen);
					while (list($key_p, $val_p) = each($productResult)){
						$proName = $productResult[$key_p]["proName"];
					}

					$paymentGetBeen = array(":idx" => $resResult[$key]["paymentIdx"]);
					$paymentResult = parent::paymentSelectInfoMOL($paymentGetBeen);
					while (list($key_p, $val_p) = each($paymentResult)){
						if($paymentResult[$key_p]["payState"] == "I"){
							$viewPayDate = substr($paymentResult[$key_p]["payDate"],2);
						}else{
							$viewPayDate = "-";
						}

						if($paymentResult[$key_p]["payPrice"]){
							$viewPayMoney = "￦".number_format($paymentResult[$key_p]["payPrice"]);
						}else{
							$viewPayMoney = "-";
						}
					}

					switch($resResult[$key]["resState"]){
						case "W" :
							$viewStatus = "<span style=\"color:#9cfaac;font-weight:bold;\">예약 대기</span>";
							$viewBtn = "<input type=\"button\" class=\"book_btn1\" value=\"취소하기\" onclick=\"resCancel('".$idx."')\"/>";
							break;
						case "U" :
							$viewStatus = "<span style=\"color:#7679f3;font-weight:bold;\">예약 완료</span>";
							$viewBtn = "<input type=\"button\" class=\"book_btn1\" value=\"취소하기\" onclick=\"resCancel('".$idx."')\"/>";
							break;
						case "C" :
							$viewStatus = "<span style=\"color:#fc2418;font-weight:bold;\">예약 취소</span>";
							$viewBtn = "-";
							break;
					}

					$returnVal .= "
                            <tr>
                                <td>res-".$idx."</td>
                                <td class=\"btskin_txt1\">".$name."</td>
                                <td class=\"btskin_txt1\">".$SHName."</td>
                                <td>".$proName."</td>
                                <td>".$resDate." ".$resStartTime."~".$resEndTime."</td>
                                <td>".$viewPayDate."</td>
                                <td class=\"btskin_txt2\">".$viewPayMoney."</td>
                                <td>".$viewStatus."</td>
                                <td>".$viewBtn."</td>
                            </tr>
					";
					$loop_number--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**유저 예약 목록**/
		public function getUserReservationListM($page="", $setOrder=""){
			$returnVal = "";

			$startNum = ($page - 1) * $this->link;
			$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":userId" => $_SESSION["USER_ID"]);
				$resTotalCntResult = parent::getMyReservationCntMOL($whereBeen);
				while (list($key, $val) = each($resTotalCntResult)){
					$resCnt = $resTotalCntResult[$key]["resCnt"];
				}

				$this->totalCnt = $resCnt;
				$this->totalPage = ($link / $resCnt) == 0 ? "1" : ($link / $resCnt);
				$record = $resCnt;
				$url_file = "/";
				$url_parameter = "com=mypage&lnd=resList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$resResult = parent::getMyReservationListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($resResult)){
					$idx				=  $resResult[$key]["idx"];
					$resDate			=  substr($resResult[$key]["resDate"],2);
					$resStartTime	=  $resResult[$key]["resStartTime"];
					$resEndTime	    =  $resResult[$key]["resEndTime"];

					$clientBeen = array(":SHIdx" => $resResult[$key]["SHIdx"]);
					$clientResult = parent::clientSelectInfoMOL($clientBeen);
					while (list($key_s, $val_s) = each($clientResult)){
						$name = $clientResult[$key_s]["name"];
						$SHName = $clientResult[$key_s]["SHName"];
						$SHId = $clientResult[$key_s]["SHId"];
					}

					$proBeen = array(":proIdx" => $resResult[$key]["proIdx"], ":SHIdx" => $resResult[$key]["SHIdx"]);
					$productResult = parent::productSelectInfoMOL($proBeen);
					while (list($key_p, $val_p) = each($productResult)){
						$proName = $productResult[$key_p]["proName"];
					}

					$paymentGetBeen = array(":idx" => $resResult[$key]["paymentIdx"]);
					$paymentResult = parent::paymentSelectInfoMOL($paymentGetBeen);
					while (list($key_p, $val_p) = each($paymentResult)){
						if($paymentResult[$key_p]["payState"] == "I"){
							$viewPayDate = substr($paymentResult[$key_p]["payDate"],2);
						}else{
							$viewPayDate = "-";
						}

						if($paymentResult[$key_p]["payPrice"]){
							$viewPayMoney = "￦".number_format($paymentResult[$key_p]["payPrice"]);
						}else{
							$viewPayMoney = "-";
						}
					}

					switch($resResult[$key]["resState"]){
						case "W" :
							$viewStatus = "예약 대기";
							$viewBtn = "<input type=\"button\" value=\"취소하기\" class=\"btn_7\" onclick=\"resCancel('".$idx."')\"/>";
							break;
						case "U" :
							$viewStatus = "예약 완료";
							$viewBtn = "<input type=\"button\" value=\"취소하기\" class=\"btn_7\" onclick=\"resCancel('".$idx."')\"/>";
							break;
						case "C" :
							$viewStatus = "예약 취소";
							$viewBtn = "-";
							break;
					}

					$fileData2 = array(":parentId" => $SHId, ":type" => "profile");
					$fileResult = parent::searchFile($fileData2);
					while (list($key_f, $val_f) = each($fileResult)){
						$saveName = $fileResult[$key_f]["saveName"];
					}

					if($saveName == ""){
						$viewProfile = "/html/sample/sample3_pic";
					}else{
						$viewProfile = "/upload/client/".$saveName;
					}
					
					$viewDateArry = explode("-", $resDate);
					$returnVal .= "
							<dt>
								<span class=\"t_cell_l lst_txt_1\">
									".$viewDateArry[1]."월 ".$viewDateArry[2]."일 <!--<span class=\"lst_txt_2\">(151208001)</span>-->
								</span>
								<span class=\"t_cell_r\">
									".$viewStatus."
								</span>
							</dt>
							<dd>
								<div class=\"bc_photo\">
									<button style=\"background:url(".$viewProfile.") no-repeat; background-size:60px 60px; border:none;\" type=\"button\" class=\"shop_photo\"></button>
								</div>
								<div class=\"float_left\">
									<ul class=\"bc_lst l_style_none\">
										<li class=\"txt_1\">".$name."</li>
										<li>".$SHName."</li>
										<li>상담분야 : ".$proName."</li>
										<li class=\"txt_3\">예약일자 : ".str_replace("-",".",$resDate)." ".$resStartTime."~".$resEndTime."</li>
										<li class=\"txt_3\">결제일자 : ".$viewPayDate."</li>
										<li class=\"txt_3\">결제금액 : <span class=\"txt_2\">".$viewPayMoney."</span> (1인)</li>
									</ul>
								</div>
							</dd>
							<dd>
								<div class=\"table\">
									<div class=\"t_cell_c\" style=\"padding-right:5px;\">
										".$viewBtn."
									</div>
									<!--<div class=\"t_cell_c\" style=\"padding-left:5px;\">
										<input type=\"button\" value=\"후기작성\" class=\"btn_7\" />
									</div>-->
								</div>
							</dd>

					";
					$loop_number--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**유저 위시 목록**/
		public function getUserWishList($page="", $setOrder=""){
			$returnVal = "";

			$startNum = ($page - 1) * $this->link;
			$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":userId" => $_SESSION["USER_ID"]);
				$wishTotalCntResult = parent::getMyWishCntMOL($whereBeen);
				while (list($key, $val) = each($wishTotalCntResult)){
					$wishCnt = $wishTotalCntResult[$key]["wishCnt"];
				}

				$this->totalCnt = $wishCnt;
				$record = $wishCnt;
				$url_file = "/";
				$url_parameter = "com=mypage&lnd=wish";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$wishResult = parent::getMyWishListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($wishResult)){
					$clientBeen = array(":SHIdx"=>$wishResult[$key]["SHIdx"]);
					$clientResult = parent::getclientInfoMOL($clientBeen);
					while (list($key_s, $val_s) = each($clientResult)){
						$SHId = $clientResult[$key_s]["SHId"];
						$SHName =$clientResult[$key_s]["SHName"];

						$fileData2 = array(":parentId" => $SHId, ":type" => "profile");
						$fileResult = parent::searchFile($fileData2);
						while (list($key_f, $val_f) = each($fileResult)){
							$saveName = $fileResult[$key_f]["saveName"];
						}

						if($saveName == ""){
							$viewProfile = "/html/sample/sp1.jpg";
						}else{
							$viewProfile = "/upload/client/".$saveName;
						}

						$fileData2 = array(":parentId" => $SHId, ":type" => "client");
						$fileResult = parent::searchFileMain($fileData2);
						$saveName = "";
						while (list($key_f, $val_f) = each($fileResult)){
							$saveName = "/upload/client/".$fileResult[$key_f]["saveName"];
						}

						if($saveName == ""){
							$fileData2 = array(":parentId" => $SHId, ":type" => "client");
							$fileResult = parent::searchFile($fileData2);
							while (list($key_f, $val_f) = each($fileResult)){
								$saveName = $fileResult[$key_f]["saveName"];
								break;
							}
						}

						if($saveName == ""){
							$clientImg = "/html/sample/s1.jpg";
						}else{
							$clientImg = "/upload/client/".$saveName;
						}

						$productInfo = "";
						$sprData = array(":SHIdx" => $wishResult[$key]["SHIdx"]);
						$sprResult = parent::searchSpr($sprData);
						while (list($key_p, $val_p) = each($sprResult)){
							$productInfo = $sprResult[$key_p]["price"];
							break;
						}

						$whereBeen = array(":code" => $SHId."_affter");				
						$amTotalCntResult = parent::affterMemoTotalMOL($whereBeen);
						while (list($key_a, $val_a) = each($amTotalCntResult)){
							$amCnt = $amTotalCntResult[$key_a]["amCnt"];
						}

						$scoreData = $this->getAffterScore($SHId."_affter");

					}

					$returnVal .= "
						<li>
							<img class=\"sc_heart\" src=\"/images/heart.png\" alt=\"\" />
							<input class=\"sc_close\" type=\"image\" src=\"/images/btn_close.png\" alt=\"닫기\" onclick=\"delWish('".$wishResult[$key]["idx"]."')\"/>
							<div class=\"sc_photo_wrap\">
								<a href=\"?com=client&lnd=clienthome&SHId=".$SHId."\"><img src=\"".$clientImg."\" alt=\"\" style=\"width:320px;height240px;\"/></a>
								<div class=\"sc_money\">
									<span>\</span>".number_format($productInfo)."
								</div>
							</div>

							<img class=\"sc_photo_face\" src=\"".$viewProfile."\" alt=\"\" />

							<p class=\"photo_link\">
								<a href=\"/html/shop_view.html\"><img src=\"/images/new.gif\" alt=\"new\" />".$SHName."</a>
							</p>
							<p class=\"photo_score\">
								신점 전체 · ".$scoreData["totalScore"]."<img src=\"/images/star.gif\" alt=\"\" />· 후기 ".$amCnt."개
							</p>
						</li>
					";
					$loop_number--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**유저 위시 목록**/
		public function getUserWishListM($page="", $setOrder=""){
			$returnVal = "";

			$startNum = ($page - 1) * $this->link;
			$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":userId" => $_SESSION["USER_ID"]);
				$wishTotalCntResult = parent::getMyWishCntMOL($whereBeen);
				while (list($key, $val) = each($wishTotalCntResult)){
					$wishCnt = $wishTotalCntResult[$key]["wishCnt"];
				}

				$this->totalCnt = $wishCnt;
				$record = $wishCnt;
				$url_file = "/";
				$url_parameter = "com=mypage&lnd=wish";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$wishResult = parent::getMyWishListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($wishResult)){
					$clientBeen = array(":SHIdx"=>$wishResult[$key]["SHIdx"]);
					$clientResult = parent::getclientInfoMOL($clientBeen);
					while (list($key_s, $val_s) = each($clientResult)){
						$SHId = $clientResult[$key_s]["SHId"];
						$SHName =$clientResult[$key_s]["SHName"];

						$fileData2 = array(":parentId" => $SHId, ":type" => "profile");
						$fileResult = parent::searchFile($fileData2);
						while (list($key_f, $val_f) = each($fileResult)){
							$saveName = $fileResult[$key_f]["saveName"];
						}

						if($saveName == ""){
							$viewProfile = "/html/sample/sp1.jpg";
						}else{
							$viewProfile = "/upload/client/".$saveName;
						}

						$fileData2 = array(":parentId" => $SHId, ":type" => "client");
						$fileResult = parent::searchFileMain($fileData2);
						$saveName = "";
						while (list($key_f, $val_f) = each($fileResult)){
							$saveName = "/upload/client/".$fileResult[$key_f]["saveName"];
						}

						if($saveName == ""){
							$fileData2 = array(":parentId" => $SHId, ":type" => "client");
							$fileResult = parent::searchFile($fileData2);
							while (list($key_f, $val_f) = each($fileResult)){
								$saveName = $fileResult[$key_f]["saveName"];
								break;
							}
						}

						if($saveName == ""){
							$clientImg = "/html/sample/s1.jpg";
						}else{
							$clientImg = "/upload/client/".$saveName;
						}

						$productInfo = "";
						$sprData = array(":SHIdx" => $wishResult[$key]["SHIdx"]);
						$sprResult = parent::searchSpr($sprData);
						while (list($key_p, $val_p) = each($sprResult)){
							$productInfo = $sprResult[$key_p]["price"];
							break;
						}

						$whereBeen = array(":code" => $SHId."_affter");				
						$amTotalCntResult = parent::affterMemoTotalMOL($whereBeen);
						while (list($key_a, $val_a) = each($amTotalCntResult)){
							$amCnt = $amTotalCntResult[$key_a]["amCnt"];
						}

						$scoreData = $this->getAffterScore($SHId."_affter");

					}

					$returnVal .= "

                        <li>
                            <img class=\"sc_heart\" src=\"/images/mobile/ic_heart_on.png\" alt=\"\" onclick=\"delWish('".$wishResult[$key]["idx"]."')\"/>
                            <div class=\"sc_photo_wrap\">
                                <a href=\"?com=client&lnd=clientHome&SHId=".$SHId."\"><img src=\"".$clientImg."\" alt=\"\" /></a>
                                <div class=\"sc_money\">
                                    <span>￦</span>".number_format($productInfo)."
                                </div>
                            </div>

                            <button style=\"background: url(".$viewProfile.") no-repeat; background-size: 60px 60px; \" type=\"button\" class=\"sc_photo_face\"></button>

                            <p class=\"photo_link\">
                                <a href=\"?com=client&lnd=clientHome&SHId=".$SHId."\">".$SHName."</a>
                            </p>
                            <p class=\"photo_score\">
                                신점 전체 · ".$scoreData["totalScore"]."<img src=\"/images/mobile/star.gif\" alt=\"\" />· 후기 ".$amCnt."개
                            </p>
                        </li>
					";
					$loop_number--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**산신각 평점**/
		public function getAffterScore($code){
			$returnData = array();
			$whereBeen = array(":code" => $code);
			$amTotalCntResult = parent::affterMemoTotalMOL($whereBeen);
			while (list($key, $val) = each($amTotalCntResult)){
				$amCnt = $amTotalCntResult[$key]["amCnt"];
			}
			$amResult = parent::affterMemoScoreMOL($whereBeen);

			while (list($key, $val) = each($amResult)){
				$ppTotal = $amResult[$key]["ppTotal"];
				$spTotal = $amResult[$key]["spTotal"];
				$lpTotal = $amResult[$key]["lpTotal"];
				$prpTotal = $amResult[$key]["prpTotal"];
			}

			$totalScore = $ppTotal + $spTotal + $lpTotal + $prpTotal;

			$returnData["totalScore"] = round(($totalScore / $amCnt) / 4);
			$returnData["ppTotalScore"] = round($ppTotal / $amCnt);
			$returnData["spTotalScore"] = round($spTotal / $amCnt);
			$returnData["lpTotalScore"] = round($lpTotal / $amCnt);
			$returnData["prpTotalScore"] = round($prpTotal / $amCnt);
			return $returnData;
		}


		/*예약취소*/
		public function reservationInfoCancel($whereBeen){
			$resResult = parent::reservationInfoCancelMOL($whereBeen);
			while (list($key, $val) = each($resResult)){
				$paymentIdx = $resResult[$key]["paymentIdx"];
			}
			
			/*결제 취소*/
			$paymentSetData = array("C",date("Y-m-d H:i:s"),"환불정보");
			$paymentData = array(":idx" => $paymentIdx);
			parent::paymentCancelMOL($paymentSetData, $paymentData);
			
			/*예약취소*/
			$resSetData = array("C");
			parent::reservationCancelMOL($resSetData,$whereBeen);
			$this->common->finalMove("lnd","예약이 취소 되었습니다.","mypage","resList");
		}
		
		/**위시 삭제**/
		public function wishDel($setBeen){
			parent::wishDeleteMOL($setBeen);
		}


		/**나의문의 리스트**/
		public function aqBoardList($page="", $setOrder=""){
			$returnVal = "";
			$searchQuery = "";

			if($cate != ""){
				$searchQuery .= " AND proCate = '".$cate."' ";
			}

			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery."order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":userId" => $_SESSION["USER_ID"]);
				$aqTotalCntResult = parent::aqBoardTotalListMOL($whereBeen);
				while (list($key, $val) = each($aqTotalCntResult)){
					$aqCnt = $aqTotalCntResult[$key]["aqCnt"];
				}

				$this->totalCnt = $aqCnt;
				$this->totalPage = ($link / $aqCnt) == 0 ? "1" : ($link / $aqCnt);
				$record = $aqCnt;
				$url_file = "/";
				$url_parameter = "com=mypage&lnd=qList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$aqResult = parent::aqBoardListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($aqResult)){
					$idx				=  $aqResult[$key]["idx"];
					$title				=  $aqResult[$key]["title"];
					$userId			=  $aqResult[$key]["userId"];
					$hit				=  $aqResult[$key]["hit"];
					$state				=  $aqResult[$key]["state"];
					$regDate			=  $aqResult[$key]["regDate"];
					
					$answerBeen = array(":idx"=> $idx);
					$answerResult = parent::aqBoardtInfoAnswerCntMOL($answerBeen );
					while (list($key_a, $val_a) = each($answerResult)){
						$answerCnt = $answerResult[$key_a]["answerCnt"];
					}

					switch($state){
						case "W" : 
							$viewState = "대기";
							break;
						case "V" : 
							$viewState = "진행대기";
							break;
						case "I" : 
							$viewState = "<span class=\"btskin_txt2\">진행중</span>";
							break;
						case "C" : 
							$viewState = "채택완료";
							break;
					}

					$productBeen = array(":idx" => $aqResult[$key]["proCate"]);
					$productResult = parent::productSelectInfoMOLUser($productBeen);

					while (list($key_s, $val_s) = each($productResult)){
						$productName = $productResult[$key_s]["proName"];
					}

					$returnVal .= "
						<tr>
							<td>".$loop_number."</td>
							<td>".$productName."</td>
							<td class=\"btskin_txt1\" style=\"text-align:left;\"><a href=\"?com=mypage&lnd=qView&idx=".$idx."\">".$title."</a></td>
							<td class=\"btskin_txt2\">15.10.31 ~ 15.11.10</td>
							<td>".substr($regDate,0,10)."</td>
							<td class=\"btskin_txt2\">".$answerCnt."</td>
							<td>".$viewState."</td>
						</tr>					
					";
					$loop_number--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**나의문의 리스트**/
		public function aqBoardListM($page="", $setOrder=""){
			$returnVal = "";
			$searchQuery = "";

			if($cate != ""){
				$searchQuery .= " AND proCate = '".$cate."' ";
			}

			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery."order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":userId" => $_SESSION["USER_ID"]);
				$aqTotalCntResult = parent::aqBoardTotalListMOL($whereBeen);
				while (list($key, $val) = each($aqTotalCntResult)){
					$aqCnt = $aqTotalCntResult[$key]["aqCnt"];
				}

				$this->totalCnt = $aqCnt;
				$this->totalPage = ($link / $aqCnt) == 0 ? "1" : ($link / $aqCnt);
				$record = $aqCnt;
				$url_file = "/";
				$url_parameter = "com=mypage&lnd=qList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$aqResult = parent::aqBoardListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($aqResult)){
					$idx				=  $aqResult[$key]["idx"];
					$title				=  $aqResult[$key]["title"];
					$userId			=  $aqResult[$key]["userId"];
					$hit				=  $aqResult[$key]["hit"];
					$state				=  $aqResult[$key]["state"];
					$regDate			=  $aqResult[$key]["regDate"];
					$answerStartDate	=  $aqResult[$key]["answerStartDate"];
					$answerEndDate		=  $aqResult[$key]["answerEndDate"];

					
					$answerBeen = array(":idx"=> $idx);
					$answerResult = parent::aqBoardtInfoAnswerCntMOL($answerBeen );
					while (list($key_a, $val_a) = each($answerResult)){
						$answerCnt = $answerResult[$key_a]["answerCnt"];
					}

					switch($state){
						case "W" : 
							$viewState = "대기";
							break;
						case "V" : 
							$viewState = "진행대기";
							break;
						case "I" : 
							$viewState = "<span class=\"btskin_txt2\">진행중</span>";
							break;
						case "C" : 
							$viewState = "채택완료";
							break;
					}

					$productBeen = array(":idx" => $aqResult[$key]["proCate"]);
					$productResult = parent::productSelectInfoMOLUser($productBeen);

					while (list($key_s, $val_s) = each($productResult)){
						$productName = $productResult[$key_s]["proName"];
					}

					$returnVal .= "
						<dt>
							<span style=\"color:#888;\">[".$loop_number."]</span> ".$productName."
							<span style=\"color:#333;display:block;margin-top:10px;\">".$title."</span>
						</dt>
						<dd>
							<ul class=\"bc_lst l_style_none\">
								<li>답변기간 : <span class=\"txt_2\">".substr($answerStartDate,2)." ~ ".substr($answerEndDate,2)."</span></li>
								<li>작성일 : ".str_replace("-",".",substr($regDate,2,8))."</li>
								<li>답변수 : <span class=\"txt_2\">".$answerCnt."</span></li>
								<li>답변채택 : <span class=\"txt_2\">".$viewState."</span></li>
							</ul>
							<div class=\"b_view_btn\">
								<input type=\"button\" value=\"상세보기\" onclick=\"location.href = '?com=mypage&lnd=qView&idx=".$idx."'\" />
							</div>
						</dd>
					";
					$loop_number--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**게시판 정보 수정 추출**/
		public function getAqBoardInfoMng($getBeen){
			$aqResult = parent::aqBoardInfoMOL($getBeen);
			$returnData = array();

			while (list($key, $val) = each($aqResult)){
				
				$paymentBeen = array(":idx" => $aqResult[$key]["paymentIdx"]);
				$paymentResult = parent::paymentSelectInfoMOL($paymentBeen);

				while (list($key_s, $val_s) = each($paymentResult)){
					switch($paymentResult[$key_s]["payState"]){
						case "W" :
							$viewPayStatus = "<span style=\"color:#9cfaac;font-weight:bold;\">결제대기</span>";
							break;
						case "I" :
							$viewPayStatus = "<span style=\"color:#7679f3;font-weight:bold;\">결제완료</span>";
							break;
						case "C" :
							$viewPayStatus = "<span style=\"color:#fc2418;font-weight:bold;\">결제취소</span>";
							break;
					}
				}

				$returnData["payStatus"] = $viewPayStatus;

				$productBeen = array(":idx" => $aqResult[$key]["proCate"]);
				$productResult = parent::productSelectInfoMOLUser($productBeen);

				while (list($key_s, $val_s) = each($productResult)){
					$productName = $productResult[$key_s]["proName"];
				}

				$returnData["productName"] = $productName;
				
				$returnData["title"] = $aqResult[$key]["title"];
				$returnData["content"] = $aqResult[$key]["content"];
				$returnData["userId"] = $aqResult[$key]["userId"];

				switch($aqResult[$key]["state"]){
					case "W" :
						$viewStatus = "결제대기";
						break;
					case "V" :
						$viewStatus = "진행대기";
						break;
					case "I" :
						$viewStatus = "진행중";
						break;
					case "C" :
						$viewStatus = "답변채택완료";
						break;
				}

				$returnData["state"] = $viewStatus;
				$returnData["proState"] = $aqResult[$key]["state"];
				$returnData["answerStartDate"] = $aqResult[$key]["answerStartDate"];
				$returnData["answerEndDate"] = $aqResult[$key]["answerEndDate"];
				$returnData["regDate"] = $aqResult[$key]["regDate"];

				$answerBeen = array(":idx"=> $getBeen[":idx"]);
				$answerResult = parent::aqBoardtInfoAnswerCntMOL($answerBeen );
				while (list($key_a, $val_a) = each($answerResult)){
					$returnData["answerCnt"] = $answerResult[$key_a]["answerCnt"];
				}

			}

			return $returnData;

		}

		/*관리자 게시판 관리 리스트 출력*/
		public function aqBoardAnswerList($getBeen, $parentStatus, $parentId){
			$returnVal = "";
			$answerResult = parent::aqBoardtInfoAnswerCntMOL($getBeen);
			while (list($key_a, $val_a) = each($answerResult)){
				$totalCnt = $answerResult[$key_a]["answerCnt"];
			}

			try{
				$aqResult = parent::aqBoardtInfoAnswerListMOL($getBeen);
				while (list($key, $val) = each($aqResult)){
					$idx				=  $aqResult[$key]["idx"];
					$choice			=  $aqResult[$key]["choice"];
					$userId			=  $aqResult[$key]["userId"];
					$regDate			=  str_replace("-",".",substr($aqResult[$key]["regDate"],0,10));
					$content			=  $aqResult[$key]["content"];
					$answerBtn = "";
					if($choice == "Y"){
						$class = "class=\"reply_select\"";
						$answerBtn = "<input type=\"button\" class=\"b_end_btn\" value=\"채택완료\" />";
					}else{
						$class = "";
						if($_SESSION["USER_ID"] == $parentId && $parentStatus != "C"){
							$answerBtn = "<input type=\"button\" class=\"b_select_btn\" value=\"채택하기\" onclick=\"answerChoice('".$idx."','".$getBeen[":idx"]."')\"/>";
						}
					}

					$returnVal .= "
						<dd ".$class.">
							<div class=\"replay_seq float_left\">[답변 ".$totalCnt."]</div>
							<div class=\"replay_content float_left\">
								<div>
								".nl2br($content)." <textarea id=\"content".$idx."\" style=\"display:none\">".$content."</textarea>
								</div>
								<div class=\"replay_info float_left\">
									".$userId."&nbsp;&nbsp;|&nbsp;&nbsp;".$regDate." 
								</div>
								".$answerBtn."
							</div>
						</dd>
					";
					$totalCnt--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/*관리자 게시판 관리 리스트 출력*/
		public function aqBoardAnswerListM($getBeen, $parentStatus, $parentId){
			$returnVal = "";
			$answerResult = parent::aqBoardtInfoAnswerCntMOL($getBeen);
			while (list($key_a, $val_a) = each($answerResult)){
				$totalCnt = $answerResult[$key_a]["answerCnt"];
			}

			try{
				$aqResult = parent::aqBoardtInfoAnswerListMOL($getBeen);
				while (list($key, $val) = each($aqResult)){
					$idx				=  $aqResult[$key]["idx"];
					$choice			=  $aqResult[$key]["choice"];
					$userId			=  $aqResult[$key]["userId"];
					$regDate			=  str_replace("-",".",substr($aqResult[$key]["regDate"],0,10));
					$content			=  $aqResult[$key]["content"];
					$answerBtn = "";
					if($choice == "Y"){
						$class = "class=\"cmt_sel\"";
						$answerBtn = "
							<div class=\"cmt_sel_btn\">
								<input type=\"button\" value=\"채택완료\" class=\"btn_1\" />
							</div>
						";
					}else{
						$class = "";
						if($_SESSION["USER_ID"] == $parentId && $parentStatus != "C"){
							$answerBtn = "
							<div class=\"cmt_sel_btn\">
								<input type=\"button\" value=\"채택하기\" class=\"btn_7\" onclick=\"answerChoice('".$idx."','".$getBeen[":idx"]."')/>
							</div>
							";
						}
					}

					$returnVal .= "

						<dd ".$class.">
							<p class=\"cmt_cnt\">[답변 ".$totalCnt."]</p>
							".$answerBtn."
							".nl2br($content)."

							<div style=\"color:#777;padding-top:8px;\">
								".$userId."&nbsp;&nbsp;|&nbsp;".$regDate."
							</div>
						</dd>
					";
					$totalCnt--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**무속인 답변 여부**/
		public function getUserAnswerCnt($getBeen){
			$aqResult = parent::aqBoardtUserInfoAnswerCntMOL($getBeen);
			while (list($key, $val) = each($aqResult)){
				$userCnt			=  $aqResult[$key]["answerCnt"];
			}
			return $userCnt;
		}

		/**신점 답변 채택**/
		public function aqBoardChoice($idx, $answerIdx){
			$parentWhereBeen = array(":idx"=>$idx);
			$updateBeen = array("C");
			parent::aqBoardStatusUpdateMOL($updateBeen, $parentWhereBeen);

			$answerWhereBeen = array(":idx"=>$answerIdx);
			$updateBeen = array("Y");
			parent::aqBoardAnswerChoiceMOL($updateBeen, $answerWhereBeen);

			$this->common->finalMove("lnd","답변이 채택 되었습니다.","mypage","qView", "&idx=".$idx);
		}

		/**신점 문의 수정**/
		public function updateAqBoardInfo($setBeen, $whereBeen){
			parent::aqBoardUpdateMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","신점 문의가 수정 되었습니다.","mypage","qView", "&idx=".$whereBeen[":idx"]);
		}

		/**후기 리스트**/
		public function affterMemoList($page=""){
			$startNum = ($page - 1) * $this->link;
			$limitQuery = " order by idx DESC limit ".$startNum." , ".$this->link;
			//$limitQuery = " order by ".$setOrder;
			try{
				$whereBeen = array(":userId" => $_SESSION["USER_ID"]);
				$amTotalCntResult = parent::affterMemoTotalUserMOL($whereBeen);
				while (list($key, $val) = each($amTotalCntResult)){
					$amCnt = $amTotalCntResult[$key]["amCnt"];
				}
				$record = $amCnt;
				$this->amTotalCnt = $amCnt;
				$this->totalPage = ($this->link / $amCnt) == 0 ? "1" : ($this->link / $amCnt);
				$url_file = "/";
				$url_parameter = "?com=mypage&lnd=aList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$amResult = parent::affterMemoListMOL($whereBeen,$limitQuery);

				while (list($key, $val) = each($amResult)){
					$addBtn = "";
					$regData = substr($amResult[$key]["writeDate"],2,8);
					$viewRegDate = str_replace("-",".", $regData);
					$viewMemo = $this->common->cutstr($amResult[$key]["memo"],"60");
					$codeArray = explode("_",$amResult[$key]["code"]);
					$SHId = $codeArray[0];

					$whereBeen = array(":SHId" => $SHId);
					$clientResult = parent::modifyclientInfo($whereBeen);

					while (list($key_s, $val_s) = each($clientResult)){
						$SHName = $clientResult[$key_s]["SHName"];
						$name = $clientResult[$key_s]["name"];
					}

					$pointerP = $amResult[$key]["pointerP"];
					$serviceP = $amResult[$key]["serviceP"];
					$locationP = $amResult[$key]["locationP"];
					$priceP = $amResult[$key]["priceP"];

					$totalScore = round(($pointerP + $serviceP + $locationP + $priceP) / 4);

					$returnVal .= "
                            <tr>
                                <td>".$loop_number."</td>
                                <td>".$name."</td>
                                <td>".$SHName."</td>
                                <td class=\"btskin_score\"><img src=\"/images/star3.gif\" alt=\"\" />".$totalScore."</td>
                                <td class=\"btskin_txt1\" style=\"text-align:left;\"><a href=\"?com=mypage&lnd=aView&idx=".$amResult[$key]["idx"]."\">".$viewMemo."</a></td>
                                <td>".$viewRegDate."</td>
                            </tr>
					";
					$loop_number--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**후기 리스트**/
		public function affterMemoListM($page=""){
			$startNum = ($page - 1) * $this->link;
			$limitQuery = " order by idx DESC limit ".$startNum." , ".$this->link;
			//$limitQuery = " order by ".$setOrder;
			try{
				$whereBeen = array(":userId" => $_SESSION["USER_ID"]);
				$amTotalCntResult = parent::affterMemoTotalUserMOL($whereBeen);
				while (list($key, $val) = each($amTotalCntResult)){
					$amCnt = $amTotalCntResult[$key]["amCnt"];
				}
				$record = $amCnt;
				$this->amTotalCnt = $amCnt;
				$this->totalPage = ($this->link / $amCnt) == 0 ? "1" : ($this->link / $amCnt);
				$url_file = "/";
				$url_parameter = "?com=mypage&lnd=aList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$amResult = parent::affterMemoListMOL($whereBeen,$limitQuery);

				while (list($key, $val) = each($amResult)){
					$addBtn = "";
					$regData = substr($amResult[$key]["writeDate"],2,8);
					$viewRegDate = str_replace("-",".", $regData);
					$viewMemo = nl2br($amResult[$key]["memo"]);
					$codeArray = explode("_",$amResult[$key]["code"]);
					$SHId = $codeArray[0];

					$whereBeen = array(":SHId" => $SHId);
					$clientResult = parent::modifyclientInfo($whereBeen);

					while (list($key_s, $val_s) = each($clientResult)){
						$SHName = $clientResult[$key_s]["SHName"];
						$name = $clientResult[$key_s]["name"];
					}

					$pointerP = $amResult[$key]["pointerP"];
					$serviceP = $amResult[$key]["serviceP"];
					$locationP = $amResult[$key]["locationP"];
					$priceP = $amResult[$key]["priceP"];

					$totalScore = round(($pointerP + $serviceP + $locationP + $priceP) / 4);

					$returnVal .= "
							<dt>
								<span class=\"float_left\">
									<span style=\"color:#888;\">[".$loop_number."]</span> ".$name." <img src=\"/images/mobile/star2.gif\" style=\"vertical-align:middle;margin:-6px 0px 0px 5px; width:16px; height:15px;\" /> ".$totalScore."
								</span>
								<span class=\"float_right\">
									".$viewRegDate."
								</span>
								<span style=\"color:#333;display:block;padding-top:10px;clear:both;\">대구 천궁암 산신당</span>
							</dt>
							<dd>
								".$viewMemo."
								<div style=\"text-align:right;margin-top:15px;\">
									<input type=\"button\" value=\"수정\" class=\"btn_7 btn_s\" style=\"margin-right:7px;\" onclick=\"location.href = '?com=mypage&lnd=aView&idx=".$amResult[$key]["idx"]."';\" /><!--<input type=\"button\" value=\"삭제\" class=\"btn_2 btn_s\" onclick=\"\" />-->
								</div>
							</dd>
					";
					$loop_number--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/*회원수정 정보 추출*/
		public function getAffterMemoModifyInfo($getBeen){
			try{
				$amResult = parent::getModifyAffterMemo($getBeen);
				$returnData = array();
				while (list($key, $val) = each($amResult)){
					$returnData["code"] = $amResult[$key]["code"];
					$returnData["userId"] = $amResult[$key]["userId"];
					$returnData["memo"] = $amResult[$key]["memo"];
					$returnData["pointerP"] = $amResult[$key]["pointerP"];
					$returnData["serviceP"] = $amResult[$key]["serviceP"];
					$returnData["locationP"] = $amResult[$key]["locationP"];
					$returnData["priceP"] = $amResult[$key]["priceP"];
					$returnData["writeDate"] = str_replace("-",".",substr($amResult[$key]["writeDate"],2));

					$codeArray = explode("_",$amResult[$key]["code"]);
					$SHId = $codeArray[0];

					$whereBeen = array(":SHId" => $SHId);
					$clientResult = parent::modifyclientInfo($whereBeen);

					while (list($key_s, $val_s) = each($clientResult)){
						$SHName = $clientResult[$key_s]["SHName"];
						$name = $clientResult[$key_s]["name"];
					}

					$returnData["SHName"] = $SHName;
					$returnData["name"] = $name;

					$pointerP = $amResult[$key]["pointerP"];
					$serviceP = $amResult[$key]["serviceP"];
					$locationP = $amResult[$key]["locationP"];
					$priceP = $amResult[$key]["priceP"];

					$totalScore = round(($pointerP + $serviceP + $locationP + $priceP) / 4);
					$returnData["totalScore"] = $totalScore;
				}
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
			}

			return $returnData;
		}

		/**후기수정**/
		public function modifyAffterMemo($setBeen, $whereBeen){
			parent::modifyAffterMemoMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","후기가 수정 되었습니다.","mypage","aView","&idx=".$whereBeen[":idx"]);
		}

		/*관리자 게시판 관리 리스트 출력*/
		public function boardList($page="", $setOrder="", $code="", $search=""){
			$returnVal = "";

			if($search["searchHead"] != ""){
				$searchQuery = " AND headWord = '".$search["searchHead"]."' ";
			}

			if($code == "notice"){
				$lnd = "noticeList";
				$this->link = 7;
			}else{
				$lnd = "list";
				$this->link = 20;
			}
			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery."order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":userId" => $_SESSION["USER_ID"]);
				$boardTotalCntResult = parent::getBoardCntMOL($whereBeen);
				while (list($key, $val) = each($boardTotalCntResult)){
					$boardCnt = $boardTotalCntResult[$key]["boardCnt"];
				}

				//$this->morBtn = $boardCnt > $this->link ? "<a href=\"#none\" onclick=\"getMoreList();\" id=\"morBtn\">더 보기</a>" : "&nbsp;";
				$this->totalCnt = $boardCnt;
				$this->totalPage = ($link / $boardCnt) == 0 ? "1" : ($link / $boardCnt);

				$record = $boardCnt;
				$url_file = "/";
				$url_parameter = "com=mypage&lnd=".$lnd;
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$boardResult = parent::getBoardListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($boardResult)){
					$idx				=  $boardResult[$key]["idx"];
					$title				=  $boardResult[$key]["title"];
					$userId				=  $boardResult[$key]["userId"];
					$content			=  nl2br($boardResult[$key]["content"]);
					$headWord			=  $boardResult[$key]["headWord"];
					$mCnt			=  $boardResult[$key]["mCnt"];

					if($code == "notice"){
						$regDateArray	=  explode("-",substr($boardResult[$key]["regDate"],0,10));
						$regDate = $regDateArray[1]."/".$regDateArray[2];
						$returnVal .= "				
							<dt><input type=\"image\" src=\"/images/btn_expand.gif\" onclick=\"toggleView(this)\" alt=\"확대\" />".$title."<span class=\"board_date_txt\">".$regDate."</span></dt>
							<dd>
								".$content."
							</dd>
						";
					}else{
						$returnVal .= "
                            <tr>
                                <td>".$loop_number."</td>
                                <td>".$headWord."</td>
                                <td class=\"btskin_txt1\" style=\"text-align:left;\"><a href=\"?com=mypage&lnd=bView&idx=".$idx."&code=".$code."\">".$title."<span class=\"board_view_txt5\">(".$mCnt.")</span></a></td>
                                <td>".$userId."</td>
                                <td>".str_replace("-",".",substr($boardResult[$key]["regDate"],2,8))."</td>
                            </tr>
						";
					}

					$loop_number--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/*관리자 게시판 관리 리스트 출력*/
		public function boardListM($page="", $setOrder="", $code="", $search=""){
			$returnVal = "";

			if($search["searchHead"] != ""){
				$searchQuery = " AND headWord = '".$search["searchHead"]."' ";
			}

			if($code == "notice"){
				$lnd = "noticeList";
				$this->link = 7;
			}else{
				$lnd = "list";
				$this->link = 20;
			}
			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery."order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":userId" => $_SESSION["USER_ID"]);
				$boardTotalCntResult = parent::getBoardCntMOL($whereBeen);
				while (list($key, $val) = each($boardTotalCntResult)){
					$boardCnt = $boardTotalCntResult[$key]["boardCnt"];
				}

				//$this->morBtn = $boardCnt > $this->link ? "<a href=\"#none\" onclick=\"getMoreList();\" id=\"morBtn\">더 보기</a>" : "&nbsp;";
				$this->totalCnt = $boardCnt;
				$this->totalPage = ($link / $boardCnt) == 0 ? "1" : ($link / $boardCnt);

				$record = $boardCnt;
				$url_file = "/";
				$url_parameter = "com=mypage&lnd=".$lnd;
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$boardResult = parent::getBoardListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($boardResult)){
					$idx				=  $boardResult[$key]["idx"];
					$title				=  $boardResult[$key]["title"];
					$userId				=  $boardResult[$key]["userId"];
					//$content			=  nl2br($boardResult[$key]["content"]);
					$viewContent = $this->common->cutstr($boardResult[$key]["content"],"100");

					$headWord			=  $boardResult[$key]["headWord"];
					$mCnt			=  $boardResult[$key]["mCnt"];

					if($code == "notice"){
						$regDateArray	=  explode("-",substr($boardResult[$key]["regDate"],0,10));
						$regDate = $regDateArray[1]."/".$regDateArray[2];
						$returnVal .= "				
							<dt><input type=\"image\" src=\"/images/btn_expand.gif\" onclick=\"toggleView(this)\" alt=\"확대\" />".$title."<span class=\"board_date_txt\">".$regDate."</span></dt>
							<dd>
								".$content."
							</dd>
						";
					}else{
						$returnVal .= "
							<dt>
								<span class=\"float_left\">
									<span style=\"color:#888;\">[".$loop_number."]</span> ".$headWord."
								</span>
								<span class=\"float_right\">
									".str_replace("-",".",substr($boardResult[$key]["regDate"],2,8))."
								</span>
								<span style=\"color:#333;display:block;padding-top:10px;clear:both;\">".$title."</span>
							</dt>
							<dd>
								".$viewContent."

								<div style=\"text-align:right;margin-top:15px;\">
									<input type=\"button\" value=\"상세보기\" class=\"btn_2 btn_s\" onclick=\"location.href = '?com=mypage&lnd=bView&idx=".$idx."&code=".$code."';\" />
								</div>
							</dd>
						";
					}

					$loop_number--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**댓글 리스트**/
		public function getMemoList($getBeen){
			$rtnList = "";

			$memoResult = parent::getBoardMemoCntMOL($getBeen);
			while (list($key_m, $val_m) = each($memoResult)){
				$memoCnt = $memoResult[$key_m]["bmCnt"];
			}
			
			$this->memoTotalCnt = $memoCnt;
			$loopCnt = $memoCnt;

			if($memoCnt > 0){
				$memoResult = parent::getBoardMemoListMOL($getBeen);
				while (list($key_m, $val_m) = each($memoResult)){
					if($memoResult[$key_m]["userId"] == $_SESSION["USER_ID"]){
						$actionBtn = "
							<input type=\"button\" class=\"b_select_btn b_select_btn_ex\" value=\"삭제\" onclick=\"memoDelete('".$memoResult[$key_m]["idx"]."');\"/>
							<input type=\"button\" class=\"b_select_btn b_select_btn_ex\" onclick=\"memoModify('".$memoResult[$key_m]["idx"]."');\" value=\"수정\" />
						";
					}else{
						$actionBtn = "";
					}

					$rtnList .= "
						<dd>
							<div class=\"replay_seq float_left\">[댓글 ".$loopCnt."]</div>
							<div class=\"replay_content float_left\">
								<div>
									".nl2br($memoResult[$key_m]["content"])." <textarea id=\"content".$memoResult[$key_m]["idx"]."\" style=\"display:none;\">".$memoResult[$key_m]["content"]."</textarea>
								</div>
								<div class=\"replay_info float_left\" style=\"margin-top:7px;\">
									".$memoResult[$key_m]["userId"]."&nbsp;&nbsp;|&nbsp;&nbsp;".str_replace("-",".",$memoResult[$key_m]["writeDate"])."
								</div>
							</div>

							<div style=\"clear:both;\">
								".$actionBtn."
							</div>
						</dd>
					";
					$loopCnt--;
				}
			}
			return $rtnList;
		}

		/**게시판 수정 데이터 추출**/
		public function boardModifyInfo($getBeen){
			$boardResult = parent::getBoardInfoMOL($getBeen);
			$returnData = array();

			while (list($key, $val) = each($boardResult)){
				$returnData["title"] = $boardResult[$key]["title"];
				$returnData["code"] = $boardResult[$key]["code"];
				$returnData["userId"] = $boardResult[$key]["userId"];
				$returnData["hit"] = $boardResult[$key]["hit"];
				$returnData["regDate"] = $boardResult[$key]["regDate"];
				$returnData["headWord"] = $boardResult[$key]["headWord"];
				$returnData["content"] = $boardResult[$key]["content"];
			}

			return $returnData;
		}

		/**게시물 수정**/
		public function boardUpadteBoardMng($setData, $whereBeen){
			$setBeen = array($setData[0],$setData[1]);
			parent::updateBoardMOL($setBeen, $whereBeen);
			$this->common->finalMoveMng("lnd","게시판물이 수정 되었습니다.","mypage","bView","&idx=".$whereBeen[":idx"]."&code=".$setData[2]);
		}

		/**게시물 수정**/
		public function boardUpadteBoardFront($setData, $whereBeen){
			$setBeen = array($setData["title"],$setData["content"], $setData["headWord"]);
			parent::updateBoardFrontMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","게시물이 수정 되었습니다.","mypage","bView","&idx=".$whereBeen[":idx"]."&code=".$setData["code"]);
		}

		/**게시물 삭제**/
		public function boardDeleteFront($whereBeen, $code){
			parent::deleteBoardMOL($whereBeen);
			parent::deleteMemoTotalMOL($whereBeen);
			$this->common->finalMove("lnd","게시물이 삭제 되었습니다.","mypage","bList","&code=".$code);
		}

		/**댓글 등록**/
		public function setBoardMemoInfo($setBeen, $code){
			parent::setBoardMemoInfoMOL($setBeen);
			$this->common->finalMove("lnd","댓글이 등록되었습니다.","mypage","bView","&idx=".$setBeen[0]."&code=".$code);
		}

		/**댓글 수정**/
		public function updateBoardMemoInfo($setBeen, $whereBeen, $code, $parentIdx){
			parent::updateBoardMemoInfoMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","댓글이 수정되었습니다.","mypage","bView","&idx=".$parentIdx."&code=".$code);
		}

		/**댓글 수정**/
		public function deleteBoardMemoInfo($whereBeen, $code, $parentIdx){
			parent::deleteBoardMemoInfoMOL($whereBeen);
			$this->common->finalMove("lnd","댓글이 삭제되었습니다.","mypage","bView","&idx=".$parentIdx."&code=".$code);
		}
	}
?>