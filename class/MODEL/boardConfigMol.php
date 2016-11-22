<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class BoardConfigMOL extends DAO {
		private $logc;
		private $clientInfo;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->clientInfo = new DAO("clientinfo");
		}

		/*사용자 게시판 메뉴 출력*/
		public function bcUserListMOL($getBeen){
		}

		/*관리자 게시판 관리 리스트 출력*/
		public function bcMngListMOL($bind="", $limitQuery){
			$bcResult = parent::selectQuery("bcInfoMngList", $bind, $limitQuery);
			return $bcResult;
		}

		/** 게시판 관리 총 ROW 출력 **/
		public function bcTotalListMOL(){
			$bcResult = parent::selectQuery("bcTotalCnt");
			return $bcResult;
		}

		/**게시판 관리 등록**/
		public function bcInsertBoardMOL($setBeen){
			parent::insertQuery("bcInfoInsert", $setBeen);
		}

		/**게시판 관리 수정**/
		public function bcUpadteBoardMOL($setBeen, $whereBeen){
			parent::updateQuery("bcInfoUpdate",$setBeen,$whereBeen);
		}

		/**게시판 관리 삭제**/
		public function bcDeleteBoardMOL(){
		}

		/**게시판 관리자 검색**/
		public function ownerIdCheckMOL($getBeen){
			$clientResult = $this->clientInfo->selectQuery("clientCnt", $getBeen);
			return $clientResult;
		}

		/**게시판 정보 수정 추출**/
		public function bcModifyInfoMOL($getBeen){
			$bcResult = parent::selectQuery("bcInfoSelect",$getBeen);
			return $bcResult;
		}
		
		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>