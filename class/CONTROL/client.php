<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/clientMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class Client extends ClientMOL {
		private $cipher;
		private $common;
		private $paging;
		private $file;
		public $pageView;
		public $approachPageView;
		public $memoPageView;
		public $searchTotalCnt;
		public $amTotalCnt;
		public $resultSIdo;
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("clientinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}

		/*입주사 로그인*/
		public function clientLogin($clientData, $loginData){
			$clientResult = parent::searchclient($clientData);

			$inputId = $loginData["id"];
			$inputPwd = $loginData["pwd"];

			while (list($key, $val) = each($clientResult)){
				$clientCnt = $clientResult[$key]["clientCnt"];
			}

			if($clientCnt == 0){
				$msg = "입주사 등록이 안되어 있습니다. 입주사 등록을 하여 주십시요.";
				$com = "client";
				$lnd = "join";
			}else{
				$clientResult = parent::searchclientInfo($clientData);
				while (list($key, $val) = each($clientResult)){
					$id = $clientResult[$key]["SHId"];
					$pwd_user = trim($this->cipher->getDecrypt($clientResult[$key]["SHPwd"]));
				}

				if( $inputPwd == $pwd_user){

					if($_SESSION["USER_ID"] != ""){
						$_SESSION = array();
						session_destroy();
					}

					$_SESSION["SH_ID"] = $id;
					$msg = $_SESSION["SH_ID"]." 입주사 회원님 로그인 되었습니다.";
					$com = "index";
					$lnd = "";
				}else{
					$msg = "비밀번호가 틀립니다.";
					$com = "client";
					$lnd = "login";
				}
			}
			$this->common->finalMove("lnd",$msg,$com,$lnd);
		}

		/*입주사 등록*/
		public function clientInsert($clientData){
			$clientData[2] = $this->cipher->getEncrypt($clientData[2]);
			parent::joinclientFront($clientData);
			$this->common->finalMove("lnd","입주사가 등록 되었습니다.","user","login");
		}

		public function clientInsertMng($clientData, $profile){
			$clientData[2] = $this->cipher->getEncrypt($clientData[2]);
			parent::joinclient($clientData);
			$this->common->finalMoveMng("lnd","입주사가 등록 되었습니다.","client","list");
		}

		/*입주사 수정 정보*/
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
				$returnData["SHRestSTime"]	= $clientResult[$key]["SHRestSTime"];
				$returnData["SHRestETime"]	= $clientResult[$key]["SHRestETime"];
				$returnData["SHApply"]	= $clientResult[$key]["SHApply"];
			}

			return $returnData;
		}


		/*입주사 수정*/
		public function clientModify($clientData,$whereData){
			parent::modifyclient($clientData,$whereData);
			$this->common->finalMove("lnd","입주사정보가 수정 되셨습니다.","client","modify");
		}

		public function clientModifyMng($clientData,$whereData, $profile){
			$clientData[10] = $this->cipher->getEncrypt($clientData[10]);

			if($profile["tmp_name"] != ""){
				$fileData2 = array(":parentId" => $whereData[":SHId"], ":type" => "profile");
				$profileData = $this->getProfileInfoListView($fileData2);

				$deleteFilePath =  uploadPath."/client/".$profileData["saveName"];
				@unlink($deleteFilePath);

				$whereBeen = array(":SHId" => $whereData[":SHId"]);
				parent::profileDeleteMOL($whereBeen);

				$rtnVal = $this->common->imageUploader($profile["tmp_name"], $profile["name"], $profile["size"], uploadPath."/client", "2000", "2000", "10485760");

				switch ($rtnVal){
					case "01" :
						$this->common->finalMoveMng("lnd","등록할수 없는 확장자 입니다.","client","modify","&SHId=".$whereData[":SHId"]);
						break;
					case "02" :
						$this->common->finalMoveMng("lnd","등록할수 없는 크기의 파일 입니다.","client","modify","&SHId=".$whereData[":SHId"]);
						break;
					case "03" :
						$this->common->finalMoveMng("lnd","등록할수 있는 용량을 초과 했습니다.","client","modify","&SHId=".$whereData[":SHId"]);
						break;
					case "04" :
						$this->common->finalMoveMng("lnd","파일 등록 오류 입니다.","client","modify","&SHId=".$whereData[":SHId"]);
						break;
					case "05" :
						$this->common->finalMoveMng("lnd","이미지 파일이 아닙니다.","client","modify","&SHId=".$whereData[":SHId"]);
						break;
				}

				$fileInsertData = array($whereData[":SHId"], "profile", $profile["type"], $profile["size"], $profile["name"], $rtnVal, "", date("Y-m-d H:i:s"));
				parent::fileInsert($fileInsertData);

			}

			parent::modifyclientMng($clientData,$whereData);
			$this->common->finalMoveMng("lnd","입주사정보가 수정 되셨습니다.","client","modify", "&SHId=".$whereData[":SHId"]);
		}

		/*입주사 아이디 체크*/
		public function clientIdCheck($idString){
			$rtnVal = "";
			$idLen = strlen($idString);

			if($idLen < 4){
				return "01"; //아이디는 4글자 이상으로 입력하여 주십시요.
				exit;
			}

			if(!preg_match("/^[a-z]/i", $idString)) {
				return "02"; //아이디의 첫글자는 영문이어야 합니다.
				exit;
			}

			if(preg_match("/[^a-z0-9-_]/i", $idString)) {
				return "03"; //아이디는 영문, 숫자, -, _ 만 사용할 수 있습니다.
				exit;
			}

			$clientData = array(":SHId" => $idString);
			$clientResult = parent::searchJoinclient($clientData);

			while (list($key, $val) = each($clientResult)){
				$clientCnt = $clientResult[$key]["clientCnt"];
			}

			if($clientCnt > 0) {
				return "04"; //이미 존재하는 아이디 입니다.
				exit;
			}

			$userData = array(":id" => $idString);
			$userResult = parent::searchUser($userData);

			while (list($key, $val) = each($userResult)){
				$userCnt = $userResult[$key]["userCnt"];
			}

			if($userCnt > 0) {
				return "04"; //이미 존재하는 아이디 입니다.
				exit;
			}

			$withoutResult = parent::withoutSearchIdMOL($userData);

			while (list($key, $val) = each($withoutResult)){
				$withOutCnt = $withoutResult[$key]["withOutCnt"];
			}

			if($withOutCnt > 0) {
				return "04"; //이미 존재하는 아이디 입니다.
				exit;
			}


			return "00";
		}

		/*입주사 목록*/
		public function clientHomeList($search=""){
			$returnVal = "";

			$searchQuery = "";

			if($search["searchSido"] != ""){
				switch($search["searchSido"]){
					case "서울특별시" : 
						$search["searchSido"] = "서울";
						break;
					case "경기도" : 
						$search["searchSido"] = "경기";
						break;
					case "강원도" : 
						$search["searchSido"] = "강원";
						break;
					case "충청북도" : 
						$search["searchSido"] = "충북";
						break;
					case "충청남도" : 
						$search["searchSido"] = "충남";
						break;
					case "경상북도" : 
						$search["searchSido"] = "경북";
						break;
					case "경상남도" : 
						$search["searchSido"] = "경남";
						break;
					case "전라북도" : 
						$search["searchSido"] = "전북";
						break;
					case "전라남도" : 
						$search["searchSido"] = "전남";
						break;
					case "제주도" : 
						$search["searchSido"] = "제주특별자치도";
						break;
					default : 
						$search["searchSido"] = $search["searchSido"];
						break;
				}

				$searchQuery .= " AND SHAddress LIKE '%".$search["searchSido"]." ".$search["searchGun"]." %'";
			}

			if($search["productType"] != ""){
				$searchQuery .= " AND c.idx = '".$search["productType"]."'";
			}

			if($search["sPrice"] != ""){
				$searchQuery .= " AND b.price BETWEEN '".$search["sPrice"]."' AND '".$search["ePrice"]."'";
			}

			if($search["searchDate"] != ""){
				$searchQuery .= " AND a.idx not in (SELECT SHIdx FROM reservation WHERE resDate = '".$search["searchDate"]."' AND resStartTime <= '".$search["searchTime"]."')";
			}

			if($search["searchWord"] != ""){

				switch($search["searchWord"]){
					case "서울특별시" : 
						$search["searchWord"] = "서울";
						break;
					case "경기도" : 
						$search["searchWord"] = "경기";
						break;
					case "강원도" : 
						$search["searchWord"] = "강원";
						break;
					case "충청북도" : 
						$search["searchWord"] = "충북";
						break;
					case "충청남도" : 
						$search["searchWord"] = "충남";
						break;
					case "경상북도" : 
						$search["searchWord"] = "경북";
						break;
					case "경상남도" : 
						$search["searchWord"] = "경남";
						break;
					case "전라북도" : 
						$search["searchWord"] = "전북";
						break;
					case "전라남도" : 
						$search["searchWord"] = "전남";
						break;
					case "제주도" : 
						$search["searchWord"] = "제주특별자치도";
						break;

					default : 
						$search["searchWord"] = $search["searchWord"];
						break;
				}
				$searchQuery .= " AND (c.proName LIKE '%".$search["searchWord"]."%' OR a.SHName LIKE '%".$search["searchWord"]."%' OR a.name LIKE '%".$search["searchWord"]."%' OR a.SHAddress LIKE '".$search["searchWord"]."%')";
			}

			$limitQuery = $searchQuery." GROUP BY SHId";

			$clientResult = parent::searchclientMOL("",$limitQuery);

			$returnVal = "[";

			while (list($key, $val) = each($clientResult)){
				$idx	=  $clientResult[$key]["idx"];
				$SHName =  $clientResult[$key]["SHName"];
				$SHLng	=  $clientResult[$key]["SHLng"];
				$SHLat	=  $clientResult[$key]["SHLat"];
				$SHDesc =  $clientResult[$key]["SHDesc"];
				$SHId	=  $clientResult[$key]["SHId"];
				$returnVal .= "
					{
						\"idx\": '".$SHId."',
						\"title\": '".$SHName."',
						\"lat\": ".$SHLng.",
						\"lng\": ".$SHLat.",
						\"description\": '".nl2br(str_replace("\r\n","<br>",$SHDesc))."'
					},
				";
			}
			$returnVal .= "]";

			return $returnVal;
		}

		/*입주사 목록*/
		public function searchMarkerDaumList($search=""){
			$returnVal = "";

			$searchQuery = "";

			if($search["searchSido"] != ""){
				switch($search["searchSido"]){
					case "서울특별시" : 
						$search["searchSido"] = "서울";
						break;
					case "경기도" : 
						$search["searchSido"] = "경기";
						break;
					case "강원도" : 
						$search["searchSido"] = "강원";
						break;
					case "충청북도" : 
						$search["searchSido"] = "충북";
						break;
					case "충청남도" : 
						$search["searchSido"] = "충남";
						break;
					case "경상북도" : 
						$search["searchSido"] = "경북";
						break;
					case "경상남도" : 
						$search["searchSido"] = "경남";
						break;
					case "전라북도" : 
						$search["searchSido"] = "전북";
						break;
					case "전라남도" : 
						$search["searchSido"] = "전남";
						break;
					case "제주도" : 
						$search["searchSido"] = "제주특별자치도";
						break;
					default : 
						$search["searchSido"] = $search["searchSido"];
						break;
				}

				$searchQuery .= " AND SHAddress LIKE '%".$search["searchSido"]." ".$search["searchGun"]." %'";
			}

			if($search["productType"] != ""){
				$searchQuery .= " AND c.idx = '".$search["productType"]."'";
			}

			if($search["sPrice"] != ""){
				$searchQuery .= " AND b.price BETWEEN '".$search["sPrice"]."' AND '".$search["ePrice"]."'";
			}

			if($search["searchDate"] != ""){
				$searchQuery .= " AND a.idx not in (SELECT SHIdx FROM reservation WHERE resDate = '".$search["searchDate"]."' AND resStartTime <= '".$search["searchTime"]."')";
			}

			if($search["searchWord"] != ""){

				switch($search["searchWord"]){
					case "서울특별시" : 
						$search["searchWord"] = "서울";
						break;
					case "경기도" : 
						$search["searchWord"] = "경기";
						break;
					case "강원도" : 
						$search["searchWord"] = "강원";
						break;
					case "충청북도" : 
						$search["searchWord"] = "충북";
						break;
					case "충청남도" : 
						$search["searchWord"] = "충남";
						break;
					case "경상북도" : 
						$search["searchWord"] = "경북";
						break;
					case "경상남도" : 
						$search["searchWord"] = "경남";
						break;
					case "전라북도" : 
						$search["searchWord"] = "전북";
						break;
					case "전라남도" : 
						$search["searchWord"] = "전남";
						break;
					case "제주도" : 
						$search["searchWord"] = "제주특별자치도";
						break;

					default : 
						$search["searchWord"] = $search["searchWord"];
						break;
				}
				$searchQuery .= " AND (c.proName LIKE '%".$search["searchWord"]."%' OR a.SHName LIKE '%".$search["searchWord"]."%' OR a.name LIKE '%".$search["searchWord"]."%' OR a.SHAddress LIKE '".$search["searchWord"]."%')";
			}

			$limitQuery = $searchQuery." GROUP BY SHId";

			$clientResult = parent::searchclientMOL("",$limitQuery);

			$returnVal = "[";

			while (list($key, $val) = each($clientResult)){
				$saveName2 = "";
				$idx	=  $clientResult[$key]["idx"];
				$SHName =  $clientResult[$key]["SHName"];
				$SHLng	=  $clientResult[$key]["SHLng"];
				$SHLat	=  $clientResult[$key]["SHLat"];
				$SHDesc =  $clientResult[$key]["SHDesc"];
				$SHId	=  $clientResult[$key]["SHId"];

				$fileData2 = array(":parentId" => $SHId, ":type" => "client");
				$fileResult = parent::searchFileMain($fileData2);
				$returnData = "";
				$loopIdx = 0;
				while (list($key_f, $val_f) = each($fileResult)){
					$saveName2 = $fileResult[$key_f]["saveName"];
				}

				if($saveName2 == ""){
					$fileData2 = array(":parentId" => $SHId, ":type" => "client");
					$fileResult = parent::searchFile($fileData2);
					while (list($key_f, $val_f) = each($fileResult)){
						$saveName2 = $fileResult[$key_f]["saveName"];
						break;
					}
				}

				$returnVal .= "
					{
						\"title\": '".$SHName."',
						\"lat\": ".$SHLng.",
						\"lng\": ".$SHLat.",
						\"shId\": '".$SHId."',
						\"img\": '".$saveName2."'
					},
				";
			}
			$returnVal .= "]";

			return $returnVal;
		}

		/*입주사 리스트*/
		public function clientListMng($page="", $setOrder="", $search=""){
			$returnVal = "";
			$searchQuery = "";

			if($search["searchType"] != ""){
				if($search["searchType"] == "name"){
					$searchQuery .= " AND name LIKE '%".$search["searchWord"]."%'";
				}else if($search["searchType"] == "id"){
					$searchQuery .= " AND SHId LIKE '%".$search["searchWord"]."%'";
				}else if($search["searchType"] == "id"){
					$searchQuery .= " AND SHName LIKE '%".$search["searchWord"]."%'";
				}
			}

			$startNum = ($page - 1) * $this->link;
			//$limitQuery = " order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = $searchQuery." order by ".$setOrder;

			try{

				$clientTotalCntResult = parent::clientTotalList("", $limitQuery);
				while (list($key, $val) = each($clientTotalCntResult)){
					$clientCnt = $clientTotalCntResult[$key]["clientCnt"];
				}
				$record = $clientCnt;
				/*$url_file = "/";
				$url_parameter = "com=client&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$clientResult = parent::clientListMng("",$limitQuery);
				while (list($key, $val) = each($clientResult)){
					$SHName		=  $clientResult[$key]["SHName"];
					$SHId		=  $clientResult[$key]["SHId"];
					if($clientResult[$key]["SHPhone"] != ""){
						$SHTel	=  $clientResult[$key]["SHPhone"];
					}else{
						$SHTel	=  "-";
					}

					switch($clientResult[$key]["SHStatus"]){
						case "S" :
							$viewStatus = "<span style=\"color:#9cfaac;font-weight:bold;\">대기중</span>";
							break;
						case "U" :
							$viewStatus = "<span style=\"color:#7679f3;font-weight:bold;\">사용중</span>";
							break;
						case "E" :
							$viewStatus = "<span style=\"color:#fc2418;font-weight:bold;\">탈퇴</span>";
							break;
					}

					$writeDate	=  $clientResult[$key]["writeDate"];

					$returnVal .= "<tr>
						<td>".$record."</td>
						<td style=\"text-transform:none;\">".$SHId."</td>
						<td>".$SHName."</td>
						<td>".$SHTel."</td>
						<td><span class=\"date\">".$writeDate."</span></td>
						<td>".$viewStatus."</td>
						<td>
							<a href=\"#none\" class=\"edit\" onclick=\"modifyMng('".$SHId."');\"><i class=\"fa fa-pencil\"></i></a>
							<a href=\"#none\" class=\"delete\" onclick=\"deleteMng('".$SHId."');\"><i class=\"fa fa-times\"></i></a>
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

		/*입주사 삭제*/
		public function clientDeleteMng($whereData){
			try{
				parent::clientDelete($whereData);
				$this->common->finalMoveMng("lnd","입주사정보가 삭제 되셨습니다.","client","list");
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","client","list");
			}
		}

		/*입주사 승인*/
		public function clientApply($whereData){
			try{
				$clientResult = parent::modifyclientInfo($whereData);
				while (list($key, $val) = each($clientResult)){
					$SHId	= $clientResult[$key]["SHId"];
					$SHName	= $clientResult[$key]["SHName"];
				}

				$boardCodeNotice = "notice_". $SHId;
				$boardNameNotice = $SHName." 공지사항";
				$boardCodeAnswer = "affter_". $SHId;
				$boardNameAnswer = $SHName." 후기";

				$boardConfigData = array($boardCodeNotice, $boardNameNotice, "board", "N", "N", $SHId,date("Y-m-d H:i:s"));
				parent::boardInsert($boardConfigData);
				$boardConfigData = array($boardCodeAnswer, $boardNameAnswer, "affter", "N", "Y", $SHId,date("Y-m-d H:i:s"));
				parent::boardInsert($boardConfigData);
				$clientApplyData = array("U");
				parent::applyclient($clientApplyData, $whereData);

				$this->common->finalMoveMng("lnd","입주사 승인처리 되었습니다.","client","list");

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","client","list");
			}
		}

		/*입주사 승인*/
		public function clientApply2($whereData){
			try{
				$clientApplyData = array("Y");
				parent::applyclient2($clientApplyData, $whereData);

				$this->common->finalMoveMng("lnd","입주사 인증처리 되었습니다.","client","list");

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","client","list");
			}
		}

		/*입주사 승인 취소*/
		public function clientCancel($whereData){
			try{
				$clientCancelData = array("C");
				parent::applyclient($clientCancelData, $whereData);

				$this->common->finalMoveMng("lnd","입주사 승인취소 처리 되었습니다.","client","list");

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","client","list");
			}
		}

		/*입주사 승인 취소*/
		public function clientCancel2($whereData){
			try{
				$clientCancelData = array("N");
				parent::applyclient2($clientCancelData, $whereData);

				$this->common->finalMoveMng("lnd","입주사 인증취소 처리 되었습니다.","client","list");

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","client","list");
			}
		}

		/*구군 출력*/
		public function zipTwoAdress($bind){
			//$returnVal = "<select name=\"depthTwoArea\" onchange=\"setGoogleMap('select');\">";
			$returnVal = "<select name=\"depthTwoArea\" onchange=\"setSelectAddress();\">";
			//<option value=\"\">선택</option>

			try{
				$clientResult = parent::zipTWODepth($bind);
				while (list($key, $val) = each($clientResult)){
					$returnVal .= "<option value=\"".$clientResult[$key]["ds_gugun"]."\">".$clientResult[$key]["ds_gugun"]."</option>";
				}

				$returnVal .= "</select>";
				return $returnVal;
			}catch (Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/*구군 출력*/
		public function zipTwoAdress2($bind, $gugun){
			$returnVal = "<select name=\"searchGun\">";
			//<option value=\"\">선택</option>

			try{
				$clientResult = parent::zipTWODepth($bind);
				while (list($key, $val) = each($clientResult)){
					$selected = "";
					if($clientResult[$key]["ds_gugun"] == $gugun) $selected = "selected";
					$returnVal .= "<option value=\"".$clientResult[$key]["ds_gugun"]."\" ".$selected.">".$clientResult[$key]["ds_gugun"]."</option>";
				}

				$returnVal .= "</select>";
				return $returnVal;
			}catch (Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/*등록된 파일 목록 출력*/
		public function getFileInfoListView($getBeen){
			$fileResult = parent::searchFile($getBeen);
			$returnData = "";
			while (list($key, $val) = each($fileResult)){
				$returnData .= "<div class=\"fileItem\">".$fileResult[$key]["orgName"]."</div>";
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

			while (list($key, $val) = each($sprResult)){
				$time = $sprResult[$key]["proTime"];

				$hour = floor($time / 60);
				$min = ($time % 60);
				$printTime = $hour."시간";

				if($min > 0){
					$printTime .= $min."분";
				}

				$returnData .= "<div class=\"fileItem\">상품 : [".$sprResult[$key]["proName"]."] 시간 : [".$printTime."] 가격 : [".number_format($sprResult[$key]["price"])."원]</div>";
			}
			return $returnData;
		}

		/**신점종류 가져오기**/
		public function getProductInfoList(){
			$productResult = parent::searchProduct();
			while (list($key, $val) = each($productResult)){
				$viewData .= "<option value=\"".$productResult[$key]["idx"]."\">".$productResult[$key]["proName"]."</option>";
			}

			return $viewData;
		}

		/**신점종류 가져오기**/
		public function getProductInfoList2($proType){
			$productResult = parent::searchProduct();
			while (list($key, $val) = each($productResult)){
				$selected = "";
				if($productResult[$key]["idx"] == $proType) $selected = "selected";

				$viewData .= "<option value=\"".$productResult[$key]["idx"]."\" ".$selected.">".$productResult[$key]["proName"]."</option>";
			}

			return $viewData;
		}

		/**검색 결과**/
		public function getSearchSHList($page="", $setOrder="", $search){
			$returnVal = "";
			$searchQuery = "";

			if($search["searchSido"] != ""){
				$searchQuery .= " AND SHAddress LIKE '%".$search["searchSido"]." ".$search["searchGun"]." %'";
			}

			if($search["productType"] != ""){
				$searchQuery .= " AND c.idx = '".$search["productType"]."'";
			}

			if($search["sPrice"] != ""){
				$searchQuery .= " AND b.price BETWEEN '".$search["sPrice"]."' AND '".$search["ePrice"]."'";
			}

			if($search["searchDate"] != ""){
				$searchQuery .= " AND a.idx not in (SELECT SHIdx FROM reservation WHERE resDate = '".$search["searchDate"]."' AND resStartTime <= '".$search["searchTime"]."')";
			}

			if($search["searchWord"] != ""){
				$searchQuery .= " AND (c.proName LIKE '%".$search["searchWord"]."%' OR a.SHName LIKE '%".$search["searchWord"]."%' OR a.name LIKE '%".$search["searchWord"]."%'  OR a.SHAddress LIKE '".$search["searchWord"]."%')";
			}

			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery." GROUP BY SHId order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = " order by ".$setOrder;

			try{

				$clientTotalCntResult = parent::getSearchSHTotalCnt("",$searchQuery);
				while (list($key, $val) = each($clientTotalCntResult)){
					$clientCnt = $clientTotalCntResult[$key]["clientCnt"];
				}
				$record = $clientCnt;
				$this->searchTotalCnt = $clientCnt;
				$url_file = "/";
				$url_parameter = "#none";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);

				$clientResult = parent::searchclientMOL("",$limitQuery);
				$loopCnt = 0;
				while (list($key, $val) = each($clientResult)){
					$saveName2 = "";
					$SHId = $clientResult[$key]["SHId"];
					$prdPrice = $clientResult[$key]["prdPrice"];
					$SHName = $clientResult[$key]["SHName"];
					$SHAddress = $clientResult[$key]["SHAddress"];
					$SHApply = $clientResult[$key]["SHApply"];

					if($loopCnt == 0){
						$addressArry = explode(" ",$SHAddress);
						if($addressArry[0] == "서울" || $addressArry[0] == "광주" || $addressArry[0] == "부산" || $addressArry[0] == "대전" || $addressArry[0] == "대구"){
							$this->resultSIdo = $addressArry[0]." ".$addressArry[1];
						}else{
							$this->resultSIdo =  $addressArry[0]." ".$addressArry[1]." ".$addressArry[2];
						}

					}

					$whereBeen = array(":code" => $SHId."_affter");
					$amTotalCntResult = parent::affterMemoTotalMOL($whereBeen);
					while (list($key_a, $val_a) = each($amTotalCntResult)){
						$amCnt = $amTotalCntResult[$key_a]["amCnt"];
					}

					/*$wishBeen = array(":SHIdx" => $clientResult[$key]["SHIdx"], ":userId"=>$_SESSION["USER_ID"]);
					$wishCnt = $this->getWishCnt($wishBeen);

					if($wishCnt > 0){
						$heartImg = "<img class=\"sc_heart\" src=\"/images/heart.png\" alt=\"\" />";
					}else{
						if($_SESSION["USER_ID"] != ""){
							$heartImg = "<img class=\"sc_heart\" src=\"/images/heart_off.png\" alt=\"\" onclick=\"setListWish('".$clientResult[$key]["SHIdx"]."');\"/>";
						}else{
							$heartImg = "<img class=\"sc_heart\" src=\"/images/heart_off.png\" alt=\"\"/>";
						}
					}
					*/
					if($SHApply == "Y"){
							$heartImg = "<img class=\"sc_heart\" src=\"/images/logo40.jpg\" alt=\"\"/>";
					}else{
							$heartImg = "";
					}

					$fileData2 = array(":parentId" => $SHId, ":type" => "profile");
					$fileResult = parent::searchFile($fileData2);
					$returnData = "";
					while (list($key_s, $val_s) = each($fileResult)){
						$saveName = $fileResult[$key_s]["saveName"];
					}

					$fileData2 = array(":parentId" => $SHId, ":type" => "client");
					$fileResult = parent::searchFileMain($fileData2);
					$returnData = "";
					$loopIdx = 0;
					while (list($key_f, $val_f) = each($fileResult)){
						$saveName2 = $fileResult[$key_f]["saveName"];
					}

					if($saveName2 == ""){
						$fileData2 = array(":parentId" => $SHId, ":type" => "client");
						$fileResult = parent::searchFile($fileData2);
						while (list($key_f, $val_f) = each($fileResult)){
							$saveName2 = $fileResult[$key_f]["saveName"];
							break;
						}
					}

					if($saveName == ""){
						$viewName = "/html/sample/sp1.jpg";
					}else{
						$viewName = "/upload/client/".$saveName;
					}

					if($saveName2 == ""){
						$viewName2 = "/html/sample/s1.jpg";
					}else{
						$viewName2 = "/upload/client/".$saveName2;
					}

					$returnVal .= "
						<li>
							".$heartImg."
							<div class=\"sc_photo_wrap\">
								<a href=\"?com=client&lnd=clienthome&SHId=".$SHId."\"><img src=\"".$viewName2."\" alt=\"\" style=\"width:320px;height:240px;\"/></a>
								<div class=\"sc_money\">
									<span>\</span>".number_format($prdPrice)."
								</div>
							</div>

							<img class=\"sc_photo_face\" src=\"".$viewName."\" alt=\"\" style=\"width:60px;height:60px;\"/>

							<p class=\"photo_link\">
								<a href=\"?com=client&lnd=clienthome&SHId=".$SHId."\"><img src=\"/images/new.gif\" alt=\"new\" />".$SHName."</a>
							</p>
							<p class=\"photo_score\">
								신점 전체 · 4.9<img src=\"/images/star.gif\" alt=\"\" />· 후기 ".$amCnt."개
							</p>
						</li>
					";

					$loopCnt++;
				}

				/*if($returnVal == ""){
					if($search["searchSido"] != ""){
						$this->resultSIdo = $search["searchSido"]." ".$search["searchGun"];
					}else{
						$this->resultSIdo = "서울 강남구";
					}
				}*/

				/*2015-12-04 수정*/
				if($returnVal == ""){

					if($search["searchSido"] != ""){
						$resultAddress = "";
						$limitQuery = " AND ds_sido LIKE '%".$search["searchSido"]."%' AND ds_gugun LIKE '%".$search["searchGun"]."%' ORDER BY ds_gugun limit 1";


						$zipResult = parent::zipTWODepthCreate($limitQuery);

						while (list($key_g, $val_g) = each($zipResult)){
							$resultAddress = $zipResult[$key_g]["ds_sido"]." ".$zipResult[$key_g]["ds_gugun"]." ".$zipResult[$key_g]["ds_dong"];
						}
						if($resultAddress == ""){
							$this->resultSIdo = "서울 강남구";
						}else{
							$this->resultSIdo = $resultAddress;
						}

						//$this->resultSIdo = $search["searchSido"]." ".$search["searchGun"];
					}else{
						if($search["searchWord"] != ""){
							$resultAddress = "";
							$limitQuery = " AND ds_sido LIKE '%".$search["searchWord"]."%' OR ds_gugun LIKE '%".$search["searchWord"]."%' ORDER BY ds_gugun limit 1";

							$zipResult = parent::zipTWODepthCreate($limitQuery);

							while (list($key_g, $val_g) = each($zipResult)){
								$resultAddress = $zipResult[$key_g]["ds_sido"]." ".$zipResult[$key_g]["ds_gugun"]." ".$zipResult[$key_g]["ds_dong"];
							}
							if($resultAddress == ""){
								$this->resultSIdo = "서울 강남구";
							}else{
								$this->resultSIdo = $resultAddress;
							}
						}else{
							$this->resultSIdo = "서울 강남구";
						}
					}

		if($_SERVER["REMOTE_ADDR"] == "123.140.248.19"){
			echo $limitQuery;
		}
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**검색 결과**/
		public function getSearchSHListM($page="", $setOrder="", $search){
			$returnVal = "";
			$searchQuery = "";

			if($search["searchSido"] != ""){
				$searchQuery .= " AND SHAddress LIKE '%".$search["searchSido"]." ".$search["searchGun"]." %'";
			}

			if($search["productType"] != ""){
				$searchQuery .= " AND c.idx = '".$search["productType"]."'";
			}

			if($search["sPrice"] != ""){
				$searchQuery .= " AND b.price BETWEEN '".$search["sPrice"]."' AND '".$search["ePrice"]."'";
			}

			if($search["searchDate"] != ""){
				$searchQuery .= " AND a.idx not in (SELECT SHIdx FROM reservation WHERE resDate = '".$search["searchDate"]."' AND resStartTime <= '".$search["searchTime"]."')";
			}

			if($search["searchWord"] != ""){
				$searchQuery .= " AND (c.proName LIKE '%".$search["searchWord"]."%' OR a.SHName LIKE '%".$search["searchWord"]."%' OR a.name LIKE '%".$search["searchWord"]."%'  OR a.SHAddress LIKE '".$search["searchWord"]."%')";
			}
			
			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery." GROUP BY SHId order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//echo $limitQuery;
			//$limitQuery = " order by ".$setOrder;

			try{

				$clientTotalCntResult = parent::getSearchSHTotalCnt("",$searchQuery);
				while (list($key, $val) = each($clientTotalCntResult)){
					$clientCnt = $clientTotalCntResult[$key]["clientCnt"];
				}
				$record = $clientCnt;
				$this->searchTotalCnt = $clientCnt;
				$url_file = "/";
				$url_parameter = "#none";
				$this->pageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);

				$clientResult = parent::searchclientMOL("",$limitQuery);
				$loopCnt = 0;
				$lastCnt = count($clientResult);
				while (list($key, $val) = each($clientResult)){
					$saveName2 = "";
					$loopCnt++;
					$SHId = $clientResult[$key]["SHId"];
					$prdPrice = $clientResult[$key]["prdPrice"];
					$SHName = $clientResult[$key]["SHName"];
					$SHAddress = $clientResult[$key]["SHAddress"];
					$SHDesc = $clientResult[$key]["SHDesc"];

					if($loopCnt == 1){
						$addressArry = explode(" ",$SHAddress);
						$this->resultSIdo = "<span>한국</span>  &gt; ". $addressArry[0];
					}

					$whereBeen = array(":code" => $SHId."_affter");
					$amTotalCntResult = parent::affterMemoTotalMOL($whereBeen);
					while (list($key_a, $val_a) = each($amTotalCntResult)){
						$amCnt = $amTotalCntResult[$key_a]["amCnt"];
					}

					$scoreData = $this->getAffterScore($SHId."_affter");


					$fileData2 = array(":parentId" => $SHId, ":type" => "profile");
					$fileResult = parent::searchFile($fileData2);
					$returnData = "";
					while (list($key_s, $val_s) = each($fileResult)){
						$saveName = $fileResult[$key_s]["saveName"];
					}

					$fileData2 = array(":parentId" => $SHId, ":type" => "client");
					$fileResult = parent::searchFileMain($fileData2);
					$returnData = "";
					$loopIdx = 0;
					while (list($key_f, $val_f) = each($fileResult)){
						$saveName2 = $fileResult[$key_f]["saveName"];
						break;
					}
					
					if($saveName2 == ""){
						$fileData2 = array(":parentId" => $SHId, ":type" => "client");
						$fileResult = parent::searchFile($fileData2);
						while (list($key_f, $val_f) = each($fileResult)){
							$saveName2 = $fileResult[$key_f]["saveName"];
							break;
						}
					}

					if($saveName == ""){
						$viewName = "/html/sample/sp1.jpg";
					}else{
						$viewName = "/upload/client/".$saveName;
					}

					if($saveName2 == ""){
						$viewName2 = "/html/sample/s1.jpg";
					}else{
						$viewName2 = "/upload/client/".$saveName2;
					}

					if($lastCnt == $loopCnt){
						$searchFilter = "
							<div style=\"position:absolute;margin-top:-68px;padding:0px 20px; box-sizing:border-box;z-index:99;\">
								<input type=\"button\" value=\"검색필터\" class=\"btn_1\" onclick=\"searchFilterGo()\" />
							</div>
						";
						$onclick = "";
					}else{
						$onclick = "onclick=\"location.href='?com=client&lnd=clientHome&SHId=".$SHId."'\"";
					}

					$returnVal .= "
					   <div style=\"background:url(".$viewName2.") no-repeat; background-size:cover;\" class=\"sl_shop_wrap\" ".$onclick.">
							<div>
							".$searchFilter."
								<!--<div class=\"sl_show_btn\">
									<input type=\"image\" src=\"/images/mobile/btn_left.gif\" alt=\"이전\" />
									<input type=\"image\" src=\"/images/mobile/btn_right.gif\" alt=\"다음\" />
								</div>-->
								<span class=\"shop_price\">
									<span>￦</span>".number_format($prdPrice)."
								</span>
							</div>
						</div>
						<div class=\"sl_shop_title\">
							<a href=\"?com=client&lnd=clientHome&SHId=".$SHId."\">".$SHName."</a>
							<button style=\"background:url(".$viewName.") no-repeat; background-size:cover;\" type=\"button\" class=\"shop_photo\" onclick=\"location.href='?com=client&lnd=clientHome&SHId=".$SHId."'\"></button>
							<div class=\"sl_shop_score\">
								<!--사주점 · --><img src=\"/images/mobile/score".$scoreData["totalScore"].".gif\" alt=\"".$scoreData["totalScore"]."점\" /> · 후기 ".number_format($amCnt)."개
							</div>
						</div>
					";

				}

				return $returnVal;


			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**점짐 메인 정보**/
		public function clientHomeInfo($getBeen){
			$clientResult = parent::modifyclientInfo($getBeen);
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
				$returnData["SHStatus"]	= $clientResult[$key]["SHStatus"];
				$returnData["SHZipcode"]	= $clientResult[$key]["SHZipcsode"];
				$returnData["SHAddress2"]	= $clientResult[$key]["SHAddress2"];
				$returnData["SHWord"]	= $clientResult[$key]["SHWord"];
				$returnData["SHApply"]	= $clientResult[$key]["SHApply"];

				$fileData2 = array(":parentId" => $clientResult[$key]["SHId"], ":type" => "profile");
				$fileResult = parent::searchFile($fileData2);
				while (list($key_f, $val_f) = each($fileResult)){
					$saveName = $fileResult[$key_f]["saveName"];
				}

				if($saveName == ""){
					$returnData["viewProfile"] = "/html/sample/sp1.jpg";
				}else{
					$returnData["viewProfile"] = "/upload/client/".$saveName;
				}

				$fileData2 = array(":parentId" => $clientResult[$key]["SHId"], ":type" => "client");
				$fileResult = parent::searchFile($fileData2);
				$loopIdx = 0;
				$clientImg = array();
				while (list($key_f, $val_f) = each($fileResult)){
					$clientImg[] = "/upload/client/".$fileResult[$key_f]["saveName"];
				}
				$returnData["clientImg"] = $clientImg;

				$fileResult = parent::searchFileMain($fileData2);
				$loopIdx = 0;
				$clientMainImg = "";
				while (list($key_f, $val_f) = each($fileResult)){
					if($fileResult[$key_f]["saveName"] != ""){
						$clientMainImg = "/upload/client/".$fileResult[$key_f]["saveName"];
					}
				}

				if($clientMainImg == "")$clientMainImg = $clientImg[0];

				$returnData["clientMainImg"] = $clientMainImg;


				$productNameInfo = "";
				$productInfo = "";
				$productSelect = "";
				$sprData = array(":SHIdx" => $clientResult[$key]["idx"]);
				$sprResult = parent::searchSpr($sprData);
				while (list($key_s, $val_s) = each($sprResult)){
					$time = $sprResult[$key_s]["proTime"];

					$hour = floor($time / 60);
					$min = ($time % 60);
					$printTime = $hour > 0 ? $hour."시간" : "";

					if($min > 0){
						$printTime .= $min."분";
					}

					$productNameInfo .= $sprResult[$key_s]["proName"].",";
					$productInfo .= "<li>".$sprResult[$key_s]["proName"]." : <span class=\"sv_txt1\">\ ".number_format($sprResult[$key_s]["price"])." / ".$printTime."</span></li>";
					$productSelect .= "<option value=\"".$sprResult[$key_s]["sprIdx"]."-".$sprResult[$key_s]["price"]."\">".$sprResult[$key_s]["proName"]."</option>";
				}

				$returnData["productNameInfo"] = substr($productNameInfo,0,strlen($productNameInfo) - 1);
				$returnData["productInfo"] = $productInfo;
				$returnData["productSelect"] = $productSelect;

				$sTimeArray = explode(":",$clientResult[$key]["SHStartTime"]);
				$eTimeArray = explode(":",$clientResult[$key]["SHEndTime"]);
				$sMin = "";
				$eMin = "";

				if($sTimeArray[0] <= 12){
					$sTimeWord = "오전";
					$sTime = $sTimeArray[0];
				}else{
					$sTimeWord = "오후";
					$sTime = ($sTimeArray[0] - 12);
				}

				if($sTimeArray[1] != "00"){
					$sMin = $sTimeArray[1]."분";
				}

				if($eTimeArray[0] <= 12){
					$eTimeWord = "오전";
					$eTime = $eTimeArray[0];
				}else{
					$eTimeWord = "오후";
					$eTime = ($eTimeArray[0] - 12);
				}

				if($eTimeArray[1] != "00"){
					$eMin = $eTimeArray[1]."분";
				}

				$returnData["viewOpenTime"] = $sTimeWord." ".$sTime."시 ".$sMin." - ".$eTimeWord." ".$eTime."시 ".$eMin;

				$regData = substr($clientResult[$key]["writeDate"],0,10);
				$regDataArr = explode("-", $regData);
				$returnData["viewRegDate"] = $regDataArr[0]."년 ".$regDataArr[1]."월";

				$mapInfo = "var markers = [";
				$idx	=  $clientResult[$key]["idx"];
				$SHName =  $clientResult[$key]["SHName"];
				$SHLng	=  $clientResult[$key]["SHLng"];
				$SHLat	=  $clientResult[$key]["SHLat"];
				$SHDesc =  $clientResult[$key]["SHDesc"];
				$SHId	=  $clientResult[$key]["SHId"];
				$mapInfo .= "
					{
						\"idx\": '".$idx."',
						\"title\": '".$SHName."',
						\"lat\": ".$SHLng.",
						\"lng\": ".$SHLat.",
						\"description\": '".nl2br(str_replace("\r\n","<br>",$SHDesc))."'
					},
				";
				$mapInfo .= "]";
				$returnData["mapInfo"] = $mapInfo;
			}
			return $returnData;

		}

		/**점짐 메인 정보**/
		public function clientHomeInfoDaum($getBeen){
			$clientResult = parent::modifyclientInfo($getBeen);
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
				$returnData["SHStatus"]	= $clientResult[$key]["SHStatus"];
				$returnData["SHZipcode"]	= $clientResult[$key]["SHZipcsode"];
				$returnData["SHAddress2"]	= $clientResult[$key]["SHAddress2"];
				$returnData["SHWord"]	= $clientResult[$key]["SHWord"];
				$returnData["SHApply"]	= $clientResult[$key]["SHApply"];

				$fileData2 = array(":parentId" => $clientResult[$key]["SHId"], ":type" => "profile");
				$fileResult = parent::searchFile($fileData2);
				while (list($key_f, $val_f) = each($fileResult)){
					$saveName = $fileResult[$key_f]["saveName"];
				}

				if($saveName == ""){
					$returnData["viewProfile"] = "/html/sample/sp1.jpg";
				}else{
					$returnData["viewProfile"] = "/upload/client/".$saveName;
				}

				$fileData2 = array(":parentId" => $clientResult[$key]["SHId"], ":type" => "client");
				$fileResult = parent::searchFile($fileData2);
				$loopIdx = 0;
				$clientImg = array();
				while (list($key_f, $val_f) = each($fileResult)){
					$clientImg[] = "/upload/client/".$fileResult[$key_f]["saveName"];
				}
				$returnData["clientImg"] = $clientImg;

				$fileResult = parent::searchFileMain($fileData2);
				$loopIdx = 0;
				$clientMainImg = "";
				while (list($key_f, $val_f) = each($fileResult)){
					if($fileResult[$key_f]["saveName"] != ""){
						$clientMainImg = "/upload/client/".$fileResult[$key_f]["saveName"];
					}
				}

				if($clientMainImg == "")$clientMainImg = $clientImg[0];

				$returnData["clientMainImg"] = $clientMainImg;


				$productNameInfo = "";
				$productInfo = "";
				$productSelect = "";
				$sprData = array(":SHIdx" => $clientResult[$key]["idx"]);
				$sprResult = parent::searchSpr($sprData);
				while (list($key_s, $val_s) = each($sprResult)){
					$time = $sprResult[$key_s]["proTime"];

					$hour = floor($time / 60);
					$min = ($time % 60);
					$printTime = $hour > 0 ? $hour."시간" : "";

					if($min > 0){
						$printTime .= $min."분";
					}

					$productNameInfo .= $sprResult[$key_s]["proName"].",";
					$productInfo .= "<li>".$sprResult[$key_s]["proName"]." : <span class=\"sv_txt1\">\ ".number_format($sprResult[$key_s]["price"])." / ".$printTime."</span></li>";
					$productSelect .= "<option value=\"".$sprResult[$key_s]["sprIdx"]."-".$sprResult[$key_s]["price"]."\">".$sprResult[$key_s]["proName"]."</option>";
				}

				$returnData["productNameInfo"] = substr($productNameInfo,0,strlen($productNameInfo) - 1);
				$returnData["productInfo"] = $productInfo;
				$returnData["productSelect"] = $productSelect;

				$sTimeArray = explode(":",$clientResult[$key]["SHStartTime"]);
				$eTimeArray = explode(":",$clientResult[$key]["SHEndTime"]);
				$sMin = "";
				$eMin = "";

				if($sTimeArray[0] <= 12){
					$sTimeWord = "오전";
					$sTime = $sTimeArray[0];
				}else{
					$sTimeWord = "오후";
					$sTime = ($sTimeArray[0] - 12);
				}

				if($sTimeArray[1] != "00"){
					$sMin = $sTimeArray[1]."분";
				}

				if($eTimeArray[0] <= 12){
					$eTimeWord = "오전";
					$eTime = $eTimeArray[0];
				}else{
					$eTimeWord = "오후";
					$eTime = ($eTimeArray[0] - 12);
				}

				if($eTimeArray[1] != "00"){
					$eMin = $eTimeArray[1]."분";
				}

				$returnData["viewOpenTime"] = $sTimeWord." ".$sTime."시 ".$sMin." - ".$eTimeWord." ".$eTime."시 ".$eMin;

				$regData = substr($clientResult[$key]["writeDate"],0,10);
				$regDataArr = explode("-", $regData);
				$returnData["viewRegDate"] = $regDataArr[0]."년 ".$regDataArr[1]."월";

				$idx	=  $clientResult[$key]["idx"];
				$SHName =  $clientResult[$key]["SHName"];
				$SHLng	=  $clientResult[$key]["SHLng"];
				$SHLat	=  $clientResult[$key]["SHLat"];
				$SHDesc =  $clientResult[$key]["SHDesc"];
				$SHId	=  $clientResult[$key]["SHId"];
			}
			return $returnData;

		}


		/**점짐 메인 정보**/
		public function clientHomeInfoM($getBeen){
			$clientResult = parent::modifyclientInfo($getBeen);
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
				$returnData["SHStatus"]	= $clientResult[$key]["SHStatus"];
				$returnData["SHZipcode"]	= $clientResult[$key]["SHZipcsode"];
				$returnData["SHAddress2"]	= $clientResult[$key]["SHAddress2"];
				$returnData["SHWord"]	= $clientResult[$key]["SHWord"];
				$returnData["SHApply"]	= $clientResult[$key]["SHApply"];

				$fileData2 = array(":parentId" => $clientResult[$key]["SHId"], ":type" => "profile");
				$fileResult = parent::searchFile($fileData2);
				while (list($key_f, $val_f) = each($fileResult)){
					$saveName = $fileResult[$key_f]["saveName"];
				}

				if($saveName == ""){
					$returnData["viewProfile"] = "/html/sample/sp1.jpg";
				}else{
					$returnData["viewProfile"] = "/upload/client/".$saveName;
				}

				$fileData2 = array(":parentId" => $clientResult[$key]["SHId"], ":type" => "client");
				$fileResult = parent::searchFile($fileData2);
				$loopIdx = 0;
				$clientImg = array();
				while (list($key_f, $val_f) = each($fileResult)){
					$clientImg[] = "/upload/client/".$fileResult[$key_f]["saveName"];
				}
				$returnData["clientImg"] = $clientImg;

				$fileResult = parent::searchFileMain($fileData2);
				$loopIdx = 0;
				$clientMainImg = "";
				while (list($key_f, $val_f) = each($fileResult)){
					$clientMainImg = "/upload/client/".$fileResult[$key_f]["saveName"];
				}

				if($clientMainImg == "")$clientMainImg = $clientImg[0];

				$returnData["clientMainImg"] = $clientMainImg;


				$productNameInfo = "";
				$productInfo = "";
				$productSelect = "";
				$sprData = array(":SHIdx" => $clientResult[$key]["idx"]);
				$sprResult = parent::searchSpr($sprData);
				while (list($key_s, $val_s) = each($sprResult)){
					$time = $sprResult[$key_s]["proTime"];

					$hour = floor($time / 60);
					$min = ($time % 60);
					$printTime = $hour > 0 ? $hour."시간" : "";

					if($min > 0){
						$printTime .= $min."분";
					}

					$productNameInfo .= $sprResult[$key_s]["proName"].",";
					$productInfo .= "<li>".$sprResult[$key_s]["proName"]." : ￦ ".number_format($sprResult[$key_s]["price"])." / ".$printTime."</li>";
					$productSelect .= "<option value=\"".$sprResult[$key_s]["sprIdx"]."-".$sprResult[$key_s]["price"]."\">".$sprResult[$key_s]["proName"]."</option>";
				}

				$returnData["productNameInfo"] = substr($productNameInfo,0,strlen($productNameInfo) - 1);
				$returnData["productInfo"] = $productInfo;
				$returnData["productSelect"] = $productSelect;

				$sTimeArray = explode(":",$clientResult[$key]["SHStartTime"]);
				$eTimeArray = explode(":",$clientResult[$key]["SHEndTime"]);
				$sMin = "";
				$eMin = "";

				if($sTimeArray[0] <= 12){
					$sTimeWord = "오전";
					$sTime = $sTimeArray[0];
				}else{
					$sTimeWord = "오후";
					$sTime = ($sTimeArray[0] - 12);
				}

				if($sTimeArray[1] != "00"){
					$sMin = $sTimeArray[1]."분";
				}

				if($eTimeArray[0] <= 12){
					$eTimeWord = "오전";
					$eTime = $eTimeArray[0];
				}else{
					$eTimeWord = "오후";
					$eTime = ($eTimeArray[0] - 12);
				}

				if($eTimeArray[1] != "00"){
					$eMin = $eTimeArray[1]."분";
				}

				$returnData["viewOpenTime"] = $sTimeWord." ".$sTime."시 ".$sMin." - ".$eTimeWord." ".$eTime."시 ".$eMin;

				$regData = substr($clientResult[$key]["writeDate"],0,10);
				$regDataArr = explode("-", $regData);
				$returnData["viewRegDate"] = $regDataArr[0]."년 ".$regDataArr[1]."월";

				$mapInfo = "var markers = [";
				$idx	=  $clientResult[$key]["idx"];
				$SHName =  $clientResult[$key]["SHName"];
				$SHLng	=  $clientResult[$key]["SHLng"];
				$SHLat	=  $clientResult[$key]["SHLat"];
				$SHDesc =  $clientResult[$key]["SHDesc"];
				$SHId	=  $clientResult[$key]["SHId"];
				$mapInfo .= "
					{
						\"idx\": '".$idx."',
						\"title\": '".$SHName."',
						\"lat\": ".$SHLng.",
						\"lng\": ".$SHLat.",
						\"description\": '".nl2br(str_replace("\r\n","<br>",$SHDesc))."'
					},
				";
				$mapInfo .= "]";
				$returnData["mapInfo"] = $mapInfo;
			}
			return $returnData;

		}

		/**점짐 메인 정보**/
		public function clientHomeInfoMDaum($getBeen){
			$clientResult = parent::modifyclientInfo($getBeen);
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
				$returnData["SHStatus"]	= $clientResult[$key]["SHStatus"];
				$returnData["SHZipcode"]	= $clientResult[$key]["SHZipcsode"];
				$returnData["SHAddress2"]	= $clientResult[$key]["SHAddress2"];
				$returnData["SHWord"]	= $clientResult[$key]["SHWord"];
				$returnData["SHApply"]	= $clientResult[$key]["SHApply"];

				$fileData2 = array(":parentId" => $clientResult[$key]["SHId"], ":type" => "profile");
				$fileResult = parent::searchFile($fileData2);
				while (list($key_f, $val_f) = each($fileResult)){
					$saveName = $fileResult[$key_f]["saveName"];
				}

				if($saveName == ""){
					$returnData["viewProfile"] = "/html/sample/sp1.jpg";
				}else{
					$returnData["viewProfile"] = "/upload/client/".$saveName;
				}

				$fileData2 = array(":parentId" => $clientResult[$key]["SHId"], ":type" => "client");
				$fileResult = parent::searchFile($fileData2);
				$loopIdx = 0;
				$clientImg = array();
				while (list($key_f, $val_f) = each($fileResult)){
					$clientImg[] = "/upload/client/".$fileResult[$key_f]["saveName"];
				}
				$returnData["clientImg"] = $clientImg;

				$fileResult = parent::searchFileMain($fileData2);
				$loopIdx = 0;
				$clientMainImg = "";
				while (list($key_f, $val_f) = each($fileResult)){
					$clientMainImg = "/upload/client/".$fileResult[$key_f]["saveName"];
				}

				if($clientMainImg == "")$clientMainImg = $clientImg[0];

				$returnData["clientMainImg"] = $clientMainImg;


				$productNameInfo = "";
				$productInfo = "";
				$productSelect = "";
				$sprData = array(":SHIdx" => $clientResult[$key]["idx"]);
				$sprResult = parent::searchSpr($sprData);
				while (list($key_s, $val_s) = each($sprResult)){
					$time = $sprResult[$key_s]["proTime"];

					$hour = floor($time / 60);
					$min = ($time % 60);
					$printTime = $hour > 0 ? $hour."시간" : "";

					if($min > 0){
						$printTime .= $min."분";
					}

					$productNameInfo .= $sprResult[$key_s]["proName"].",";
					$productInfo .= "<li>".$sprResult[$key_s]["proName"]." : ￦ ".number_format($sprResult[$key_s]["price"])." / ".$printTime."</li>";
					$productSelect .= "<option value=\"".$sprResult[$key_s]["sprIdx"]."-".$sprResult[$key_s]["price"]."\">".$sprResult[$key_s]["proName"]."</option>";
				}

				$returnData["productNameInfo"] = substr($productNameInfo,0,strlen($productNameInfo) - 1);
				$returnData["productInfo"] = $productInfo;
				$returnData["productSelect"] = $productSelect;

				$sTimeArray = explode(":",$clientResult[$key]["SHStartTime"]);
				$eTimeArray = explode(":",$clientResult[$key]["SHEndTime"]);
				$sMin = "";
				$eMin = "";

				if($sTimeArray[0] <= 12){
					$sTimeWord = "오전";
					$sTime = $sTimeArray[0];
				}else{
					$sTimeWord = "오후";
					$sTime = ($sTimeArray[0] - 12);
				}

				if($sTimeArray[1] != "00"){
					$sMin = $sTimeArray[1]."분";
				}

				if($eTimeArray[0] <= 12){
					$eTimeWord = "오전";
					$eTime = $eTimeArray[0];
				}else{
					$eTimeWord = "오후";
					$eTime = ($eTimeArray[0] - 12);
				}

				if($eTimeArray[1] != "00"){
					$eMin = $eTimeArray[1]."분";
				}

				$returnData["viewOpenTime"] = $sTimeWord." ".$sTime."시 ".$sMin." - ".$eTimeWord." ".$eTime."시 ".$eMin;

				$regData = substr($clientResult[$key]["writeDate"],0,10);
				$regDataArr = explode("-", $regData);
				$returnData["viewRegDate"] = $regDataArr[0]."년 ".$regDataArr[1]."월";

				$mapInfo = "var markers = [";
				$idx	=  $clientResult[$key]["idx"];
				$SHName =  $clientResult[$key]["SHName"];
				$SHLng	=  $clientResult[$key]["SHLng"];
				$SHLat	=  $clientResult[$key]["SHLat"];
				$SHDesc =  $clientResult[$key]["SHDesc"];
				$SHId	=  $clientResult[$key]["SHId"];
				$mapInfo .= "
					{
						\"idx\": '".$idx."',
						\"title\": '".$SHName."',
						\"lat\": ".$SHLng.",
						\"lng\": ".$SHLat.",
						\"description\": '".nl2br(str_replace("\r\n","<br>",$SHDesc))."'
					},
				";
				$mapInfo .= "]";
				$returnData["mapInfo"] = $mapInfo;
			}
			return $returnData;

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

		/**후기등록**/
		public function insertAffterMemo($setBeen, $SHId){
			parent::insertAffterMemoMOL($setBeen);
			$this->common->finalMove("lnd","후기가 등록이 되었습니다.","client","clienthome","&SHId=".$SHId);
		}

		/**후기등록**/
		public function insertAffterMemoM($setBeen, $SHId){
			parent::insertAffterMemoMOL($setBeen);
			$this->common->finalMove("lnd","후기가 등록이 되었습니다.","client","clientHome","&SHId=".$SHId);
		}

		/**후기삭제**/
		public function deleteAffterMemo($whereBeen, $SHId){
			parent::deleteAffterMemoMOL($whereBeen);
			$this->common->finalMove("lnd","후기가 삭제 되었습니다.","client","clienthome","&SHId=".$SHId);
		}

		/**후기삭제**/
		public function deleteAffterMemoM($whereBeen, $SHId){
			parent::deleteAffterMemoMOL($whereBeen);
			$this->common->finalMove("lnd","후기가 삭제 되었습니다.","client","clientHome","&SHId=".$SHId);
		}

		/**후기수정**/
		public function modifyAffterMemo($setBeen, $whereBeen, $SHId){
			parent::modifyAffterMemoMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","후기가 수정 되었습니다.","client","clienthome","&SHId=".$SHId);
		}

		/**후기수정**/
		public function modifyAffterMemoM($setBeen, $whereBeen, $SHId){
			parent::modifyAffterMemoMOL($setBeen, $whereBeen);
			$this->common->finalMove("lnd","후기가 수정 되었습니다.","client","clientHome","&SHId=".$SHId);
		}

		/**후기 리스트**/
		public function affterMemoList($page="", $code, $SHId){
			$this->link = 2;
			$startNum = ($page - 1) * $this->link;
			$limitQuery = " order by idx DESC limit ".$startNum." , ".$this->link;
			//$limitQuery = " order by ".$setOrder;
			try{
				$whereBeen = array(":code" => $code);
				$amTotalCntResult = parent::affterMemoTotalMOL($whereBeen);
				while (list($key, $val) = each($amTotalCntResult)){
					$amCnt = $amTotalCntResult[$key]["amCnt"];
				}
				$record = $amCnt;
				$this->amTotalCnt = $amCnt;
				$url_file = "/";
				$url_parameter = "com=client&lnd=clienthome&SHId=".$SHId;
				$this->memoPageView = $this->paging->Link_Memo($page,$record,$this->link,$this->linking,$url_file,$url_parameter);

				$amResult = parent::affterMemoListMOL($whereBeen,$limitQuery);

				while (list($key, $val) = each($amResult)){
					$addBtn = "";
					$userWhereBeen = array(":id"=>$amResult[$key]["userId"]);
					$userResult = parent::getUserInfo($userWhereBeen);
					while (list($key_u, $val_u) = each($userResult)){
						$userName = trim($this->cipher->getDecrypt($userResult[$key_u]["name"]));
					}

					$regData = substr($amResult[$key]["writeDate"],0,10);
					$regDataArr = explode("-", $regData);
					$viewRegDate = $regDataArr[0]."년 ".$regDataArr[1]."월";

					if($amResult[$key]["userId"] == $_SESSION["USER_ID"]){
						$addBtn = "
									<button type=\"button\" class=\"btn_review\" onclick=\"modifyMemo('".$amResult[$key]["idx"]."')\">수정</button>
									<button type=\"button\" class=\"btn_review\" onclick=\"deleteMemo('".$amResult[$key]["idx"]."')\">삭제</button>
						";
					}

					$returnVal .= "
						<li>
							<div class=\"sv_review_pic\">
								<!--<img src=\"/html/sample/svp1.jpg\" alt=\"\" /><br />-->".$userName."
							</div>
							<div class=\"sv_review_txt\">
								<p class=\"sv_review_txt2\">".nl2br($amResult[$key]["memo"])."<textarea id=\"memo".$amResult[$key]["idx"]."\" style=\"display:none\">".$amResult[$key]["memo"]."</textarea>
								</p>
								<div class=\"sv_review_date\">".$viewRegDate."</div>
								<div class=\"float_right\">
									<!--<button type=\"button\" class=\"btn_review\"><img src=\"/images/recommend.gif\" alt=\"\" />추천</button>-->
									".$addBtn."
								</div>
							</div>
						</li>
					";
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**후기 리스트**/
		public function affterMemoListM($page="", $code, $SHId){
			$this->link = 2;
			$startNum = ($page - 1) * $this->link;
			$limitQuery = " order by idx DESC limit ".$startNum." , ".$this->link;
			//$limitQuery = " order by ".$setOrder;
			try{
				$whereBeen = array(":code" => $code);
				$amTotalCntResult = parent::affterMemoTotalMOL($whereBeen);
				while (list($key, $val) = each($amTotalCntResult)){
					$amCnt = $amTotalCntResult[$key]["amCnt"];
				}
				$record = $amCnt;
				$this->amTotalCnt = $amCnt;
				$url_file = "/";
				$url_parameter = "com=client&lnd=clienthome&SHId=".$SHId;
				$this->memoPageView = $this->paging->Link_Memo($page,$record,$this->link,$this->linking,$url_file,$url_parameter);

				$amResult = parent::affterMemoListMOL($whereBeen,$limitQuery);

				while (list($key, $val) = each($amResult)){
					$addBtn = "";
					$userWhereBeen = array(":id"=>$amResult[$key]["userId"]);
					$userResult = parent::getUserInfo($userWhereBeen);
					while (list($key_u, $val_u) = each($userResult)){
						$userName = trim($this->cipher->getDecrypt($userResult[$key_u]["name"]));
					}

					$regData = substr($amResult[$key]["writeDate"],0,10);
					$regDataArr = explode("-", $regData);
					$viewRegDate = $regDataArr[0]."년 ".$regDataArr[1]."월";

					if($amResult[$key]["userId"] == $_SESSION["USER_ID"]){
						$addBtn = "
									<button type=\"button\" class=\"cmt_btn\" onclick=\"modifyMemo('".$amResult[$key]["idx"]."')\">수정</button>
									<button type=\"button\" class=\"cmt_btn\" onclick=\"deleteMemo('".$amResult[$key]["idx"]."')\">삭제</button>
						";
					}

					$returnVal .= "

						<dt>
							".$userName."
						</dt>
						<dd id=\"moreTextCmt".$amResult[$key]["idx"]."\" class=\"sv_cmt_txt\">
							<div id=\"moreTextLayerCmt".$amResult[$key]["idx"]."\" onclick=\"expand('Cmt".$amResult[$key]["idx"]."')\" class=\"more_wrap2\"></div>
						   ".nl2br($amResult[$key]["memo"])."
						</dd>
						<dd id=\"moreTextLinkCmt0\" class=\"sv_more\">
							<a href=\"javascript:expand('Cmt".$amResult[$key]["idx"]."')\" class=\"link4\">+ 더보기</a>
						</dd>
						<dd class=\"sv_cmt_btn\">
							<div>".$viewRegDate."</div>
							
							<div>
								<!--<button type=\"button\" class=\"cmt_btn\">
									<img src=\"/images/mobile/btn_like.gif\" alt=\"\" />추천
								</button>-->
								".$addBtn."
							</div>
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

		/*후기정보 출력*/
		public function getAffterInfo($getBeen){
			$afterResult = parent::affterMemoListSelectMOL($getBeen);
			$returnVal = array();
			while (list($key, $val) = each($afterResult)){
				$returnVal["memo"] = $afterResult[$key]["memo"];
				$returnVal["pointerP"] = $afterResult[$key]["pointerP"];
				$returnVal["serviceP"] = $afterResult[$key]["serviceP"];
				$returnVal["locationP"] = $afterResult[$key]["locationP"];
				$returnVal["priceP"] = $afterResult[$key]["priceP"];
			}
			return $returnVal;
		}

		/*상품정보 출력*/
		public function getSprInfoListView2($getBeen){
			$sprResult = parent::searchSpr2($getBeen);
			$returnData = array();

			while (list($key, $val) = each($sprResult)){
				$returnData["time"] = $sprResult[$key]["proTime"];
			}
			return $returnData;
		}

		/*상품정보 출력*/
		public function getResCntInfo($getBeen, $limitQuery){
			$resResult = parent::getResCntMOL($getBeen, $limitQuery);

			while (list($key, $val) = each($resResult)){
				$resCnt = $resResult[$key]["resCnt"];
			}
			return $resCnt;
		}


		/**입주사 예약**/
		public function setReservationInfo($getBeen){
			$sprBeen = array(":idx" => $getBeen[1]);
			$sprResult = parent::searchSpr2($sprBeen);
			while (list($key, $val) = each($sprResult)){
				$proIdx = $sprResult[$key]["proIdx"];
			}
			/*결제 데이터 생성*/
			$paymentBeen = array("B", "R", $getBeen[5], $getBeen[3], "0", "", "", "W", "", "", "", "", date("Y-m-d H:i:s"));
			$paymentIdx = parent::paymentInfoInsert($paymentBeen);

			$reservationBeen = array($getBeen[0], $proIdx, $paymentIdx, $getBeen[5], $getBeen[6], $getBeen[7], $getBeen[8], $getBeen[4], "W", date("Y-m-d H:i:s"));
			parent::setReservationInfoMOL($reservationBeen);
		}

		/**위시 체크**/
		public function getWishCnt($getBeen){
			$whisResult = parent::getWishCntMOL($getBeen);
			while (list($key, $val) = each($whisResult)){
				$wishCnt = $whisResult[$key]["wishCnt"];
			}

			return $wishCnt;
		}

		/**위시 등록**/
		public function setWish($getBeen){
			parent::whishInfoInsert($getBeen);
		}

		/**검색 결과**/
		public function getApproachSHList($page="", $setOrder="", $search, $notIdx){
			$returnVal = "";
			$searchQuery = "";
			$this->link = 6;
			if($search["searchSido"] != ""){
				$searchQuery .= " AND SHAddress LIKE '%".$search["searchSido"]." ".$search["searchGun"]." %' AND a.idx not in (".$notIdx.")";
			}

			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery." GROUP BY SHId order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = " order by ".$setOrder;

			try{

				$clientTotalCntResult = parent::getSearchSHTotalCnt("",$searchQuery);
				while (list($key, $val) = each($clientTotalCntResult)){
					$clientCnt = $clientTotalCntResult[$key]["clientCnt"];
				}
				$record = $clientCnt;
				$this->searchTotalCnt = $clientCnt;
				$url_file = "/";
				$url_parameter = "#none";
				$this->approachPageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);

				$clientResult = parent::searchclientMOL("",$limitQuery);
				while (list($key, $val) = each($clientResult)){

					if($notIdx != $clientResult[$key]["SHIdx"]){
						$saveName2 = "";
						$SHId = $clientResult[$key]["SHId"];
						$prdPrice = $clientResult[$key]["prdPrice"];
						$SHName = $clientResult[$key]["SHName"];

						$whereBeen = array(":code" => $SHId."_affter");
						$amTotalCntResult = parent::affterMemoTotalMOL($whereBeen);
						while (list($key_a, $val_a) = each($amTotalCntResult)){
							$amCnt = $amTotalCntResult[$key_a]["amCnt"];
						}

						$scoreData = $this->getAffterScore($SHId."_affter");

						$wishBeen = array(":SHIdx" => $clientResult[$key]["SHIdx"], ":userId"=>$_SESSION["USER_ID"]);
						$wishCnt = $this->getWishCnt($wishBeen);

						if($wishCnt > 0){
							$heartImg = "<img class=\"sc_heart\" src=\"/images/heart.png\" alt=\"\" />";
						}else{
							if($_SESSION["USER_ID"] != ""){
								$heartImg = "<img class=\"sc_heart\" src=\"/images/heart_off.png\" alt=\"\" onclick=\"setListWishH('".$clientResult[$key]["SHIdx"]."');\"/>";
							}else{
								$heartImg = "<img class=\"sc_heart\" src=\"/images/heart_off.png\" alt=\"\"/>";
							}
							//$heartImg = "<img class=\"sc_heart\" src=\"/images/heart_off.png\" alt=\"\" />";
						}

						$fileData2 = array(":parentId" => $SHId, ":type" => "profile");
						$fileResult = parent::searchFile($fileData2);
						$returnData = "";
						while (list($key, $val) = each($fileResult)){
							$saveName = $fileResult[$key]["saveName"];
						}

						$fileData2 = array(":parentId" => $SHId, ":type" => "client");
						$fileResult = parent::searchFileMain($fileData2);
						$returnData = "";
						$loopIdx = 0;
						while (list($key, $val) = each($fileResult)){
							$saveName2 = $fileResult[$key]["saveName"];
						}

						if($saveName2 == ""){
							$fileResult = parent::searchFile($fileData2);
							while (list($key_f, $val_f) = each($fileResult)){
								$saveName2 = $fileResult[$key_f]["saveName"];
								break;
							}
						}

						if($saveName == ""){
							$viewName = "/html/sample/sp1.jpg";
						}else{
							$viewName = "/upload/client/".$saveName;
						}

						if($saveName2 == ""){
							$viewName2 = "/html/sample/s1.jpg";
						}else{
							$viewName2 = "/upload/client/".$saveName2;
						}

						$returnVal .= "
							<li>
								".$heartImg."
								<div class=\"sc_photo_wrap\">
									<a href=\"?com=client&lnd=clienthome&SHId=".$SHId."\"><img src=\"".$viewName2."\" alt=\"\" style=\"width:320px;height:240px;\"/></a>
									<div class=\"sc_money\">
										<span>\</span>".number_format($prdPrice)."
									</div>
								</div>

								<img class=\"sc_photo_face\" src=\"".$viewName."\" alt=\"\" style=\"width:60px;height:60px;\"/>

								<p class=\"photo_link\">
									<a href=\"?com=client&lnd=clienthome&SHId=".$SHId."\"><img src=\"/images/new.gif\" alt=\"new\" />".$SHName."</a>
								</p>
								<p class=\"photo_score\">
									신점 전체 · ".$scoreData["totalScore"]."<img src=\"/images/star.gif\" alt=\"\" />· 후기 ".$amCnt."개
								</p>
							</li>
						";
					}
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**검색 결과**/
		public function getApproachSHListM($page="", $setOrder="", $search, $notIdx){
			$returnVal = "";
			$searchQuery = "";
			$this->link = 6;
			if($search["searchSido"] != ""){
				$searchQuery .= " AND SHAddress LIKE '%".$search["searchSido"]." ".$search["searchGun"]." %' AND a.idx not in (".$notIdx.")";
			}

			$startNum = ($page - 1) * $this->link;
			$limitQuery = $searchQuery." GROUP BY SHId order by ".$setOrder." limit ".$startNum." , ".$this->link;
			//$limitQuery = " order by ".$setOrder;

			try{

				$clientTotalCntResult = parent::getSearchSHTotalCnt("",$searchQuery);
				while (list($key, $val) = each($clientTotalCntResult)){
					$clientCnt = $clientTotalCntResult[$key]["clientCnt"];
				}
				$record = $clientCnt;
				$this->searchTotalCnt = $clientCnt;
				$url_file = "/";
				$url_parameter = "#none";
				$this->approachPageView = $this->paging->Link_Search($page,$record,$this->link,$this->linking,$url_file,$url_parameter);

				$clientResult = parent::searchclientMOL("",$limitQuery);
				while (list($key, $val) = each($clientResult)){
					if($notIdx != $clientResult[$key]["SHIdx"]){
						$saveName2 = "";
						$SHId = $clientResult[$key]["SHId"];
						$prdPrice = $clientResult[$key]["prdPrice"];
						$SHName = $clientResult[$key]["SHName"];

						$whereBeen = array(":code" => $SHId."_affter");
						$amTotalCntResult = parent::affterMemoTotalMOL($whereBeen);
						while (list($key_a, $val_a) = each($amTotalCntResult)){
							$amCnt = $amTotalCntResult[$key_a]["amCnt"];
						}

						$wishBeen = array(":SHIdx" => $clientResult[$key]["SHIdx"], ":userId"=>$_SESSION["USER_ID"]);
						$wishCnt = $this->getWishCnt($wishBeen);

						if($wishCnt > 0){
							$heartImg = "<img class=\"sc_heart\" src=\"/images/mobile/ic_heart_on.png\" alt=\"\" />";
						}else{
							if($_SESSION["USER_ID"] != ""){
								$heartImg = "<img class=\"sc_heart\" src=\"/images/mobile/ic_heart.png\" alt=\"\" onclick=\"setListWishH('".$clientResult[$key]["SHIdx"]."');\"/>";
							}else{
								$heartImg = "<img class=\"sc_heart\" src=\"/images/mobile/ic_heart.png\" alt=\"\"/>";
							}
							//$heartImg = "<img class=\"sc_heart\" src=\"/images/mobile/ic_heart.png\" alt=\"\" />";
						}

						$fileData2 = array(":parentId" => $SHId, ":type" => "profile");
						$fileResult = parent::searchFile($fileData2);
						$returnData = "";
						while (list($key, $val) = each($fileResult)){
							$saveName = $fileResult[$key]["saveName"];
						}

						$fileData2 = array(":parentId" => $SHId, ":type" => "client");
						$fileResult = parent::searchFileMain($fileData2);
						$returnData = "";
						$loopIdx = 0;
						while (list($key, $val) = each($fileResult)){
							$saveName2 = $fileResult[$key]["saveName"];
							//break;
						}

					if($saveName2 == ""){
						$fileResult = parent::searchFile($fileData2);
						while (list($key_f, $val_f) = each($fileResult)){
							$saveName2 = $fileResult[$key_f]["saveName"];
							break;
						}
					}

						$scoreData = $this->getAffterScore($SHId."_affter");


						if($saveName == ""){
							$viewName = "/html/sample/sp1.jpg";
						}else{
							$viewName = "/upload/client/".$saveName;
						}

						if($saveName2 == ""){
							$viewName2 = "/html/sample/s1.jpg";
						}else{
							$viewName2 = "/upload/client/".$saveName2;
						}

						$returnVal .= "

							<li>
								".$heartImg."
								<div class=\"sc_photo_wrap\">
									<a href=\"?com=client&lnd=clientHome&SHId=".$SHId."\"><img src=\"".$viewName2."\" alt=\"\" /></a>
									<div class=\"sc_money\">
										<span>￦</span>".number_format($prdPrice)."
									</div>
								</div>

								<button style=\"background: url(".$viewName.") no-repeat; background-size: 60px 60px; \" type=\"button\" class=\"sc_photo_face\"></button>

								<p class=\"photo_link\">
									<a href=\"?com=client&lnd=clientHome&SHId=".$SHId."\">".$SHName."</a>
								</p>
								<p class=\"photo_score\">
									신점 전체 · ".$scoreData["totalScore"]."<img src=\"/images/mobile/star.gif\" alt=\"\" />· 후기 ".$amCnt."개
								</p>
							</li>
						";
					}
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		/**예약 제한 확인**/
		public function resLimitDayCnt($whereBeen, $limitBeen){
			$limitQuery = " AND (startDate <= '".$limitBeen["resDate"]."' AND endDate >= '".$limitBeen["resDate"]."')";
			$resResult = parent::resLimitDayCntMOL($whereBeen, $limitQuery);
			while (list($key, $val) = each($resResult)){
				$limitCnt = $resResult[$key]["limitCnt"];
			}

			$rtnCode = $limitCnt > 0 ? "L" : "F";
			echo $rtnCode;
		}

		/*예약 정보 출력*/
		public function getLimitDayInfoListView($getBeen){
			$limitResult = parent::getLimitInfoList($getBeen);
			$returnData = "";

			while (list($key, $val) = each($limitResult)){
				$startDate = $limitResult[$key]["startDate"];
				$endDate = $limitResult[$key]["endDate"];
				$idx = $limitResult[$key]["idx"];

				$rtnVal = "";

				$returnData .= "<div class=\"fileItem\">".$startDate."~".$endDate." <span class=\"deleteFile\" onclick=\"deleteLimit('".$idx."')\">x</span></div>";
			}
			return $returnData;
		}

		/*예약 정보 출력*/
		public function getLimitDayInfoListView2($getBeen){
			$limitResult = parent::getLimitInfoList($getBeen);
			$returnData = "";

			while (list($key, $val) = each($limitResult)){
				$startDate = $limitResult[$key]["startDate"];
				$endDate = $limitResult[$key]["endDate"];
				$idx = $limitResult[$key]["idx"];

				$rtnVal = "";

				$returnData .= "<div class=\"fileItem\">".$startDate."~".$endDate."</div>";
			}
			return $returnData;
		}

		public function setLimitDayInfo($limitSDate, $limitEDate, $SHIdx){
			$loopCnt = sizeof($limitSDate);
			$limitWhereBeen = array(":SHIdx"=>$SHIdx);
			//parent::emptryLimitDay($limitWhereBeen);
			for($i=0; $i < $loopCnt; $i++){
				$setBeenData = array($SHIdx, $limitSDate[$i], $limitEDate[$i],date("Y-m-d H:i:s"));
				parent::setLimitDay($setBeenData);
			}
		}

		public function deleteLimitDayInfo($whereBeen){
			parent::deleteLimitDayMOL($whereBeen);
		}
	}
?>