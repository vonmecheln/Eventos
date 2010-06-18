<?php
/**
 * Classe referente a tabela acao contendo
 * todas as a��es dos m�dulos
 */
class Classe_Acao extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Acao";
	protected $_tabela = "acao";
	# campo => (label,tipo,tamanho,requerido)
	protected $_campos = array("acao_cod"=>array("C�digo","chave"),
								"acao_nome"=>array("A��o","texto",60,true),
								"acao_titulo"=>array("Titulo","texto",60,true),
								"acao_ordem"=>array("Ordem no Menu","inteiro",2,true),
								"mdl_cod"=>array("M�dulo","estrangeiro",0,true),
								"acao_separador"=>array("Separdor","simnao",0,true)
								);
	protected $_chavepk   = "acao_cod";
	protected $_descritor = "acao_titulo";
	protected $_estrangeiros = array("mdl_cod"=>"Classe_Modulo");
	protected $_unicos = array("acao_nome");
}
?>