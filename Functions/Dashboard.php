<?php

require 'Moduls/Views.php';

/**
* 
*/
class Dashboard extends Views{
	
	function __construct(){
		parent::__construct();
	}
	
	public function home(){
		$this->header_view();
		$this->footer_view();
	}

}
?>