<?php
class Classe_Modulo extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Modulo";
	protected $_tabela = "modulo";
	protected $_campos = array("mdl_cod"=>array("Código","chave",),
								"mdl_nome"=>array("Módulo","texto",60,true),
								"mdl_titulo"=>array("Titulo","texto",60,true),
								"mdl_ordem"=>array("Ordem no Menu","inteiro",2,true),
								"mnu_cod"=>array("Menu","estrangeiro",2,true)
								);
	protected $_chavepk = "mdl_cod";
	protected $_descritor = "mdl_titulo";
	
	protected $_estrangeiros = array("mnu_cod"=>"Classe_Menu");
	protected $_unicos = array("mdl_nome");
}
?>