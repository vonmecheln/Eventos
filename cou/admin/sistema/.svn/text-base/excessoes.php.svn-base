<?php
/**
 * Sistema_Excessoes
 *
 * @abstract Esta classe é responsável pelo controle
 * das excessoes geradas pelo sistema. Ela extende
 * a classe Exception do PHP, e padroniza as mensagem
 * de retorno.
 *
 * @example
 *   	try{
 * 			if (true) {
 * 				echo "OK";
 * 			}else{
 * 				$mensagem = "Erro";
 * 				$tipo = 0;
 * 				throw new Sistema_Excessoes($mensagem,$tipo);
 * 			}
 * 		}catch(Sistema_Excessoes $e){
 * 			echo($e);
 * 		}
 *
 * @author Alexandre Magno Semmer
 * @version 2.0
 * @since 17/12/2007
 * @package sistema
 *
 */
class Sistema_Excessoes extends Exception  {

	  /**
	   * Recebe a mensagem de excessão
	   */
	public function __construct($message, $code = 0) {
	  	$_SESSION["excessao"] = null;
	  	unset($_SESSION["excessao"]);
	  	 # Garante que tudo é atribuído corretamente
	   	parent::__construct($message, $code);

	}

	public function getTipoErro(){
  	  	switch($this->code){
  	  		case 0: /**
  	  				* Erro mostrado quando um arquivo ou diretório
  	  				* é chamado pelo sistema e não existe
  	  				*/
  	  				$tipo = "<b>NÃO ENCONTRADO</b>";
  	  				break;
  	  		case 1:/**
  	  				* Erro mostrado quando um valor é passado
  	  				* de forma incorreta a uma variavel
  	  				*/
  	  			    $tipo = "<b>TIPO INVÁLIDO</b>";
  	  			    break;
  	  		case 2:/**
  	  				* Erro mostrado quando é trabalhado
  	  				* com vetor de maneira erronea
  	  				*/
  	  			    $tipo = "<b>VETOR INVÁLIDO</b>";
  	  			    break;
		    case 3: /**
		             * Um método que não existe foi chamado em uma classe
		             ***/
		             $tipo = "<b>MÉTODO INEXISTENTE</b>";
		             break;
            case 4:
            		$tipo = "<b>SQL ERROR</b>";
					break;
            case 5:
            		$tipo = "<b>INESPERADO</b>";
					break;
            case 6:
            		$tipo = "<b>ERRO DE SISTEMA</b>";
					break;
            case 7:
            		$tipo = "<b>ERRO NA PERSISTÊNCIA</b>";
					break;
            case 8:
            		$tipo = "<b>PROPRIEDADE INEXISTENTE</b>";
            		break;
            case 9:
            		$tipo = "<b>MÉTODO INVÁLIDO</b>";
            		break;            		
  	  		default:
  	  				$tipo = "ERRO ";
  	  				break;
  	  	}
  	  	return $tipo;
	}

	  /**
	   * __toString()
	   *
	   * @abstract Representação do objeto personalizada no formato string
	   *
	   * @return String
	   */
	public function __toString() {
		$tipo = $this->getTipoErro();
		
		# Verifica se o erro é um metodo invalido
		if($this->code == 9){
			return "";
		}
		

		$err = sprintf("<br><p>
						<div style='color:#FFFFFF;background-color:#666666; padding:1px'><h2>%s</h2></div>
						<b>CÓDIGO</b> : %d <br>
						<b>MENSAGEM</b> : %s <br>
						<b>ARQUIVO</b> : %s <br>
						<b>LINHA</b> : %s
						<div style='color:#FFFFFF;background-color:#666666'>&nbsp;</div>
						</p>",
						$tipo,
  						Exception::getCode(),
  						Exception::getMessage(),
  						Exception::getFile(),
  						Exception::getLine());

  	  	return $err;
  	  }

	public function setSessao(){
		$vetorExcessao['tipo'] = utf8_encode($this->getTipoErro());
		$vetorExcessao['code'] = Exception::getCode();
		$vetorExcessao['file'] = Exception::getFile();
		$vetorExcessao['line'] = Exception::getLine();
		$vetorExcessao['message'] = utf8_encode(Exception::getMessage());

		$_SESSION['excessao'] = $vetorExcessao;
	}

  	  /**
  	   * getErro()
  	   *
  	   * @abstract Retorna o erro com uma formatação
  	   * mais amigavél e interativa com o usuário.
  	   * Com a intenção de ser utilizado para erros
  	   * do usuário.
  	   *
  	   * @return String
  	   *
  	   */
  	public function getErro(){

  	  //	$_SESSION["excessao"] = true;

		$err = sprintf("<div id='msg_id' align='center' style='color:#FFFFFF;background-color:#990000; padding:2px; z-index:100'>" .
						"<h2>MENSAGEM DE ERRO</h2>" .
						"<h3>%s</h3>" .
						"<input type='button' onclick='document.getElementById(\"msg_id\").visible=false' value='Fechar'/>" .
						"</div>",
  						Exception::getMessage());
  	  	return $err;
  	  }

  	  /**
  	   * temExcessao()
  	   *
  	   * @abstract Verifica na sessão se foi encontado uma excessão
  	   *
  	   * @return Boolean Sessao referente ao status da exception
  	   *
  	   * @todo Criar um nome para a sessão
  	   */
  	  public static function temExcessao(){
		//	return $_SESSION["excessao"];
  	  }
 }
?>
