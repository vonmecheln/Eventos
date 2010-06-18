<?php
class Classe_EntradaCursos extends Sistema_Persistencia {
	
	protected $_classe = "Classe_EntradaCursos";
	protected $_tabela = "entrada_cursos";
	protected $_campos = array("etcr_cod"=>array("Código","chave"),
								"crs_cod"=>array("Curso","estrangeiro",9,true),
								"usr_cod"=>array("Participante","inteiro",9,true),
								"etcr_data"=>array("Data","data")
								);
	protected $_chavepk = "etcr_cod";
	protected $_descritor = "crs_cod";
	protected $_formulario = array("form1"=>array("etcr_cod","crs_cod","usr_cod"));
	protected $_estrangeiros = array("crs_cod"=>"Classe_Cursos");
	
}
?>