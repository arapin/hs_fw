<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/paymentMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class Payment extends PaymentMOL {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			parent:: __construct("paymentinfo");
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}
		
		/*사용자 결제 리스트 출력*/
		public function paymentUserList($getBeen){
		}

		/*관리자 결제 리스트 출력*/
		public function paymentMngList($page="", $setOrder="", $search){
			$returnVal = "";
			$searchQuery = "";

			if($search["searchPayState"] != ""){
				$searchQuery .= " AND payState = '".$search["searchPayState"]."' ";
			}

			if($search["searchPayType"] != ""){
				$searchQuery .= " AND payType = '".$search["searchPayType"]."' ";
			}

			if($search["startDate"] != ""){
				$searchQuery .= " AND payDate between '".$search["startDate"]."' AND '".$search["endDate"]."'";
			}

			if($search["searchWord"] != ""){
				$searchQuery .= " AND a.userId LIKE '%".$search["searchWord"]."%' ";
			}

			if($search["SHIdx"] != ""){
				$searchQuery .= " AND b.SHIdx = '".$search["SHIdx"]."'";
			}

			$startNum = ($page - 1) * $this->link;
			//$limitQuery = "order by ".$setOrder." limit ".$startNum." , ".$this->link;
			$limitQuery = $searchQuery."order by ".$setOrder;

			try{

				$paymentTotalCntResult = parent::paymentTotalList("",$limitQuery);
				while (list($key, $val) = each($paymentTotalCntResult)){
					$paymentCnt = $paymentTotalCntResult[$key]["paymentCnt"];
				}
				$record = $paymentCnt;
				/*$url_file = "/";
				$url_parameter = "com=user&lnd=list&mng=Y";
				$this->pageView = $this->paging->Link($page,$record,$this->link,$this->linking,$url_file,$url_parameter);
				$loop_number=$record - $startNum;*/

				$paymentResult = parent::paymentMngListMOL("",$limitQuery);
				while (list($key, $val) = each($paymentResult)){
					$payType		=  $paymentResult[$key]["payType"];
					$proType		=  $paymentResult[$key]["proType"];
					$userId			=  $paymentResult[$key]["userId"];
					$price			=  $paymentResult[$key]["price"];
					$payPrice		=  $paymentResult[$key]["payPrice"];
					$payInfo		=  $paymentResult[$key]["payInfo"];
					$payDate		=  $paymentResult[$key]["payDate"];
					$payState		=  $paymentResult[$key]["payState"];
					$regDate		=  $paymentResult[$key]["regDate"];
					$idx			=  $paymentResult[$key]["idx"];
					$viewPayBtn = "";

					switch($payState){
						case "W" :
							$viewStatus = "<span style=\"color:#9cfaac;font-weight:bold;\">결제대기</span>";
							if($proType == "Q"){
								$viewPayBtn = "<a href=\"#\" class=\"approve\" style=\"padding-right:10px;\"  onclick=\"payment('".$idx."');\"><i class=\"fa fa-check\"></i></a>";
							}
							$viewBtn = "<a href=\"#none\" class=\"delete\" onclick=\"paymentCancel('".$idx."');\"><i class=\"fa fa-times\"></i></a>";
							break;
						case "I" :
							$viewStatus = "<span style=\"color:#7679f3;font-weight:bold;\">결제완료</span>";
							$viewBtn = "<a href=\"#none\" class=\"delete\" onclick=\"paymentCancel('".$idx."');\"><i class=\"fa fa-times\"></i></a>";
							break;
						case "C" :
							$viewStatus = "<span style=\"color:#fc2418;font-weight:bold;\">결제취소</span>";
							$viewBtn = "";
							break;
					}

					switch($payType){
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

					switch($proType){
						case "R" :
							$viewProduct = "예약";
							$proBeen = array(":idx" => $idx);
							$productResult = parent::productSelectInfoMOL($proBeen);
							while (list($key_p, $val_p) = each($productResult)){
								$proName = $productResult[$key_p]["proName"];
							}
							$viewProInfo = "[".$viewProduct."] ".$proName;
							break;
						case "Q" :
							$viewProduct = "문의점";
							$getBeen = array(":idx" => $idx);
							$aqBoardResult = parent::aqBoardSelectInfoMOL($getBeen);
							while (list($key_s, $val_s) = each($aqBoardResult)){
								$title = $aqBoardResult[$key_s]["title"];
							}

							$viewProInfo = "[".$viewProduct."] 제목 : ".$title;
							break;
					}

					$returnVal .= "<tr>
						<td>".$record."</td>
						<td><a href=\"?com=payment&lnd=view&idx=".$idx."&mng=Y\">".$viewProInfo."</a></td>
						<td>".$viewPayType."</td>
						<td style=\"text-transform:none;\">".$userId."</td>
						<td><span class=\"date\">".$payDate."</span></td>
						<td><span class=\"date\">".$regDate."</span></td>
						<td>".$viewStatus."</td>
						<td>
							".$viewPayBtn."
							<!--<a href=\"#none\" class=\"info\" onclick=\"paymentInfo('".$idx."');\"><i class=\"fa fa-info\"></i></a>-->
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

		/*결제취소*/
		public function paymentCancel($whereBeen){
			$paymentResult = parent::paymentInfoCancelMOL($whereBeen);
			while (list($key, $val) = each($paymentResult)){
				$proType = $paymentResult[$key]["proType"];
				$payType = $paymentResult[$key]["payType"];
			}
			
			/*예약취소*/
			if($proType == "R"){

				$resSetData = array("C");
				$resWhereData = array(":paymentIdx" => $whereBeen[":idx"]);
				parent::reservationCancelMOL($resSetData,$resWhereData);

			/*문의점 취소*/
			}else if($proType == "Q"){
			}

			$paymentSetData = array("C",date("Y-m-d H:i:s"),"환불정보");
			parent::paymentCancelMOL($paymentSetData, $whereBeen);
			$this->common->finalMoveMng("lnd","결제가 취소 되었습니다.","payment","list");			
		}

		/**결제정보 출력**/
		public function getPaymentInfo($getBeen){
			$paymentResult = parent::paymentInfoCancelMOL($getBeen);
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

				switch($paymentResult[$key]["proType"]){
					case "R" :
						$viewProduct = "예약";
						$productResult = parent::productSelectInfoMOL($getBeen);
						while (list($key_p, $val_p) = each($productResult)){
							$proName = $productResult[$key_p]["proName"];
						}

						$clientResult = parent::clientSelectInfoMOL($getBeen);
						while (list($key_s, $val_s) = each($clientResult)){
							$SHName = trim($this->cipher->getDecrypt($clientResult[$key_s]["SHName"]));
							$SName = trim($this->cipher->getDecrypt($clientResult[$key_s]["name"]));
						}
						$viewProInfo = "[".$viewProduct."] <br/>".$proName." <br/>무속인명 : ".$SHName." <br/>점집명 : ".$SName;
						break;
					case "Q" :
						$viewProduct = "문의점";
						$aqBoardResult = parent::aqBoardSelectInfoMOL($getBeen);
						while (list($key_s, $val_s) = each($aqBoardResult)){
							$title = $aqBoardResult[$key_s]["title"];
						}

						$viewProInfo = "[".$viewProduct."] <br/>제목 : ".$title;
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
				$rtnData["proType"] = $viewProInfo;
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

		/*결제*/
		public function paymentApply($setBeen, $whereBeen){
			$paymentResult = parent::paymentInfoCancelMOL($whereBeen);
			while (list($key, $val) = each($paymentResult)){
				$proType = $paymentResult[$key]["proType"];
				$payType = $paymentResult[$key]["payType"];
			}
			
			/*예약 처리*/
			if($proType == "R"){

			/*문의글 노출 처리*/
			}else if($proType == "Q"){
				$aqWhereBeen = array(":paymentIdx" => $whereBeen[":idx"]);
				$aqSetBeen = array("V");
				parent::aqBoardUpadteBoardMOL($aqSetBeen,$aqWhereBeen);
			}
			
			/*결제 처리*/
			parent::paymentApplyMOL($setBeen, $whereBeen);
		}
		
	}
?>