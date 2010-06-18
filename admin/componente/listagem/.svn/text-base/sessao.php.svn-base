<?php
session_start();
/**
 * @abstract Trata as sessoes da listagem
 *
 * @copyright  -
 * @version    1.0
 * @author     -
 * @since      11/03/2009
 */
class Componente_Listagem_Sessao {
	
	/**
	 * Nome da sessao
	 * @var string
	 */
	private $_nome = null;
	
	/**
	 * Construtor recebe o nome da listagem
	 * @param $nome
	 */
	public function __construct($nome=null){
		$nome = strtolower($nome);
		$this->_nome = $nome;
		$_SESSION['listagem'][$nome]['data'] = date("d-m-Y H:i:s");
	}
	
	/**
	 * Seta uma informaçao na sessao
	 * @param $nome
	 * @param $valor
	 */
	public function setDado($nome,$valor){
		$nome = strtolower($nome);
		$_SESSION['listagem'][$this->_nome][$nome] =$valor;
	}
	
	/**
	 * Retorna uma informacao da sessao
	 * @param $nome
	 * @return Array 
	 */
	public function getDado($nome){
		$nome = strtolower($nome);
		return $_SESSION['listagem'][$this->_nome][$nome];
	}
	
	/**
	 * Retorna todas as informações da sessao
	 * @return Array
	 */
	public function getSessao(){
		return $_SESSION['listagem'][$this->_nome];
	}
	
	
	
	/**
	 * Destroi a sessao
	 */
	public function destruir($nome = null){
		$this->_nome = (is_null($nome)) ? $this->_nome : $nome;
		$_SESSION['listagem'][$this->_nome] = null;
		unset($_SESSION['listagem'][$this->_nome]);
	}
	
}
?>