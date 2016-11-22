<?
	require_once($_SERVER["DOCUMENT_ROOT"].'/class/DAO/setDaoXml.class.php');
	require_once($_SERVER["DOCUMENT_ROOT"].'/class/DAO/class.db.php');
	
	class DAO{
		private $svName;
		private $been;
		private $db;

		public function __construct($svName="") {
			$this->been = new SetDaoXml();
			$this->db = new db();
			$this->db->setErrorCallbackFunction("echo");
			$this->svName = $svName;
		}

		public function selectQuery($proId="", $bind="", $limitQuery=""){
			$DAObeen = $this->been->getDaoBeen($this->svName, $proId, "select");
			$selectField = join(",",$DAObeen["returnField"]);
			if(trim($DAObeen["returnWhere"]) == ""){
				$results = $this->db->select($DAObeen["returnTable"],"","",$selectField);
			}else{
				if($limitQuery == ""){
					$results = $this->db->select($DAObeen["returnTable"],$DAObeen["returnWhere"],$bind,$selectField);
				}else{
					$results = $this->db->select($DAObeen["returnTable"],$DAObeen["returnWhere"].$limitQuery,$bind,$selectField);
				}
			}
			return $results;
		}

		public function insertQuery($proId="", $bind=""){
			$DAObeen = $this->been->getDaoBeen($this->svName, $proId, "insert");
			
			$arrayCnt = count($DAObeen["returnField"]);
			for($i=0; $i < $arrayCnt; $i++){
				$keyVal = $DAObeen["returnField"][$i];
				$insertArray["$keyVal"] = $bind[$i];
			}
			$rtnVal = $this->db->insert($DAObeen["returnTable"],$insertArray);
			unset($DAObeen);
			return $this->db->lastInsertId();
		}

		public function updateQuery($proId="", $bind="", $whereBind=""){
			$DAObeen = $this->been->getDaoBeen($this->svName, $proId, "update");
			$arrayCnt = count($DAObeen["returnField"]);
			for($i=0; $i < $arrayCnt; $i++){
				$keyVal = $DAObeen["returnField"][$i];
				$updateArray["$keyVal"] = $bind[$i];
			}


			$this->db->update($DAObeen["returnTable"],$updateArray,$DAObeen["returnWhere"],$whereBind);
			unset($DAObeen);
		}

		public function deleteQuery($proId="", $bind=""){
			$DAObeen = $this->been->getDaoBeen($this->svName, $proId, "delete");

			$this->db->delete($DAObeen["returnTable"],$DAObeen["returnWhere"],$bind);
		}
	}
?>