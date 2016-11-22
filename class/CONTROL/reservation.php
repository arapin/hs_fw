<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/reservationMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class Reservation extends ReservationMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("reservationinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}
		
		/*사용자 예약 리스트 출력*/
		public function reservationUserList($getBeen){
		}

		/*관리자 예약 리스트 출력*/
		public function reservationMngList($page="", $setOrder="", $search){
			$returnVal = "";

			$searchQuery = "";

			if($search["searchPayState"] != ""){
				$searchQuery .= " AND resState = '".$search["searchPayState"]."' ";
			}

			if($search["startDate"] != ""){
				$searchQuery .= " AND resDate between '".$search["startDate"]."' AND '".$search["endDate"]."'";
			}

			if($search["searchWord"] != ""){
				$searchQuery .= " AND resUserId LIKE '%".$search["searchWord"]."%' ";
			}

			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = $searchQuery."order by ".$setOrder;

			try{

				$resTotalCntResult = parent::resTotalList("",$limitQuery);
				while (list($key, $val) = each($resTotalCntResult)){
					$resCnt = $resTotalCntResult[$key]["resCnt"];
				}
				$record = $resCnt;
				/*$url_file = "/";
				$url_parameter = "com=user&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$resResult = parent::reservationMngListMOL("",$limitQuery);
				while (list($key, $val) = each($resResult)){
					$resUserId		=  $resResult[$key]["resUserId"];
					$resDate		=  $resResult[$key]["resDate"];
					$resStartTime	=  $resResult[$key]["resStartTime"];
					$resEndTime		=  $resResult[$key]["resEndTime"];
					$regDate		=  $resResult[$key]["regDate"];
					$resState		=  $resResult[$key]["resState"];
					$idx			=  $resResult[$key]["idx"];

					switch($resState){
						case "W" :
							$viewStatus = "<span style=\"color:#9cfaac;font-weight:bold;\">예약대기</span>";
							$viewBtn = "<a href=\"#none\" class=\"delete\" onclick=\"resCancel('".$idx."');\"><i class=\"fa fa-times\"></i></a>";
							break;
						case "U" :
							$viewStatus = "<span style=\"color:#7679f3;font-weight:bold;\">예약완료</span>";
							$viewBtn = "<a href=\"#none\" class=\"delete\" onclick=\"resCancel('".$idx."');\"><i class=\"fa fa-times\"></i></a>";
							break;
						case "C" :
							$viewStatus = "<span style=\"color:#fc2418;font-weight:bold;\">예약취소</span>";
							$viewBtn = "";
							break;
					}
					
					$proBeen = array(":proIdx" => $resResult[$key]["proIdx"], ":SHIdx" => $resResult[$key]["SHIdx"]);
					$productResult = parent::productSelectInfoMOL($proBeen);
					while (list($key_p, $val_p) = each($productResult)){
						$proName = $productResult[$key_p]["proName"];
					}

					$clientBeen = array(":SHIdx" => $resResult[$key]["SHIdx"]);
					$clientResult = parent::clientSelectInfoMOL($clientBeen);
					while (list($key_s, $val_s) = each($clientResult)){
						$SHName = $clientResult[$key_s]["SHName"];
					}

					$returnVal .= "<tr>
						<td>".$record."</td>
						<td style=\"text-transform:none;\"><a href=\"?com=reservation&lnd=view&idx=".$idx."&mng=Y\">".$resUserId."</a></td>
						<td>".$proName."</td>
						<td>".$SHName."</td>
						<td><span class=\"date\">".$resDate."</span></td>
						<td>".$resStartTime." - ".$resEndTime."</td>
						<td><span class=\"date\">".$regDate."</span></td>
						<td>".$viewStatus."</td>
						<td>
							<!--<a href=\"#none\" class=\"info\" onclick=\"resInfo('".$idx."');\"><i class=\"fa fa-info\"></i></a>-->
							".$viewBtn."
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

		/*예약취소*/
		public function reservationInfoCancel($whereBeen){
			$resResult = parent::reservationInfoCancelMOL($whereBeen);
			while (list($key, $val) = each($resResult)){
				$paymentIdx = $resResult[$key]["paymentIdx"];
			}
			
			/*결제 취소*/
			$paymentSetData = array("C",date("Y-m-d H:i:s"),"환불정보");
			$paymentData = array(":idx" => $paymentIdx);
			parent::paymentCancelMOL($paymentSetData, $paymentData);
			
			/*예약취소*/
			$resSetData = array("C");
			parent::reservationCancelMOL($resSetData,$whereBeen);
			$this->common->finalMoveMng("lnd","예약이 취소 되었습니다.","reservation","list");
		}

		/**예약정보 출력**/
		public function reservationInfo($whereBeen){
			$rtnData = array();

			$resResult = parent::reservationInfoViewMOL($whereBeen);
			while (list($key, $val) = each($resResult)){
				$rtnData["resUserId"] = $resResult[$key]["resUserId"];
				$rtnData["resDate"] = $resResult[$key]["resDate"];
				$rtnData["resStartTime"] = $resResult[$key]["resStartTime"];
				$rtnData["resEndTime"] = $resResult[$key]["resEndTime"];

				switch($resResult[$key]["resState"]){
					case "W" :
						$viewStatus = "<span style=\"color:#9cfaac;font-weight:bold;\">예약 대기</span>";
						break;
					case "U" :
						$viewStatus = "<span style=\"color:#7679f3;font-weight:bold;\">예약 완료</span>";
						break;
					case "C" :
						$viewStatus = "<span style=\"color:#fc2418;font-weight:bold;\">예약 취소</span>";
						break;
				}

				$rtnData["resState"] = $viewStatus;
				$rtnData["regDate"] = $resResult[$key]["regDate"];
			}

			$resResult = parent::reservationInfoCancelMOL($whereBeen);
			while (list($key, $val) = each($resResult)){
				$paymentIdx = $resResult[$key]["paymentIdx"];
				$proIdx = $resResult[$key]["proIdx"];
				$SHIdx = $resResult[$key]["SHIdx"];
			}
			
			$productGetBeen = array(":proIdx" => $proIdx, ":SHIdx" => $SHIdx);
			$productResult = parent::productSelectInfoMOL($productGetBeen);
			while (list($key, $val) = each($productResult)){
				$rtnData["proName"] = $productResult[$key]["proName"];
			}

			$clientBeen = array(":SHIdx" => $SHIdx);
			$clientResult = parent::clientSelectInfoMOL($clientBeen);
			while (list($key_s, $val_s) = each($clientResult)){
				$rtnData["SHName"] = trim($this->cipher->getDecrypt($clientResult[$key_s]["SHName"]));
				$rtnData["SName"] = trim($this->cipher->getDecrypt($clientResult[$key_s]["name"]));
			}

			$paymentGetBeen = array(":idx" => $paymentIdx);
			$paymentResult = parent::paymentSelectInfoMOL($paymentGetBeen);
			while (list($key, $val) = each($paymentResult)){

				switch($paymentResult[$key]["payState"]){
					case "W" :
						$viewStatus = "<span style=\"color:#9cfaac;font-weight:bold;\">결제대기</span>";
						break;
					case "I" :
						$viewStatus = "<span style=\"color:#7679f3;font-weight:bold;\">결제완료</span>";
						break;
					case "C" :
						$viewStatus = "<span style=\"color:#fc2418;font-weight:bold;\">결제취소</span>";
						break;
				}

				switch($paymentResult[$key]["payType"]){
					case "B" :
						$viewPayType = "무통장입금";
						break;
					case "C" :
						$viewPayType = "신용/체크 카드";
						break;
					case "R" :
						$viewPayType = "실시간계좌이체";
						break;
				}
				
				if($paymentResult[$key]["payInfo"] != ""){
					$arrayPayInfo = explode("|", $paymentResult[$key]["payInfo"]); 
					$viewPayInfo = "입금은행 : ".$arrayPayInfo[0]."<br/>입금자 : ".$arrayPayInfo[1];
				}

				if($paymentResult[$key]["payState"] == "C"){
					$viewCancelInfo = $paymentResult[$key]["cancelInfo"];
					$viewCancelDate = $paymentResult[$key]["cancelDate"];
				}else{
					$viewCancelDate = "-";
					$viewCancelInfo = "-";
				}

				$rtnData["payType"] = $viewPayType;
				$rtnData["proType"] = $paymentResult[$key]["proType"];
				$rtnData["userId"] = $paymentResult[$key]["userId"];
				$rtnData["price"] = number_format($paymentResult[$key]["price"])."원";
				$rtnData["payPrice"] = number_format($paymentResult[$key]["payPrice"])."원";
				$rtnData["payState"] = $viewStatus;
				$rtnData["payDate"] = $paymentResult[$key]["payDate"];
				$rtnData["cancelInfo"] = $viewCancelInfo;
				$rtnData["cancelDate"] = $viewCancelDate;
				$rtnData["payInfo"] = $viewPayInfo;
			}
			return $rtnData;
		}

		/*예약*/
		public function reservationInfoAdd($getBeen){
		}
		
	}
?>