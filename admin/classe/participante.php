<?php
class Classe_Participante extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Participante";
	protected $_tabela = "participante";
	protected $_campos = array("tpp_cod"=>array("Código","chave",),
								"tpp_nome"=>array("Tipo","texto",60,true),
								"tpp_desc"=>array("Descrição","texto",100,false),
								"usr_cod"=>array("Usuario","inteiro","",false),
								"tpp_cracha"=>array("Nome no Crachá","texto",60,false)
								);
	protected $_chavepk   = "tpp_cod";
	protected $_descritor = "tpp_nome";
	protected $_estrangeiros = array("usr_cod"=>"Classe_Usuario");
		
}
?>
