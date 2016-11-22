<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class MngMol extends DAO {
		private $logc;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
		}
		
		/** 관리자등록 **/
		public function joinMng($bind){
			parent::insertQuery("managerInfoInsert",$bind);
		}

		/** 관리자등록 여부 확인 **/
		public function searchMng($bind){
			$userResult = parent::selectQuery("managerCnt", $bind);
			return $userResult;
		}

		/** 로그인 관리자정보 조회 **/
		public function searchMngInfo($bind){
			$userResult = parent::selectQuery("managerLogin", $bind);
			return $userResult;
		}

		/** 관리자정보 수정 관리자정보 조회 **/
		public function modifyMngInfo($bind){
			$mngResult = parent::selectQuery("managerModify", $bind);
			return $mngResult;
		}

		/** 관리자정보 수정**/
		public function modifyMng($bind, $whereBind){
			parent::updateQuery("managerInfoUpdate",$bind,$whereBind);
		}

		/** 관리자 리스트 출력 **/
		public function mngList($bind="", $limitQuery){
			$mngResult = parent::selectQuery("managerList", $bind, $limitQuery);
			return $mngResult;
		}

		/** 관리자 총 ROW 출력 **/
		public function mngTotalList(){
			$mngResult = parent::selectQuery("managerTotalCnt");
			return $mngResult;
		}

		/** 관리자 삭제 **/
		public function mngDelete($whereBind){
			parent::deleteQuery("managerInfoDelete", $whereBind);
		}

		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>