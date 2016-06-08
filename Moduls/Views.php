<?php
/**
* 
*/
class Views{
	protected 	$load_css;
	protected 	$load_js;
	private 	$pageVars = array();
	private 	$template;
	private 	$menu = array('Beranda'=>'?pg=home','Bantuan'=>'?pg=help');
	function __construct(){
		$this->set_enqueue();
	}

	public function Dir_asset_list($dir=''){
		$dir  = './Assets/'.$dir;
    	return $this->Dir_list($dir);
	}

	public function Dir_list($dir=''){
		$list = array();
		if (is_dir($dir)){
  			if ($dh = opendir($dir)){
    			while (($file = readdir($dh)) !== false){
    				if (!in_array($file,array('.','..'))) {
    					$list[] = $file;
    				}
    			}
    			closedir($dh);
    		}
    	}
    	return $list;
	}

	public function set_enqueue(){
		$this->load_css = $this->Dir_asset_list('css/');
		$this->load_js	= $this->Dir_asset_list('js/');
	}
	
	public function render_css(){
		$view = '';
		if (!is_null($this->load_css) && is_array($this->load_css)) {
			foreach ($this->load_css as $key => $value) {
				$view .='<link href="./Assets/css/'.$value.'" rel="stylesheet">';				
			}
		}
		return $view;
	}

	public function render_js(){
		$view ='';
		if (!is_null($this->load_js) && is_array($this->load_js)) {
			foreach ($this->load_js as $key => $value) {
				$view .='<script src="./Assets/js/'.$value.'"></script>';
			}
		}
		return $view;
	}

	public function add_menu($data=array()){
		$n_data = count($data);
		if ($n_data > 0) {
			$this->menu = array_merge($this->menu,$data);
		}
	}
	public function get_menu(){
		return $this->menu;
	}

	public function header_view(){
		$this->set('title','Siapbro!');
		$this->set('enqueue_css',$this->render_css());
		$this->set('menu',$this->get_menu());
		$this->template = './Templates/header.php';
		$this->render();
	}
	public function footer_view(){
		$this->set('enqueue_js',$this->render_js());
		$this->template = './Templates/footer.php';
		$this->render();	
	}


	public function set($var, $val){
		$this->pageVars[$var] = $val;
	}

	public function set_Template($tmp='',$render=false){
		if (in_array($tmp, $this->Dir_list('./Templates/'))) {
			$this->template = $tmp;
		}
	}

	public function render(){
		extract($this->pageVars);
		ob_start();
		require($this->template);
		echo ob_get_clean();
	}
	
}
