<?php

class Classe_Programacao extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Programacao";
	protected $_tabela = "programacao";
	# campo => (label,tipo,tamanho,requerido)
	protected $_campos = array("prg_cod"=>array("C�digo","chave"),
								"prg_data"=>array("Data","data",60,true),
								"prg_hora"=>array("Hora","texto",20,true),
								"prg_tema"=>array("Tema","texto",60,true),
								"prg_palestrante"=>array("Palestrante","texto",60,false),
								"prg_descricao"=>array("Descri��o","textarea")
								);
	protected $_chavepk   = "prg_cod";
	protected $_descritor = "prg_tema";
	/*protected $_estrangeiros = array("mdl_cod"=>"Classe_Modulo");
	protected $_unicos = array("acao_nome");*/
}
?>