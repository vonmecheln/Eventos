<?php
class Modulo_Configuracao extends Sistema_Modulo{
	
	public function acaoTesteAcao(){
		$l = Sistema_Layout::instanciar();
		$m = Sistema_Mensagem::instanciar();
		$m->setSucesso("tESte");
		$l->setNomePagina("Teste para A��o");
		$l->setCorpo("Texto Acao");
	}

	public function ajaxTesteAjax(){
		echo "ajax".$_GET['a'];
	}	
	
}
?>