<?php session_start(); # Start para a sessуo PHP

	# Nуo deixa a pсgina permanecer no cache
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	
	/**
	 * @abstract Arquivo principal do sistema, todas as pсgina 
	 * que deverуo ser visualizadas no navegador serуo chamadas 
	 * por este arquivo.
	 * 
	 * @copyright  -
	 * @author     -
	 * @version    1.0
	 * @since      10/03/2009
	 */
	
	# Inclui o arquivo de configuraчуo
	include 'config.php';
	
	# Instancia a classe para mensagens
	$mensagem = Sistema_Mensagem::instanciar();

	# Instancia a classe de controle do sistema
	$controle = Sistema_Controle::instanciar();
	# Executa o controle 
    $controle->executar();

    # Exibe o conteudo
    $template = Sistema_Layout::instanciar();
    $template->exibir();    
    
	
?>