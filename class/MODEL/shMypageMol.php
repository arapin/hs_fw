<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class SHMaypageMOL extends DAO {
		private $logc;
		private $clientInfo;
		private $paymentInfo;
		private $reservationInfo;
		private $aqBoardInfo;
		private $userInfo;
		private $file;
		private $productInfo;
		private $wish;
		private $afftermemo;
		private $productInfo2;
		private $board;
		private $boardMemo;
		private $reslimitday;
		private $clientCalc;


		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->clientInfo = new DAO("clientinfo");
			$this->paymentInfo = new DAO("paymentinfo");
			$this->reservationInfo = new DAO("reservationinfo");
			$this->aqBoardInfo = new DAO("aqboardinfo");
			$this->userInfo = new DAO("userinfo");
			$this->file = new DAO("fileinfo");
			$this->productInfo = new DAO("shrelayproinfo");
			$this->wish = new DAO("shWishInfo");
			$this->afftermemo = new DAO("afftermemoinfo");
			$this->productInfo2 = new DAO("productinfo");
			$this->board = new DAO("boardinfo");
			$this->boardMemo = new DAO("boardmemo");
			$this->reslimitday = new DAO("reslimitday");
			$this->clientCalc = new DAO("clientCalc");
		}

		/**점집 예약 총갯수**/
		public function getMyReservationCntMOL($getBeen){
			$rtnResult = $this->reservationInfo->selectQuery("myReservationSHTotalCnt",$getBeen);
			return $rtnResult;
		}

		/**점집 예약 리스트**/
		public function getMyReservationListMOL($bind="", $limitQuery){
			$rtnResult = $this->reservationInfo->selectQuery("reservationInfoSHList",$bind, $limitQuery);
			return $rtnResult;
		}

		/**점집 결제 총갯수**/
		public function getMyPaymentCntMOL($getBeen){
			$rtnResult = $this->paymentInfo->selectQuery("myPaymentSHTotalCnt",$getBeen);
			return $rtnResult;
		}

		/**점집 결제 리스트**/
		public function getMyPaymentListMOL($bind="", $limitQuery){
			$rtnResult = $this->paymentInfo->selectQuery("getPaymentInfoSHList",$bind, $limitQuery);
			return $rtnResult;
		}

		/**신점 문의 정보 수정 추출**/
		public function aqBoardInfoMOL($getBeen){
			$aqBoardResult = $this->aqBoardInfo->selectQuery("aqBoardInfoSelect",$getBeen);
			return $aqBoardResult;
		}

		/*결제 정보 출력*/
		public function paymentSelectInfoMOL($getBeen){
			$paymentResult = $this->paymentInfo->selectQuery("paymentCancelInfo", $getBeen);
			return $paymentResult;
		}

		/*상품 정보 출력*/
		public function productSelectInfoMOLUser($getBeen){
			$productResult = $this->productInfo2->selectQuery("productInfoSelect", $getBeen);
			return $productResult;
		}

		/*답변 총 갯수 출력*/
		public function aqBoardtInfoAnswerCntMOL($getBeen){
			$aqResult = $this->aqBoardInfo->selectQuery("aqBoardAnswerTotalCntMng", $getBeen);
			return $aqResult;
		}

		/*답변 리스트*/
		public function aqBoardtInfoAnswerListMOL($getBeen){
			$aqResult = $this->aqBoardInfo->selectQuery("aqBoardAnswerList", $getBeen);
			return $aqResult;
		}

		/*유저 답변 총 갯수 출력*/
		public function aqBoardtUserInfoAnswerCntMOL($getBeen){
			$aqResult = $this->aqBoardInfo->selectQuery("aqBoardUserAnswerTotalCntMng", $getBeen);
			return $aqResult;
		}
		
		/**무속인 답변 총 갯수**/
		public function aqBoardclientAnswerTotalCntMOL($getBeen){
			$aqResult = $this->aqBoardInfo->selectQuery("aqBoardUserAnswerTotalCntclient",$getBeen);
			return $aqResult;
		}

		/**무속인 답변 총 갯수**/
		public function aqBoardclientAnswerListMOL($getBeen, $limitQuery){
			$aqResult = $this->aqBoardInfo->selectQuery("aqBoardAnswerInfoclient",$getBeen, $limitQuery);
			return $aqResult;
		}

		/**신전문의 답변 수정 입력**/
		public function aqBoardUpdateMOL($setBeen, $whereBeen){
			return $this->aqBoardInfo->updateQuery("aqBoardInfoUpdate",$setBeen, $whereBeen);
		}

		/**신전문의 답변 삭제**/
		public function aqBoardAnswerInfoDeleteMOL($whereBeen){
			$this->aqBoardInfo->deleteQuery("aqInfoDelete", $whereBeen);
		}

		/**게시물 예약 총갯수**/
		public function getBoardCntMOL($getBeen){
			$rtnResult = $this->board->selectQuery("boardTotalCntUser",$getBeen);
			return $rtnResult;
		}

		/**게시물 리스트**/
		public function getBoardListMOL($bind="", $limitQuery){
			$rtnResult = $this->board->selectQuery("boardInfoListUser",$bind, $limitQuery);
			return $rtnResult;
		}

		/**게시물 정보 가져오기**/
		public function getBoardInfoMOL($getBeen){
			$rtnResult = $this->board->selectQuery("boardInfoSelect",$getBeen);
			return $rtnResult;
		}

		/**게시물 수정**/
		public function updateBoardFrontMOL($setBeen, $whereBeen){
			$this->board->updateQuery("boardInfoUpdateFront",$setBeen, $whereBeen);
		}

		public function deleteBoardMOL($whereBeen){
			$this->board->deleteQuery("boardInfoDelete",$whereBeen);
		}

		/**댓글 등록**/
		public function setBoardMemoInfoMOL($setBeen){
			$this->boardMemo->insertQuery("boardMemoInfoInsert",$setBeen);
		}

		/**댓글 총갯수**/
		public function getBoardMemoCntMOL($getBeen){
			$rtnResult = $this->boardMemo->selectQuery("boardMemoTotalCntMng",$getBeen);
			return $rtnResult;
		}

		/**댓글 리스트**/
		public function getBoardMemoListMOL($getBeen){
			$rtnResult = $this->boardMemo->selectQuery("boardMemoInfoList",$getBeen);
			return $rtnResult;
		}

		/**댓글 수정**/
		public function updateBoardMemoInfoMOL($setBeen, $whereBeen){
			$this->boardMemo->updateQuery("boardMemoInfoUpdate",$setBeen, $whereBeen);
		}

		/**댓글 삭제**/
		public function deleteBoardMemoInfoMOL($whereBeen){
			$this->boardMemo->deleteQuery("boardMemoDelete", $whereBeen);
		}
		
		/**댓글 전체삭제**/
		public function deleteMemoTotalMOL($whereBeen){
			$this->boardMemo->deleteQuery("boardMemoDeleteTotal", $whereBeen);
		}

		/** 회원정보 수정 회원정보 조회 **/
		public function modifyclientInfo($bind){
			$clientResult = $this->clientInfo->selectQuery("clientModify", $bind);
			return $clientResult;
		}

		/*점집 정보 출력*/
		public function clientSelectInfoMOL($getBeen){
			$clientResult = $this->clientInfo->selectQuery("getclientName", $getBeen);
			return $clientResult;
		}

		/*상품 정보 출력*/
		public function productSelectInfoMOLSh($getBeen){
			$productResult = $this->productInfo->selectQuery("sprSelectInfo", $getBeen);
			return $productResult;
		}

		/*예약취소정보*/
		public function reservationInfoCancelMOL($whereBeen){
			$resResult = $this->reservationInfo->selectQuery("reservationCancelInfo", $whereBeen);
			return $resResult;
		}

		/*예약취소*/
		public function reservationCancelMOL($setBeen, $whereBeen){
			$this->reservationInfo->updateQuery("reservationInfoUpdate",$setBeen, $whereBeen);
		}

		/*결제 취소*/
		public function paymentCancelMOL($setBeen, $whereBeen){
			$this->paymentInfo->updateQuery("paymentInfoUpdate",$setBeen,$whereBeen);
		}

		/** 등록된 파일 목록 출력 **/
		public function searchFile($bind){
			$fileResult = $this->file->selectQuery("uploadFileInfoList", $bind);
			return $fileResult;
		}

		/** 등록된 상품정보 출력 **/
		public function searchSpr($bind){
			$sprResult = $this->productInfo->selectQuery("sprInfoList", $bind);
			return $sprResult;
		}

		/*대표이미지 설정*/
		public function setMainImgChkMOL($setBeen, $whereBeen){
			$this->file->updateQuery("mainImageChk",$setBeen, $whereBeen);
		}

		/*대표이미지 초기화*/
		public function setMainImgDefaultMOL($setBeen){
			$this->file->updateQuery("mainImageChkDefault",$setBeen);
		}

		/** 등록된 파일 정보 출력 **/
		public function uploadFileInfo($bind){
			$fileResult = $this->file->selectQuery("uploadFileInfo", $bind);
			return $fileResult;
		}

		/** 파일 삭제 **/
		public function deleteFileInfo($whereBind){
			$this->file->deleteQuery("fileInfoDelete", $whereBind);
		}

		/** 파일등록 **/
		public function insertFile($bind){
			$this->file->insertQuery("uploadFileInfoInsert",$bind);
		}

		/** 등록된 상품정보 출력 **/
		public function searchProduct(){
			$productResult = $this->productInfo2->selectQuery("productInfoList");
			return $productResult;
		}

		/*상품 삭제*/
		public function deleteProductMOL($whereBind){
			$this->productInfo->deleteQuery("sprInfoDelete", $whereBind);
		}

		/** 상품정보 등록 **/
		public function setProduct($setBeen){
			$this->productInfo->insertQuery("sprInfoInsertFront", $setBeen);
		}

		/** 상품정보 등록 **/
		public function emptryProduct($whereBeen){
			$this->productInfo->deleteQuery("sprInfoDeleteDefault", $whereBeen);
		}

		/** 예약 제한일 비우기 **/
		public function emptryLimitDay($whereBeen){
			$this->reslimitday->deleteQuery("limitInfoDelete", $whereBeen);
		}

		/** 예약 제한일 등록 **/
		public function setLimitDay($setBeen){
			$this->reslimitday->insertQuery("limitInfoInsert", $setBeen);
		}

		/** 등록된 예약 제한일 출력 **/
		public function getLimitInfoList($whereBeen){
			$resResult = $this->reslimitday->selectQuery("searchLimitInfoList", $whereBeen);
			return $resResult;
		}

		/** 무속인정보 관리자 수정**/
		public function modifyclientMng($bind, $whereBind){
			$this->clientInfo->updateQuery("clientInfoUpdateMng",$bind,$whereBind);
		}


		/** 등록된 상품정보 출력 **/
		public function getResUserInfo($whereBeen){
			$resResult = $this->reservationInfo->selectQuery("getResViewInfo", $whereBeen);
			return $resResult;
		}

		/** 프로파일 삭제**/
		public function profileDeleteMOL($bind){
			$this->file->deleteQuery("profileDelete",$bind);
		}

		/** 파일 기록용**/
		public function fileInsert($bind){
			$this->file->insertQuery("uploadFileInfoInsert",$bind);
		}
		
		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}

		/** 예약 제한일 비우기 **/
		public function deleteLimitDayMOL($whereBeen){
			$this->reslimitday->deleteQuery("limitInfoDeleteSelect", $whereBeen);
		}
		
		/**예약 상태별 카운트**/
		public function getResStateCntMOL($whereBeen){
			$resResult = $this->reservationInfo->selectQuery("getResStateCnt", $whereBeen);
			return $resResult;
		}

		/**무속인 예약 수정**/
		public function updateResInfoclient($bind,$whereBind){
			$this->reservationInfo->updateQuery("reservationInfoUpdateclient",$bind,$whereBind);
		}

		/**무속인 정산 카운트**/
		public function clientCalcTotalListMOL($whereBeen){
			$scalResult = $this->clientCalc->selectQuery("clientCalcTotalList", $whereBeen);
			return $scalResult;
		}

		/**무속인 정산 리스트**/
		public function clientCalcListMOL($whereBeen, $limitQuery){
			$scalResult = $this->clientCalc->selectQuery("clientCalcList", $whereBeen, $limitQuery);
			return $scalResult;
		}

		/**무속인 정산 리스트**/
		public function clientCalcTotalInfoMOL($whereBeen){
			$scalResult = $this->clientCalc->selectQuery("clientCalcTotalInfo", $whereBeen);
			return $scalResult;
		}

		/**무속인 예약 결제 정보 리스트**/
		public function clientCalcResInfoMOL($whereBeen, $limitQuery){
			$payResult = $this->paymentInfo->selectQuery("paymentCalcResList", $whereBeen, $limitQuery);
			return $payResult;
		}

		/**무속인 예약 결제 총합 정보**/
		public function clientCalcResTotalInfoMOL($whereBeen, $limitQuery){
			$payResult = $this->paymentInfo->selectQuery("paymentCalcResTotalInfo", $whereBeen, $limitQuery);
			return $payResult;
		}
	}
?>