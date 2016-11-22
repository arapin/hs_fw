<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class ProductMOL extends DAO {
		private $logc;
		private $reservationInfo;
		private $aqBoardInfo;
		private $clientInfo;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
		}

		/*상품 총 레코드*/
		public function productTotalList(){
			$productResult = parent::selectQuery("productInfoTotalCnt");
			return $productResult;
		}
		
		/*관리자 상품 리스트 출력*/
		public function productMngListMOL($bind="", $limitQuery){
			$productResult = parent::selectQuery("productInfoListMng", $bind, $limitQuery);
			return $productResult;
		}

		/*관리자 상품 정보 출력*/
		public function productSelectInfoMOL($getBeen){
			$productResult = parent::selectQuery("productInfoSelect", $getBeen);
			return $productResult;
		}

		/*상품 정보 등록*/
		public function productInfoInsertMOL($setBeen){
			parent::insertQuery("productInfoInsert",$setBeen);
		}

		/*상품 정보 수정*/
		public function productInfoUpdateMOL($setBeen,$whereBeen){
			parent::updateQuery("productInfoUpdate",$setBeen,$whereBeen);
		}

		/*상품 정보 삭제*/
		public function productInfoDeleteMOL($whereBeen){
			parent::deleteQuery("productInfoDelete",$whereBeen);
		}

		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>