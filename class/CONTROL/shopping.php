<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/shoppingMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class Shopping extends ShoppingMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $morBtn="";
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
	}
?>