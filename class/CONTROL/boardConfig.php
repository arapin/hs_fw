<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/boardConfigMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class BoardConfig extends BoardConfigMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("boardconfig");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}
		
		/*사용자 게시판 메뉴 출력*/
		public function bcUserList($getBeen){
		}

		/*관리자 게시판 관리 리스트 출력*/
		public function bcMngList($page="", $setOrder=""){
			$returnVal = "";

			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{

				$bcTotalCntResult = parent::bcTotalListMOL();
				while (list($key, $val) = each($bcTotalCntResult)){
					$bcCnt = $bcTotalCntResult[$key]["bcCnt"];
				}
				$record = $bcCnt;
				/*$url_file = "/";
				$url_parameter = "com=user&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$bcResult = parent::bcMngListMOL("",$limitQuery);
				while (list($key, $val) = each($bcResult)){
					$boardCode		=  $bcResult[$key]["boardCode"];
					$boardName		=  $bcResult[$key]["boardName"];
					$boardType		=  $bcResult[$key]["boardType"];
					$ownerId			=  $bcResult[$key]["ownerId"];
					$regDate			=  $bcResult[$key]["regDate"];
					$idx				=  $bcResult[$key]["idx"];

					switch($boardType){
						case "affter" : 
							$viewType = "후기";
							break;
						case "board" : 
							$viewType = "게시판";
							break;
						case "answer" : 
							$viewType = "문의점";
							break;
					}

					if($boardType == "answer"){
						$boardLink = "?com=aqBoard&lnd=list";
					}else{
						if($boardCode=="notice"){
							$boardLink = "?com=board&lnd=noticeList&code=".$boardCode;
						}else{
							$boardLink = "?com=board&lnd=list&code=".$boardCode;
						}
					}

					$returnVal .= "<tr>
						<td>".$record."</td>
						<td style=\"text-transform:none;\"><a href=\"".$boardLink."\" target=\"_blank\">".$boardCode."</a></td>
						<td>".$boardName	."</td>
						<td>".$viewType."</td>
						<td style=\"text-transform:none;\">".$ownerId."</td>
						<td><span class=\"date\">".$regDate."</span></td>
						<td>
							<a href=\"#none\" class=\"edit\" onclick=\"modifyMng('".$idx."');\"><i class=\"fa fa-pencil\"></i></a>
							<!--<a href=\"#none\" class=\"delete\" onclick=\"deleteMng('".$idx."');\"><i class=\"fa fa-times\"></i></a>-->
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

		/**게시판 관리 등록**/
		public function bcInsertBoard($setBeen){
			parent::bcInsertBoardMOL($setBeen);
			$this->common->finalMoveMng("lnd","게시판이 생성 되었습니다.","boardConfig","list");
		}

		/**게시판 관리 수정**/
		public function bcUpadteBoard($setBeen, $whereBeen){
			parent::bcUpadteBoardMOL($setBeen, $whereBeen);
			$this->common->finalMoveMng("lnd","게시판정보가 수정 되었습니다.","boardConfig","modify","&idx=".$whereBeen[":idx"]);
		}

		/**게시판 정보 수정 추출**/
		public function bcModifyInfo($getBeen){
			$bcResult = parent::bcModifyInfoMOL($getBeen);
			$returnData = array();

			while (list($key, $val) = each($bcResult)){
				$returnData["boardCode"] = $bcResult[$key]["boardCode"];
				$returnData["boardName"] = $bcResult[$key]["boardName"];
				$returnData["boardType"] = $bcResult[$key]["boardType"];
				$returnData["depthType"] = $bcResult[$key]["depthType"];
				$returnData["payType"] = $bcResult[$key]["payType"];
				$returnData["ownerId"] = $bcResult[$key]["ownerId"];
				$returnData["useType"] = $bcResult[$key]["useType"];
			}

			return $returnData;

		}

		/**게시판관리자 검색**/
		public function ownerIdCheck($idString){
			$rtnVal = "";
			
			if($idString != "free"){
				$clientData = array(":SHId" => $idString);
				$clientResult = parent::ownerIdCheckMOL($clientData);

				while (list($key, $val) = each($clientResult)){
					$clientCnt = $clientResult[$key]["clientCnt"];
				}

				if($clientCnt == 0) {
					return "01";
					exit;
				}

				return "00";
			}else{
				return "02";
			}

		}

		/**게시판 관리 삭제**/
		public function bcDeleteBoard(){
		}
		
	}
?>