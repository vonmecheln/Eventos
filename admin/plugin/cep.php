<?php
class Plugin_Cep extends Sistema_Plugin 
{
    public function formataInsercao($valor){
    	return sprintf("'%s'",$valor);
    }
    
	public function formataExibicao($valor){
    	return $valor;
    }    
    
	/**
	 * Cria um campo CPF
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {
    	
    	$l = Sistema_Layout::instanciar();
    	$l->includeJavaScript(SISTEMA_URL."javascript/mascara/mascara.js");
    	
    	return sprintf('<input type="text" name="%s" id="%s" value="%s" size="10" maxlength="9" onkeypress="return mascara(null,\'%s\',\'99999-999\', event);" />',
    					$nome_campo,$nome_campo,$valor_campo,$nome_campo);
    }
    
    public function valida($legenda,$valor) 
    {
    	if($valor == "") return true;
    	
		$pattern = "/^([0-9]{2})\.?([0-9]{3})-?([0-9]{3})$/";			
		if (preg_match($pattern, $valor)) {
			return TRUE;
		} else {
			return "O campo ".$legenda." n�o � um CEP v�lido";
		}
    }    
    
}

?>