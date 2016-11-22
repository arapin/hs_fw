<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class MypageMOL extends DAO {
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
		}

		/**유저 예약 총갯수**/
		public function getMyReservationCntMOL($getBeen){
			$rtnResult = $this->reservationInfo->selectQuery("myReservationTotalCnt",$getBeen);
			return $rtnResult;
		}

		/**유저 예약 리스트**/
		public function getMyReservationListMOL($bind="", $limitQuery){
			$rtnResult = $this->reservationInfo->selectQuery("reservationInfoUserList",$bind, $limitQuery);
			return $rtnResult;
		}

		/**유저 결제 총갯수**/
		public function getMyPaymentCntMOL($getBeen){
			$rtnResult = $this->paymentInfo->selectQuery("myPaymentTotalCnt",$getBeen);
			return $rtnResult;
		}

		/**유저 결제 리스트**/
		public function getMyPaymentListMOL($bind="", $limitQuery){
			$rtnResult = $this->paymentInfo->selectQuery("getPaymentInfoUserList",$bind, $limitQuery);
			return $rtnResult;
		}

		/** 회원정보 수정 회원정보 조회 **/
		public function modifyUserInfo($bind){
			$userResult = $this->userInfo->selectQuery("userModify", $bind);
			return $userResult;
		}

		/** 회원정보 수정**/
		public function modifyUser($bind, $whereBind){
			$this->userInfo->updateQuery("userInfoUpdate",$bind,$whereBind);
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

		/*상품 정보 출력*/
		public function productSelectInfoMOL($getBeen){
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

		/**유저 위시 총갯수**/
		public function getMyWishCntMOL($getBeen){
			$rtnResult = $this->wish->selectQuery("wishCntTotalCnt",$getBeen);
			return $rtnResult;
		}

		/**유저 결제 리스트**/
		public function getMyWishListMOL($bind="", $limitQuery){
			$rtnResult = $this->wish->selectQuery("wishInfoList",$bind, $limitQuery);
			return $rtnResult;
		}

		/**점집 정보**/
		public function getclientInfoMOL($bind){
			$rtnResult = $this->clientInfo->selectQuery("getclientName",$bind);
			return $rtnResult;
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

		/**후기 총갯수**/
		public function affterMemoTotalMOL($bind){
			$amResult = $this->afftermemo->selectQuery("affterMemoTotalCntMng", $bind);
			return $amResult;
		}

		/**후기 점수 출력**/
		public function affterMemoScoreMOL($bind){
			$amResult = $this->afftermemo->selectQuery("affterMemoScoreInfo", $bind);
			return $amResult;
		}

		/*위시 삭제*/
		public function wishDeleteMOL($whereBeen){
			$this->wish->deleteQuery("wishDelete",$whereBeen);
		}

		/** 신점 문의 관리 총 ROW 출력 **/
		public function aqBoardTotalListMOL($whereBeen){
			$aqResult = $this->aqBoardInfo->selectQuery("aqBoardTotalCntUser", $whereBeen);
			return $aqResult;
		}

		/*유저 신점 문의 리스트 출력*/
		public function aqBoardListMOL($bind="", $limitQuery){
			$aqBoardResult = $this->aqBoardInfo->selectQuery("aqBoardInfoListUser", $bind, $limitQuery);
			return $aqBoardResult;
		}

		/*답변 총 갯수 출력*/
		public function aqBoardtInfoAnswerCntMOL($getBeen){
			$aqResult = $this->aqBoardInfo->selectQuery("aqBoardAnswerTotalCntMng", $getBeen);
			return $aqResult;
		}

		/*상품 정보 출력*/
		public function productSelectInfoMOLUser($getBeen){
			$productResult = $this->productInfo2->selectQuery("productInfoSelect", $getBeen);
			return $productResult;
		}

		/**신점 문의 정보 수정 추출**/
		public function aqBoardInfoMOL($getBeen){
			$aqBoardResult = $this->aqBoardInfo->selectQuery("aqBoardInfoSelect",$getBeen);
			return $aqBoardResult;
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

		/**게시물 상태 변경**/
		public function aqBoardStatusUpdateMOL($setBeen, $whereBeen){
			$this->aqBoardInfo->updateQuery("aqStateUpdateUser", $setBeen, $whereBeen);
		}

		/****/
		public function aqBoardAnswerChoiceMOL($setBeen, $whereBeen){
			$this->aqBoardInfo->updateQuery("aqChoiceUpdateUser",$setBeen, $whereBeen);
		}

		/**결제정보 입력**/
		public function aqBoardUpdateMOL($setBeen, $whereBeen){
			return $this->aqBoardInfo->updateQuery("aqBoardInfoUpdate",$setBeen, $whereBeen);
		}

		/**후기등록**/
		public function insertAffterMemoMOL($bind){
			$this->afftermemo->insertQuery("affterMemoInfoInsert", $bind);
		}
		
		/**후기 삭제**/
		public function deleteAffterMemoMOL($bind){
			$this->afftermemo->deleteQuery("affterMemoDelete", $bind);
		}

		/**후기 수정**/
		public function modifyAffterMemoMOL($setBeen, $whereBeen){
			$this->afftermemo->updateQuery("affterMemoInfoUpdate", $setBeen, $whereBeen);
		}

		/**후기 총갯수**/
		public function affterMemoTotalUserMOL($bind){
			$amResult = $this->afftermemo->selectQuery("affterMemoTotalCntUser", $bind);
			return $amResult;
		}

		/**후기 총갯수**/
		public function affterMemoListMOL($bind, $limitQuery){
			$amResult = $this->afftermemo->selectQuery("affterMemoInfoListUser", $bind, $limitQuery);
			return $amResult;
		}

		/** 회원정보 수정 회원정보 조회 **/
		public function getModifyAffterMemo($bind){
			$amResult = $this->afftermemo->selectQuery("affterMemoInfoSelect", $bind);
			return $amResult;
		}

		/** 회원정보 수정 회원정보 조회 **/
		public function modifyclientInfo($bind){
			$clientResult = $this->clientInfo->selectQuery("clientModify", $bind);
			return $clientResult;
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

		/** 등록된 메인 파일 목록 출력 **/
		public function searchFileMain($bind){
			$fileResult = $this->file->selectQuery("uploadFileInfoMain", $bind);
			return $fileResult;
		}

		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}
	}
?>