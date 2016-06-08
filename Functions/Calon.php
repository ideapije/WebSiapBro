<?php

	require './Db/Query.php';
	/**
	* 
	*/
	class Calon extends Query{
		
		function __construct(){
			parent::__construct();
			$this->set_table('calon');
		}
		public function Register($data=array()){
			return $this->InsertData($data);
		}
		public function ShowAll(){
			return $this->getAll();
		}
	}
