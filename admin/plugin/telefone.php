<?php
class Plugin_Telefone extends Sistema_Plugin 
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
    	
		$layout = Sistema_Layout::instanciar();
		$layout->includeJavaScript("javascript/mascara/mascara.js");
    	
    	return sprintf('<input type="text" maxlength="15" size="15" name="%s" id="%s" value="%s" onkeypress="return mascara(null, \'%s\', \'(99) 9999-9999\', event);" />',
    					$nome_campo,$nome_campo,$valor_campo,$nome_campo);
    }

    
	public function valida($legenda,$valor)
	{
		if($valor == "") return true;
		$pattern = "/^\(\d{2}\) \d{4}-\d{4}$/";
		if(!preg_match($pattern,$valor)){
			return "O campo ".$legenda." não é um telefone válido.";
		} else {
			return true;
		}
	}    
    
}

?>