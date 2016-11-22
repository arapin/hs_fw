<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/mainMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class Main extends MainMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("sample");
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

					$returnVal .= "
					<tr>
						<td>".$record."</td>
						<td>".$seq."</td>
						<td style=\"text-transform:none;\">".$locationName."</td>
						<td><span class=\"date\">".$regDate."</span></td>
						<td>
							<a href=\"#none\" class=\"edit\" onclick=\"modifyLocation('".$idx."');\"><i class=\"fa fa-pencil\"></i></a>
							<!--<a href=\"#none\" class=\"delete\" onclick=\"deleteMng('".$idx."');\"><i class=\"fa fa-times\"></i></a>-->
						</td>
					</tr>
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
		public function mainBigList($page="", $setOrder=""){
			$returnVal = "";
			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{
				$mbTotalCntResult = parent::mainBigTotalCnt();
				while (list($key, $val) = each($mbTotalCntResult)){
					$mbCnt = $mbTotalCntResult[$key]["mbCnt"];
				}
				$record = $mbCnt;
				/*$url_file = "/";
				$url_parameter = "com=mng&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$mbResult = parent::mainBigTotalList("",$limitQuery);
				while (list($key, $val) = each($mbResult)){
					$idx	=  $mbResult[$key]["idx"];
					$imgName =  $mbResult[$key]["locationName"];
					$regDate	=  $mbResult[$key]["regDate"];
					$seq	=  $mbResult[$key]["seq"];

					$returnVal .= "
					<tr>
						<td>".$record."</td>
						<td>".$seq."</td>
						<td style=\"text-transform:none;\">".$regDate."</td>
						<td><span class=\"date\">".$regDate."</span></td>
						<td>
							<a href=\"#none\" class=\"edit\" onclick=\"modifyBig('".$idx."');\"><i class=\"fa fa-pencil\"></i></a>
							<!--<a href=\"#none\" class=\"delete\" onclick=\"deleteMng('".$idx."');\"><i class=\"fa fa-times\"></i></a>-->
						</td>
					</tr>
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
		public function mainMiddleList($page="", $setOrder=""){
			$returnVal = "";
			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{
				$mbTotalCntResult = parent::mainMiddleTotalCnt();
				while (list($key, $val) = each($mbTotalCntResult)){
					$mbCnt = $mbTotalCntResult[$key]["mbCnt"];
				}
				$record = $mbCnt;
				/*$url_file = "/";
				$url_parameter = "com=mng&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$mbResult = parent::mainMiddleTotalList("",$limitQuery);
				while (list($key, $val) = each($mbResult)){
					$idx	=  $mbResult[$key]["idx"];
					$imgName =  $mbResult[$key]["locationName"];
					$regDate	=  $mbResult[$key]["regDate"];
					$seq	=  $mbResult[$key]["seq"];

					$returnVal .= "
					<tr>
						<td>".$record."</td>
						<td>".$seq."</td>
						<td style=\"text-transform:none;\">".$regDate."</td>
						<td><span class=\"date\">".$regDate."</span></td>
						<td>
							<a href=\"#none\" class=\"edit\" onclick=\"modifyMiddle('".$idx."');\"><i class=\"fa fa-pencil\"></i></a>
							<!--<a href=\"#none\" class=\"delete\" onclick=\"deleteMng('".$idx."');\"><i class=\"fa fa-times\"></i></a>-->
						</td>
					</tr>
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

		/*회원수정 정보 추출*/
		public function mainLogcationInfo($getBeen){
			try{
				$mlResult = parent::mainLocationSelectMOL($getBeen);
				$returnData = array();
				while (list($key, $val) = each($mlResult)){
					$returnData["idx"] = $mlResult[$key]["idx"];
					$returnData["seq"] = $mlResult[$key]["seq"];
					$returnData["locationName"] = $mlResult[$key]["locationName"];
				}
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
			}

			return $returnData;
		}

		/*회원수정 정보 추출*/
		public function mainBigInfo($getBeen){
			try{
				$mlResult = parent::mainBigSelectMOL($getBeen);
				$returnData = array();
				while (list($key, $val) = each($mlResult)){
					$returnData["idx"] = $mlResult[$key]["idx"];
					$returnData["seq"] = $mlResult[$key]["seq"];
					$returnData["imgName"] = $mlResult[$key]["imgName"];
				}
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
			}

			return $returnData;
		}

		/*회원수정 정보 추출*/
		public function mainMiddleInfo($getBeen){
			try{
				$mlResult = parent::mainMiddleSelectMOL($getBeen);
				$returnData = array();
				while (list($key, $val) = each($mlResult)){
					$returnData["idx"] = $mlResult[$key]["idx"];
					$returnData["seq"] = $mlResult[$key]["seq"];
					$returnData["imgName"] = $mlResult[$key]["imgName"];
				}
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
			}

			return $returnData;
		}

		/*등록된 파일 목록 출력*/
		public function getFileInfoListView($getBeen){
			//print_r($getBeen);
			$fileResult = parent::searchFile($getBeen);
			$returnData = "";
			while (list($key, $val) = each($fileResult)){
				$returnData .= "<div class=\"fileItem\"><img src=\"/upload/main/".$fileResult[$key]["saveName"]."\" style=\"width:100px;height:100px;\" />".$fileResult[$key]["orgName"]."</div>";
				//$returnData .= "<div class=\"fileItem\">".$fileResult[$key]["orgName"]."</div>";
			}

			return $returnData;
		}

		/*등록된 프로파일 이미지 출력*/
		public function getImgInfoListView($getBeen){
			$fileResult = parent::searchFile($getBeen);
			$returnData = "";
			while (list($key, $val) = each($fileResult)){
				$returnData["saveName"] = $fileResult[$key]["saveName"];
				$returnData["orgName"] = $fileResult[$key]["orgName"];
			}

			return $returnData;
		}
		
		/**메인 이미지 수정**/
		public function mainLocationImg($idx,$locationImg){

			if($locationImg["tmp_name"] != ""){
				$rtnVal = $this->common->imageUploader($locationImg["tmp_name"], $locationImg["name"], $locationImg["size"], uploadPath."/main", "320", "240", "10485760");

				switch ($rtnVal){
					case "01" : 
						$this->common->finalMove("lnd","등록할수 없는 확장자 입니다.","main","locationView","&idx=".$idx);
						break;
					case "02" : 
						$this->common->finalMove("lnd","등록할수 없는 크기의 파일 입니다.","main","locationView","&idx=".$idx);
						break;
					case "03" : 
						$this->common->finalMove("lnd","등록할수 있는 용량을 초과 했습니다.","main","locationView","&idx=".$idx);
						break;
					case "04" : 
						$this->common->finalMove("lnd","파일 등록 오류 입니다.","main","locationView","&idx=".$idx);
						break;
					case "05" : 
						$this->common->finalMove("lnd","이미지 파일이 아닙니다.","main","locationView","&idx=".$idx);
						break;
				}

				$fileData2 = array(":parentId" => $idx, ":type" => "mainLocation");
				$profileData = $this->getImgInfoListView($fileData2);

				$deleteFilePath =  uploadPath."/main/".$profileData["saveName"];
				@unlink($deleteFilePath);

				$whereBeen = array(":idx" => $idx, ":type" => "mainLocation");
				parent::imgDeleteMOL($whereBeen);

				$fileInsertData = array($idx, "mainLocation", $locationImg["type"], $locationImg["size"], $locationImg["name"], $rtnVal, "", date("Y-m-d H:i:s"));
				parent::fileInsert($fileInsertData);

			}
			$this->common->finalMoveMng("lnd","메인 지역 이미지가 수정 되셨습니다.","main","locationView", "&idx=".$idx);
		}

		/**메인 이미지 수정**/
		public function mainBigImg($idx,$locationImg){

			if($locationImg["tmp_name"] != ""){
				$rtnVal = $this->common->imageUploader($locationImg["tmp_name"], $locationImg["name"], $locationImg["size"], uploadPath."/main", "1280", "600", "10485760");

				switch ($rtnVal){
					case "01" : 
						$this->common->finalMove("lnd","등록할수 없는 확장자 입니다.","main","bigView","&idx=".$idx);
						break;
					case "02" : 
						$this->common->finalMove("lnd","등록할수 없는 크기의 파일 입니다.","main","bigView","&idx=".$idx);
						break;
					case "03" : 
						$this->common->finalMove("lnd","등록할수 있는 용량을 초과 했습니다.","main","bigView","&idx=".$idx);
						break;
					case "04" : 
						$this->common->finalMove("lnd","파일 등록 오류 입니다.","main","bigView","&idx=".$idx);
						break;
					case "05" : 
						$this->common->finalMove("lnd","이미지 파일이 아닙니다.","main","bigView","&idx=".$idx);
						break;
				}

				$fileData2 = array(":parentId" => $idx, ":type" => "mainBig");
				$profileData = $this->getImgInfoListView($fileData2);

				$deleteFilePath =  uploadPath."/main/".$profileData["saveName"];
				@unlink($deleteFilePath);

				$whereBeen = array(":idx" => $idx, ":type" => "mainBig");
				parent::imgDeleteMOL($whereBeen);


				$fileInsertData = array($idx, "mainBig", $locationImg["type"], $locationImg["size"], $locationImg["name"], $rtnVal, "", date("Y-m-d H:i:s"));
				parent::fileInsert($fileInsertData);

			}
			$this->common->finalMoveMng("lnd","메인 대표 이미지가 수정 되셨습니다.","main","bigView", "&idx=".$idx);
		}

		/**메인 이미지 수정**/
		public function mainMiddleImg($idx,$locationImg){

			if($locationImg["tmp_name"] != ""){
				$rtnVal = $this->common->imageUploader($locationImg["tmp_name"], $locationImg["name"], $locationImg["size"], uploadPath."/main", "1280", "600", "10485760");

				switch ($rtnVal){
					case "01" : 
						$this->common->finalMove("lnd","등록할수 없는 확장자 입니다.","main","bigView","&idx=".$idx);
						break;
					case "02" : 
						$this->common->finalMove("lnd","등록할수 없는 크기의 파일 입니다.","main","bigView","&idx=".$idx);
						break;
					case "03" : 
						$this->common->finalMove("lnd","등록할수 있는 용량을 초과 했습니다.","main","bigView","&idx=".$idx);
						break;
					case "04" : 
						$this->common->finalMove("lnd","파일 등록 오류 입니다.","main","bigView","&idx=".$idx);
						break;
					case "05" : 
						$this->common->finalMove("lnd","이미지 파일이 아닙니다.","main","bigView","&idx=".$idx);
						break;
				}

				$fileData2 = array(":parentId" => $idx, ":type" => "mainMiddle");
				$profileData = $this->getImgInfoListView($fileData2);

				$deleteFilePath =  uploadPath."/main/".$profileData["saveName"];
				@unlink($deleteFilePath);

				$whereBeen = array(":idx" => $idx, ":type" => "mainMiddle");
				parent::imgDeleteMOL($whereBeen);


				$fileInsertData = array($idx, "mainMiddle", $locationImg["type"], $locationImg["size"], $locationImg["name"], $rtnVal, "", date("Y-m-d H:i:s"));
				parent::fileInsert($fileInsertData);

			}
			$this->common->finalMoveMng("lnd","메인 서브 이미지가 수정 되셨습니다.","main","middleView", "&idx=".$idx);
		}

		public function getMainBigImg($getBeen){
			$mbResult = parent::getMainBigImgMOL($getBeen);
			while (list($key, $val) = each($mbResult)){
				$idx = $mbResult[$key]["idx"];
			}

			$fileData2 = array(":parentId" => $idx, ":type" => "mainBig");
			$profileData = $this->getImgInfoListView($fileData2);
			$rtnData =  "/upload/main/".$profileData["saveName"];
			return $rtnData;
		}

		public function getMainMiddleImg($getBeen){
			$mbResult = parent::getMainMiddleImgMOL($getBeen);
			while (list($key, $val) = each($mbResult)){
				$idx = $mbResult[$key]["idx"];
			}

			$fileData2 = array(":parentId" => $idx, ":type" => "mainMiddle");
			$profileData = $this->getImgInfoListView($fileData2);
			$rtnData =  "/upload/main/".$profileData["saveName"];
			return $rtnData;
		}


		/*관리자 리스트*/
		public function mainMovieList($page="", $setOrder=""){
			$returnVal = "";
			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{
				$mmTotalCntResult = parent::mainMovieTotalCnt();
				while (list($key, $val) = each($mmTotalCntResult)){
					$mmCnt = $mmTotalCntResult[$key]["mmCnt"];
				}
				$record = $mmCnt;
				/*$url_file = "/";
				$url_parameter = "com=mng&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$mmResult = parent::mainMovieTotalList("",$limitQuery);
				while (list($key, $val) = each($mmResult)){
					$idx	=  $mmResult[$key]["idx"];
					$seq =  $mmResult[$key]["seq"];
					$url	=  $mmResult[$key]["url"];
					$writeDate	=  $mmResult[$key]["writeDate"];

					$returnVal .= "
					<tr>
						<td>".$record."</td>
						<td>".$seq."</td>
						<td style=\"text-transform:none;\">".$url."</td>
						<td><span class=\"date\">".$writeDate."</span></td>
						<td>
							<a href=\"#none\" class=\"edit\" onclick=\"modifyMovie('".$idx."');\"><i class=\"fa fa-pencil\"></i></a>
							<!--<a href=\"#none\" class=\"delete\" onclick=\"deleteMng('".$idx."');\"><i class=\"fa fa-times\"></i></a>-->
						</td>
					</tr>
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

		/*회원수정 정보 추출*/
		public function mainMovieInfo($getBeen){
			try{
				$mmResult = parent::mainMovieSelectMOL($getBeen);
				$returnData = array();
				while (list($key, $val) = each($mmResult)){
					$returnData["idx"] = $mmResult[$key]["idx"];
					$returnData["seq"] = $mmResult[$key]["seq"];
					$returnData["url"] = $mmResult[$key]["url"];
				}
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
			}

			return $returnData;
		}

		/**메인 이미지 수정**/
		public function mainMovieUpdate($bind, $whereBeen){
			parent::updatemainMovieMOL($bind, $whereBeen);
			$this->common->finalMoveMng("lnd","메인 동영상 경로가 수정 되셨습니다.","main","movieView", "&idx=".$whereBeen[":idx"]);
		}
	}
?>