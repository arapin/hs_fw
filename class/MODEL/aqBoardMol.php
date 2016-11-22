<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class aqBoardMOL extends DAO {
		private $logc;
		private $clientInfo;
		private $paymentInfo;
		private $productInfo;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->clientInfo = new DAO("clientinfo");
			$this->paymentInfo = new DAO("paymentinfo");
			$this->productInfo = new DAO("productinfo");
		}

		/*신점 문의 리스트 출력*/
		public function bcUserListMOL($getBeen){
		}

		/*관리자 신점 문의 리스트 출력*/
		public function aqBoardListMOL($bind="", $limitQuery){
			$aqBoardResult = parent::selectQuery("aqBoardInfoList", $bind, $limitQuery);
			return $aqBoardResult;
		}

		/*관리자 신점 문의 리스트 출력*/
		public function aqBoardListMngMOL($bind="", $limitQuery){
			$aqBoardResult = parent::selectQuery("aqBoardInfoListMng", $bind, $limitQuery);
			return $aqBoardResult;
		}

		/** 신점 문의 관리 총 ROW 출력 **/
		public function aqBoardTotalListMOL(){
			$aqResult = parent::selectQuery("aqBoardTotalCnt");
			return $aqResult;
		}

		/** 신점 문의 관리 총 ROW 출력 **/
		public function aqBoardTotalListMngMOL(){
			$aqResult = parent::selectQuery("aqBoardTotalCntMng");
			return $aqResult;
		}

		/**신점 문의 정보 수정 추출**/
		public function aqBoardInfoMOL($getBeen){
			$aqBoardResult = parent::selectQuery("aqBoardInfoSelect",$getBeen);
			return $aqBoardResult;
		}

		/**신점 문의 답변 정보 추출**/
		public function aqBoardAnswerInfoMOL($getBeen){
			$aqBoardResult = parent::selectQuery("aqBoardAnswerInfo",$getBeen);
			return $aqBoardResult;
		}

		/**문의점 상태 수정**/
		public function aqBoardUpadteBoardMOL($setBeen, $whereBeen){
			parent::updateQuery("bcInfoUpdate",$setBeen,$whereBeen);
		}

		/*결제 정보 출력*/
		public function paymentSelectInfoMOL($getBeen){
			$paymentResult = $this->paymentInfo->selectQuery("paymentCancelInfo", $getBeen);
			return $paymentResult;
		}

		/*상품 정보 출력*/
		public function productSelectInfoMOL($getBeen){
			$productResult = $this->productInfo->selectQuery("productInfoSelect", $getBeen);
			return $productResult;
		}

		/*상품 셀렉트 출력*/
		public function productSelectInfoQuestionMOL(){
			$productResult = $this->productInfo->selectQuery("productInfoListQuestion");
			return $productResult;
		}

		/**신점문의 정보 입력**/
		public function aqBoardInsertMOL($setBeen){
			parent::insertQuery("aqBoardInfoInsert",$setBeen);
		}
		
		/**결제정보 입력**/
		public function paymentInfoInsert($setBeen){
			return $this->paymentInfo->insertQuery("paymentInfoInsert",$setBeen);
		}

		/**결제정보 입력**/
		public function aqBoardUpdateMOL($setBeen, $whereBeen){
			return parent::updateQuery("aqBoardInfoUpdate",$setBeen, $whereBeen);
		}
		
		/**답변 등록**/
		public function aqBoardAnswerMOL($setBeen){
			parent::insertQuery("aqBoardAnswerInsert", $setBeen);
		}

		/**게시물 상태 변경**/
		public function aqBoardStatusUpdateMOL($setBeen, $whereBeen){
			parent::updateQuery("aqStateUpdateUser", $setBeen, $whereBeen);
		}

		/*답변 총 갯수 출력*/
		public function aqBoardtInfoAnswerCntMOL($getBeen){
			$aqResult = parent::selectQuery("aqBoardAnswerTotalCntMng", $getBeen);
			return $aqResult;
		}

		/*답변 리스트*/
		public function aqBoardtInfoAnswerListMOL($getBeen){
			$aqResult = parent::selectQuery("aqBoardAnswerList", $getBeen);
			return $aqResult;
		}

		/*유저 답변 총 갯수 출력*/
		public function aqBoardtUserInfoAnswerCntMOL($getBeen){
			$aqResult = parent::selectQuery("aqBoardUserAnswerTotalCntMng", $getBeen);
			return $aqResult;
		}

		/**답변 삭제**/
		public function aqBoardAnswerInfoDeleteMOL($whereBeen){
			parent::deleteQuery("aqInfoDelete", $whereBeen);
		}

		/****/
		public function aqBoardAnswerChoiceMOL($setBeen, $whereBeen){
			parent::updateQuery("aqChoiceUpdateUser",$setBeen, $whereBeen);
		}

		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>