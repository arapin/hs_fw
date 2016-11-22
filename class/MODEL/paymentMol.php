<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class PaymentMOL extends DAO {
		private $logc;
		private $reservationInfo;
		private $aqBoardInfo;
		private $clientInfo;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->reservationInfo = new DAO("reservationinfo");
			$this->aqBoardInfo = new DAO("aqboardinfo");
			$this->clientInfo = new DAO("clientinfo");
		}

		/*사용자 결제 리스트 출력*/
		public function paymentUserListMOL($getBeen){
		}

		/*관리자 결제 리스트 출력*/
		public function paymentMngListMOL($bind="", $limitQuery){
			$paymentResult = parent::selectQuery("getPaymentInfoMngList", $bind, $limitQuery);
			return $paymentResult;
		}

		/*결제 총 레코드*/
		public function paymentTotalList($bind="", $limitQuery){
			$paymentResult = parent::selectQuery("paymentTotalCnt",$bind="", $limitQuery);
			return $paymentResult;
		}

		/*결제취소정보*/
		public function paymentInfoCancelMOL($whereBeen){
			$paymentResult = parent::selectQuery("paymentCancelInfo", $whereBeen);
			return $paymentResult;
		}

		/*결제취소*/
		public function paymentCancelMOL($setBeen, $whereBeen){
			parent::updateQuery("paymentInfoUpdate",$setBeen,$whereBeen);
		}

		/*결제처리*/
		public function paymentApplyMOL($setBeen, $whereBeen){
			parent::updateQuery("paymentApplyUpdate",$setBeen,$whereBeen);
		}

		/*결제*/
		public function paymentAddMOL($setBeen){
		}

		/*결제 정보 출력*/
		public function paymentSelectInfoMOL($setBeen,$whereBeen){
			parent::updateQuery("paymentInfoUpdate",$setBeen,$whereBeen);
		}

		/*예약 상태변경*/
		public function reservationCancelMOL($setBeen, $whereBeen){
			$this->reservationInfo->updateQuery("reservationInfoUpdate", $setBeen, $whereBeen);
		}

		/**문의점 상태 수정**/
		public function aqBoardUpadteBoardMOL($setBeen, $whereBeen){
			$this->aqBoardInfo->updateQuery("aqStateUpdate",$setBeen,$whereBeen);
		}

		/*점집 정보 출력*/
		public function clientSelectInfoMOL($getBeen){
			$clientResult = $this->clientInfo->selectQuery("getclientNamePay", $getBeen);
			return $clientResult;
		}

		/*문의점 정보 출력*/
		public function aqBoardSelectInfoMOL($getBeen){
			$aqBoardResult = $this->aqBoardInfo->selectQuery("aqBoardInfoPay", $getBeen);
			return $aqBoardResult;
		}

		/*점집 정보 출력*/
		public function productSelectInfoMOL($getBeen){
			$reservationResult = $this->reservationInfo->selectQuery("getPayProductName", $getBeen);
			return $reservationResult;
		}
		
		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>