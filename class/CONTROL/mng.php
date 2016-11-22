<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/mngMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class Mng extends MngMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $link = "20";
		public $linking = "10";
		
		/*생성자*/
		public function __construct() {
			parent:: __construct("managerinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}
		
		/*회원 로그인*/
		public function mngLogin($mngData, $loginData){
			try{
				$mngResult = parent::searchMng($mngData);
				$inputPwd = $loginData["mngPwd"];
				$inputId = $loginData["mngId"];

				while (list($key, $val) = each($mngResult)){
					$mngCnt = $mngResult[$key]["mngCnt"];
				}

				if($mngCnt == 0){
					$msg = "산신각 관리자가 아닙니다.";
					$this->common->finalMoveMng("lnd",$msg,"mng","login");
					exit;

				}else{
					$mngResult = parent::searchMngInfo($mngData);
					while (list($key, $val) = each($mngResult)){
						$id = $mngResult[$key]["mngId"];
						$level = $mngResult[$key]["mngLevel"];
						$pwdMng = trim($this->cipher->getDecrypt($mngResult[$key]["mngPwd"]));
					}
					if( $inputPwd == $pwdMng){
						$_SESSION["ADMIN_ID"] = $id;
						$_SESSION["ADMIN_LEVEL"] = $level;
						$msg = $_SESSION["ADMIN_ID"]." 관리자님 로그인 되었습니다.";
						$com = "user";
						$lnd = "list";
						$logData = array("AL", $_SERVER["REMOTE_ADDR"], $id." 관리자-로그인", date("Y-m-d H:i:s"), $id);
						parent::logInsert($logData);
					}else{
						$msg = "비밀번호가 틀립니다.";
						$this->common->finalMoveMng("lnd",$msg,"mng","login");
						exit;
					}
				}
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$msg = "시스템 오류입니다. 로그인을 다시 시도하여 주십시요";
				$this->common->finalMoveMng("lnd",$msg,"mng","login","","");
				exit;
			}

			$this->common->finalMoveMng("lnd",$msg,$com,$lnd);
		}
		
		/*관리자등록*/
		public function mngInsert($mngData){
			try{
				$mngData[1] = $this->cipher->getEncrypt($mngData[1]);
				$mngData[2] = $this->cipher->getEncrypt($mngData[2]);
				parent::joinMng($mngData);
				$this->common->finalMoveMng("lnd","관리자가 등록 되었습니다.","mng","list");
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","user","join");
			}
		}
		
		/*관리자수정 정보 추출*/
		public function mngModifyInfo($mngData){
			try{
				$mngResult = parent::modifyMngInfo($mngData);
				$returnData = array();
				while (list($key, $val) = each($mngResult)){
					$returnData["mngId"] = $mngResult[$key]["mngId"];
					$returnData["mngLevel"] = $mngResult[$key]["mngLevel"];
					$returnData["mngName"] = trim($this->cipher->getDecrypt($mngResult[$key]["mngName"]));
					$returnData["mngPwd"] = trim($this->cipher->getDecrypt($mngResult[$key]["mngPwd"]));
				}
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
			}

			return $returnData;
		}
		
		/*관리자정보 수정*/
		public function mngModify($mngData, $whereData){
			try{
				$mngData[1] = $this->cipher->getEncrypt($mngData[1]);
				$mngData[2] = $this->cipher->getEncrypt($mngData[2]);
				parent::modifyMng($mngData,$whereData);
				$this->common->finalMoveMng("lnd","관리자정보가 수정 되었습니다.","mng","modify","&idx=".$whereData[":idx"]);
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","user","modify");
			}
		}

		/*관리자 리스트*/
		public function mngUserList($page="", $setOrder=""){
			$returnVal = "";
			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{
				$mngTotalCntResult = parent::mngTotalList();
				while (list($key, $val) = each($mngTotalCntResult)){
					$mngCnt = $mngTotalCntResult[$key]["mngCnt"];
				}
				$record = $mngCnt;
				/*$url_file = "/";
				$url_parameter = "com=mng&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$mngResult = parent::mngList("",$limitQuery);
				while (list($key, $val) = each($mngResult)){
					$idx	=  $mngResult[$key]["idx"];
					$mngName =  trim($this->cipher->getDecrypt($mngResult[$key]["mngName"]));
					$mngId	=  $mngResult[$key]["mngId"];
					$writeDate	=  $mngResult[$key]["writeDate"];

					$returnVal .= "
					<tr>
						<td>".$record."</td>
						<td style=\"text-transform:none;\">".$mngId."</td>
						<td>".$mngName."</td>
						<td><span class=\"date\">".$writeDate."</span></td>
						<td>
							<a class=\"btn btn-info\" href=\"#\" onclick=\"modifyMng('".$idx."');\"><i class=\"halflings-icon white edit\"></i></a>
							<a class=\"btn btn-danger\" href=\"#\" onclick=\"deleteMng('".$idx."');\"><i class=\"halflings-icon white trash\"></i></a>
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

		/*회원 아이디 체크*/
		public function mngIdCheck($idString){
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
			
			$mngData = array(":mngId" => $idString);
			$mngResult = parent::searchMng($mngData);

			while (list($key, $val) = each($mngResult)){
				$mngCnt = $mngResult[$key]["mngCnt"];
			}

			if($mngCnt > 0) {
				return "04"; //이미 존재하는 아이디 입니다.
				exit;
			}

			return "00";
		}

		/*관리자정보 삭제*/
		public function mngInfoDelete($whereData){
			try{
				parent::mngDelete($whereData);
				$this->common->finalMoveMng("lnd","관리자정보가 삭제 되었습니다.","mng","list");
			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMove("lnd","시스템 오류입니다.","user","modify");
			}
		}
	}
?>