<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class MainMOL extends DAO {
		private $logc;
		private $mainLocation;
		private $fileinfo;
		private $multimedia;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->mainLocation = new DAO("mainLocation");
			$this->fileinfo = new DAO("fileinfo");
			$this->multimedia = new DAO("multimedia");
		}

		/*상품 총 레코드*/
		public function mainLocationTotalCnt(){
			$mlResult = $this->mainLocation->selectQuery("mainLoctionTotalCnt");
			return $mlResult;
		}

		/*상품 총 레코드*/
		public function mainLocationTotalList($bind,$limitQuery){
			$mlResult = $this->mainLocation->selectQuery("mainLoctionList", $bind, $limitQuery);
			return $mlResult;
		}

		/*상품 총 레코드*/
		public function mainLocationSelectMOL($bind){
			$mlResult = $this->mainLocation->selectQuery("mainLoctionSelect", $bind);
			return $mlResult;
		}

		/** 등록된 파일 목록 출력 **/
		public function searchFile($bind){
			$fileResult = $this->fileinfo->selectQuery("uploadFileInfoList", $bind);
			return $fileResult;
		}

		/** 파일 삭제**/
		public function imgDeleteMOL($bind){
			$this->fileinfo->deleteQuery("mainImgDelete",$bind);
		}

		/** 파일 기록용**/
		public function fileInsert($bind){
			$this->fileinfo->insertQuery("uploadFileInfoInsert",$bind);
		}

		/*상품 총 레코드*/
		public function mainMovieTotalCnt(){
			$mmResult = $this->multimedia->selectQuery("multimediaTotalCnt");
			return $mmResult;
		}

		/*상품 총 레코드*/
		public function mainMovieTotalList($bind,$limitQuery){
			$mmResult = $this->multimedia->selectQuery("multimediaInfoList", $bind, $limitQuery);
			return $mmResult;
		}
		
		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>