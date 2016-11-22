<?php
/*
* class desc : xml 으로부터 PDO에 매칭할 데이터를 가져오는 class
* write : jung hyun su
* write date : 2015-08-20
* 사용방법 : 
* 클래스 선언 $setDaoXml = new SetDaoXml();
*/
class SetDaoXml {
	private $svName;
	private $proId;
	private $xml;
	private $queType;
	public $returnField = array();
	public $returnData = array();
	public $returnTable;
	public $returnWhere;
	public $returnVal = array();

	public function __construct() {
	}

	private function getXmlFile(){
		$this->xml = simplexml_load_file($_SERVER["DOCUMENT_ROOT"]."/daoXml/".$this->svName.".xml") or die("Error: Cannot create object");
	}

	private function getXmlBeen(){
		unset($this->returnField);

		$this->getXmlFile();

		if($this->queType == "insert"){
			foreach ($this->xml->insert as $value){
				$id = $value["id"];

				if($this->proId == $id){
					$this->returnTable = $value->table;
					$fieldCnt = count($value->field->item);

					for($i=0; $i < $fieldCnt; $i++){
						$this->returnField[$i] =  $value->field->item[$i];
					}
				}
			}
		}else if($this->queType == "update"){
			foreach ($this->xml->update as $value){
				$id = $value["id"];
				if($this->proId == $id){
					$this->returnTable = $value->table;
					$this->returnWhere = $value->where;
					$fieldCnt = count($value->field->item);

					for($i=0; $i < $fieldCnt; $i++){
						$this->returnField[$i] =  $value->field->item[$i];
					}
				}
			}
		}else if($this->queType == "delete"){
			foreach ($this->xml->delete as $value){
				$id = $value["id"];

				if($this->proId == $id){
					$this->returnTable = $value->table;
					$this->returnWhere = $value->where;
				}
			}
		}else if($this->queType == "select"){
			foreach ($this->xml->select as $value){
				$id = $value["id"];

				if($this->proId == $id){
					$this->returnTable = $value->table;
					$this->returnWhere = $value->where;

					$fieldCnt = count($value->field->item);

					for($i=0; $i < $fieldCnt; $i++){
						$this->returnField[$i] =  $value->field->item[$i];
					}
				}
			}
		}
	}

	public function getDaoBeen($svName="", $proId="", $type=""){
		if($svName == "" || $proId == "" || $proId == "") exit;
		$this->svName = $svName;
		$this->proId = $proId;
		$this->queType = $type;
		
		$this->getXmlBeen();

		if($this->queType == "insert"){
			$this->returnVal["returnField"] = $this->returnField;
			$this->returnVal["returnTable"] = $this->returnTable;
		}else if($this->queType == "update"){
			$this->returnVal["returnField"] = $this->returnField;
			$this->returnVal["returnTable"] = $this->returnTable;
			$this->returnVal["returnWhere"] = $this->returnWhere;
		}else if($this->queType == "delete"){
			$this->returnVal["returnTable"] = $this->returnTable;
			$this->returnVal["returnWhere"] = $this->returnWhere;
		}else if($this->queType == "select"){
			$this->returnVal["returnField"] = $this->returnField;
			$this->returnVal["returnTable"] = $this->returnTable;
			$this->returnVal["returnWhere"] = $this->returnWhere;
		}

		return $this->returnVal;
	}
}
?> 