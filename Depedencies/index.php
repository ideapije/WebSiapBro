<?php
function set_require($dir=''){
	if (is_dir($dir)){
  			if ($dh = opendir($dir)){
    			while (($file = readdir($dh)) !== false){
    				if (!in_array($file,array('.','..','index.html'))) {
    					require $dir.'/'.$file;
    				}
    			}
    			closedir($dh);
    		}
	}
}
set_require('./Functions/');
?>
