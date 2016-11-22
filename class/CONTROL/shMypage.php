<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/shMypageMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class SHMypage extends SHMaypageMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $totalCnt;
		public $totalPage;
		public $resCancelCnt;
		public $resWatingCnt;
		public $resCompletCnt;
		public $shCalTotalPrice;
		public $shCalTotalCnt;
		public $totalImg;
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("sample");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}

		/**무속인 답변 리스트**/
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
				$whereBeen = array(":userId" => $_SESSION["SH_ID"]);
				$aqTotalCntResult = parent::aqBoardclientAnswerTotalCntMOL($whereBeen);
				while (list($key, $val) = each($aqTotalCntResult)){
					$answerCnt = $aqTotalCntResult[$key]["answerCnt"];
				}

				$this->totalCnt = $answerCnt;
				$this->totalPage = ($link / $answerCnt) == 0 ? "1" : ($link / $answerCnt);
				$record = $answerCnt;
				$url_file = "/";
				$url_parameter = "com=mypage&lnd=qList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$aqResult = parent::aqBoardclientAnswerListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($aqResult)){
					$parentIdx				=  $aqResult[$key]["parentIdx"];
					$getBeen = array(":idx"=>$parentIdx);
					$parentResult = parent::aqBoardInfoMOL($getBeen);
					
					while (list($key_p, $val_p) = each($parentResult)){

						$idx				=  $parentResult[$key_p]["idx"];
						$title				=  $parentResult[$key_p]["title"];
						$userId			=  $parentResult[$key_p]["userId"];
						$hit				=  $parentResult[$key_p]["hit"];
						$state				=  $parentResult[$key_p]["state"];
						$regDate			=  $parentResult[$key_p]["regDate"];
						
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

						$productBeen = array(":idx" => $parentResult[$key_p]["proCate"]);
						$productResult = parent::productSelectInfoMOLUser($productBeen);

						while (list($key_s, $val_s) = each($productResult)){
							$productName = $productResult[$key_s]["proName"];
						}
					}

					$returnVal .= "
						<tr>
							<td>".$loop_number."</td>
							<td>".$productName."</td>
							<td class=\"btskin_txt1\" style=\"text-align:left;\"><a href=\"?com=shMypage&lnd=qView&idx=".$idx."\">".$title."</a></td>
							<td class=\"btskin_txt2\">15.10.31 ~ 15.11.10</td>
							<td>".substr($regDate,0,10)."</td>
							<td>".$userId."</td>
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

		/**무속인 답변 리스트**/
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
				$whereBeen = array(":userId" => $_SESSION["SH_ID"]);
				$aqTotalCntResult = parent::aqBoardclientAnswerTotalCntMOL($whereBeen);
				while (list($key, $val) = each($aqTotalCntResult)){
					$answerCnt = $aqTotalCntResult[$key]["answerCnt"];
				}

				$this->totalCnt = $answerCnt;
				$this->totalPage = ($link / $answerCnt) == 0 ? "1" : ($link / $answerCnt);
				$record = $answerCnt;
				$url_file = "/";
				$url_parameter = "com=mypage&lnd=qList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$aqResult = parent::aqBoardclientAnswerListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($aqResult)){
					$parentIdx				=  $aqResult[$key]["parentIdx"];
					$getBeen = array(":idx"=>$parentIdx);
					$parentResult = parent::aqBoardInfoMOL($getBeen);
					
					while (list($key_p, $val_p) = each($parentResult)){

						$idx				=  $parentResult[$key_p]["idx"];
						$title				=  $parentResult[$key_p]["title"];
						$userId			=  $parentResult[$key_p]["userId"];
						$hit				=  $parentResult[$key_p]["hit"];
						$state				=  $parentResult[$key_p]["state"];
						$regDate			=  substr($parentResult[$key_p]["regDate"],2,8);
						$answerStartDate			=  substr($parentResult[$key_p]["answerStartDate"],2);
						$answerEndDate			=  substr($parentResult[$key_p]["answerEndDate"],2);
						
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

						$productBeen = array(":idx" => $parentResult[$key_p]["proCate"]);
						$productResult = parent::productSelectInfoMOLUser($productBeen);

						while (list($key_s, $val_s) = each($productResult)){
							$productName = $productResult[$key_s]["proName"];
						}
					}

					$returnVal .= "

						<dt>
							<span style=\"color:#888;\">[".$loop_number."]</span> ".$productName."
							<span style=\"color:#333;display:block;margin-top:10px;\">".$title."</span>
						</dt>
						<dd>
							<ul class=\"bc_lst l_style_none\">
								<li>답변기간 : <span class=\"txt_2\">".$answerStartDate." ~ ".$answerEndDate."</span></li>
								<li>작성일 : ".$regDate."</li>
								<li>작성자 : ".$userId."</li>
								<li>답변수 : <span class=\"txt_2\">".$answerCnt."</span></li>
								<li>답변채택 : <span class=\"txt_2\">".$viewState."</span></li>
							</ul>
							<div class=\"b_view_btn\">
								<input type=\"button\" value=\"상세보기\" onclick=\"location.href = '?com=shMypage&lnd=qView&idx=".$idx."'\" />
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

					if($userId == $_SESSION["SH_ID"]){
						if($parentStatus != "C"){
							$userBtn = "
								<input type=\"button\" class=\"b_select_btn b_select_btn_ex\" value=\"삭제\" onclick=\"deleteAnswer('".$idx."')\"/>
								<input type=\"button\" class=\"b_select_btn b_select_btn_ex\" value=\"수정\" onclick=\"modifyAnswer('".$idx."')\"/>
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
								".$answerBtn."
							</div>
							".$userBtn."
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
						$answerBtn = "<input type=\"button\" class=\"btn_1\" value=\"채택완료\" />";
					}else{
						$class = "";
						if($_SESSION["USER_ID"] == $parentId && $parentStatus != "C"){
							$answerBtn = "<input type=\"button\" class=\"b_select_btn\" value=\"채택하기\" onclick=\"answerChoice('".$idx."','".$getBeen[":idx"]."')\"/>";
						}
					}

					if($userId == $_SESSION["SH_ID"]){
						if($parentStatus != "C"){
							$answerBtn = "
		                        <input type=\"button\" value=\"수정\" class=\"btn_2\" style=\"margin-right:5px;\" onclick=\"deleteAnswer('".$idx."')\"/>
								<input type=\"button\" value=\"삭제\" class=\"btn_2\" onclick=\"modifyAnswer('".$idx."')\"/>
								";
						}
					}

					$returnVal .= "

						<dd ".$class.">
							<p class=\"cmt_cnt\">[답변 ".$totalCnt."]</p>
							<div class=\"cmt_sel_btn\">
								".$answerBtn."
							</div>

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

		/**신점 답변 수정**/
		public function aqBoardAnswerUpdate($setBeen, $whereBeen, $parentIdx){
			parent::aqBoardUpdateMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","답변이 수정 되었습니다.","shMypage","qView", "&idx=".$parentIdx);
		}

		/**신점 답변 삭제**/
		public function aqBoardAnswerDelete($whereBeen, $parentIdx){
			parent::aqBoardAnswerInfoDeleteMOL($whereBeen);
			$this->common->finalMove("lnd","답변이 삭제 되었습니다.","shMypage","qView", "&idx=".$parentIdx);
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
				$whereBeen = array(":userId" => $_SESSION["SH_ID"]);
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
                                <td class=\"btskin_txt1\" style=\"text-align:left;\"><a href=\"?com=shMypage&lnd=bView&idx=".$idx."&code=".$code."\">".$title."<span class=\"board_view_txt5\">(".$mCnt.")</span></a></td>
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
				$whereBeen = array(":userId" => $_SESSION["SH_ID"]);
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
					$viewContent	= $this->common->cutstr($boardResult[$key]["content"],"100");
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
								<span style=\"color:#333;display:block;padding:10px 0px 15px 0px;clear:both;\">".$title."</span>
								작성자 : ".$userId."
							</dt>
							<dd>
								".$viewContent."

								<div style=\"text-align:right;margin-top:15px;\">
									<input type=\"button\" value=\"상세보기\" class=\"btn_2 btn_s\" onclick=\"location.href = '?com=shMypage&lnd=bView&idx=".$idx."&code=".$code."';\" />
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
					if($memoResult[$key_m]["userId"] == $_SESSION["SH_ID"]){
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

		/**댓글 리스트**/
		public function getMemoListM($getBeen){
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
					if($memoResult[$key_m]["userId"] == $_SESSION["SH_ID"]){
						$actionBtn = "
						<div style=\"text-align:right;padding:10px 0px 20px 0px; overflow:auto;\">
							<div class=\"float_left\">
								<input type=\"button\" value=\"수정\" class=\"btn_9 btn_s\" style=\"margin-right:7px;\" onclick=\"memoModify('".$memoResult[$key_m]["idx"]."');\" />
								<input type=\"button\" value=\"삭제\" class=\"btn_2 btn_s\" onclick=\"memoDelete('".$memoResult[$key_m]["idx"]."');\"/>
							</div>
						</div>
						";
					}else{
						$actionBtn = "";
					}

					$rtnList .= "
						<div style=\"border:1px solid #ccc; padding:15px 10px 10px 10px; font-size:14px; line-height:150%;\">
							<div style=\"color:#888;\">
								<span class=\"float_left\">[댓글".$loopCnt."] / ".$memoResult[$key_m]["userId"]."</span>
								<span class=\"float_right\">".str_replace("-",".",$memoResult[$key_m]["writeDate"])."</span>
							</div>

							<p style=\"clear:both;margin:0px;padding-top:10px;\">
								".nl2br($memoResult[$key_m]["content"])." <textarea id=\"content".$memoResult[$key_m]["idx"]."\" style=\"display:none;\">".$memoResult[$key_m]["content"]."</textarea>
							</p>
						</div>

						".$actionBtn."
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
			$this->common->finalMoveMng("lnd","게시판물이 수정 되었습니다.","shMypage","bView","&idx=".$whereBeen[":idx"]."&code=".$setData[2]);
		}

		/**게시물 수정**/
		public function boardUpadteBoardFront($setData, $whereBeen){
			$setBeen = array($setData["title"],$setData["content"], $setData["headWord"]);
			parent::updateBoardFrontMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","게시물이 수정 되었습니다.","shMypage","bView","&idx=".$whereBeen[":idx"]."&code=".$setData["code"]);
		}

		/**게시물 삭제**/
		public function boardDeleteFront($whereBeen, $code){
			parent::deleteBoardMOL($whereBeen);
			parent::deleteMemoTotalMOL($whereBeen);
			$this->common->finalMove("lnd","게시물이 삭제 되었습니다.","shMypage","bList","&code=".$code);
		}

		/**댓글 등록**/
		public function setBoardMemoInfo($setBeen, $code){
			parent::setBoardMemoInfoMOL($setBeen);
			$this->common->finalMove("lnd","댓글이 등록되었습니다.","shMypage","bView","&idx=".$setBeen[0]."&code=".$code);
		}

		/**댓글 수정**/
		public function updateBoardMemoInfo($setBeen, $whereBeen, $code, $parentIdx){
			parent::updateBoardMemoInfoMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","댓글이 수정되었습니다.","shMypage","bView","&idx=".$parentIdx."&code=".$code);
		}

		/**댓글 수정**/
		public function deleteBoardMemoInfo($whereBeen, $code, $parentIdx){
			parent::deleteBoardMemoInfoMOL($whereBeen);
			$this->common->finalMove("lnd","댓글이 삭제되었습니다.","shMypage","bView","&idx=".$parentIdx."&code=".$code);
		}

		/*점집 수정 정보*/
		public function clientModifyInfo($clientData){
			$clientResult = parent::modifyclientInfo($clientData);
			$returnData = array();
			while (list($key, $val) = each($clientResult)){
				$returnData["idx"]		= $clientResult[$key]["idx"];
				$returnData["SHId"]		= $clientResult[$key]["SHId"];
				$returnData["SHPwd"]	= trim($this->cipher->getDecrypt($clientResult[$key]["SHPwd"]));
				$returnData["name"]		= $clientResult[$key]["name"];
				$returnData["SHName"]	= $clientResult[$key]["SHName"];
				$returnData["SHTel"]	= $clientResult[$key]["SHTel"];
				$returnData["SHPhone"]	= $clientResult[$key]["SHPhone"];
				$returnData["SHAddress"]= $clientResult[$key]["SHAddress"];
				$returnData["SHStartTime"]	= $clientResult[$key]["SHStartTime"];
				$returnData["SHEndTime"]	= $clientResult[$key]["SHEndTime"];
				$returnData["SHLng"]	= $clientResult[$key]["SHLng"];
				$returnData["SHLat"]	= $clientResult[$key]["SHLat"];
				$returnData["SHDesc"]	= $clientResult[$key]["SHDesc"];
				$returnData["SHWord"]	= $clientResult[$key]["SHWord"];
				$returnData["SHStatus"]	= $clientResult[$key]["SHStatus"];
				$returnData["SHZipcode"]	= $clientResult[$key]["SHZipcode"];
				$returnData["SHAddress2"]	= $clientResult[$key]["SHAddress2"];
				$returnData["SHEmail"]	= $clientResult[$key]["SHEmail"];
				$returnData["SHRestSTime"]	= $clientResult[$key]["SHRestSTime"];
				$returnData["SHRestETime"]	= $clientResult[$key]["SHRestETime"];
			}

			return $returnData;
		}


		/**유저 예약 목록**/
		public function getclientReservationList($page="", $setOrder="", $shIdx){
			$returnVal = "";

			$startNum = ($page - 1) * $this->link;
			$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":SHIdx" => $shIdx);
				$resTotalCntResult = parent::getMyReservationCntMOL($whereBeen);
				while (list($key, $val) = each($resTotalCntResult)){
					$resCnt = $resTotalCntResult[$key]["resCnt"];
				}

				$this->totalCnt = $resCnt;
				$this->totalPage = ($link / $resCnt) == 0 ? "1" : ($link / $resCnt);
				$record = $resCnt;
				$url_file = "/";
				$url_parameter = "com=shMypage&lnd=resList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$resResult = parent::getMyReservationListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($resResult)){
					$idx				=  $resResult[$key]["idx"];
					$resDate			=  substr($resResult[$key]["resDate"],2);
					$resStartTime	=  $resResult[$key]["resStartTime"];
					$resEndTime	    =  $resResult[$key]["resEndTime"];
					$resCnt	    =  $resResult[$key]["resCnt"];

					$clientBeen = array(":SHIdx" => $resResult[$key]["SHIdx"]);
					$clientResult = parent::clientSelectInfoMOL($clientBeen);
					while (list($key_s, $val_s) = each($clientResult)){
						$name = $clientResult[$key_s]["name"];
						$SHName = $clientResult[$key_s]["SHName"];
					}

					$proBeen = array(":proIdx" => $resResult[$key]["proIdx"], ":SHIdx" => $resResult[$key]["SHIdx"]);
					$productResult = parent::productSelectInfoMOLSh($proBeen);
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
                                <td class=\"btskin_txt1\" onclick=\"setResInfo('".$idx."');\">".$name."</td>
                                <td>".$proName."</td>
                                <td>".$resDate." ".$resStartTime."~".$resEndTime."</td>
                                <td>".$viewPayDate."</td>
                                <td>".$resCnt."</td>
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
		public function getclientReservationListM($page="", $setOrder="", $shIdx){
			$returnVal = "";

			$startNum = ($page - 1) * $this->link;
			$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":SHIdx" => $shIdx);
				$resTotalCntResult = parent::getMyReservationCntMOL($whereBeen);
				while (list($key, $val) = each($resTotalCntResult)){
					$resCnt = $resTotalCntResult[$key]["resCnt"];
				}

				$this->totalCnt = $resCnt;
				$this->totalPage = ($link / $resCnt) == 0 ? "1" : ($link / $resCnt);
				$record = $resCnt;
				$url_file = "/";
				$url_parameter = "com=shMypage&lnd=resList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$resResult = parent::getMyReservationListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($resResult)){
					$idx				=  $resResult[$key]["idx"];
					$resDate			=  substr($resResult[$key]["resDate"],2);
					$resStartTime	=  $resResult[$key]["resStartTime"];
					$resEndTime	    =  $resResult[$key]["resEndTime"];
					$resCnt	    =  $resResult[$key]["resCnt"];

					$proBeen = array(":proIdx" => $resResult[$key]["proIdx"], ":SHIdx" => $resResult[$key]["SHIdx"]);
					$productResult = parent::productSelectInfoMOLSh($proBeen);
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
					$userWhereBeen = array(":idx" => $resResult[$key]["idx"]);
					$resUserResult = parent::getResUserInfo($userWhereBeen);
					while (list($key_u, $val_u) = each($resUserResult)){
						$name	= trim($this->cipher->getDecrypt($resUserResult[$key_u]["name"]));
						$phone	= trim($this->cipher->getDecrypt($resUserResult[$key_u]["phone"]));
					}


					switch($resResult[$key]["resState"]){
						case "W" :
							$viewStatus = "<span style=\"color:#9cfaac;font-weight:bold;\">예약 대기</span>";
							$viewBtn = "<input type=\"button\" value=\"취소하기\" style=\"width:140px;\" class=\"btn_7\" onclick=\"resCancel('".$idx."')\"/>";
							break;
						case "U" :
							$viewStatus = "<span style=\"color:#7679f3;font-weight:bold;\">예약 완료</span>";
							$viewBtn = "<input type=\"button\" value=\"취소하기\" style=\"width:140px;\" class=\"btn_7\" onclick=\"resCancel('".$idx."')\"/>";
							break;
						case "C" :
							$viewStatus = "<span style=\"color:#fc2418;font-weight:bold;\">예약 취소</span>";
							$viewBtn = "-";
							break;
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
								<ul class=\"bc_lst l_style_none\">
									<li><span style=\"color:#666;\">예약자명</span> : <span class=\"txt_1\">".$name."</span> (".$phone.")</li>
									<li><span style=\"color:#666;\">예약분류</span> : <span class=\"txt_2\">".$proName."</span></li>
									<li class=\"txt_3\">예약일자 : ".$resDate." ".$resStartTime."~".$resEndTime."</li>
									<li class=\"txt_3\">결제일자 : ".$viewPayDate."</li>
									<li class=\"txt_3\">결제금액 : <span class=\"txt_2\">￦ ".$viewPayMoney."</span> (".$resCnt."인)</li>
								</ul>
							</dd>
							<dd>
								<div class=\"table\">
									<div class=\"t_cell_c\" style=\"padding-right:5px;\">
									".$viewBtn."
									</div>
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
			$this->common->finalMove("lnd","예약이 취소 되었습니다.","shMypage","resList");
		}


		/*등록된 파일 목록 출력*/
		public function getFileInfoListView($getBeen){
			$fileResult = parent::searchFile($getBeen);
			$returnData = "";
			$this->totalImg = count($fileResult);
			while (list($key, $val) = each($fileResult)){
				if($fileResult[$key]["main"] == "Y"){
					$mainWord = "대표사진";
				}else{
					$mainWord = "";
				}

				$returnData .= "
					<label>
						<input type=\"radio\" name=\"chkMain\" value=\"".$fileResult[$key]["idx"]."\"/><!--<input type=\"checkbox\" name=\"chkDel[]\" value=\"".$fileResult[$key]["idx"]."\"/>-->".$mainWord."
						<img src=\"/upload/client/".$fileResult[$key]["saveName"]."\" alt=\"\" style=\"width:90px;height:60px;\"/>
					</label>
				";
			}

			return $returnData;
		}

		/*등록된 파일 목록 출력*/
		public function getFileInfoListViewM($getBeen){
			$fileResult = parent::searchFile($getBeen);
			$returnData = "";
			$this->totalImg = count($fileResult);
			while (list($key, $val) = each($fileResult)){
				if($fileResult[$key]["main"] == "Y"){
					$mainWord = "<span style=\"vertical-align:middle; padding-left:10px;\" class=\"txt_2\">[대표사진]</span>";
				}else{
					$mainWord = "";
				}

				$returnData .= "
					<dt>
						<img src=\"/upload/client/".$fileResult[$key]["saveName"]."\" height=\"90\" alt=\"\" />".$mainWord."
					</dt>
					<dd>
						".$fileResult[$key]["orgName"]."
					</dd>
				";
			}

			return $returnData;
		}

		/*등록된 파일 목록 출력*/
		public function getFileInfoListViewM2($getBeen){
			$fileResult = parent::searchFile($getBeen);
			$returnData = "";
			$this->totalImg = count($fileResult);
			while (list($key, $val) = each($fileResult)){
				if($fileResult[$key]["main"] == "Y"){
					$checked = "checked";
				}else{
					$checked = "";
				}

				$returnData .= "
					<dt>
                        <input type=\"radio\" style=\"vertical-align:top;\" name=\"chkMain\" value=\"".$fileResult[$key]["idx"]."\" ".$checked."/>
						<img src=\"/upload/client/".$fileResult[$key]["saveName"]."\" height=\"90\" alt=\"\" />
						<input type=\"image\" src=\"/images/mobile/btn_close2.gif\" alt=\"삭제\" class=\"del_btn2\" onclick=\"deleteFile('".$fileResult[$key]["idx"]."')\"/>
					</dt>
					<dd>
						".$fileResult[$key]["orgName"]."
					</dd>
				";
			}

			return $returnData;
		}

		/*등록된 프로파일 이미지 출력*/
		public function getProfileInfoListView($getBeen){
			$fileResult = parent::searchFile($getBeen);
			$returnData = "";
			while (list($key, $val) = each($fileResult)){
				$returnData["saveName"] = $fileResult[$key]["saveName"];
				$returnData["orgName"] = $fileResult[$key]["orgName"];
			}

			return $returnData;
		}


		/*상품정보 출력*/
		public function getSprInfoListView($getBeen){
			$sprResult = parent::searchSpr($getBeen);
			$returnData = "";
			$loopCnt = sizeof($sprResult);
			$i = 1;
			while (list($key, $val) = each($sprResult)){
				$time = $sprResult[$key]["proTime"];
				$proIdx = $sprResult[$key]["proIdx"];

				$rtnVal = "";
				$productResult = parent::searchProduct();
				while (list($key_p, $val_p) = each($productResult)){
					$selecred = $proIdx == $productResult[$key_p]["idx"] ? "selected" : "";
					$rtnVal .= "<option value=\"".$productResult[$key_p]["idx"]."\" ".$selecred.">".$productResult[$key_p]["proName"]."</option>";
				}
				
				if($i != 1){
					$addBtn = "<input type=\"button\" value=\"삭제\" class=\"sj_btn2\" onclick=\"delRow('".$i."');\"/>";
				}else{
					$addBtn = "";
				}
				$setOption = "";
				for($j=30; $j < 500; $j+=30){
					$hour = floor($j / 60);
					$min = ($j % 60);
					
					$printTime = $hour > 0 ? $hour."시간" : "";
					
					if($min > 0){
						$printTime .= $min."분";
					}

					$selected = $time == $j ? "selected" : "";

					$setOption .= "<option value=\"".$j."\" ".$selected.">".$printTime."</option>";
				}

				$returnData .= "
					<li id=\"proArea".$i."\">
						<select name=\"proIdx[]\">
							".$rtnVal."
						</select>
						<select name=\"proTime[]\">
							".$setOption."
						</select>
						<input type=\"text\" value=\"".$sprResult[$key]["price"]."\" name=\"price[]\"/><span>원/1명</span>
						".$addBtn."
					</li>
				";
				$i++;

			}
			return $returnData;
		}

		/*상품정보 출력*/
		public function getSprInfoListViewM($getBeen){
			$sprResult = parent::searchSpr($getBeen);
			$returnData = "";

			while (list($key, $val) = each($sprResult)){
				$time = $sprResult[$key]["proTime"];

				$hour = floor($time / 60);
				$min = ($time % 60);
				$printTime = $hour."시간";

				if($min > 0){
					$printTime .= $min."분";
				}

				$returnData .= "[".$sprResult[$key]["proName"]."] 시간 : [".$printTime."] 가격 : [".number_format($sprResult[$key]["price"])."원]\n";
			}
			return $returnData;
		}

		/*상품정보 출력*/
		public function getSprInfoListViewM2($getBeen){
			$sprResult = parent::searchSpr($getBeen);
			$returnData = "";

			while (list($key, $val) = each($sprResult)){
				$time = $sprResult[$key]["proTime"];

				$hour = floor($time / 60);
				$min = ($time % 60);
				$printTime = $hour."시간";

				if($min > 0){
					$printTime .= $min."분";
				}

				$returnData .= "<li>[".$sprResult[$key]["proName"]."] 시간 : [".$printTime."] 가격 : [".number_format($sprResult[$key]["price"])."원]<input type=\"image\" src=\"/images/mobile/btn_close2.gif\" alt=\"삭제\" class=\"del_btn\" onclick=\"deleteSpr('".$sprResult[$key]["sprIdx"]."')\"/></li>";
			}
			return $returnData;
		}

		/*예약 정보 출력*/
		public function getLimitDayInfoListView($getBeen){
			$limitResult = parent::getLimitInfoList($getBeen);
			$returnData = "";
			$loopCnt = sizeof($limitResult);
			$i = 1;
			while (list($key, $val) = each($limitResult)){
				$startDate = $limitResult[$key]["startDate"];
				$endDate = $limitResult[$key]["endDate"];

				$rtnVal = "";

				
				if($i != 1){
					$addBtn = "<input type=\"button\" value=\"삭제\" class=\"sj_btn2\" onclick=\"delDateItem('".$i."');\"/>";
				}else{
					$addBtn = "";
				}

				$returnData .= "
					<div id=\"limitArea".$i."\">
						<input type=\"text\" name=\"limitSDate[]\" id=\"limitSDate".$i."\" value=\"".$startDate."\" /> ~ <input type=\"text\" name=\"limitEDate[]\" id=\"limitEDate".$i."\" value=\"".$endDate."\" /> ".$addBtn."<script>setCal('limitDate','".$i."')</script>
					</div>
				";
				$i++;

			}
			return $returnData;
		}

		/*예약 정보 출력*/
		public function getLimitDayInfoListViewM($getBeen){
			$limitResult = parent::getLimitInfoList($getBeen);
			$returnData = "";

			while (list($key, $val) = each($limitResult)){
				$startDate = $limitResult[$key]["startDate"];
				$endDate = $limitResult[$key]["endDate"];
				$idx = $limitResult[$key]["idx"];

				$rtnVal = "";

				$returnData .= $startDate."~".$endDate."\n";
			}
			return $returnData;
		}

		/*예약 정보 출력*/
		public function getLimitDayInfoListViewM2($getBeen){
			$limitResult = parent::getLimitInfoList($getBeen);
			$returnData = "";
			$loopCnt = sizeof($limitResult);
			$i = 1;
			while (list($key, $val) = each($limitResult)){
				$startDate = $limitResult[$key]["startDate"];
				$endDate = $limitResult[$key]["endDate"];
				$idx = $limitResult[$key]["idx"];

				$returnData .= "
                    <li>".$startDate."~".$endDate." <input type=\"image\" src=\"/images/mobile/btn_close2.gif\" alt=\"삭제\" class=\"del_btn\" onclick=\"deleteLimit('".$idx."')\"/></li>
				";
				$i++;

			}
			return $returnData;
		}

		public function getProductSelectinfo(){
			$productResult = parent::searchProduct();
			$returnData = "<option value=\"\">신점분류</option>";
			while (list($key, $val) = each($productResult)){
				$returnData .= "<option value=\"".$productResult[$key]["idx"]."\">".$productResult[$key]["proName"]."</option>";
			}

			return $returnData;
		}
		
		/**대표이미지 설정**/
		public function setMainImgChk($setBeen, $whereBeen){
			$dafaultBeen = array("");
			parent::setMainImgDefaultMOL($dafaultBeen);
			parent::setMainImgChkMOL($setBeen, $whereBeen);
		}

		/*파일 삭제*/
		public function deleteImgFile($getBeen, $fileData){
			$fileResult = parent::uploadFileInfo($getBeen);
			while (list($key, $val) = each($fileResult)){
				$saveName = $fileResult[$key]["saveName"];
			}
			$deleteFilePath = $fileData["deletePath"]."/".$saveName;
			parent::deleteFileInfo($getBeen);
			@unlink($deleteFilePath);
		}

		/*파일 삭제*/
		public function deleteImgFileM($getBeen, $fileData){
			$fileResult = parent::uploadFileInfo($getBeen);
			while (list($key, $val) = each($fileResult)){
				$saveName = $fileResult[$key]["saveName"];
			}
			$deleteFilePath = $fileData["deletePath"]."/".$saveName;
			parent::deleteFileInfo($getBeen);
			@unlink($deleteFilePath);
			$this->common->finalMove("lnd","사진이 삭제 되었습니다.","shMypage","mngFile");
		}

		/*파일 추가*/
		public function addImgFile($fileData){
			$fileArray = $fileData[0];
			$cate = $fileData[1];
			$parentId = $fileData[2];
			$folder = $fileData[3];
			$fileNameArray = array();

			$fileCnt = sizeof($fileArray["name"]);

			for($i=0; $i < $fileCnt; $i++){

				$fileUploadDir = $folder;

				try{
					$rtnVal = $this->common->imageUploader($fileArray["tmp_name"][$i], $fileArray["name"][$i], $fileArray["size"][$i], $fileUploadDir, "2000", "2000", "10485760");
					$fileInsertData = array($parentId, $cate, $fileArray["type"][$i], $fileArray["size"][$i], $fileArray["name"][$i], $rtnVal, "", date("Y-m-d H:i:s"));
					parent::insertFile($fileInsertData);

				}catch(Exception $e){
					$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
					parent::logInsert($logData);
				}
			}
		}
		
		/*상품추가*/
		public function addProduct($setBeenData){
			parent::setProduct($setBeenData);
			$this->common->finalMove("lnd","상품이 추가 되었습니다.","shMypage","mngProduct","&SHIdx=".$setBeenData[0]);
		}

		public function deleteProduct($whereData, $SHIdx){
			parent::deleteProductMOL($whereData);
			$this->common->finalMove("lnd","상품이 삭제 되었습니다.","shMypage","mngProduct","&SHIdx=".$SHIdx);
		}

		/*파일 추가*/
		public function addImgFileM($fileData){
			$fileArray = $fileData[0];
			$cate = $fileData[1];
			$parentId = $fileData[2];
			$folder = $fileData[3];

			$fileUploadDir = $folder;

			try{
				$rtnVal = $this->common->imageUploader($fileArray["tmp_name"], $fileArray["name"], $fileArray["size"], $fileUploadDir, "2000", "2000", "10485760");
				$fileInsertData = array($parentId, $cate, $fileArray["type"], $fileArray["size"], $fileArray["name"], $rtnVal, "", date("Y-m-d H:i:s"));
				parent::insertFile($fileInsertData);

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
			}

			$this->common->finalMove("lnd","사진이 등록 되셨습니다.","shMypage","mngFile");
		}

		/*파일 추가*/
		public function addImgFile2($profile, $whereData){
			$fileData2 = array(":parentId" => $whereData[":SHId"], ":type" => "profile");
			$profileData = $this->getProfileInfoListView($fileData2);

			$deleteFilePath =  uploadPath."/client/".$profileData["saveName"];
			@unlink($deleteFilePath);

			$whereBeen = array(":SHId" => $whereData[":SHId"]);
			parent::profileDeleteMOL($whereBeen);

			$rtnVal = $this->common->imageUploader($profile["tmp_name"], $profile["name"], $profile["size"], uploadPath."/client", "100", "100", "10485760");

			switch ($rtnVal){
				case "01" : 
					$this->common->finalMove("lnd","등록할수 없는 확장자 입니다.","shMypage","modify","");
					break;
				case "02" : 
					$this->common->finalMove("lnd","등록할수 없는 크기의 파일 입니다.","shMypage","modify","");
					break;
				case "03" : 
					$this->common->finalMove("lnd","등록할수 있는 용량을 초과 했습니다.","shMypage","modify","");
					break;
				case "04" : 
					$this->common->finalMove("lnd","파일 등록 오류 입니다.","shMypage","modify","");
					break;
				case "05" : 
					$this->common->finalMove("lnd","이미지 파일이 아닙니다.","shMypage","modify","");
					break;
			}

			$fileInsertData = array($whereData[":SHId"], "profile", $profile["type"], $profile["size"], $profile["name"], $rtnVal, "", date("Y-m-d H:i:s"));
			parent::fileInsert($fileInsertData);

		}

		public function clientModifyMng($clientData,$whereData, $profile, $proIdx, $proTime, $price, $SHIdx, $limitSDate, $limitEDate){
			$clientData[10] = $this->cipher->getEncrypt($clientData[10]);

			if($profile["tmp_name"] != ""){
				$fileData2 = array(":parentId" => $whereData[":SHId"], ":type" => "profile");
				$profileData = $this->getProfileInfoListView($fileData2);

				$deleteFilePath =  uploadPath."/client/".$profileData["saveName"];
				@unlink($deleteFilePath);

				$whereBeen = array(":SHId" => $whereData[":SHId"]);
				parent::profileDeleteMOL($whereBeen);

				$rtnVal = $this->common->imageUploader($profile["tmp_name"], $profile["name"], $profile["size"], uploadPath."/client", "100", "100", "10485760");

				switch ($rtnVal){
					case "01" : 
						$this->common->finalMove("lnd","등록할수 없는 확장자 입니다.","shMypage","modify","");
						break;
					case "02" : 
						$this->common->finalMove("lnd","등록할수 없는 크기의 파일 입니다.","shMypage","modify","");
						break;
					case "03" : 
						$this->common->finalMove("lnd","등록할수 있는 용량을 초과 했습니다.","shMypage","modify","");
						break;
					case "04" : 
						$this->common->finalMove("lnd","파일 등록 오류 입니다.","shMypage","modify","");
						break;
					case "05" : 
						$this->common->finalMove("lnd","이미지 파일이 아닙니다.","shMypage","modify","");
						break;
				}

				$fileInsertData = array($whereData[":SHId"], "profile", $profile["type"], $profile["size"], $profile["name"], $rtnVal, "", date("Y-m-d H:i:s"));
				parent::fileInsert($fileInsertData);

			}

			$loopCnt = sizeof($proIdx);
			$proWhereBeen = array(":SHIdx"=>$SHIdx);
			parent::emptryProduct($proWhereBeen);
			for($i=0; $i < $loopCnt; $i++){
				$setBeenData = array($SHIdx, $proIdx[$i], $proTime[$i], $price[$i],date("Y-m-d H:i:s"));
				parent::setProduct($setBeenData);
			}

			$loopCnt = sizeof($limitSDate);
			$limitWhereBeen = array(":SHIdx"=>$SHIdx);
			parent::emptryLimitDay($limitWhereBeen);
			for($i=0; $i < $loopCnt; $i++){
				$setBeenData = array($SHIdx, $limitSDate[$i], $limitEDate[$i],date("Y-m-d H:i:s"));
				parent::setLimitDay($setBeenData);
			}

			parent::modifyclientMng($clientData,$whereData);
			$this->common->finalMove("lnd","입점정보가 수정 되셨습니다.","shMypage","modify", "");
		}

		public function clientModifyMngM($clientData,$whereData){
			$clientData[10] = $this->cipher->getEncrypt($clientData[10]);

			parent::modifyclientMng($clientData,$whereData);
			$this->common->finalMove("lnd","입점정보가 수정 되셨습니다.","shMypage","modify", "");
		}


		/*상품코드 등록*/
		public function getProductSelect2(){
			$productResult = parent::searchProduct();
			$returnData = "<option value=\"\">신점분류</option>";
			while (list($key, $val) = each($productResult)){
				$returnData .= "<option value=\"".$productResult[$key]["idx"]."\">".$productResult[$key]["proName"]."</option>";
			}

			return $returnData;
		}

		/**예약/예약자정보**/
		public function getResUserInfo($whereBeen){
			$resUserResult = parent::getResUserInfo($whereBeen);
			while (list($key, $val) = each($resUserResult)){
				$name			= trim($this->cipher->getDecrypt($resUserResult[$key]["name"]));
				$birthday		= $resUserResult[$key]["birthday"];
				$birthdayType	= $resUserResult[$key]["birthdayType"];
				$birthdayTime	= $resUserResult[$key]["birthdayTime"];
				$proName		= $resUserResult[$key]["proName"];
				$resDate		= $resUserResult[$key]["resDate"];
				$resStartTime	= $resUserResult[$key]["resStartTime"];
				$resEndTime		= $resUserResult[$key]["resEndTime"];
				$resCnt			= $resUserResult[$key]["resCnt"];
				$payPrice		= $resUserResult[$key]["payPrice"];
				
				if($birthdayType == "M"){
					$viewBirthType = "음";
				}else{
					$viewBirthType = "양";
				}

				$viewBirthDay = str_replace("-",".",$birthday);
				$userBirthInfo = $viewBirthDay." (".$viewBirthType.") ".$birthdayTime;
				$resDataInfo = str_replace("-",".",substr($resDate,2))." ".$resStartTime."~".$resEndTime;
			}

			$rtnJsonCode = "{\"userName\":\"".$name."\",\"userBirthInfo\":\"".$userBirthInfo."\",\"proName\":\"".$proName."\",\"resDate\":\"".$resDataInfo."\",\"resCnt\":\"".$resCnt."명\",\"payPrice\":\"".number_format($payPrice)."원\"}";
			return $rtnJsonCode;
		}

		public function deleteLimitDayInfo($whereBeen, $SHIdx){
			parent::deleteLimitDayMOL($whereBeen);
			$this->common->finalMove("lnd","예약제한일자가 삭제 되었습니다.","shMypage","limitDay", "&SHIdx=".$SHIdx);
		}

		public function setLimitDayInfo($limitSDate, $limitEDate, $SHIdx){
			$setBeenData = array($SHIdx, $limitSDate, $limitEDate,date("Y-m-d H:i:s"));
			parent::setLimitDay($setBeenData);
			$this->common->finalMove("lnd","예약제한일자가 추가 되었습니다.","shMypage","limitDay", "&SHIdx=".$SHIdx);
		}

		/**무속인 정산 리스트**/
		public function clientCalcList($page="", $setOrder="", $year=""){
			$returnVal = "";
			$searchQuery = "";

			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery."order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$clientData = array(":SHId" => $_SESSION["SH_ID"]);
				$clientResult = parent::modifyclientInfo($clientData);
				$returnData = array();
				while (list($key, $val) = each($clientResult)){
					$SHIdx		= $clientResult[$key]["idx"];
				}

				$whereBeen = array(":SHId" => $_SESSION["SH_ID"], ":year" => $year);
				$scalTotalResult = parent::clientCalcTotalListMOL($whereBeen);
				while (list($key, $val) = each($scalTotalResult)){
					$scCnt = $scalTotalResult[$key]["scCnt"];
				}

				$scalTotalResult = parent::clientCalcTotalInfoMOL($whereBeen);
				while (list($key, $val) = each($scalTotalResult)){
					$totalPrice = $scalTotalResult[$key]["totalPrice"];
					$totalCnt = $scalTotalResult[$key]["totalCnt"];
				}

				$totalPrice = $totalPrice == "" ? "0" : $totalPrice;
				$totalCnt = $totalCnt == "" ? "0" : $totalCnt;

				$this->totalCnt = $scCnt;
				$this->totalPage = ($link / $scCnt) == 0 ? "1" : ($link / $scCnt);
				$this->shCalTotalPrice = $totalPrice;
				$this->shCalTotalCnt = $totalCnt;

				$record = $scCnt;
				$url_file = "/";
				$url_parameter = "com=shMypage&lnd=calList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$scalResult = parent::clientCalcListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($scalResult)){
					$idx				=  $scalResult[$key]["idx"];
					$year				=  $scalResult[$key]["year"];
					$month				=  $scalResult[$key]["month"];
					$calcPrice			=  $scalResult[$key]["calcPrice"];
					$calcCnt			=  $scalResult[$key]["calcCnt"];
					$calcState			=  $scalResult[$key]["calcState"];
					$regDate			=  $scalResult[$key]["regDate"];
					
					$fristDay = "1";
					$lastDay = date("t", mktime("00","00","00",$month,$fristDay,$year));
					if($calcState == "Y"){
						$viewState = "지급";
						$stateClass = "";
					}else{
						$viewState = "미지급";
						$stateClass = "class=\"btskin_txt2\"";
					}

					$returnVal .= "
						<tr>
							<td>".$year."년</td>
							<td style=\"color:#333;\"><a href=\"?com=shMypage&lnd=calView&year=".$year."&month=".$month."&SHIdx=".$SHIdx."\" style=\"text-decoration:none; color:#333;\">".$month."월</a></td>
							<td>".$year.".".$month.".01~".$year.".".$month.".".$lastDay."</td>
							<td class=\"btskin_txt2\">￦".number_format($calcPrice)."</td>
							<td>".number_format($calcCnt)."건</td>
							<td ".$stateClass.">".$viewState."</td>
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

		/**무속인 정산 리스트**/
		public function clientCalcListM($page="", $setOrder="", $year=""){
			$returnVal = "";
			$searchQuery = "";

			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery."order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{

				$clientData = array(":SHId" => $_SESSION["SH_ID"]);
				$clientResult = parent::modifyclientInfo($clientData);
				$returnData = array();
				while (list($key, $val) = each($clientResult)){
					$SHIdx		= $clientResult[$key]["idx"];
				}

				$whereBeen = array(":SHId" => $_SESSION["SH_ID"], ":year" => $year);
				$scalTotalResult = parent::clientCalcTotalListMOL($whereBeen);
				while (list($key, $val) = each($scalTotalResult)){
					$scCnt = $scalTotalResult[$key]["scCnt"];
				}

				$scalTotalResult = parent::clientCalcTotalInfoMOL($whereBeen);
				while (list($key, $val) = each($scalTotalResult)){
					$totalPrice = $scalTotalResult[$key]["totalPrice"];
					$totalCnt = $scalTotalResult[$key]["totalCnt"];
				}

				$totalPrice = $totalPrice == "" ? "0" : $totalPrice;
				$totalCnt = $totalCnt == "" ? "0" : $totalCnt;

				$this->totalCnt = $scCnt;
				$this->totalPage = ($link / $scCnt) == 0 ? "1" : ($link / $scCnt);
				$this->shCalTotalPrice = $totalPrice;
				$this->shCalTotalCnt = $totalCnt;

				$record = $scCnt;
				$url_file = "/";
				$url_parameter = "com=shMypage&lnd=calList";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$scalResult = parent::clientCalcListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($scalResult)){
					$idx				=  $scalResult[$key]["idx"];
					$year				=  $scalResult[$key]["year"];
					$month				=  $scalResult[$key]["month"];
					$calcPrice			=  $scalResult[$key]["calcPrice"];
					$calcCnt			=  $scalResult[$key]["calcCnt"];
					$calcState			=  $scalResult[$key]["calcState"];
					$regDate			=  $scalResult[$key]["regDate"];
					
					$fristDay = "1";
					$lastDay = date("t", mktime("00","00","00",$month,$fristDay,$year));
					if($calcState == "Y"){
						$viewState = "지급";
						$stateClass = "class=\"txt_3\"";
					}else{
						$viewState = "미지급";
						$stateClass = "class=\"txt_2\"";
					}

					$returnVal .= "

						<dt style=\"padding:10px;\">
							<span class=\"t_cell_l lst_txt_1\">
								".$year."년 ".$month."월
							</span>
							<span class=\"t_cell_r\">
								<input type=\"button\" value=\"상세보기\" onclick=\"location.href = '?com=shMypage&lnd=calView&year=".$year."&month=".$month."&SHIdx=".$SHIdx."'\" class=\"btn_2 btn_s\" style=\"font-size:13px; color:#555; padding:5px 10px;\" />
							</span>
						</dt>
						<dd>
							<ul class=\"bc_lst l_style_none\">
								<li><span style=\"color:#666;\">정산기간</span> : <span class=\"txt_3\">".$year.".".$month.".01~".$year.".".$month.".".$lastDay."</span></li>
								<li><span style=\"color:#666;\">금액</span> : <span class=\"txt_2\">￦".number_format($calcPrice)."원</span></li>
								<li><span style=\"color:#666;\">정산건수</span> : <span class=\"txt_3\">".number_format($calcCnt)."건</span></li>
								<li><span style=\"color:#666;\">지급현황</span> : <span ".$stateClass.">".$viewState."</span></li>
							</ul>
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

		/**무속인 정산 리스트**/
		public function clientCalcView($page="", $setOrder="", $year="", $month="", $SHIdx){
			$returnVal = "";
			$lastDay = date("t", mktime("00","00","00",$month,"01",$year));

			$limitQuery = " AND payDate between '".$year."-".$month."-01' AND '".$year."-".$month."-".$lastDay."' order by ".$setOrder;
			$whereBeen = array(":SHIdx" => $SHIdx);

			//$limitQuery = "order by ".$setOrder;
			$scalResult = parent::clientCalcResTotalInfoMOL($whereBeen,$limitQuery);
			while (list($key, $val) = each($scalResult)){
				$totalPrice = $scalResult[$key]["totalPrice"];
				$totalCnt = $scalResult[$key]["totalCnt"];
			}

			$totalPrice = $totalPrice == "" ? "0" : $totalPrice;
			$totalCnt = $totalCnt == "" ? "0" : $totalCnt;
			$this->shCalTotalPrice = $totalPrice;
			$this->shCalTotalCnt = $totalCnt;


			try{

				$scalResult = parent::clientCalcResInfoMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($scalResult)){
					$payType				=  $scalResult[$key]["payType"];
					$proType				=  $scalResult[$key]["proType"];
					$userId				=  $scalResult[$key]["userId"];
					$payPrice			=  $scalResult[$key]["payPrice"];
					$payState			=  $scalResult[$key]["payState"];
					$payDate			=  $scalResult[$key]["payDate"];
					$payInfo			=  $scalResult[$key]["payInfo"];
					$price			=  $scalResult[$key]["price"];
					$resState			=  $scalResult[$key]["resState"];
					
					switch($payType){
						case "M" : $viewPayType = "무통장"; break;
						case "C" : $viewPayType = "카드"; break;
						case "O" : $viewPayType = "실시간계좌이체"; break;
						case "P" : $viewPayType = "휴대폰"; break;
					}

					$returnVal .= "
                            <tr>
                                <td>".$payDate."</td>
                                <td style=\"color:#333;\">예약</td>
                                <td>".$userId."</td>
                                <td class=\"btskin_txt2\">￦".number_format($payPrice)."</td>
                                <td>".$viewPayType."</td>
                                <td class=\"btskin_txt2\">결제완료</td>
                            </tr>
					";
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**무속인 정산 리스트**/
		public function clientCalcViewM($page="", $setOrder="", $year="", $month="", $SHIdx){
			$returnVal = "";
			$lastDay = date("t", mktime("00","00","00",$month,"01",$year));

			$limitQuery = " AND payDate between '".$year."-".$month."-01' AND '".$year."-".$month."-".$lastDay."' order by ".$setOrder;
			$whereBeen = array(":SHIdx" => $SHIdx);

			//$limitQuery = "order by ".$setOrder;
			$scalResult = parent::clientCalcResTotalInfoMOL($whereBeen,$limitQuery);
			while (list($key, $val) = each($scalResult)){
				$totalPrice = $scalResult[$key]["totalPrice"];
				$totalCnt = $scalResult[$key]["totalCnt"];
			}

			$totalPrice = $totalPrice == "" ? "0" : $totalPrice;
			$totalCnt = $totalCnt == "" ? "0" : $totalCnt;
			$this->shCalTotalPrice = $totalPrice;
			$this->shCalTotalCnt = $totalCnt;


			try{

				$scalResult = parent::clientCalcResInfoMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($scalResult)){
					$payType				=  $scalResult[$key]["payType"];
					$proType				=  $scalResult[$key]["proType"];
					$userId				=  $scalResult[$key]["userId"];
					$payPrice			=  $scalResult[$key]["payPrice"];
					$payState			=  $scalResult[$key]["payState"];
					$payDate			=  $scalResult[$key]["payDate"];
					$payInfo			=  $scalResult[$key]["payInfo"];
					$price			=  $scalResult[$key]["price"];
					$resState			=  $scalResult[$key]["resState"];
					
					switch($payType){
						case "M" : $viewPayType = "무통장"; break;
						case "C" : $viewPayType = "카드"; break;
						case "O" : $viewPayType = "실시간계좌이체"; break;
						case "P" : $viewPayType = "휴대폰"; break;
					}

					$returnVal .= "
							<dt style=\"padding:10px;\">
								<span class=\"t_cell_l lst_txt_1\">
									".$payDate."
								</span>
							</dt>
							<dd>
								<ul class=\"bc_lst l_style_none\">
									<li><span style=\"color:#666;\">상품분류</span> : <span class=\"txt_3\">예약</span></li>
									<li><span style=\"color:#666;\">결제유저</span> : <span class=\"txt_3\">".$userId."</span></li>
									<li><span style=\"color:#666;\">금액</span> : <span class=\"txt_2\">".number_format($payPrice)."원</span></li>
									<li><span style=\"color:#666;\">결제분류</span> : <span class=\"txt_3\">".$viewPayType."</span></li>
									<li><span style=\"color:#666;\">결제상태</span> : <span class=\"txt_2\">결제완료</span></li>
								</ul>
							</dd>
					";
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}
	}
?>