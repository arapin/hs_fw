<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class FileMOL extends DAO {
		private $logc;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
		}
		
		/** 파일등록 **/
		public function insertFile($bind){
			parent::insertQuery("uploadFileInfoInsert",$bind);
		}

		/** 등록된 파일 목록 출력 **/
		public function searchFile($bind){
			$fileResult = parent::selectQuery("uploadFileInfoList", $bind);
			return $fileResult;
		}

		/** 등록된 파일 정보 출력 **/
		public function uploadFileInfo($bind){
			$fileResult = parent::selectQuery("uploadFileInfo", $bind);
			return $fileResult;
		}

		/** 파일 삭제 **/
		public function deleteFileInfo($whereBind){
			parent::deleteQuery("fileInfoDelete", $whereBind);
		}

		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>