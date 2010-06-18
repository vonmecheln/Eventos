<?php
class Classe_Permissoes extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Permissoes";
	protected $_tabela = "permissoes";
	protected $_campos = array("prm_cod"=>array("Cуdigo","chave"),
								"prm_salvar"=>array("Salvar","simnao"),
								"prm_exibir"=>array("Exibir","simnao"),
								"prm_inativa"=>array("Inativar","simnao"),
								"grp_cod"=>array("Grupo","estrangeiro","",false),
								"acao_cod"=>array("Aзгo","estrangeiro","",false)
								);
	protected $_chavepk   = "prm_cod";
	//protected $_descritor = "usr_nome";
	
	protected $_estrangeiros = array("grp_cod"=>"Classe_Grupo","acao_cod"=>"Classe_Acao");
}
?>