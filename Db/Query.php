<?php
require_once 'Koneksi.php';
/**
* 
*/
class Query extends Koneksi{
	protected $statement;
	protected $table_name;
	protected $table_list = array();
	function __construct(){
		parent::__construct();
		$this->set_table_list();

	}
	public function set_table_list(){
		$res  = $this->db->prepare('show tables');
		$res->execute();
		$send = array();
		foreach ($res->fetchAll() as $key => $value) {
			$send[] = $value['Tables_in_siapbro'];
		}
		$this->table_list = $send;
	}
	public function set_table($table=''){
		if (in_array($table, $this->table_list)) {
			$this->table_name 	= $table;
		}
	}
	public function set_statement($str=''){
		$this->statement = $str;
	}
	public function getFields($implode=false){
		$send =array();
		if (!is_null($this->table_name)) {
			$this->set_statement('DESC '.$this->table_name);
			foreach ($this->ShowArray() as $key => $value) {
				if ($value['Field'] != 'id') {
					$send[] = $value['Field'];
				}
			}
		}
		return ($implode)? implode(',',$send) : $send;
	}
	public function getAll(){
		if (!is_null($this->table_name)) {
			$this->statement = 'select * from '.$this->table_name;
			return $this->ShowArray();
		}
		return false;

	}
	public function InsertData($data=array()){
		if (!is_null($this->table_name)) {
			$entry = implode('","', $data);
			$this->statement = 'INSERT INTO '.$this->table_name.'('.$this->getFields(true).') VALUES("'.$entry.'")';
			if ($this->RunQuery()) {
				return $this->db->lastInsertId();
			}
		}
		return false;
	}
	public function ShowArray(){
		if (!is_null($this->statement)) {
			$res =$this->db->prepare($this->statement);
			$res->execute();
			return $res->fetchAll();
		}
		return false;
	}
	
	public function RunQuery(){
		if (!is_null($this->statement)) {
			return $this->db->exec($this->statement);
		}
		return false;
	}


	

}
?>