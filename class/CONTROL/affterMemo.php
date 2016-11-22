<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/affterMemoMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class AffterMemo extends AffterMemoMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("afftermemoinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}

		/*관리자 예약 리스트 출력*/
		public function affterList($page="", $setOrder=""){
			$returnVal = "";

			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = "order by ".$setOrder;

			try{

				$affterMemoTotalCntResult = parent::affterMemoTotalCntMOL();
				while (list($key, $val) = each($affterMemoTotalCntResult)){
					$amCnt = $affterMemoTotalCntResult[$key]["amCnt"];
				}
				$record = $amCnt;
				/*$url_file = "/";
				$url_parameter = "com=user&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$amResult = parent::affterMemoListMOL("",$limitQuery);
				while (list($key, $val) = each($amResult)){

					$smCodeArray = explode("_",$amResult[$key]["code"]);
					$smGetBeen = array(":SHId" => $smCodeArray[0]);
					$clientResult = parent::modifyclientInfo($smGetBeen);
					while (list($key_s, $val_s) = each($clientResult)){
						$SHName = $clientResult[$key_s]["SHName"];
					}

					$viewContent = $this->common->cutstr($amResult[$key]["memo"], 30);

					$pointerP = $amResult[$key]["pointerP"];
					$serviceP = $amResult[$key]["serviceP"];
					$locationP = $amResult[$key]["locationP"];
					$priceP = $amResult[$key]["priceP"];

					$totalScore = $pointerP + $serviceP + $locationP + $priceP;

					$viewTotalScore= round($totalScore / 4);

					$returnVal .= "<tr>
						<td>".$record."</td>
						<td style=\"text-transform:none;\">".$SHName."</td>
						<td style=\"text-transform:none;\"><a href=\"?com=affterMemo&lnd=view&idx=".$amResult[$key]["idx"]."&mng=Y\">".$amResult[$key]["userId"]."</a></td>
						<td>".$viewContent."</td>
						<td>".$viewTotalScore."점</td>
						<td><span class=\"date\">".$amResult[$key]["writeDate"]."</span></td>
						<td>
							<a href=\"#none\" class=\"delete\" onclick=\"deleteMng('".$amResult[$key]["idx"]."');\"><i class=\"fa fa-times\"></i></a>
						</td>
					</tr>";
					$record--;
				}

				return $returnVal;

			}catch(Exception $e){
				$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
				parent::logInsert($logData);
				$this->common->finalMoveMng("lnd","시스템 오류입니다.","","");
			}
		}

		public function affterMemoInfo($getBeen){
			$returnVal = array();
			$amResult = parent::affterMemoInfoMOL($getBeen);
			while (list($key, $val) = each($amResult)){
				$returnVal["code"] = $amResult[$key]["code"];
				$returnVal["userId"] = $amResult[$key]["userId"];
				$returnVal["memo"] = $amResult[$key]["memo"];
				$returnVal["pointerP"] = $amResult[$key]["pointerP"];
				$returnVal["serviceP"] = $amResult[$key]["serviceP"];
				$returnVal["locationP"] = $amResult[$key]["locationP"];
				$returnVal["priceP"] = $amResult[$key]["priceP"];
				$returnVal["writeDate"] = $amResult[$key]["writeDate"];
			}

			$smCodeArray = explode("_",$returnVal["code"]);
			$smGetBeen = array(":SHId" => $smCodeArray[0]);
			$clientResult = parent::modifyclientInfo($smGetBeen);
			while (list($key_s, $val_s) = each($clientResult)){
				$returnVal["SHName"] = $clientResult[$key_s]["SHName"];
			}

			return $returnVal;
		}

		public function affterMemoDelete($whereBeen){
			parent::affterMemoInfoDeleteMOL($whereBeen);
			$this->common->finalMoveMng("lnd","후기가 삭제 되었습니다.","affterMemo","list");
		}
		
	}
?>