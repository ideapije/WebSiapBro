<?php
class Koneksi{
	public $db;
	function __construct(){
		$this->set_database();
	}
	function set_database(){
		$dbh = new PDO('mysql:host=localhost;dbname=siapbro', 'root', 'jvmdev-123');
		$this->db = $dbh;
	}
}