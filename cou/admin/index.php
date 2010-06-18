<?php session_start(); # Start para a sess�o PHP

	# N�o deixa a p�gina permanecer no cache
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	
	/**
	 * @abstract Arquivo principal do sistema, todas as p�gina 
	 * que dever�o ser visualizadas no navegador ser�o chamadas 
	 * por este arquivo.
	 * 
	 * @copyright  -
	 * @author     -
	 * @version    1.0
	 * @since      10/03/2009
	 */
	
	# Inclui o arquivo de configura��o
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