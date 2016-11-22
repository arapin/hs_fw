<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/sprMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";

	class Spr extends SprMOL {
		private $cipher;
		private $common;
		
		/*생성자*/
		public function __construct() {
			parent:: __construct("shrelayproinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
		}
		
		/*상품정보 출력*/
		public function getSprInfoList($getBeen){
			$sprResult = parent::searchSpr($getBeen);
			$returnData = "";

			while (list($key, $val) = each($sprResult)){
				$time = $sprResult[$key]["proTime"];

				$hour = floor($time / 60);
				$min = ($time % 60);
				$printTime = $hour."시간";
				
				if($min > 0){
					$printTime .= $min."분";
				}

				$returnData .= "<div class=\"fileItem\">상품 : [".$sprResult[$key]["proName"]."] 시간 : [".$printTime."] 가격 : [".number_format($sprResult[$key]["price"])."원] <span class=\"deleteFile\" onclick=\"deleteSpr('".$sprResult[$key]["sprIdx"]."')\">x</span></div>";
			}
			return $returnData;
		}

		/*상품정보 출력*/
		public function getSprInfoListView($getBeen){
			$sprResult = parent::searchSpr($getBeen);
			$returnData = "";

			while (list($key, $val) = each($sprResult)){
				$time = $sprResult[$key]["proTime"];

				$hour = floor($time / 60);
				$min = ($time % 60);
				$printTime = $hour."시간";
				
				if($min > 0){
					$printTime .= $min."분";
				}

				$returnData .= "<div class=\"fileItem\">상품 : [".$sprResult[$key]["proName"]."] 시간 : [".$printTime."] 가격 : [".number_format($sprResult[$key]["price"])."원]</div>";
			}
			return $returnData;
		}
		
		/*상품 등록*/
		public function addProduct($setBeen){
			$arrayPro = $setBeen[1];
			$arrayPrice = $setBeen[2];
			$loopCnt = sizeof($arrayPro);

			for($i=0; $i < $loopCnt; $i++){
				$setBeenData = array($setBeen[0], $arrayPro[$i], $arrayPrice[$i],date("Y-m-d H:i:s"));
				parent::setProduct($setBeenData);
			}

			$logData = array("PI", $_SERVER["REMOTE_ADDR"], "상품 등록", date("Y-m-d H:i:s"), "");
			parent::logInsert($logData);

		}
		
		/*상품코드 등록*/
		public function getProductSelect(){
			$productResult = parent::searchProduct();
			$returnData = "<select name=\"proIdx[]\"><option value=\"\">신점분류</option>";
			while (list($key, $val) = each($productResult)){
				$returnData .= "<option value=\"".$productResult[$key]["idx"]."\">".$productResult[$key]["proName"]."</option>";
			}
			$returnDate .= "</select>";

			return $returnData;
		}

		/*상품코드 등록*/
		public function getProductSelect2(){
			$productResult = parent::searchProduct();
			$returnData = "<option value=\"\">신점분류</option>";
			while (list($key, $val) = each($productResult)){
				$returnData .= "<option value=\"".$productResult[$key]["idx"]."\">".$productResult[$key]["proName"]."</option>";
			}

			return $returnData;
		}
		
		/*상품 삭제*/
		public function deleteProduct($getBeen){
			parent::deleteProductInfo($getBeen);
		}
	}
?>