<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class ShoppingMOL extends DAO {
		private $logc;
		private $userInfo;


		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->userInfo = new DAO("userinfo");
		}

		/** 회원정보 수정 회원정보 조회 **/
		public function modifyUserInfo($bind){
			$userResult = $this->userInfo->selectQuery("userModify", $bind);
			return $userResult;
		}

	}
?>