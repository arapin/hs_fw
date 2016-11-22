<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/boardMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class Board extends BoardMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $memoTotalCnt;
		public $morBtn="";
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("boardinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}

		/*관리자 게시판 관리 리스트 출력*/
		public function boardList($page="", $setOrder="", $code="", $search=""){
			$returnVal = "";

			if($search["searchHead"] != ""){
				$searchQuery .= " AND headWord = '".$search["searchHead"]."' ";
			}

			if($search["searchValue"] != ""){
				$searchQuery .= " AND (title LIKE '%".$search["searchValue"]."%' OR content LIKE '%".$search["searchValue"]."%' OR userId LIKE '%".$search["searchValue"]."%')";
			}

			if($code == "notice"){
				$lnd = "noticeList";
				$this->link = 7;
			}else if($code == "search" || $code == "con" || $code == "booking"){
				$lnd = "noticeList2";
				$this->link = 7;
			}else{
				$lnd = "list";
				$this->link = 20;
			}
			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery."order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = "order by ".$setOrder;

			try{
				$whereBeen = array(":code" => $code);
				$boardTotalCntResult = parent::getBoardCntMOL($whereBeen, $limitQuery);
				while (list($key, $val) = each($boardTotalCntResult)){
					$boardCnt = $boardTotalCntResult[$key]["boardCnt"];
				}

				//$this->morBtn = $boardCnt > $this->link ? "<a href=\"#none\" onclick=\"getMoreList();\" id=\"morBtn\">더 보기</a>" : "&nbsp;";
				$this->totalCnt = $boardCnt;
				$this->totalPage = ($link / $boardCnt) == 0 ? "1" : ($link / $boardCnt);

				$record = $boardCnt;
				$url_file = "/";
				$url_parameter = "com=board&lnd=".$lnd."&code=".$code;
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;

				$boardResult = parent::getBoardListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($boardResult)){
					$headTd = "";
					$idx				=  $boardResult[$key]["idx"];
					$title				=  $boardResult[$key]["title"];
					$userId				=  $boardResult[$key]["userId"];
					$content			=  nl2br($boardResult[$key]["content"]);
					$headWord			=  $boardResult[$key]["headWord"];
					$mCnt			=  $boardResult[$key]["mCnt"];

					if($code == "notice" || $code == "search" || $code == "con" || $code == "booking"){
						$regDateArray	=  explode("-",substr($boardResult[$key]["regDate"],0,10));
						$regDate = $regDateArray[1]."/".$regDateArray[2];
						$returnVal .= "				
							<dt><input type=\"image\" src=\"/images/btn_expand.gif\" onclick=\"toggleView(this)\" alt=\"확대\" />".$title."<span class=\"board_date_txt\">".$regDate."</span></dt>
							<dd>
								".$content."
							</dd>
						";
					}else{
						if($code == "community" || $code == "travel" || $code == "area" ) $headTd = "<td>".$headWord."</td>";
						$returnVal .= "
                            <tr>
                                <td>".$loop_number."</td>
                                ".$headTd."
                                <td class=\"btskin_txt1\" style=\"text-align:left;\"><a href=\"?com=board&lnd=view&idx=".$idx."&code=".$code."\">".$title."<span class=\"board_view_txt5\">(".$mCnt.")</span></a></td>
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
				$searchQuery .= " AND headWord = '".$search["searchHead"]."' ";
			}

			if($search["searchValue"] != ""){
				$searchQuery .= " AND (title LIKE '%".$search["searchValue"]."%' OR content LIKE '%".$search["searchValue"]."%' OR userId LIKE '%".$search["searchValue"]."%')";
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
				$whereBeen = array(":code" => $code);
				$boardTotalCntResult = parent::getBoardCntMOL($whereBeen, $limitQuery);
				while (list($key, $val) = each($boardTotalCntResult)){
					$boardCnt = $boardTotalCntResult[$key]["boardCnt"];
				}

				//$this->morBtn = $boardCnt > $this->link ? "<a href=\"#none\" onclick=\"getMoreList();\" id=\"morBtn\">더 보기</a>" : "&nbsp;";
				$this->totalCnt = $boardCnt;
				$this->totalPage = ($link / $boardCnt) == 0 ? "1" : ($link / $boardCnt);

				$record = $boardCnt;
				$url_file = "/";
				$url_parameter = "com=board&lnd=".$lnd."&code=".$code;
				$this->pageView = $this->paging->Link_Mobile($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
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

					if($code == "notice" || $code == "search" || $code == "booking" || $code == "con"){
						$regDateArray	=  explode("-",substr($boardResult[$key]["regDate"],0,10));
						$regDate = $regDateArray[1]."/".$regDateArray[2];
						$returnVal .= "
						
							<dt><input type=\"image\" src=\"/images/mobile/collapse.gif\" onclick=\"toggleView(this)\" alt=\"축소\" />".$title."<span class=\"board_date_txt\">".$regDate."</span></dt>
							<dd style=\"display:block;\">
								".$content."
							</dd>
						";
					}else{
						if($code == "community" || $code == "travel" || $code == "area" ) {
							$headWord = $headWord;
						}else{
							$headWord = "";
						}

						$returnVal .= "

							<dt>
								<span class=\"float_left\">
									<span style=\"color:#888;\">[".$loop_number."]</span> ".$headWord."
								</span>
								<span class=\"float_right\">
									".str_replace("-",".",substr($boardResult[$key]["regDate"],2,8))."
								</span>
								<span style=\"color:#333;display:block;padding:10px 0px 15px 0px;clear:both;\">".$title."<span class=\"txt_2\">(".$mCnt.")</span></span>
								작성자 : ".$userId."
							</dt>
							<dd>
								".$viewContent."

								<div style=\"text-align:right;margin-top:15px;\">
									<input type=\"button\" value=\"상세보기\" class=\"btn_2 btn_s\" onclick=\"location.href = '?com=board&lnd=view&idx=".$idx."&code=".$code."';\" />
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

		/*관리자 게시판 관리 리스트 출력*/
		public function boardMngList($page="", $setOrder="", $code="", $search=""){
			$returnVal = "";

			if($search["searchHead"] != ""){
				$searchQuery .= " AND headWord = '".$search["searchHead"]."' ";
			}

			if($search["searchValue"] != ""){
				$searchQuery .= " AND (title LIKE '%".$search["searchValue"]."%' OR content LIKE '%".$search["searchValue"]."%' OR userId LIKE '%".$search["searchValue"]."%')";
			}

			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = $searchQuery."order by ".$setOrder;

			try{
				$whereBeen = array(":code" => $code);
				$boardTotalCntResult = parent::getBoardCntMOL($whereBeen, $limitQuery);
				while (list($key, $val) = each($boardTotalCntResult)){
					$boardCnt = $boardTotalCntResult[$key]["boardCnt"];
				}

				$record = $boardCnt;
				/*$url_file = "/";
				$url_parameter = "com=board&lnd=".$lnd."&code=".$code;
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$boardResult = parent::getBoardListMOL($whereBeen,$limitQuery);
				while (list($key, $val) = each($boardResult)){
					$idx				=  $boardResult[$key]["idx"];
					$title				=  $boardResult[$key]["title"];
					$userId				=  $boardResult[$key]["userId"];
					$hit				=  $boardResult[$key]["hit"];
					$regDate			=  $boardResult[$key]["regDate"];
					$headWord			=  $boardResult[$key]["headWord"];
					
					if($code == "community" || $code == "travel" || $code == "area" ) {
						//$headWord = "<td>".$headWord."</td>";
					}else{
						//$headWord = "";
					}

					$returnVal .= "<tr>
						<td>".$record."</td>
						<td>".$title."</td>
						<td style=\"text-transform:none;\">".$userId."</td>
						<td>".$hit."</td>
						<td><span class=\"date\">".$regDate."</span></td>
						<td>
							<a class=\"btn btn-success\" href=\"#\" onclick=\"viewMng('".$idx."','".$code."');\"><i class=\"halflings-icon white zoom-in\"></i></a>
							<a class=\"btn btn-info\" href=\"#\" onclick=\"modifyMng('".$idx."','".$code."');\"><i class=\"halflings-icon white edit\"></i></a>
							<a class=\"btn btn-danger\" href=\"#\" onclick=\"deleteMng('".$idx."','".$code."');\"><i class=\"halflings-icon white trash\"></i></a>
						</td>
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
					if($memoResult[$key_m]["userId"] == $_SESSION["USER_ID"] || $memoResult[$key_m]["userId"] == $_SESSION["SH_ID"]){
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
					if($memoResult[$key_m]["userId"] == $_SESSION["USER_ID"] || $memoResult[$key_m]["userId"] == $_SESSION["SH_ID"]){
						$actionBtn = "
							<input type=\"button\" value=\"수정\" class=\"btn_9 btn_s\" style=\"margin-right:7px;\" onclick=\"memoModify('".$memoResult[$key_m]["idx"]."');\" /><input type=\"button\" value=\"삭제\" class=\"btn_2 btn_s\" onclick=\"memoDelete('".$memoResult[$key_m]["idx"]."');\" />
						";
					}else{
						$actionBtn = "";
					}

					$rtnList .= "

						<div style=\"border:1px solid #ccc; padding:15px 10px 10px 10px; font-size:14px; line-height:150%;\">
							<div style=\"color:#888;\">
								<span class=\"float_left\">[댓글".$loopCnt."]&nbsp;&nbsp;<span class=\"txt_1\">".$memoResult[$key_m]["userId"]."</span></span>
								<span class=\"float_right\">".str_replace("-",".",$memoResult[$key_m]["writeDate"])."</span>
							</div>

							<p style=\"clear:both;margin:0px;padding-top:10px;\">
								".nl2br($memoResult[$key_m]["content"])." <textarea id=\"content".$memoResult[$key_m]["idx"]."\" style=\"display:none;\">".$memoResult[$key_m]["content"]."</textarea>
							</p>

							<div style=\"text-align:right;\">
								".$actionBtn."
							</div>
						</div>
					";
					$loopCnt--;
				}
			}
			return $rtnList;
		}

		/**게시판 관리 등록**/
		public function boardInsert($setBeen){
			/*thread 가져오기*/
			$whereBeen = array(":code" => $setBeen[3]);
			$boardThreadResult = parent::getBoardThreadMOL($whereBeen);
			while (list($key, $val) = each($boardThreadResult)){
				$minThread = $boardThreadResult[$key]["minThread"];
			}
			$insertMaxThread = ceil($minThread / 1000) * 1000 - 1000;
			
			if($setBeen[3] == "notice"){
				$lnd = "noticeList";
			}else if($setBeen[3] == "community" || $setBeen[3] == "travel" || $setBeen[3] == "area"){
				$lnd = "list";
			}

			$boardSetBeen = array($setBeen[3], $insertMaxThread, "1", $setBeen[2], $setBeen[0], $setBeen[1], $_SERVER["REMOTE_ADDR"], "0", $setBeen[4], $setBeen[5]);
			parent::setBoardDataMOL($boardSetBeen);
			$this->common->finalMove("lnd","게시물이 등록 되었습니다.","board",$lnd,"&code=".$setBeen[3]);
		}

		/**게시판 관리 등록**/
		public function boardInsertMng($setBeen){
			/*thread 가져오기*/
			$whereBeen = array(":code" => $setBeen[3]);
			$boardThreadResult = parent::getBoardThreadMOL($whereBeen);
			while (list($key, $val) = each($boardThreadResult)){
				$minThread = $boardThreadResult[$key]["minThread"];
			}
			$insertMaxThread = ceil($minThread / 1000) * 1000 - 1000;

			$boardSetBeen = array($setBeen[3], $insertMaxThread, "1", $setBeen[2], $setBeen[0], $setBeen[1], $_SERVER["REMOTE_ADDR"], "0", $setBeen[4], $setBeen[5]);
			parent::setBoardDataMOL($boardSetBeen);
			$this->common->finalMoveMng("lnd","게시물이 등록 되었습니다.","board","list","&code=".$setBeen[3]);
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
			$this->common->finalMoveMng("lnd","게시판물이 수정 되었습니다.","board","view","&idx=".$whereBeen[":idx"]."&code=".$setData[2]);
		}

		/**게시물 수정**/
		public function boardUpadteBoardFront($setData, $whereBeen){
			$setBeen = array($setData["title"],$setData["content"], $setData["headWord"]);
			parent::updateBoardFrontMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","게시물이 수정 되었습니다.","board","view","&idx=".$whereBeen[":idx"]."&code=".$setData["code"]);
		}
		
		/**게시물 삭제**/
		public function boardDeleteMng($whereBeen, $code){
			parent::deleteBoardMOL($whereBeen);
			$this->common->finalMoveMng("lnd","게시물이 삭제 되었습니다.","board","list","&code=".$code);
		}

		/**게시물 삭제**/
		public function boardDeleteFront($whereBeen, $code){
			parent::deleteBoardMOL($whereBeen);
			parent::deleteMemoTotalMOL($whereBeen);
			$this->common->finalMove("lnd","게시물이 삭제 되었습니다.","board","list","&code=".$code);
		}

		/**댓글 등록**/
		public function setBoardMemoInfo($setBeen, $code){
			parent::setBoardMemoInfoMOL($setBeen);
			$this->common->finalMove("lnd","댓글이 등록되었습니다.","board","view","&idx=".$setBeen[0]."&code=".$code);
		}

		/**댓글 수정**/
		public function updateBoardMemoInfo($setBeen, $whereBeen, $code, $parentIdx){
			parent::updateBoardMemoInfoMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","댓글이 수정되었습니다.","board","view","&idx=".$parentIdx."&code=".$code);
		}

		/**댓글 수정**/
		public function deleteBoardMemoInfo($whereBeen, $code, $parentIdx){
			parent::deleteBoardMemoInfoMOL($whereBeen);
			$this->common->finalMove("lnd","댓글이 삭제되었습니다.","board","view","&idx=".$parentIdx."&code=".$code);
		}
		
	}
?>