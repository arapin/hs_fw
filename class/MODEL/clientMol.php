<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/DAO/DAO.class.php";

	class ClientMOL extends DAO {
		private $logc;
		private $zipCode;
		private $boardConfig;
		private $fileInfo;
		private $productInfo;
		private $productInfo2;
		private $afftermemoinfo;
		private $userinfo;
		private $reservationInfo;
		private $paymentInfo;
		private $shWish;
		private $userWithoutInfo;
		private $reslimitday;

		public function __construct($svName) {
			parent:: __construct($svName);
			$this->logc = new DAO("logcinfo");
			$this->zipCode = new DAO("zipinfo");
			$this->boardConfig = new DAO("boardconfig");
			$this->fileInfo = new DAO("fileinfo");
			$this->productInfo = new DAO("shrelayproinfo");
			$this->productInfo2 = new DAO("productinfo");
			$this->afftermemoinfo = new DAO("afftermemoinfo");
			$this->userinfo = new DAO("userinfo");
			$this->reservationInfo = new DAO("reservationinfo");
			$this->paymentInfo = new DAO("paymentinfo");
			$this->shWish = new DAO("shWishInfo");
			$this->userWithoutInfo = new DAO("userwithoutinfo");
			$this->reslimitday = new DAO("reslimitday");
		}
		
		/** 점짐 가입 **/
		public function joinclient($bind){
			parent::insertQuery("clientInfoInsert",$bind);
		}

		/** 점짐 가입 **/
		public function joinclientFront($bind){
			parent::insertQuery("clientInfoInsertFront",$bind);
		}

		/** 점집 리스트 출력 **/
		public function clientList($bind="", $limitQuery){
			$clientResult = parent::selectQuery("clientList",$bind,$limitQuery);
			return $clientResult;
		}

		/** 점집 로그인 회원정보 유무 **/
		public function searchclient($bind){
			$clientResult = parent::selectQuery("clientCnt", $bind);
			return $clientResult;
		}

		/** 점집 로그인 회원정보 유무 **/
		public function searchJoinclient($bind){
			$clientResult = parent::selectQuery("clientJoinCnt", $bind);
			return $clientResult;
		}

		/** 점집 로그인 회원정보 정보 **/
		public function searchclientInfo($bind){
			$clientResult = parent::selectQuery("clientLoginInfo", $bind);
			return $clientResult;
		}

		/** 회원가입 여부 확인 **/
		public function searchUser($bind){
			$userResult = $this->userinfo->selectQuery("userCnt", $bind);
			return $userResult;
		}

		/** 회원탈퇴 아이디 조회 입력 **/
		public function withoutSearchIdMOL($whereBeen){
			$userResult = $this->userWithoutInfo->selectQuery("searchIdWithout",$whereBeen);
			return $userResult;
		}

		/** 회원정보 수정 회원정보 조회 **/
		public function modifyclientInfo($bind){
			$clientResult = parent::selectQuery("clientModify", $bind);
			return $clientResult;
		}

		/** 무속인정보 수정**/
		public function modifyclient($bind, $whereBind){
			parent::updateQuery("clientInfoUpdate",$bind,$whereBind);
		}

		/** 무속인정보 관리자 수정**/
		public function modifyclientMng($bind, $whereBind){
			parent::updateQuery("clientInfoUpdateMng",$bind,$whereBind);
		}

		/** 주소 구군**/
		public function zipTWODepth($bind){
			$clientResult = $this->zipCode->selectQuery("zipTWODepth",$bind);
			return $clientResult;
		}

		/** 주소 구군**/
		public function zipTWODepthCreate($limitQuery){
			$clientResult = $this->zipCode->selectQuery("zipTWODepthCreate","",$limitQuery);
			return $clientResult;
		}

		/** 무속인 관리자 리스트 출력 **/
		public function clientListMng($bind="", $limitQuery){
			$userResult = parent::selectQuery("clientListMng", $bind, $limitQuery);
			return $userResult;
		}

		/** 무속인 관리자 리스트 출력 **/
		public function searchclientMOL($bind="", $limitQuery){
			$userResult = parent::selectQuery("searchclientList", $bind, $limitQuery);
			return $userResult;
		}

		/** 무속인 총 ROW 출력 **/
		public function clientTotalList($bind="", $limitQuery){
			$userResult = parent::selectQuery("clientTotalCnt", $bind, $limitQuery);
			return $userResult;
		}

		/** 무속인 정보 삭제 **/
		public function clientDelete($bind){
			parent::deleteQuery("clientInfoDelete",$bind);
		}

		/** 게시판 생성**/
		public function boardInsert($bind){
			$this->boardConfig->insertQuery("bcInfoInsert",$bind);
		}

		/** 무속인정보 수정**/
		public function applyclient($bind, $whereBind){
			parent::updateQuery("clientApply",$bind,$whereBind);
		}

		/** 무속인정보 수정**/
		public function applyclient2($bind, $whereBind){
			parent::updateQuery("clientApply2",$bind,$whereBind);
		}
		
		/** 로그 기록용**/
		public function logInsert($bind){
			$this->logc->insertQuery("logcInfoInsert",$bind);
		}

		/** 파일 기록용**/
		public function fileInsert($bind){
			$this->fileInfo->insertQuery("uploadFileInfoInsert",$bind);
		}

		/** 프로파일 삭제**/
		public function profileDeleteMOL($bind){
			$this->fileInfo->deleteQuery("profileDelete",$bind);
		}

		/** 파일 정보 수정**/
		public function modifyFileParentId($bind, $whereBind){
			$this->fileInfo->updateQuery("uploadFileInfoParentUpdate",$bind,$whereBind);
		}

		/** 등록된 파일 목록 출력 **/
		public function searchFile($bind){
			$fileResult = $this->fileInfo->selectQuery("uploadFileInfoList", $bind);
			return $fileResult;
		}

		/** 등록된 메인 파일 목록 출력 **/
		public function searchFileMain($bind){
			$fileResult = $this->fileInfo->selectQuery("uploadFileInfoMain", $bind);
			return $fileResult;
		}

		/** 신점 종류 출력 **/
		public function searchProduct(){
			$productResult = $this->productInfo2->selectQuery("productInfoList");
			return $productResult;
		}

		/** 등록된 상품정보 출력 **/
		public function searchSpr($bind){
			$sprResult = $this->productInfo->selectQuery("sprInfoList", $bind);
			return $sprResult;
		}

		/**후기등록**/
		public function insertAffterMemoMOL($bind){
			$this->afftermemoinfo->insertQuery("affterMemoInfoInsert", $bind);
		}
		
		/**후기 삭제**/
		public function deleteAffterMemoMOL($bind){
			$this->afftermemoinfo->deleteQuery("affterMemoDelete", $bind);
		}

		/**후기 수정**/
		public function modifyAffterMemoMOL($setBeen, $whereBeen){
			$this->afftermemoinfo->updateQuery("affterMemoInfoUpdate", $setBeen, $whereBeen);
		}

		/**후기 총갯수**/
		public function affterMemoTotalMOL($bind){
			$amResult = $this->afftermemoinfo->selectQuery("affterMemoTotalCntMng", $bind);
			return $amResult;
		}

		/**후기 총갯수**/
		public function affterMemoListMOL($bind, $limitQuery){
			$amResult = $this->afftermemoinfo->selectQuery("affterMemoInfoList", $bind, $limitQuery);
			return $amResult;
		}

		/**후기 점수 출력**/
		public function affterMemoScoreMOL($bind){
			$amResult = $this->afftermemoinfo->selectQuery("affterMemoScoreInfo", $bind);
			return $amResult;
		}

		/**후기 가져오기**/
		public function affterMemoListSelectMOL($bind){
			$amResult = $this->afftermemoinfo->selectQuery("affterMemoInfoSelect", $bind);
			return $amResult;
		}

		/**회원 정보 출력**/
		public function getUserInfo($bind){
			$userResult = $this->userinfo->selectQuery("userModify", $bind);
			return $userResult;
		}

		/**검색 점집 리스트**/
		public function getSearchSHTotalCnt($bind="", $limitQuery){
			$searchResult = parent::selectQuery("searchclientTotalCnt", $bind, $limitQuery);
			return $searchResult;
			
		}

		/** 선택된 상품정보 출력 **/
		public function searchSpr2($bind){
			$sprResult = $this->productInfo->selectQuery("sprSelectInfo2", $bind);
			return $sprResult;
		}

		/** 예약 체크 **/
		public function getResCntMOL($bind, $limitQuery){
			$resResult = $this->reservationInfo->selectQuery("getResCnt", $bind, $limitQuery);
			return $resResult;
		}

		/**예약 입력**/
		public function setReservationInfoMOL($setBeen){
			$this->reservationInfo->insertQuery("reservationInfoInsert",$setBeen);			
		}

		/**결제정보 입력**/
		public function paymentInfoInsert($setBeen){
			return $this->paymentInfo->insertQuery("paymentInfoInsert",$setBeen);
		}

		/**위시정보 입력**/
		public function whishInfoInsert($setBeen){
			return $this->shWish->insertQuery("wishInfoInsert",$setBeen);
		}

		/**예약제한일자 조회**/
		public function resLimitDayCntMOL($whereBeen="", $limitQuery){
			$resResult = $this->reslimitday->selectQuery("searchLimitInfo",$whereBeen, $limitQuery);
			return $resResult;

		}

		/** 예약 체크 **/
		public function getWishCntMOL($bind){
			$wishResult = $this->shWish->selectQuery("wishCntMng", $bind);
			return $wishResult;
		}

		/** 등록된 예약 제한일 출력 **/
		public function getLimitInfoList($whereBeen){
			$resResult = $this->reslimitday->selectQuery("searchLimitInfoList", $whereBeen);
			return $resResult;
		}

		/** 예약 제한일 비우기 **/
		public function emptryLimitDay($whereBeen){
			$this->reslimitday->deleteQuery("limitInfoDelete", $whereBeen);
		}

		/** 예약 제한일 비우기 **/
		public function deleteLimitDayMOL($whereBeen){
			$this->reslimitday->deleteQuery("limitInfoDeleteSelect", $whereBeen);
		}

		/** 예약 제한일 등록 **/
		public function setLimitDay($setBeen){
			$this->reslimitday->insertQuery("limitInfoInsert", $setBeen);
		}
	}
?>