<?php
class Template_Parser {
	private $path_to_tpl;
	private $macros = array();
	private $left_delimiter = '{';
	private $right_delimiter = '}';
	
	public function ParseTpl($path_to_tpl, $macros = array(), $main=true) {
    	$this->path_to_tpl = $path_to_tpl;
    	$this->macros = $macros;
    	
    	if(!is_dir('templates/')) {
    		if(!is_dir('../templates/')) $dir = '../../templates/';
    		else $dir = '../templates/';
    	}
    	else $dir = 'templates/';

    	$file = file_get_contents($dir.$this->path_to_tpl);
    		
		foreach($this->macros as $key => $value) {
			$file = str_replace($this->left_delimiter.strtoupper($key).$this->right_delimiter, $value, $file);	
		}
		
		if ($main == true) print $file;
		else return $file;
    }
} 
?>
