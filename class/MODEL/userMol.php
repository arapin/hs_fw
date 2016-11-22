<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class UserMOL extends DAO {
		private $logc;
		private $userWithoutInfo;
		private $clientInfo;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->userWithoutInfo = new DAO("userwithoutinfo");
			$this->clientInfo = new DAO("clientinfo");
		}
		
		/** 회원가입 **/
		public function joinUser($bind){
			parent::insertQuery("userInfoInsert",$bind);
		}

		/** 회원가입 여부 확인 **/
		public function searchUser($bind){
			$userResult = parent::selectQuery("userCnt", $bind);
			return $userResult;
		}

		/** 로그인 회원정보 조회 **/
		public function searchUserInfo($bind){
			$userResult = parent::selectQuery("userLogin", $bind);
			return $userResult;
		}

		/** 회원정보 수정 회원정보 조회 **/
		public function modifyUserInfo($bind){
			$userResult = parent::selectQuery("userModify", $bind);
			return $userResult;
		}

		/** 회원정보 수정**/
		public function modifyUser($bind, $whereBind){
			parent::updateQuery("userInfoUpdate",$bind,$whereBind);
		}

		/** 회원 리스트 출력 **/
		public function userList($bind="", $limitQuery){
			$userResult = parent::selectQuery("userList", $bind, $limitQuery);
			return $userResult;
		}

		/** 회원 총 ROW 출력 **/
		public function userTotalList($bind="", $limitQuery){
			$userResult = parent::selectQuery("userTotalCnt",$bind, $limitQuery);
			return $userResult;
		}

		/** 회원 삭제 **/
		public function deleteUser($whereBind){
			parent::deleteQuery("userInfoDelete", $whereBind);
		}

		/** 아이디 찾기 **/
		public function userIdSearchMOL($whereBeen){
			$userResult = parent::selectQuery("userIdSearch", $whereBeen);
			return $userResult;
		}

		/** 아이디 찾기 **/
		public function userPwdSearchMOL($whereBeen){
			$userResult = parent::selectQuery("userPwdSearch", $whereBeen);
			return $userResult;
		}

		/** 회원탈퇴 정보 입력 **/
		public function withoutUser($bind){
			$this->userWithoutInfo->insertQuery("userWithoutInfoInsert",$bind);
		}

		/** 회원탈퇴 아이디 조회 입력 **/
		public function withoutSearchIdMOL($whereBeen){
			$userResult = $this->userWithoutInfo->selectQuery("searchIdWithout",$whereBeen);
			return $userResult;
		}

		/** 점집 로그인 회원정보 유무 **/
		public function searchclient($bind){
			$clientResult = $this->clientInfo->selectQuery("clientJoinCnt", $bind);
			return $clientResult;
		}

		/** 점집 로그인 회원정보 유무 **/
		public function searchclient2($bind){
			$clientResult = $this->clientInfo->selectQuery("clientCnt", $bind);
			return $clientResult;
		}

		/** 점집 로그인 회원정보 정보 **/
		public function searchclientInfo($bind){
			$clientResult = $this->clientInfo->selectQuery("clientLoginInfo", $bind);
			return $clientResult;
		}

		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>