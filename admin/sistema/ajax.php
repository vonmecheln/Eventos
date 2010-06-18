<?php
/**
 * @abstract Classe responsável por manipular as informações
 * que estão no Sistema_Mensagem ou informações adicionadas
 * manualmente e retorna-las por Ajax via JSON.
 * @copyright  -
 * @version    1.0
 * @author     -
 * @since      13/03/2009
 *
 */
class Sistema_Ajax
{
    /**
     * @abstract Vetor com os dados para serem
     * tranformados em JSON
     * @var Array
     */
    private $_dados  = null;
    /**
     * @abstract Objeto Sistema_AjaxBotao para adicionar
     * um botão na listagem
     * @var Sistema_AjaxBotao
     */
    private $_botoes = null;
    /**
     * @abstract Vetor com os dados das variaveis passadas
     * para integras os dados de retorno
     * @var Array
     */
    private $_vars   = null;
    
    /**
     * @abstract Construtor poderá receber um vetor com os dados
     * @param $dados
     */
    public function __construct($dados = null) {
        if ($dados) {
            $this->_dados = $dados;
        }
    }
    
    /**
     * @abstract Adiciona um vetor para ser gerado um JSON
     * @param $dados
     */    
    public function addJSON($dados) {
        $json = new Sistema_Json();
        $this->_dados = $json->encode($dados);
    }
    
    /**
     * @abstract Adiciona uma váriavel para o retorno
     * @param $nomeVar
     * @param $valores
     */
    public function addVar($nomeVar,$valores = null){
        //Se for um vetor, seta os campos um por um
        if (is_array($nomeVar)) {
            foreach ($nomeVar AS $nomevar=>$valor) {
                $this->addVar($nomevar,$valor);
            }
        //Se não for vetor, adiciona os valores
        } else {
            $this->_vars[$nomeVar] = $valores;
        }
    }    
    
    /**
     * @abstract Executa o comando para retornar os dados 
     * em JSON para o AJAx
     * @param $xjson
     * @return String JSON
     */
 	public function responde($xjson = false){
        
       
        
        $msg  = Sistema_Mensagem::instanciar();
        $json = new Sistema_Json();
        
        
        //Adiciona as Variáveis adicionais na resposta do Ajax
        if ($this->_vars != null) {
            foreach ($this->_vars AS $campo=>$valor) {
                $respostajax[$campo] = $valor;
            }
        }
        
        $respostajax['qtd']      = ($msg->getMensagem(true)) ? count($msg->getMensagem(true)) : 0;
        $respostajax['mensagem'] = ($msg->getMensagem());
        $respostajax['tipo']     = $msg->getTipo();
        $respostajax['campos']   = $msg->getCamposErro();
        $respostajax['erro']     = ($msg->temErro()) ? 1 : 0;
        $respostajax['alerta']   = ($msg->temAlerta()) ? 1 : 0;

		
        if(is_array($this->_botoes)){
        	foreach ($this->_botoes as $k=>$v){
        		$respostajax['botao'][]	 = $v;	
        	}
        }
        
        
        $resposta = $json->encode($respostajax);
        $resposta = str_replace("\n",'<br />',$resposta);
        # Verifica se irá retornar junto com o cabeçalho HTTP
		if($xjson){
			header("Content-Type: text/html; charset=iso-8859-1");
	    	header('X-JSON: '.$resposta);
		}else{
			# Retorna como texto
			header("Content-Type: text/html; charset=iso-8859-1");
			echo $resposta;	
		}
	    
    }    
    
    /*
    public function setBotao(Sistema_AjaxRespostaBotao $botao)
    {
    	if($botao instanceof Sistema_AjaxRespostaBotao ){
    		$this->_botoes[] = $botao->getBotaoVetores();
    	}else{
    		$msg  = Sistema_Mensagem::instanciar();
    		$msg->setErro(" Este botão não está instanciado para Sistema_BotaoFerramenta");
    	}	
    }*/
    
    

    
    
   

}



?>