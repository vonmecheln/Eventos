<?php
class Classe_Cursos extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Cursos";
	protected $_tabela = "cursos";
	protected $_campos = array("crs_cod"=>array("Código","chave"),
								"crs_titulo"=>array("Titulo","texto",100,true),
								"crs_horas"=>array("Total de Horas","inteiro",9,true),
								"crs_tipo"=>array("Tipo do Curso","tipocurso",100,true),
								"crs_professor"=>array("Professores","textarea")
								);
	protected $_chavepk = "crs_cod";
	protected $_descritor = "crs_titulo";
	protected $_unicos = array("crs_titulo");
	
}
?>