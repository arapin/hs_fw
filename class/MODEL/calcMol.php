<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class CalcMOL extends DAO {
		private $logc;
		private $clientInfo;
		private $paymentInfo;
		private $reservationInfo;
		private $aqBoardInfo;
		private $userInfo;
		private $productInfo;
		private $productInfo2;
		private $clientCalc;


		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->clientInfo = new DAO("clientinfo");
			$this->paymentInfo = new DAO("paymentinfo");
			$this->reservationInfo = new DAO("reservationinfo");
			$this->aqBoardInfo = new DAO("aqboardinfo");
			$this->userInfo = new DAO("userinfo");
			$this->productInfo = new DAO("shrelayproinfo");
			$this->productInfo2 = new DAO("productinfo");
			$this->clientCalc = new DAO("clientCalc");
		}

		/**정산내역 리스트**/
		public function calcListMOL($getBeen, $limitQuery){
			$calcResult = $this->clientCalc->selectQuery("calcList", $getBeen, $limitQuery);
			return $calcResult;
		}

		/**정산내역 총 갯수**/
		public function calcTotalListMOL($getBeen, $limitQuery){
			$calcResult = $this->clientCalc->selectQuery("calcTotalList", $getBeen, $limitQuery);
			return $calcResult;
		}
		
		/**정산내역 확인**/
		public function monthCalcCountMOL($getBeen){
			$calcResult = $this->clientCalc->selectQuery("monthCalcCount", $getBeen);
			return $calcResult;
		}

		/**정산 대상 무속인 가져오기**/
		public function paymentCalcclientUserMOL($getBeen, $limitQuery){
			$calcResult = $this->paymentInfo->selectQuery("paymentCalcclientUser", $getBeen, $limitQuery);
			return $calcResult;
		}

		/**무속인 예약 결제 총합 정보**/
		public function clientCalcResTotalInfoMOL($whereBeen, $limitQuery){
			$payResult = $this->paymentInfo->selectQuery("paymentCalcResTotalInfo", $whereBeen, $limitQuery);
			return $payResult;
		}

		/**무속인명 가져오기**/
		public function getclientNameMOL($getBeen){
			$clientResult = $this->clientInfo->selectQuery("getclientName", $getBeen);
			return $clientResult;
		}

		/**무속인명 가져오기**/
		public function modifyclientInfo($getBeen){
			$clientResult = $this->clientInfo->selectQuery("clientModify", $getBeen);
			return $clientResult;
		}

		/**정산내역 입력**/
		public function setclientCalcInfoMOL($setBeen){
			$this->clientCalc->insertQuery("clientCalcInsert",$setBeen);
		}

		/**정산 금액 지급 수정**/
		public function clientCalcStateUpdateMOL($getBeen, $setBeen){
			$this->clientCalc->updateQuery("clientCalcStateUpdate",$setBeen,$getBeen);
		}
	}
?>