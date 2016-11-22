<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/indexMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class Index extends MainMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("clientinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}

		/*관리자 리스트*/
		public function mainLogcationList($page="", $setOrder=""){
			$returnVal = "";
			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{
				$mlTotalCntResult = parent::mainLocationTotalCnt();
				while (list($key, $val) = each($mlTotalCntResult)){
					$mlCnt = $mlTotalCntResult[$key]["mlCnt"];
				}
				$record = $mlCnt;
				/*$url_file = "/";
				$url_parameter = "com=mng&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$mlResult = parent::mainLocationTotalList("",$limitQuery);
				while (list($key, $val) = each($mlResult)){
					$idx	=  $mlResult[$key]["idx"];
					$locationName =  $mlResult[$key]["locationName"];
					$regDate	=  $mlResult[$key]["regDate"];
					$seq	=  $mlResult[$key]["seq"];

					$getBeen = array(":parentId" => $idx, ":type" => "mainLocation");
					$fileData = $this->getProfileInfoListView($getBeen);

					switch($locationName){
						case "서울특별시" : 
							$getSido = "서울";
							break;
						case "경기도" : 
							$getSido = "경기";
							break;
						case "강원도" : 
							$getSido = "강원";
							break;
						case "충청북도" : 
							$getSido = "충북";
							break;
						case "충청남도" : 
							$getSido = "충남";
							break;
						case "경상북도" : 
							$getSido = "경북";
							break;
						case "경상남도" : 
							$getSido = "경남";
							break;
						case "전라북도" : 
							$getSido = "전북";
							break;
						case "전라남도" : 
							$getSido = "전남";
							break;
						default : 
							$getSido = $locationName;
							break;
					}

					$returnVal .= "
                    <li>
                        <div class=\"shop_photo_overlay\" style=\"background:url(/upload/main/".$fileData["saveName"].") no-repeat\"><a href=\"#none\" onclick=\"goLocation('".$getSido."')\">".$locationName."<br /></a></div>
                    </li>
					";
					$record--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/*관리자 리스트*/
		public function mainLogcationListM($page="", $setOrder=""){
			$returnVal = "";
			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{
				$mlTotalCntResult = parent::mainLocationTotalCnt();
				while (list($key, $val) = each($mlTotalCntResult)){
					$mlCnt = $mlTotalCntResult[$key]["mlCnt"];
				}
				$record = $mlCnt;
				/*$url_file = "/";
				$url_parameter = "com=mng&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$mlResult = parent::mainLocationTotalList("",$limitQuery);
				while (list($key, $val) = each($mlResult)){
					$idx	=  $mlResult[$key]["idx"];
					$locationName =  $mlResult[$key]["locationName"];
					$regDate	=  $mlResult[$key]["regDate"];
					$seq	=  $mlResult[$key]["seq"];

					$getBeen = array(":parentId" => $idx, ":type" => "mainLocation");
					$fileData = $this->getProfileInfoListView($getBeen);

					switch($locationName){
						case "서울특별시" : 
							$getSido = "서울";
							break;
						case "경기도" : 
							$getSido = "경기";
							break;
						case "강원도" : 
							$getSido = "강원";
							break;
						case "충청북도" : 
							$getSido = "충북";
							break;
						case "충청남도" : 
							$getSido = "충남";
							break;
						case "경상북도" : 
							$getSido = "경북";
							break;
						case "경상남도" : 
							$getSido = "경남";
							break;
						case "전라북도" : 
							$getSido = "전북";
							break;
						case "전라남도" : 
							$getSido = "전남";
							break;
						default : 
							$getSido = $locationName;
							break;
					}

					$returnVal .= "
            <dt style=\"background:url(/upload/main/".$fileData["saveName"].") no-repeat; background-size:cover;\">
                <a href=\"#none\" onclick=\"goLocation('".$getSido."')\">".$locationName."</a>
            </dt>
					";
					$record--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
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

		/*관리자 리스트*/
		public function mainMovieListSeq($page="", $setOrder=""){

			$returnVal = "";
			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{
				$mmTotalCntResult = parent::mainMovieTotalCnt();
				while (list($key, $val) = each($mlTotalCntResult)){
					$mmCnt = $mmTotalCntResult[$key]["mmCnt"];
				}
				$record = $mmCnt;
				/*$url_file = "/";
				$url_parameter = "com=mng&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$mmResult = parent::mainMovieTotalList("",$limitQuery);
				$loopCnt = 1;
				while (list($key, $val) = each($mmResult)){
					$url	=  $mmResult[$key]["url"];
					if($loopCnt < 3){
						$leftStyle = "margin-right:20px;";
					}else{
						$leftStyle = "";
					}
					$returnVal .= "
						<iframe width=\"320\" height=\"210\" src=\"".$url."\" frameborder=\"0\" style=\"margin-top:20px;".$leftStyle." float:left;\" allowfullscreen></iframe>
					";
					$loopCnt++;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}
		/*관리자 리스트*/
		public function mainMovieListSeqM($page="", $setOrder=""){

			$returnVal = "";
			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{
				$mmTotalCntResult = parent::mainMovieTotalCnt();
				while (list($key, $val) = each($mlTotalCntResult)){
					$mmCnt = $mmTotalCntResult[$key]["mmCnt"];
				}
				$record = $mmCnt;
				/*$url_file = "/";
				$url_parameter = "com=mng&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$mmResult = parent::mainMovieTotalList("",$limitQuery);
				$loopCnt = 1;
				while (list($key, $val) = each($mmResult)){
					$url	=  $mmResult[$key]["url"];
					if($loopCnt < 3){
						$leftStyle = "margin-right:20px;";
					}else{
						$leftStyle = "";
					}
					$returnVal .= "
						<iframe width=\"100%\" height=\"320\" src=\"".$url."\" frameborder=\"0\"></iframe>
					";
					$loopCnt++;
					break;
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