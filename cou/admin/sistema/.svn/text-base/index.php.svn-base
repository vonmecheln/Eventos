<?php
class Sistema_Index{
	
	public function __construct(){}
	
	public function principal(){
		
		$layout   = Sistema_Layout::instanciar();
		$layout->includeCss(SISTEMA_URL."sistema/index/css/estilo.css");		
		
		$template = new Sistema_Layout_Tela("sistema/index/template/index.tpl");
		
		
		$anot = new Sistema_Index_Anotacoes();
		$template->addVar("titulo_anotacoes","Anotações/Tarefas Agendadas");
		$template->addVar("conteudo_anotacoes",$anot->getUltimasAnostacoes(5));
		$atalhos = new Sistema_Index_Atalhos();
		$template->addVar("titulo_atalho","Atalhos");
		$template->addVar("conteudo_atalhos",$atalhos->getAtalhos());
		
		$layout->setNomePagina("Principal");
		$layout->setCorpo($template->getTela());		
		
	}
	
	

}
?>