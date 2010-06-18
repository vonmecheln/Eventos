<?php
session_start();
/**
 * @abstract Classe que manipula os menus do sistema.
 *
 * @copyright  -
 * @version    1.0
 * @author     -
 * @since      10/03/2009
 */
class Sistema_Menu {
	
	public function __construct(){
		
	}
	
	/**
	 * @abstract Retorna uma lista HTML com o menu
	 * @return unknown_type
	 */
	public function getMenu(){
		$menu = unserialize($_SESSION['menu']);
		
		# Monta a lista em cima do vetor menu
		$lista = "<ul id='nav'>";
		foreach($menu as $nomemenu=>$modulo){
			$lista .= sprintf("<li><a href='#' class='daddy1'>%s</a><ul>",ucwords(strtolower($nomemenu)));
			foreach($modulo as $titulo=>$links){
				$lista .= sprintf("<li><a href='#' class='daddy2'>%s</a><ul>",ucwords(strtolower($titulo)));
				if(is_array($links)){
					foreach($links as $v){
						$separador = ($v['separador']) ? " style='border-bottom:1px solid #CCC;' " :"";
						$lista .= sprintf("<li %s ><a href='%s' style='%s'>%s</a></li>",$separador,$v['link'],$v['css'],$v['nome']);
					}	
				}
				$lista .= "</ul></li>";
			}
			$lista .= "</ul></li>";
		}
		//$lista .= sprintf("<li><a href='%ssair.php' class='sair'>Sair</a></li>",SISTEMA_URL,$sair);
		$lista .= "</ul>";
		
		return sprintf("%s",$lista);
	}
	
}
?>
