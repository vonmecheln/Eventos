<?php
class Classe_Menu extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Menu";
	protected $_tabela = "menu";
	protected $_campos = array("mnu_cod"=>array("C�digo","incremento",),
								"mnu_nome"=>array("Menu","texto",60,true),
								"mnu_ordem"=>array("Ordem no Menu","inteiro",2,true)
								);
	protected $_chavepk = "mnu_cod";
	protected $_descritor = "mnu_nome";
	protected $_unicos = array("mnu_nome");
}
?>