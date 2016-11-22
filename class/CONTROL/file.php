<?
	include $_SERVER["DOCUMENT_ROOT"]."/class/MODEL/fileMol.php";
	include $_SERVER["DOCUMENT_ROOT"]."/class/COMMON/common.class.php";

	class File extends FileMOL {
		
		private $common;

		/*생성자*/
		public function __construct() {
			parent:: __construct("fileinfo");
			$this->common = new Common();
		}
		
		/*파일 추가*/
		public function addImgFile($fileData){
			$fileArray = $fileData[0];
			$cate = $fileData[1];
			$parentId = $fileData[2];
			$folder = $fileData[3];
			$rtnUrl = $fileData[4];
			$fileNameArray = array();

			$fileCnt = sizeof($fileArray["name"]);

			for($i=0; $i < $fileCnt; $i++){

				$fileUploadDir = $folder;

				try{
					$rtnVal = $this->common->imageUploader($fileArray["tmp_name"][$i], $fileArray["name"][$i], $fileArray["size"][$i], $fileUploadDir, "2000", "2000", "10485760");
					
					if($rtnUrl != ""){
						switch ($rtnVal){
							case "01" : 
								$this->common->finalMoveMng("url","등록할수 없는 확장자 입니다.","","","",$rtnUrl);
								break;
							case "02" : 
								$this->common->finalMoveMng("url","등록할수 없는 크기의 파일 입니다.","","","",$rtnUrl);
								break;
							case "03" : 
								$this->common->finalMoveMng("url","등록할수 있는 용량을 초과 했습니다.","","","",$rtnUrl);
								break;
							case "04" : 
								$this->common->finalMoveMng("url","파일 등록 오류 입니다.","","","",$rtnUrl);
								break;
							case "05" : 
								$this->common->finalMoveMng("url","이미지 파일이 아닙니다.","","","",$rtnUrl);
								break;
						}
					}

					$fileNameArray[] = $fileArray["name"][$i];
					$fileInsertData = array($parentId, $cate, $fileArray["type"][$i], $fileArray["size"][$i], $fileArray["name"][$i], $rtnVal, "", date("Y-m-d H:i:s"));
					parent::insertFile($fileInsertData);

					$logData = array("FI", $_SERVER["REMOTE_ADDR"], "파일 등록", date("Y-m-d H:i:s"), $fileUploadDir."/".$rtnVal);
					parent::logInsert($logData);

				}catch(Exception $e){
					$logData = array("E", $_SERVER["REMOTE_ADDR"], $e->getMessage(), date("Y-m-d H:i:s"), "");
					parent::logInsert($logData);
				}
			}

			return $fileNameArray;
		}
		
		/*등록된 파일 목록 출력*/
		public function getFileInfoList($getBeen){
			$fileResult = parent::searchFile($getBeen);
			$returnData = "";
			while (list($key, $val) = each($fileResult)){
				$returnData .= "<div class=\"fileItem\">".$fileResult[$key]["orgName"]." <span class=\"deleteFile\" onclick=\"deleteFile('".$fileResult[$key]["idx"]."')\">x</span></div>";
			}

			return $returnData;
		}

		/*등록된 파일 목록 출력*/
		public function getFileInfoListView($getBeen){
			$fileResult = parent::searchFile($getBeen);
			$returnData = "";
			while (list($key, $val) = each($fileResult)){
				$returnData .= "<div class=\"fileItem\">".$fileResult[$key]["orgName"]."</div>";
			}

			return $returnData;
		}

		/*파일 삭제*/
		public function deleteImgFile($getBeen, $fileData){
			$fileResult = parent::uploadFileInfo($getBeen);
			while (list($key, $val) = each($fileResult)){
				$saveName = $fileResult[$key]["saveName"];
			}
			$deleteFilePath = $fileData["deletePath"]."/".$saveName;
			parent::deleteFileInfo($getBeen);
			@unlink($deleteFilePath);
			//$this->common->finalMoveMng("url","파일이 삭제 되었습니다.","","","",$fileData["rtnUrl"]);
		}
	}
?>