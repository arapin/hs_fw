<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/aqBoardMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class AqBoard extends AqBoardMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $link = "20";
		public $linking = "10";
		public $totalCnt = 0;
		public $totalPage = 0;

		/*생성자*/
		public function __construct() {
			parent:: __construct("aqboardinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}

		/*관리자 게시판 관리 리스트 출력*/
		public function aqBoardList($page="", $setOrder="", $search=""){
			$returnVal = "";
			$searchQuery = "";

			if($search["searchState"] != ""){
				$searchQuery .= " AND state = '".$search["searchState"]."' ";
			}

			if($search["searchValue"] != ""){
				$searchQuery .= " AND (title LIKE '%".$search["searchValue"]."%' OR content LIKE '%".$search["searchValue"]."%' OR userId LIKE '%".$search["searchValue"]."%')";
			}

			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery."order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{

				$aqTotalCntResult = parent::aqBoardTotalListMOL();
				while (list($key, $val) = each($aqTotalCntResult)){
					$aqCnt = $aqTotalCntResult[$key]["aqCnt"];
				}

				$this->totalCnt = $aqCnt;
				$this->totalPage = ($link / $aqCnt) == 0 ? "1" : ($link / $aqCnt);
				$record = $aqCnt;
				$url_file = "/";
				$url_parameter = "com=user&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$aqResult = parent::aqBoardListMOL("",$limitQuery);
				while (list($key, $val) = each($aqResult)){
					$idx				=  $aqResult[$key]["idx"];
					$title				=  $aqResult[$key]["title"];
					$userId			=  $aqResult[$key]["userId"];
					$hit				=  $aqResult[$key]["hit"];
					$state				=  $aqResult[$key]["state"];
					$regDate			=  $aqResult[$key]["regDate"];
					$answerCnt		=  $aqResult[$key]["answerCnt"];
					$answerStartDate		=  $aqResult[$key]["answerStartDate"];
					$answerEndDate		=  $aqResult[$key]["answerEndDate"];
					
					/*$answerBeen = array(":idx"=> $idx);
					$answerResult = parent::aqBoardtInfoAnswerCntMOL($answerBeen );
					while (list($key_a, $val_a) = each($answerResult)){
						$answerCnt = $answerResult[$key_a]["answerCnt"];
					}*/

					switch($state){
						case "W" : 
							$viewState = "대기";
							break;
						case "V" : 
							$viewState = "진행대기";
							break;
						case "I" : 
							$viewState = "<img src=\"/images/btn_sel_ing.gif\" alt=\"진행중\" />";
							break;
						case "C" : 
							$viewState = "<img src=\"/images/btn_sel_end.gif\" alt=\"채택완료\">";
							break;
					}

					$productBeen = array(":idx" => $aqResult[$key]["proCate"]);
					$productResult = parent::productSelectInfoMOL($productBeen);

					while (list($key_s, $val_s) = each($productResult)){
						$productName = $productResult[$key_s]["proName"];
					}
					
					if($_SESSION["SH_ID"] != ""){
						$url = "?com=aqBoard&lnd=view&idx=".$idx;
					}else{					
						$url = $_SESSION["USER_ID"] == $userId ? "?com=aqBoard&lnd=view&idx=".$idx : "#none";
					}
					
					if($answerStartDate != ""){
						$viewAnswerStartDate = str_replace("-",".",substr($answerStartDate,2));
						$viewAnswerEndDate = str_replace("-",".",substr($answerEndDate,2));
						$viewAnswerDate = $viewAnswerStartDate." ~ ".$viewAnswerEndDate;
					}else{
						$viewAnswerDate = "-";
					}

					$returnVal .= "					
                            <tr>
                                <td>".$loop_number."</td>
                                <td>".$productName."</td>
                                <td class=\"btskin_txt1\" style=\"text-align:left;\"><a href=\"".$url."\">".$title."</a></td>
                                <td class=\"btskin_txt2\">".$viewAnswerDate."</td>
                                <td>".substr($regDate,0,10)."</td>
                                <td>".$userId."</td>
                                <td class=\"btskin_txt2\">".$answerCnt."</td>
                                <td class=\"btskin_txt2\">".$viewState."</td>
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

		/*관리자 게시판 관리 리스트 출력*/
		public function aqBoardListM($page="", $setOrder="", $search=""){
			$returnVal = "";
			$searchQuery = "";

			if($search["searchState"] != ""){
				$searchQuery .= " AND state = '".$search["searchState"]."' ";
			}

			if($search["searchValue"] != ""){
				$searchQuery .= " AND (title LIKE '%".$search["searchValue"]."%' OR content LIKE '%".$search["searchValue"]."%' OR userId LIKE '%".$search["searchValue"]."%')";
			}

			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery."order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{

				$aqTotalCntResult = parent::aqBoardTotalListMOL();
				while (list($key, $val) = each($aqTotalCntResult)){
					$aqCnt = $aqTotalCntResult[$key]["aqCnt"];
				}

				$this->totalCnt = $aqCnt;
				$this->totalPage = ($link / $aqCnt) == 0 ? "1" : ($link / $aqCnt);
				$record = $aqCnt;
				$url_file = "/";
				$url_parameter = "com=user&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$aqResult = parent::aqBoardListMOL("",$limitQuery);
				while (list($key, $val) = each($aqResult)){
					$idx				=  $aqResult[$key]["idx"];
					$title				=  $aqResult[$key]["title"];
					$userId			=  $aqResult[$key]["userId"];
					$hit				=  $aqResult[$key]["hit"];
					$state				=  $aqResult[$key]["state"];
					$regDate			=  $aqResult[$key]["regDate"];
					$answerCnt		=  $aqResult[$key]["answerCnt"];
					$answerStartDate		=  $aqResult[$key]["answerStartDate"];
					$answerEndDate		=  $aqResult[$key]["answerEndDate"];
					
					/*$answerBeen = array(":idx"=> $idx);
					$answerResult = parent::aqBoardtInfoAnswerCntMOL($answerBeen );
					while (list($key_a, $val_a) = each($answerResult)){
						$answerCnt = $answerResult[$key_a]["answerCnt"];
					}*/

					switch($state){
						case "W" : 
							$viewState = "대기";
							break;
						case "V" : 
							$viewState = "진행대기";
							break;
						case "I" : 
							$viewState = "<img src=\"/images/btn_sel_ing.gif\" alt=\"진행중\" />";
							break;
						case "C" : 
							$viewState = "<img src=\"/images/btn_sel_end.gif\" alt=\"채택완료\">";
							break;
					}

					$productBeen = array(":idx" => $aqResult[$key]["proCate"]);
					$productResult = parent::productSelectInfoMOL($productBeen);

					while (list($key_s, $val_s) = each($productResult)){
						$productName = $productResult[$key_s]["proName"];
					}
					
					if($_SESSION["SH_ID"] != ""){
						$url = "?com=aqBoard&lnd=view&idx=".$idx;
					}else{					
						$url = $_SESSION["USER_ID"] == $userId ? "?com=aqBoard&lnd=view&idx=".$idx : "";
					}
					
					if($answerStartDate != ""){
						$viewAnswerStartDate = str_replace("-",".",substr($answerStartDate,2));
						$viewAnswerEndDate = str_replace("-",".",substr($answerEndDate,2));
						$viewAnswerDate = $viewAnswerStartDate." ~ ".$viewAnswerEndDate;
					}else{
						$viewAnswerDate = "-";
					}

					$returnVal .= "
					
							<dt>
								<span style=\"color:#888;\">[".$loop_number."]</span> ".$productName."
								<span style=\"color:#333;display:block;margin-top:10px;\">".$title."</span>
							</dt>
							<dd>
								<ul class=\"bc_lst l_style_none\">
									<li>답변기간 : <span class=\"txt_2\">".$viewAnswerDate."</span></li>
									<li>작성일 : ".str_replace("-",".",substr($regDate,2,8))."</li>
									<li>작성자 : ".$userId."</li>
									<li>답변수 : <span class=\"txt_2\">".$answerCnt."</span></li>
									<li>답변채택 : <span class=\"txt_2\">".$viewState."</span></li>
								</ul>
								<div class=\"b_view_btn\">
									<input type=\"button\" value=\"상세보기\" onclick=\"location.href = '".$url."'\" />
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

		/*관리자 게시판 관리 리스트 출력*/
		public function aqBoardListMng($page="", $setOrder=""){
			$returnVal = "";

			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{

				$aqTotalCntResult = parent::aqBoardTotalListMngMOL();
				while (list($key, $val) = each($aqTotalCntResult)){
					$aqCnt = $aqTotalCntResult[$key]["aqCnt"];
				}

				$record = $aqCnt;
				/*$url_file = "/";
				$url_parameter = "com=user&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$aqResult = parent::aqBoardListMngMOL("",$limitQuery);
				while (list($key, $val) = each($aqResult)){
					$idx				=  $aqResult[$key]["idx"];
					$title				=  $aqResult[$key]["title"];
					$userId			=  $aqResult[$key]["userId"];
					$state				=  $aqResult[$key]["state"];
					$regDate			=  $aqResult[$key]["regDate"];

					switch($state){
						case "W" : 
							$viewState = "<span style=\"color:#9cfaac;font-weight:bold;\">대기</span>";
							break;
						case "V" :
							$viewStatus = "<span style=\"color:#7679f3;font-weight:bold;\">진행대기</span>";
							break;
						case "I" :
							$viewStatus = "<span style=\"color:#7679f3;font-weight:bold;\">진행중</span>";
							break;
						case "C" : 
							$viewState = "<span style=\"color:#fc2418;font-weight:bold;\">채택완료</span>";
							break;
					}

					$returnVal .= "<tr>
						<td>".$record."</td>
						<td><a href=\"#none\" onclick=\"viewMng('".$idx."');\">".$title."</a></td>
						<td style=\"text-transform:none;\">".$userId."</td>
						<td>".$viewState."</td>
						<td><span class=\"date\">".$regDate."</span></td>
					</tr>";

					$record--;
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
				$productResult = parent::productSelectInfoMOL($productBeen);

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

				$answerBeen = array(":idx"=> $getBeen[":idx"]);
				$answerResult = parent::aqBoardtInfoAnswerCntMOL($answerBeen );
				while (list($key_a, $val_a) = each($answerResult)){
					$returnData["answerCnt"] = $answerResult[$key_a]["answerCnt"];
				}

				if($aqResult[$key]["answerStartDate"] != ""){
					$viewAnswerStartDate = str_replace("-",".",$aqResult[$key]["answerStartDate"]);
					$viewAnswerEndDate = str_replace("-",".",$aqResult[$key]["answerEndDate"]);
					$viewAnswerDate = $viewAnswerStartDate." ~ ".$viewAnswerEndDate;
				}else{
					$viewAnswerDate = "-";
				}

				$returnData["answerDate"] = $viewAnswerDate;

			}

			return $returnData;

		}

		/**신점문의 등록**/
		public function setAqBoardInfo($setBeen){
			$title = $setBeen[0];
			$content = $setBeen[1];
			$userId = $setBeen[2];
			$proCate = $setBeen[3];
			$proPrice = $setBeen[4];
			$answerStartDate = $setBeen[5];
			$answerEndDate = $setBeen[6];
			
			/*결제 데이터 생성*/
			$paymentBeen = array("B", "Q", $userId, $proPrice, "0", "", "", "W", "", "", "", "", date("Y-m-d H:i:s"));
			$paymentIdx = parent::paymentInfoInsert($paymentBeen);
			
			/*신점문의 등록*/
			$aqSetBeen = array("Q", "", $content, "0", "", $paymentIdx, $proCate, date("Y-m-d H:i:s"), "W", $title, $userId, $answerStartDate, $answerEndDate);
			parent::aqBoardInsertMOL($aqSetBeen);
			$this->common->finalMove("lnd","신점 문의가 등록 되었습니다.","aqBoard","list");
		}

		/**신점문의 상담구분**/
		public function getProductInfoList($cate=""){
			$rtnVal = "";
			$productResult = parent::productSelectInfoQuestionMOL();
			while (list($key, $val) = each($productResult)){
				$selecred = $cate == $productResult[$key]["idx"] ? "selected" : "";
				$rtnVal .= "<option value=\"".$productResult[$key]["idx"]."-".$productResult[$key]["proPrice"]."\" ".$selecred.">".$productResult[$key]["proName"]."</option>";
			}

			return $rtnVal;
		}
		
		/**신점 문의 수정**/
		public function updateAqBoardInfo($setBeen, $whereBeen){
			parent::aqBoardUpdateMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","신점 문의가 수정 되었습니다.","aqBoard","view", "&idx=".$whereBeen[":idx"]);
		}

		/**신점 답변 달기**/
		public function aqBoardAnswer($setBeen){
			parent::aqBoardAnswerMOL($setBeen);
			$whereBeen = array(":idx"=>$setBeen[2]);
			$updateBeen = array("I");
			parent::aqBoardStatusUpdateMOL($updateBeen, $whereBeen);
			$this->common->finalMove("lnd","답변이 등록 되었습니다.","aqBoard","view", "&idx=".$setBeen[2]);
		}

		/**신점 답변 채택**/
		public function aqBoardChoice($idx, $answerIdx){
			$parentWhereBeen = array(":idx"=>$idx);
			$updateBeen = array("C");
			parent::aqBoardStatusUpdateMOL($updateBeen, $parentWhereBeen);

			$answerWhereBeen = array(":idx"=>$answerIdx);
			$updateBeen = array("Y");
			parent::aqBoardAnswerChoiceMOL($updateBeen, $answerWhereBeen);

			$this->common->finalMove("lnd","답변이 채택 되었습니다.","aqBoard","view", "&idx=".$idx);
		}

		/**신점 답변 수정**/
		public function aqBoardAnswerUpdate($setBeen, $whereBeen, $parentIdx){
			parent::aqBoardUpdateMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","답변이 수정 되었습니다.","aqBoard","view", "&idx=".$parentIdx);
		}

		/**신점 답변 삭제**/
		public function aqBoardAnswerDelete($whereBeen, $parentIdx){
			parent::aqBoardAnswerInfoDeleteMOL($whereBeen);
			$this->common->finalMove("lnd","답변이 삭제 되었습니다.","aqBoard","view", "&idx=".$parentIdx);
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

					if($userId == $_SESSION["SH_ID"]){
						if($parentStatus != "C"){
							$userBtn = "
								<div style=\"clear:both;\">
									<input type=\"button\" value=\"수정\" class=\"b_select_btn b_select_btn_ex\" onclick=\"modifyAnswer('".$idx."')\"/>
									<input type=\"button\" value=\"삭제\" class=\"b_select_btn b_select_btn_ex\" onclick=\"deleteAnswer('".$idx."')\"/>
								</div>
								";
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
							</div>
							".$answerBtn.$userBtn."
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
						$answerBtn = "<input type=\"button\" value=\"채택완료\" class=\"btn_1\" />";
					}else{
						$class = "";
						if($_SESSION["USER_ID"] == $parentId && $parentStatus != "C"){
							$answerBtn = "<input type=\"button\" class=\"btn_7\" value=\"채택하기\" onclick=\"answerChoice('".$idx."','".$getBeen[":idx"]."')\"/>";
						}
					}

					if($userId == $_SESSION["SH_ID"]){
						if($parentStatus != "C"){
							$userBtn = "
								<div style=\"clear:both;\">
									<input type=\"button\" value=\"수정\" class=\"btn_1\" onclick=\"modifyAnswerM('".$idx."')\"/>
									<input type=\"button\" value=\"삭제\" class=\"btn_2\" onclick=\"deleteAnswer('".$idx."')\"/>
								</div>
								";
						}
					}

					$returnVal .= "

						<dd ".$class.">
							<p class=\"cmt_cnt\">[답변 ".$totalCnt."]</p>
							<div class=\"cmt_sel_btn\">
								".$answerBtn.$userBtn."
							</div>

							".nl2br($content)." <textarea id=\"content".$idx."\" style=\"display:none\">".$content."</textarea>
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
	}
?>