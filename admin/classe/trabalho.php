<?php
class Classe_Trabalho extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Trabalho";
	protected $_tabela = "trabalho";
	protected $_campos = array(
		"trb_cod"=>array("C�digo","incremento"),
		"usr_cod"=>array("Particpante","participante",true),
		"trb_titulo"=>array("T�tulo","texto",255,true),
		"trb_apresentador"=>array("Apresentador","texto",255,true),
		"trb_coautor"=>array("Coautor","texto",255),
		"trb_orientador"=>array("Orientador","texto",255,true),
		"trb_area"=>array("�rea","texto",255),
		"trb_areabasica"=>array("�rea B�sica","texto",255),
		"trb_outraqual"=>array("Outra Qual","texto",255),
		"trb_categoria"=>array("Categoria","texto",255,true),
		//"trb_resumo"=>array("Resumo","textarea",1500,false),
		"trb_referencia1"=>array("Refer�ncia 1","texto",500,true),
		"trb_referencia2"=>array("Refer�ncia 2","texto",500,true),
		"trb_referencia3"=>array("Refer�ncia  3","texto",500),
		"trb_palavraschave"=>array("Palavras Chaves","texto",255,true),
		"trb_frmapresentacao"=>array("Forma de Apresenta��o","texto",255,true),
		"trb_observacao"=>array("Observa��o","textarea",255,false),
		"trb_status"=>array("Status","status",255,true),
	);

	protected $_chavepk = "trb_cod";
	protected $_descritor = "trb_titulo";
}
?>