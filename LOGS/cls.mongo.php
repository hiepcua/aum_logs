<?php
class CLS_MONGO{
	private $pro=array(	'HOSTNAME'=>'localhost',
						'USERNAME'=>'trungvq',
						'PASSWORD'=>'trungvq@2020',
						'DATANAME'=>'aumsys','PORT'=>'27017');
	private $conn=NULL;
	private $rs;
	private $lastid;
	public function __construct(){
		$this->HOSTNAME=HOSTNAME;
		$this->USERNAME=DB_USERNAME;
		$this->PASSWORD=DB_PASSWORD;
		$this->DATANAME=DB_DATANAME;
		$this->PORT=DB_PORT;
	}
	private function connect(){
		$conn=new MongoDB\Driver\Manager("mongodb://".$this->HOSTNAME.":".$this->PORT, array("username" => $this->USERNAME, "password" => $this->PASSWORD,"database"=>'admin'))
		if(!$conn){
			echo "Can't connect MySQL Server!";
			return false;
		}
		$this->conn=$conn;
		return true;
	}
	// function query
	public function Insert($_data=[]){
		$bulk = new MongoDB\Driver\BulkWrite;
		$bulk->insert($_data);
		//$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
		$result=$this->conn->executeBulkWrite('db.collection', $bulk);
		$this->lastids=$result->getUpsertedIds();
	}
	public function Update($_data=[],$_where=[]){
		$option=['multi' => false, 'upsert' => false];
		$bulk = new MongoDB\Driver\BulkWrite;
		$bulk->update($_where,['$set'=>$_data],$option);
		$result=$this->conn->executeBulkWrite('db.collection', $bulk);
		if($result->getModifiedCount()>0){
			return true;
		}else{
			foreach ($result->getWriteErrors() as $writeError) {
				printf("Operation#%d: %s (%d)\n", $writeError->getIndex(), $writeError->getMessage(), $writeError->getCode());
			}
			return false;
		}
	}
	public function Upsert($_data=[],$_where=[]){
		$option=['multi' => false, 'upsert' => true];
		$bulk = new MongoDB\Driver\BulkWrite;
		$bulk->update($_where,['$set'=>$_data],$option);
		$result=$this->conn->executeBulkWrite('db.collection', $bulk);
		if($result->getUpsertedCount()>0){
			return true;
		}else{
			foreach ($result->getWriteErrors() as $writeError) {
				printf("Operation#%d: %s (%d)\n", $writeError->getIndex(), $writeError->getMessage(), $writeError->getCode());
			}
			return false;
		}
	}
	public function Del($_where=[],$_limit=[]){
		$bulk = new MongoDB\Driver\BulkWrite;
		$bulk->delete($_where,$_limit);
		$result=$this->conn->executeBulkWrite('db.collection', $bulk);
		if($result->getDeletedCount()>0){
			return true;
		}else{
			foreach ($result->getWriteErrors() as $writeError) {
				printf("Operation#%d: %s (%d)\n", $writeError->getIndex(), $writeError->getMessage(), $writeError->getCode());
			}
			return false;
		}
	}
	public function find(){
		$c = new MongoDB\Driver\Query($filter, $options);
	}
}
?>