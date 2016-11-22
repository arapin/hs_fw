<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/userMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class User extends UserMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("userinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}
		
		/*회원 로그인*/
		public function userLogin($userData, $loginData,$SHId=""){
			try{
				$userResult = parent::searchUser($userData);
				$inputPwd = $loginData["pwd"];
				$inputId = $loginData["id"];

				while (list($key, $val) = each($userResult)){
					$userCnt = $userResult[$key]["userCnt"];
				}

				if($userCnt == 0){
					$clientData = array(":SHId" => $userData[":id"]);

					$clientResult = parent::searchclient2($clientData);

					$inputId = $loginData["id"];
					$inputPwd = $loginData["pwd"];

					while (list($key, $val) = each($clientResult)){
						$clientCnt = $clientResult[$key]["clientCnt"];
					}

					if($clientCnt == 0){
						$msg = "산신각 회원이 아닙니다. 회원가입을 하여 주십시요";
						$com = "user";
						$lnd = "join";
					}else{
						$clientResult = parent::searchclientInfo($clientData);
						while (list($key, $val) = each($clientResult)){
							$id = $clientResult[$key]["SHId"];
							$name = $clientResult[$key]["name"];
							$pwd_user = trim($this->cipher->getDecrypt($clientResult[$key]["SHPwd"]));
						}
						
						if( $inputPwd == $pwd_user){

							if($_SESSION["USER_ID"] != ""){
								$_SESSION = array();
								session_destroy();
							}

							$_SESSION["SH_ID"] = $id;
							$_SESSION["SH_NAME"] = $name;
							$msg = $_SESSION["SH_ID"]." 무속인 회원님 로그인 되었습니다.";
							$com = "index";
							$lnd = "";
						}else{
							$msg = "비밀번호가 틀립니다.";
							$com = "user";
							$lnd = "login";
						}
					}

				}else{
					$userResult = parent::searchUserInfo($userData);
					while (list($key, $val) = each($userResult)){
						$id = $userResult[$key]["id"];
						$pwd_user = trim($this->cipher->getDecrypt($userResult[$key]["pwd"]));
						$name = trim($this->cipher->getDecrypt($userResult[$key]["name"]));
					}

					if( $inputPwd == $pwd_user){

						if($_SESSION["SH_ID"] != ""){
							$_SESSION = array();
							session_destroy();
						}

						$_SESSION["USER_ID"] = $id;
						$_SESSION["USER_NAME"] = $name;
						$msg = $_SESSION["USER_ID"]." 회원님 로그인 되었습니다.";
						$com = "index";
						$lnd = "";
						$logData = array("L", $_SERVER["REMOTE_ADDR"], $id."-로그인", date("Y-m-d H:i:s"), $id);
						parent::logInsert($logData);
					}else{
						$msg = "비밀번호가 틀립니다.";
						$com = "user";
						$lnd = "login";
					}
				}
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$msg = "시스템 오류입니다. 로그인을 다시 시도하여 주십시요";
				$com = "user";
				$lnd = "login";
			}
			
			if($SHId == ""){
				$this->common->finalMove("lnd",$msg,$com,$lnd);
			}else{
				$this->common->finalMove("lnd",$msg,"client","clienthome","&SHId=".$SHId);
			}
		}
		
		/*회원가입*/
		public function userInsert($userData){
			try{
				$userData[1] = $this->cipher->getEncrypt($userData[1]);
				$userData[2] = $this->cipher->getEncrypt($userData[2]);
				$userData[7] = $this->cipher->getEncrypt($userData[7]);
				$userData[8] = $this->cipher->getEncrypt($userData[8]);
				$userData[9] = $this->cipher->getEncrypt($userData[9]);
				$userData[10] = $this->cipher->getEncrypt($userData[10]);
				$userData[11] = $this->cipher->getEncrypt($userData[11]);
				$userData[12] = $this->cipher->getEncrypt($userData[12]);
				parent::joinUser($userData);
				$logData = array("J", $_SERVER["REMOTE_ADDR"], $userData[0]."-회원가입", date("Y-m-d H:i:s"), $userData[0]);
				parent::logInsert($logData);
				$this->common->finalMove("lnd","회원가입 되셨습니다.","user","login");
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","user","join");
			}
		}

		public function userInsertMng($userData){
			try{
				$userData[1] = $this->cipher->getEncrypt($userData[1]);
				$userData[2] = $this->cipher->getEncrypt($userData[2]);
				$userData[7] = $this->cipher->getEncrypt($userData[7]);
				$userData[8] = $this->cipher->getEncrypt($userData[8]);
				$userData[9] = $this->cipher->getEncrypt($userData[9]);
				$userData[10] = $this->cipher->getEncrypt($userData[10]);
				$userData[11] = $this->cipher->getEncrypt($userData[11]);
				$userData[12] = $this->cipher->getEncrypt($userData[12]);
				parent::joinUser($userData);
				$this->common->finalMoveMng("lnd","회원등록 되었습니다.","user","list");
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","user","list");
			}
		}
		
		/*회원수정 정보 추출*/
		public function userModifyInfo($userData){
			try{
				$userResult = parent::modifyUserInfo($userData);
				$returnData = array();
				while (list($key, $val) = each($userResult)){
					$returnData["id"] = $userResult[$key]["id"];
					$returnData["pwd"] = $userResult[$key]["pwd"];
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

				parent::modifyUser($userData,$whereData);
				$logData = array("M", $_SERVER["REMOTE_ADDR"], $whereData[":id"]."-회원정보 수정", date("Y-m-d H:i:s"), $whereData[":id"]);
				parent::logInsert($logData);
				$this->common->finalMove("lnd","회원정보가 수정 되셨습니다.","user","modify");
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","user","modify");
			}
		}

		public function userModifyMng($userData, $whereData){
			try{
				$userData[0] = $this->cipher->getEncrypt($userData[0]);
				$userData[4] = $this->cipher->getEncrypt($userData[4]);
				$userData[5] = $this->cipher->getEncrypt($userData[5]);
				$userData[6] = $this->cipher->getEncrypt($userData[6]);
				$userData[7] = $this->cipher->getEncrypt($userData[7]);
				$userData[8] = $this->cipher->getEncrypt($userData[8]);
				$userData[9] = $this->cipher->getEncrypt($userData[9]);

				parent::modifyUser($userData,$whereData);
				$this->common->finalMoveMng("lnd","회원정보가 수정 되었습니다.","user","modify","&id=".$whereData[":id"]);
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","user","modify");
			}
		}

		/*회원정보 리스트*/
		public function userListMng($page="", $setOrder="", $search=""){
			$returnVal = "";
			$searchQuery = "";

			if($search["searchType"] != ""){
				if($search["searchType"] == "name"){
					$searchQuery .= " AND name = '".$this->cipher->getEncrypt($search["searchWord"])."'";
				}else if($search["searchType"] == "id"){
					$searchQuery .= " AND id LIKE '%".$search["searchWord"]."%'";
				}
			}

			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = $searchQuery."order by ".$setOrder;

			try{

				$userTotalCntResult = parent::userTotalList("",$limitQuery);
				while (list($key, $val) = each($userTotalCntResult)){
					$userCnt = $userTotalCntResult[$key]["userCnt"];
				}
				$record = $userCnt;
				/*$url_file = "/";
				$url_parameter = "com=user&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$userResult = parent::userList("",$limitQuery);
				while (list($key, $val) = each($userResult)){
					$name		=  $userResult[$key]["name"];
					$id			=  $userResult[$key]["id"];
					$birthday	=  $userResult[$key]["birthday"];
					$email		=  trim($this->cipher->getDecrypt($userResult[$key]["email"]));
					$name		=  trim($this->cipher->getDecrypt($userResult[$key]["name"]));
					$phone		=  trim($this->cipher->getDecrypt($userResult[$key]["phone"]));
					$writeDate	=  $userResult[$key]["writeDate"];
					//$viewBirthday = substr($birthday,0,4)."-".substr($birthday,4,2)."-".substr($birthday,6,2);
					//$viewPhone = substr($phone,0,3)."-".substr($phone,3,4)."-".substr($phone,7,4);

					$returnVal .= "<tr>
						<td>".$record."</td>
						<td style=\"text-transform:none;\">".$id."</td>
						<td>".$name."</td>
						<td><span class=\"date\">".$birthday	."</span></td>
						<td>".$phone."</td>
						<td><span class=\"date\">".$writeDate."</span></td>
						<td>
							<a class=\"btn btn-info\" href=\"#\" onclick=\"modifyMng('".$id."');\"><i class=\"halflings-icon white edit\"></i></a>
							<a class=\"btn btn-danger\" href=\"#\" onclick=\"deleteMng('".$id."');\"><i class=\"halflings-icon white trash\"></i></a>
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

		/*회원 아이디 체크*/
		public function userIdCheck($idString){
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

			$clientData = array(":SHId" => $idString);
			$clientResult = parent::searchclient($clientData);

			while (list($key, $val) = each($clientResult)){
				$clientCnt = $clientResult[$key]["clientCnt"];
			}

			if($clientCnt > 0) {
				return "04"; //이미 존재하는 아이디 입니다.
				exit;
			}

			return "00";
		}
		
		/*회원 삭제*/
		public function userDeleteMng($whereData){
			try{
				parent::deleteUser($whereData);
				$this->common->finalMoveMng("lnd","회원정보가 삭제 되셨습니다.","user","list");
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","user","modify");
			}
		}

		/*회원 삭제*/
		public function userDelete($setBeen, $whereData){
			try{
				$setBeen[1] = $this->cipher->getEncrypt($setBeen[1]);
				parent::withoutUser($setBeen);
				parent::deleteUser($whereData);
				session_destroy();
				$this->common->finalMove("lnd","탈퇴 처리 되셨습니다.","index","");
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","user","modify");
			}
		}

		public function userAuthNumCreate($phone){
			$authNum = $this->common->getAuthNum(4);
			/*휴대폰 발송*/

			return $authNum;
		}

		/**회원 아이디 찾기**/
		public function userIdSearch($whereBeen){
			$whereBeen[":name"] = $this->cipher->getEncrypt($whereBeen[":name"]);
			$whereBeen[":email"] = $this->cipher->getEncrypt($whereBeen[":email"]);
			$userResult = parent::userIdSearchMOL($whereBeen);
			while (list($key, $val) = each($userResult)){
				$id = $userResult[$key]["id"];
			}

			if($id == ""){
				return "99";
			}else{
				return $id;
			}
		}

		/**회원 아이디 찾기**/
		public function userPwdSearch($whereBeen){
			$whereBeen[":name"] = $this->cipher->getEncrypt($whereBeen[":name"]);
			$whereBeen[":email"] = $this->cipher->getEncrypt($whereBeen[":email"]);
			$userResult = parent::userPwdSearchMOL($whereBeen);
			while (list($key, $val) = each($userResult)){
				$pwd = $userResult[$key]["pwd"];
			}

			if($pwd == ""){
				return "99";
			}else{
				return trim($this->cipher->getDecrypt($pwd));
			}
		}
	}
?>