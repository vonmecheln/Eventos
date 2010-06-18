<?php
class Sistema_Mapa {
	
	protected $_mapas = null;
	
	public function __construct(){
		
	}
	
	public function setMapas($tabela,$array){
		$this->_mapas[$tabela] = $array;
	}
	
	public function getMapa($tabela){
		return $this->_mapas[$tabela];
	}
	
}
?>