<?php
/***********************************************************
 * 			CONFIGURA��ES GERAIS
 ***********************************************************/
	 # Seta o timezone da data que o sitema ir� 
	 # utilizar, no caso, o formato de data Brasileiro
	 date_default_timezone_set("America/Sao_Paulo");

	 # Fun��o que seta os erros que dever�o ser tratado pelo PHP, 
	 # no caso todo tipo de erro gerado pelo PHP
	 error_reporting(E_ALL);	
	
	 # M�todo que seta qual fun��o sera chamada
	 # quando ocorrer um erro gerado pelo PHP. 
	 set_error_handler('my_error_handler');

	 // constantes
	 define("ATIVO",1);
	 define("BLOQUEADO",2);
	 define("CANCELADO",3);
	 define("EMANALISE",4);
	 define("ACEITO",5);
	 define("ACEITOCOMRESALVAS",6);
	 define("REJEITADO",7);	 

	// email sem o @ anselmobattisti
	 define("EMAIL","cou_unioeste");
	 define("EMAIL_SENHA","cou2008");
	 
/***********************************************************
 * 			DEFINI��ES DE VARI�VEIS DO SISTEMA
 ***********************************************************/
    define('SISTEMA_DIR', '/var/www/eventos/cou/admin/');
    define('SISTEMA_URL', 'http://projetos.unioeste.br/eventos/cou/admin/');
	define('UPLOAD_DIR', SISTEMA_DIR.'../trabalhos/files/');
	define('COMPROVANTE_DIR', SISTEMA_DIR.'../trabalhos/comprovantes/');

    define('SISTEMA_INDEX', 'http://projetos.unioeste.br/eventos/cou/admin/index.php'); 
	define('SISTEMA_SITE', 'http://projetos.unioeste.br/eventos/cou/');       
    
	define('COMPROVANTE_URL', SISTEMA_SITE.'trabalhos/comprovantes/');

    # difine qual o nome da base de dados que o sistema esta usando.
    define('BASE','eventos_cou');
	# Usuario do banco 
	define("USUARIO","alebatistti");
	# Senha do banco
	define("PSWORD","1234");
	# Servidor
	define("LOCALHOST","localhost");
	# Parametro referente ao modulo do sistema
	define("MODULO","mod");
	# Parametro Referente a acao do sistema
	define("ACAO","act");
	# C�digo (grp_cod) do grupo desenvolvedor
	define("DESENVOLVEDOR",1);
	# Parametro para indicar quando sera exibido uma tela em uma janela
	define("JANELA","jan");	

/***********************************************************
 * 			FUN��ES INICIAIS DO SISTEMA
 ***********************************************************/    
	/**
	 * my_error_handler()
	 * 
	 * @abstract Configura��o das Exception do PHP, que ser�o
	 * interceptadas pelo sistema, possibilitando a padroniza��o
	 * das mensagens de erros, al�m de aumentar a seguran�a do 
	 * c�digo escrito.
	 * 
	 * @return String 
	 * @param $code Integer
	 * @param $message String
	 * @param $file String
	 * @param $line Integer
	 */
	function my_error_handler($code, $message, $file, $line){
		
	    $code = $code & error_reporting();
	    if($code == 0) return;
	    if(!defined('E_STRICT'))            define('E_STRICT', 2048);
	    if(!defined('E_RECOVERABLE_ERROR')) define('E_RECOVERABLE_ERROR', 4096);
	    
	    switch($code){
	        case E_ERROR:  
				  $tipo = "<b>ERRO:</b>";   
				  break;
	        case E_WARNING: 
				  $tipo = "<b>AVISO:</b>";   
				  break;
	        case E_PARSE:   
				  $tipo = "<b>ERRO ESCRITA:</b>";   
				  break;			
	        case E_NOTICE:  // Constantes do banco retornam esse erro 
	        	  return;    
				  $tipo = "<b>OBSERVA��O:</b>";   
				  break;
	        case E_CORE_ERROR:   
				  $tipo = "<b>ERRO INTERNO DO PHP:</b>";   
				  break;			      
	        case E_CORE_WARNING:      
				  $tipo = "<b>AVISO INTERNO DO PHP:</b>";   
				  break;
	        case E_COMPILE_ERROR:     
				  $tipo = "<b>ERRO DE COMPILA��O:</b>";   
				  break;
	        case E_COMPILE_WARNING:    
				  $tipo = "<b>AVISO DE COMPILA��O:</b>";   
				  break;
	        case E_USER_ERROR:   
				  $tipo = "<b>ERRO DE USU�RIO:</b>";   
				  break;		 
	        case E_USER_WARNING:
				  $tipo = "<b>AVISO AO USU�RIO:</b>";   
				  break;
	        case E_USER_NOTICE: 
				  $tipo = "<b>OBSERVA��O AO USU�RIO:</b>";   
				  break;			
	        case E_STRICT:   // ADODB Retorna esse erro
	        	  return;
				  $tipo = "<b>OBSERVA��O ESTRITA:</b>";   
				  break;
	        case E_RECOVERABLE_ERROR: 
				  $tipo = "<b>RECOBERABLE ERROR:</b>";   
				  break;
				  
	        default: 
				  $tipo = sprintf("<b>ERRO DESCONHECIDO: (%s) </b>",$code);   
				  break;			  
	    }
	    
		$err = sprintf("<br><p>
						<div style='color:#FFFFFF;background-color:#666666; padding:1px'><h2>%s</h2></div>
						<b>C�DIGO</b> : %d <br>
						<b>MENSAGEM</b> : %s <br>
						<b>ARQUIVO</b> : %s <br>
						<b>LINHA</b> : %s 
						<div style='color:#FFFFFF;background-color:#666666'>&nbsp;</div>
						</p>",
						$tipo,
						$code,
						$message,
						$file,
						$line);  
						
		echo $err;
	}

	/**
	 * __autoload()
	 * 
	 * @abstract Fun��o que � invocada sempre que uma 
	 * classe � instanciada e seu arquivo correspondente
	 * n�o foi incluido.
	 *
	 * @param string $classe
	 * @return boolean
	 */
 	function __autoload($classe) {
    
 		# Verifica se classe ja existe
 	    if(class_exists($classe)){
 	   	 	return true;
 	    }
 	    
 	    # Monta o caminho do arquivo conforme o nome da classe
 	    # Diretorio_Diretorio_NomeArquivo
 	    # diretorio/diretorio/nomearquivo.php
 	    $caminho  = explode('_',strtolower($classe));
 	    $arquivo  = SISTEMA_DIR . strtolower(implode("/",$caminho)) . ".php";
		
 	     # S� inclui se for um arquivo do sistema
 	    $diretorios = array("classe","componente","modulo","plugin","sistema");
 	    if(in_array($caminho[0],$diretorios)){
 	    	try{
 	    		# Verifica se o arquivo existe
				if (file_exists($arquivo)) {
					# Inclui o arquivo
	            	require_once $arquivo;
	            	return true;
				} else {
					# Mensagem para excess�o
					$mensagem = sprintf("Arquivo n�o existe : <i style='color:#3333FF'>%s</i>",$arquivo);
					$cod = ($caminho[0] == "modulo") ? 9 : 0;
					throw new Sistema_Excessoes($mensagem,$cod);
				}
 	    	}catch(Sistema_Excessoes $e){
	 	    		# retorna a excess�o
	 	    		echo($e);
 	    	}
 	    }else{
 	    	return true;
 	    } 	    
 	}	
?>