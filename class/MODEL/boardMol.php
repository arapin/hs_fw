<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class BoardMOL extends DAO {
		private $logc;
		private $file;
		private $boardMemo;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->file = new DAO("fileinfo");
			$this->boardMemo = new DAO("boardmemo");
		}

		/**게시물 예약 총갯수**/
		public function getBoardCntMOL($getBeen, $limitQuery){
			$rtnResult = parent::selectQuery("boardTotalCnt",$getBeen, $limitQuery);
			return $rtnResult;
		}

		/**게시물 리스트**/
		public function getBoardListMOL($bind="", $limitQuery){
			$rtnResult = parent::selectQuery("boardInfoList",$bind, $limitQuery);
			return $rtnResult;
		}
		
		/**게시물 thread 가져오기**/
		public function getBoardThreadMOL($getBeen){
			$rtnResult = parent::selectQuery("getBoardThread",$getBeen);
			return $rtnResult;
		}

		/**게시물 정보 가져오기**/
		public function getBoardInfoMOL($getBeen){
			$rtnResult = parent::selectQuery("boardInfoSelect",$getBeen);
			return $rtnResult;
		}

		/**게시물 등록**/
		public function setBoardDataMOL($setBeen){
			parent::insertQuery("boardInfoInsert",$setBeen);
		}

		/**게시물 수정**/
		public function updateBoardMOL($setBeen, $whereBeen){
			parent::updateQuery("boardInfoUpdate",$setBeen, $whereBeen);
		}

		/**게시물 수정**/
		public function updateBoardFrontMOL($setBeen, $whereBeen){
			parent::updateQuery("boardInfoUpdateFront",$setBeen, $whereBeen);
		}

		public function deleteBoardMOL($whereBeen){
			parent::deleteQuery("boardInfoDelete",$whereBeen);
		}

		/**댓글 등록**/
		public function setBoardMemoInfoMOL($setBeen){
			$this->boardMemo->insertQuery("boardMemoInfoInsert",$setBeen);
		}

		/**댓글 총갯수**/
		public function getBoardMemoCntMOL($getBeen){
			$rtnResult = $this->boardMemo->selectQuery("boardMemoTotalCntMng",$getBeen);
			return $rtnResult;
		}

		/**댓글 리스트**/
		public function getBoardMemoListMOL($getBeen){
			$rtnResult = $this->boardMemo->selectQuery("boardMemoInfoList",$getBeen);
			return $rtnResult;
		}

		/**댓글 수정**/
		public function updateBoardMemoInfoMOL($setBeen, $whereBeen){
			$this->boardMemo->updateQuery("boardMemoInfoUpdate",$setBeen, $whereBeen);
		}

		/**댓글 삭제**/
		public function deleteBoardMemoInfoMOL($whereBeen){
			$this->boardMemo->deleteQuery("boardMemoDelete", $whereBeen);
		}
		
		/**댓글 전체삭제**/
		public function deleteMemoTotalMOL($whereBeen){
			$this->boardMemo->deleteQuery("boardMemoDeleteTotal", $whereBeen);
		}

		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}

	}
?>