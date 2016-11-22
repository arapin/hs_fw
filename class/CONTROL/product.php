<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/productMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";

	class Product extends ProductMOL {
		private $cipher;
		private $common;
		
		/*생성자*/
		public function __construct() {
			parent:: __construct("productinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
		}
		
		/*상품정보 리스트 출력*/
		public function getProductInfoList($page="", $setOrder){

			$returnVal = "";

			$startNum = ($page - 1) * $this->link;
			$limitQuery = "order by ".$setOrder;


			$productTotalCntResult = parent::productTotalList();
			while (list($key, $val) = each($productTotalCntResult)){
				$productCnt = $productTotalCntResult[$key]["productCnt"];
			}
			$record = $productCnt;
			$productResult = parent::productMngListMOL("",$limitQuery);

			while (list($key, $val) = each($productResult)){
					$idx = $productResult[$key]["idx"];
					$proName = $productResult[$key]["proName"];
					$proPrice = $productResult[$key]["proPrice"];
					$returnVal .= "<tr>
						<td>".$record."</td>
						<td>".$proName."</td>
						<td>".number_format($proPrice)."원</td>
						<td><span class=\"date\">".$productResult[$key]["regDate"]."</span></td>
						<td>
							<a href=\"#none\" class=\"edit\" onclick=\"modifyMng('".$idx."');\"><i class=\"fa fa-pencil\"></i></a>
							<a href=\"#none\" class=\"delete\" onclick=\"deleteMng('".$idx."');\"><i class=\"fa fa-times\"></i></a>
						</td>
					</tr>";
					$record--;
			}
			return $returnVal;
		}

		/*상품정보 출력*/
		public function getProductInfoListView($getBeen){
			$productResult = parent::productSelectInfoMOL($getBeen);
			$returnData = "";

			while (list($key, $val) = each($productResult)){
				$returnData["proName"] = $productResult[$key]["proName"];
				$returnData["proPrice"] = $productResult[$key]["proPrice"];
			}
			return $returnData;
		}
		
		/*상품 등록*/
		public function addProduct($setBeen){
			parent::productInfoInsertMOL($setBeen);
			$this->common->finalMoveMng("lnd","상품이 등록 되었습니다.","product","list","");
		}

		/*상품 수정*/
		public function updateProduct($setBeen, $whereBeen){
			parent::productInfoUpdateMOL($setBeen, $whereBeen);
			$this->common->finalMoveMng("lnd","상품이 수정 되었습니다.","product","modify","&idx=".$whereBeen[":idx"]);
		}

		/*상품 삭제*/
		public function deleteProduct($whereBeen){
			parent::productInfoDeleteMOL($whereBeen);
			$this->common->finalMoveMng("lnd","상품이 삭제 되었습니다.","product","list","");
		}
	}
?>