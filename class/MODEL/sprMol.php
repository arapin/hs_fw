<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class SprMOL extends DAO {
		private $logc;
		private $product;


		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->product = new DAO("productinfo");
		}

		/** 등록된 상품정보 출력 **/
		public function searchSpr($bind){
			$sprResult = parent::selectQuery("sprInfoList", $bind);
			return $sprResult;
		}

		/** 등록된 상품정보 출력 **/
		public function searchProduct(){
			$productResult = $this->product->selectQuery("productInfoList");
			return $productResult;
		}

		/** 상품정보 등록 **/
		public function setProduct($setBeen){
			parent::insertQuery("sprInfoInsert", $setBeen);
		}

		/*상품 삭제*/
		public function deleteProductInfo($whereBind){
			parent::deleteQuery("sprInfoDelete", $whereBind);
		}

		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>