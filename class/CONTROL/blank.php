<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/cipher.class.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/paging.class.php";

	class Blank {
		private $cipher;
		private $common;
		private $paging;
		public $pageView;
		public $morBtn="";
		public $link = "20";
		public $linking = "10";

		/*생성자*/
		public function __construct() {
			$this->cipher = new Cipher("wpgbxla#$%wpdksrhksfus@good!=");
			$this->common = new Common();
			$this->paging = new Paging();
		}
	}
?>