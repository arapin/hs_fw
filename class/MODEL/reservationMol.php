<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class ReservationMOL extends DAO {
		private $logc;
		private $productInfo;
		private $paymentInfo;
		private $clientInfo;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->productInfo = new DAO("shrelayproinfo");
			$this->paymentInfo = new DAO("paymentinfo");
			$this->clientInfo = new DAO("clientinfo");
		}

		/*사용자 예약 리스트 출력*/
		public function reservationUserListMOL($getBeen){
		}

		/*관리자 예약 리스트 출력*/
		public function reservationMngListMOL($bind="", $limitQuery){
			$resResult = parent::selectQuery("reservationInfoMngList", $bind, $limitQuery);
			return $resResult;
		}

		/** 예약 총 ROW 출력 **/
		public function resTotalList($bind="", $limitQuery){
			$resResult = parent::selectQuery("reservationTotalCnt", $bind, $limitQuery);
			return $resResult;
		}

		/*예약취소정보*/
		public function reservationInfoCancelMOL($whereBeen){
			$resResult = parent::selectQuery("reservationCancelInfo", $whereBeen);
			return $resResult;
		}

		/*예약정보*/
		public function reservationInfoViewMOL($whereBeen){
			$resResult = parent::selectQuery("reservationInfoView", $whereBeen);
			return $resResult;
		}
		
		/*예약취소*/
		public function reservationCancelMOL($setBeen, $whereBeen){
			parent::updateQuery("reservationInfoUpdate",$setBeen, $whereBeen);
		}

		/*예약*/
		public function reservationInfoAddMOL($setBeen){
		}

		/*상품 정보 출력*/
		public function productSelectInfoMOL($getBeen){
			$productResult = $this->productInfo->selectQuery("sprSelectInfo", $getBeen);
			return $productResult;
		}

		/*점집 정보 출력*/
		public function clientSelectInfoMOL($getBeen){
			$clientResult = $this->clientInfo->selectQuery("getclientName", $getBeen);
			return $clientResult;
		}

		/*결제 정보 출력*/
		public function paymentSelectInfoMOL($getBeen){
			$paymentResult = $this->paymentInfo->selectQuery("paymentCancelInfo", $getBeen);
			return $paymentResult;
		}

		/*결제 취소*/
		public function paymentCancelMOL($setBeen, $whereBeen){
			$this->paymentInfo->updateQuery("paymentInfoUpdate",$setBeen,$whereBeen);
		}
		
		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>