<?php

if (!class_exists("Smarty")) {
    #Carrega a Classe Smarty
    require_once SISTEMA_DIR.'sistema/smarty/Smarty.class.php';
}

class Sistema_Layout_Tela extends Smarty
{
	    
    private $_template;
    
    
    /**
     * Construtor da Classe
     * @example "templates/index.tpl"
     * @param string $template caminho do template
     */
    public function __construct($template)
    {
        
        $msg = Sistema_Mensagem::instanciar();
        
        $this->template_dir = SISTEMA_DIR . 'templates';
    	$this->compile_dir  = SISTEMA_DIR . 'templates/templates_c';
    	$this->config_dir   = SISTEMA_DIR . 'templates/configs';
    	$this->cache_dir    = SISTEMA_DIR . 'templates/cache';

    	$this->caching = false;
        
        $template_nome = SISTEMA_DIR . $template;
        if (file_exists($template_nome)) {        	
            $this->_template = $template_nome;
        } else {
            $msg->setErro("Erro ao Criar Template: Arquivo de Template não é válido");
            return false;
        }
        $this->addVar("SISTEMA_URL",SISTEMA_URL);
    }
    
    /**
     * Adiciona uma váriavel no template
     *
     * @param String $nome
     * @param Mixed $valor
     */
    public function addVar($nome,$valor) {
        $this->assign($nome,$valor);
    }
    
    /**
     * Adiciona um Vetor de variáveis no sistema
     * o vetor deve ter o seguinte formato:
     * 
     * nome da variavel => valor da variavel
     *
     * @param Array $vetor
     */
    public function addVetorVar($vetor) {
        if (is_array($vetor)) {
            $this->assign($vetor);
        }
    }
   

    /**
     * Retorna o template "preenchido"
     *
     * @return String
     */
    public function getTela()
    {
        return $this->fetch($this->_template);
    }
}

?>