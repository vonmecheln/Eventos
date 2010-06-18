<?php
class Classe_Grupo extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Grupo";
	protected $_tabela = "grupo";
	protected $_campos = array("grp_cod"=>array("C�digo","chave"),
								"grp_nome"=>array("Grupo","texto",60,true),
								"grp_descricao"=>array("Descri��o","texto",70),
								"stt_cod"=>array("Status","status")
								);
	protected $_chavepk = "grp_cod";
	protected $_descritor = "grp_nome";
	protected $_unicos = array("grp_nome");
	
}
?>