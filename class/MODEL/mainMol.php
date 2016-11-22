<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class MainMOL extends DAO {
		private $logc;
		private $mainLocation;
		private $mainBig;
		private $mainMiddle;
		private $fileinfo;
		private $multimedia;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->mainLocation = new DAO("mainLocation");
			$this->mainBig = new DAO("mainBig");
			$this->mainMiddle = new DAO("mainMiddle");
			$this->fileinfo = new DAO("fileinfo");
			$this->multimedia = new DAO("multimedia");
		}

		/*상품 총 레코드*/
		public function mainLocationTotalCnt(){
			$mlResult = $this->mainLocation->selectQuery("mainLoctionTotalCnt");
			return $mlResult;
		}

		/*상품 총 레코드*/
		public function mainBigTotalCnt(){
			$mbResult = $this->mainBig->selectQuery("mainBigTotalCnt");
			return $mbResult;
		}

		/*상품 총 레코드*/
		public function mainMiddleTotalCnt(){
			$mbResult = $this->mainMiddle->selectQuery("mainMiddleTotalCnt");
			return $mbResult;
		}

		/*상품 총 레코드*/
		public function mainMovieTotalCnt(){
			$mmResult = $this->multimedia->selectQuery("multimediaTotalCnt");
			return $mmResult;
		}

		/*상품 총 레코드*/
		public function mainLocationTotalList($bind,$limitQuery){
			$mlResult = $this->mainLocation->selectQuery("mainLoctionList", $bind, $limitQuery);
			return $mlResult;
		}

		/*상품 총 레코드*/
		public function mainBigTotalList($bind,$limitQuery){
			$mbResult = $this->mainBig->selectQuery("mainBigList", $bind, $limitQuery);
			return $mbResult;
		}

		/*상품 총 레코드*/
		public function mainMiddleTotalList($bind,$limitQuery){
			$mbResult = $this->mainMiddle->selectQuery("mainMiddleList", $bind, $limitQuery);
			return $mbResult;
		}

		/*상품 총 레코드*/
		public function mainMovieTotalList($bind,$limitQuery){
			$mmResult = $this->multimedia->selectQuery("multimediaInfoList", $bind, $limitQuery);
			return $mmResult;
		}

		/*상품 총 레코드*/
		public function mainLocationSelectMOL($bind){
			$mlResult = $this->mainLocation->selectQuery("mainLoctionSelect", $bind);
			return $mlResult;
		}

		/*상품 총 레코드*/
		public function mainBigSelectMOL($bind){
			$mbResult = $this->mainBig->selectQuery("mainBigSelect", $bind);
			return $mbResult;
		}

		/*상품 총 레코드*/
		public function mainMiddleSelectMOL($bind){
			$mbResult = $this->mainMiddle->selectQuery("mainMiddleSelect", $bind);
			return $mbResult;
		}

		/*상품 총 레코드*/
		public function mainMovieSelectMOL($bind){
			$mmResult = $this->multimedia->selectQuery("mainMovieSelect", $bind);
			return $mmResult;
		}

		/**게시물 수정**/
		public function updatemainMovieMOL($setBeen, $whereBeen){
			$this->multimedia->updateQuery("multimediaInfoUpdate",$setBeen, $whereBeen);
		}

		/** 등록된 파일 목록 출력 **/
		public function searchFile($bind){
			$fileResult = $this->fileinfo->selectQuery("uploadFileInfoList", $bind);
			return $fileResult;
		}

		public function getMainBigImgMOL($getBeen){
			$mbResult = $this->mainBig->selectQuery("mainBigSelectSeq", $getBeen);
			return $mbResult;
		}

		public function getMainMiddleImgMOL($getBeen){
			$mbResult = $this->mainMiddle->selectQuery("mainMiddleSelectSeq", $getBeen);
			return $mbResult;
		}

		/** 파일 삭제**/
		public function imgDeleteMOL($bind){
			$this->fileinfo->deleteQuery("mainImgDelete",$bind);
		}

		/** 파일 기록용**/
		public function fileInsert($bind){
			$this->fileinfo->insertQuery("uploadFileInfoInsert",$bind);
		}
		
		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>