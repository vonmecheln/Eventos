<?php
class Classe_Comprovante extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Comprovante";
	protected $_tabela = "comprovante";
	protected $_campos = array("cmp_cod"=>array("Código","chave",),
								"cmp_img"=>array("Comprovante","imagem",120,true),
								"cmp_data"=>array("Data","textohtml",100,false),
								"stt_cod"=>array("Status","status","",false),
								"usr_cod"=>array("Usuario","inteiro","",false),
								"cmp_obs"=>array("Observação","textohtml",200,false)
								);
	protected $_chavepk   = "cmp_cod";
	protected $_descritor = "cmp_img";
	protected $_formulario = array("form1"=>array("cmp_cod","cmp_data","cmp_obs","stt_cod","cmp_img"));
		
}
?>
