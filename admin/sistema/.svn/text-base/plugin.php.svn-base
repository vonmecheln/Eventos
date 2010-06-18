<?php
abstract class Sistema_Plugin {
	
	/**
	 * @abstract Recebe o nome da classe para alguns plugins
	 * @var String
	 */
	protected $_classeEstrangeira = null;
	
	/**
	 * @abstract Recebe o nome da classe referente a tabela
	 * @var String
	 */
	protected $_classe = null;	
	
	/**
	 * @abstract Instancia do Sistema_Mensagem
	 * @var Sistema_Mensagem
	 */
	protected $_msg = null;
	
	public function __construct(){
		$this->_msg = Sistema_Mensagem::instanciar();
	}

    public function formataInsercao($valor){
        return $valor;
    }	
    
    public function formataExibicao($valor){
        return $valor;
    }	    
    
    /**
     * @abstract Recebe o nome da classe estrangeira
     * @param $classe
     */
    public function setClasseEstrangeira($classe){
    	$this->_classeEstrangeira = $classe;
    }
	
    /**
     * @abstract Recebe o nome da classe referente a tabela
     * @param $classe
     */
    public function setClasse($classe){
    	$this->_classe = $classe;
    }    
    
    public function valida($legenda,$valor) 
    {
		return TRUE;
    }

    public function verificaVazio($legenda,$valor,$requerido){
        if($requerido && $valor == ""){
    		return "O campo <u>".$legenda."</u> não pode estar vázio";
    	}
    	return FALSE;
    }

    
}
?>