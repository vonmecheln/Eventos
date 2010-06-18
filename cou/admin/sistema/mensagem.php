<?php

class Sistema_Mensagem
{
    //Vetor que armazena as mensagens de erro 
    private $erros;
    //Vetor que armazena as mensagens de sucesso
    private $sucesso;
    //Vetor que armazena as mensagens de alerta
    private $alerta;

    //Vetor com os campos que deram erros
    private $_camposErro;
    
    //SingleTon Design Pattern 
    static private $_instancia = null;
	/**
	 * __construct()
	 * 
	 * @author Everton Emilio Tavares
	 * @access public
	 */
    private function __construct() 
    {
        $this->erros = Array();
    }
	
	/**
     *	instanciar()
     *
     *	Fornece o Singleton para a classe
     *
	 * @author Everton Emilio Tavares
	 * @access public
	 * @return Sistema_Mensagem
     */	
    public static function instanciar()
    {
        if (!self::$_instancia instanceof self) {
            self::$_instancia = new self();
        }
        return self::$_instancia;
    }
	
    /**
	 * 
	 * setCampoErro
	 * 
	 * @abstract
	 * Seta um campo que deu erro
	 * 
	 * @param String $nomeCampo - Nome (id) do campo que deu erro
	 * 
	 * @author Everton Emilio Tavares
	 * @access public
	 */
    public function setCampoErro($nomeCampo)
    {
        //$this->_camposErro[$nomeCampo] = $nomeCampo;
        $this->_camposErro[] = $nomeCampo;
    }
    
    
	/**
	 * 
	 * setErro
	 * 
	 * @abstract
	 * Seta uma nova mensagem de erro a execução
	 * 
	 * @param $strErro - Mensagem de erro a ser adicionada
	 * 
	 * @author Everton Emilio Tavares
	 * @access public
	 */
    public function setErro($strErro)
    {
	    if (($this->erros == null) || array_search($strErro,$this->erros) === false) {
            $this->erros[] = $strErro;
	    }
    }


    /**
	 * 
	 * setSucesso
	 * 
	 * @abstract
	 * Seta uma nova mensagem de sucesso a execução
	 * 
	 * @param $strErro - Mensagem de sucesso a ser adicionada
	 * 
	 * @author Everton Emilio Tavares
	 * @access public
	 */
	public function setSucesso($strSucesso)
	{
	    if (($this->sucesso == null) || (array_search($strSucesso,$this->sucesso) === false)) {
	        $this->sucesso[] = $strSucesso;
	    }
	}

    /**
	 * 
	 * setAlerta
	 * 
	 * @abstract
	 * Seta uma nova mensagem de Alerta a execução
	 * 
	 * @param $strErro - Mensagem de alerta a ser adicionada
	 * 
	 * @author Everton Emilio Tavares
	 * @access public
	 */
	public function setAlerta($strAlerta)
	{
		$this->alerta[] = $strAlerta;
	}

	
    /**
     * 
     * getMensagem
     * 
     * @abstract
     * Retorna as mensagens existentes, com a seguinte prioridade:
     * - Mensagem de Erro
     * - Mensagem de Alerta
     * - Mensagem de Sucesso
     * Não retorna mensagens de dois tipos distintos.
     *
     * @return String com a mensagem.
     * 
     * @author Everton Emilio Tavares 
     * @access public
     * 
     */
    public function getMensagem($array = false)
    {
        if (count($this->erros) > 0){
            $retorno = $this->erros;
        } else if (count($this->alerta) > 0){
        	$retorno = $this->alerta;
        } else if (count($this->sucesso) > 0) {
        	$retorno = $this->sucesso;
        } else {
            return false;
        }
        
        if ($array) {
            return $retorno;
        } else {
            return implode("<br />",$retorno);
        }
    }

    /**
     * 
     * getCampoErro
     * 
     * @abstract
     * Retorna o vetor com os campos 
     * 
     * @return 
     * @author Everton Emilio Tavares
     * @access public
     */
    public function getCamposErro()
    {
        return $this->_camposErro;
    }
    

   /**
    * 
    * getTipo
    * 
    * @abstract
    * Retorna o tipo de mensagem presente no sistema.
    * 
    * @return string com o tipo da mensagem ('erro','sucesso','alerta') ou
    *         false caso não exista mensagem.
     * @author Everton Emilio Tavares
     * @access public
     */
    public function getTipo() 
    {

        if (count($this->erros) > 0){
        	return "erro";
        } else if (count($this->alerta) > 0){
        	return "alerta";
        } else if (count($this->sucesso) > 0) {
        	return "sucesso";        	
        }
        return false;
    }
    
    
    /**
     * 
     * temErro
     * 
     * @abstract
     * Identifica se ocorreu um erro
     * 
     * @return Boolean - Verdadeiro caso tenha ocorrido erro, Falso caso não
     * tenha ocorrido
     * 
     * @author Everton Emilio Tavares
     * @access public
     * 
     */
    public function temErro()
    {        
        if (count($this->erros) > 0) {
        	return true;
        } else {
        	return false;
        }
    }
    
    
    /**
     * 
     * temAlerta
     * 
     * @abstract
     * Identifica se ocorreu alguma mensagem de Alerta no Sistema
     * 
     * @return Boolean - Verdadeiro caso tenha ocorrido erro, Falso caso não
     * tenha ocorrido
     * 
     * @author Everton Emilio Tavares
     * @access public
     * 
     */
    public function temAlerta()
    {
        if (count($this->alerta) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * limparMensagem
     * 
     * @abstract 
     * Limpa os vetores que contém as mensagens
     * 
     * @param bool erro diz ser as mensagens de erro serão limpas
     * @param bool alerta diz se as mensagens de alerta serão limpas
     * @param bool sucesso diz se as mensagens de sucesso serão limpas
     * 
     * @return null
     * 
     * @author Anselmo Luiz Éden Battii
     * @access public
     * */
    public function limparMensagem($erro=true,$alerta=true,$sucesso=true){
        if($erro) {
            $this->erros = null;
        }
        if($alerta) {
            $this->alerta = null;
        }
        if($sucesso) {
            $this->sucesso = null;
        }
        return;
    }
}

?>