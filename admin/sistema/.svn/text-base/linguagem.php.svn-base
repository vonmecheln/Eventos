<?php
class Sistema_Linguagem{
	
	private $_modulo = null;
	private $leng = "pt-br";
	
	public function __construct($modulo){
		$this->_modulo = strtolower($modulo);
	}
	
	public function getTitulos(){
		$arquivo = SISTEMA_DIR."modulo/linguagem/".$this->_modulo.".php";
		if(file_exists($arquivo)){
			$vetores = include($arquivo);
			return $vetores[$this->leng];
		}
		return array();
	}
	
}
?>