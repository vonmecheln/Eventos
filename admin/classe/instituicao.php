<?php
class Classe_Instituicao extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Instituicao";
	protected $_tabela = "instituicao";
	protected $_campos = array("inst_cod"=>array("Código","chave"),
								"inst_nome"=>array("Nome","texto",60,true),
								"inst_telefone"=>array("Telefone","telefone",15,false),
								"inst_contato"=>array("Contato","texto",60,true),
								"cid_cod"=>array("Cidade","cidade","",false)
								);
	protected $_chavepk   = "inst_cod";
	protected $_descritor = "inst_nome";
	
	/*protected $_formulario = array("trocarsenha"=>array("usr_senha"));*/
	protected $_unicos = array("inst_nome");
}
?>
