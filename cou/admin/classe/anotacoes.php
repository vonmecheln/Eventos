<?php
class Classe_Anotacoes extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Anotacoes";
	protected $_tabela = "anotacoes";
	protected $_campos = array("ant_cod"=>array("Cуdigo","chave"),
								"ant_titulo"=>array("Titulo","texto",60,true),
								"ant_texto"=>array("Descriзгo","textarea",250),
								"ant_data"=>array("Data","data",null,true),
								"usr_cod"=>array("Usuбrio","usuario",null,true),
								"stt_cod"=>array("Status","status")
								);
	protected $_chavepk = "ant_cod";
	protected $_descritor = "ant_titulo";
	protected $_formulario = array("form1"=>array("ant_cod","ant_data","ant_titulo","ant_texto","stt_cod"));
	
}
?>