<?php
class Plugin_Texto extends Sistema_Plugin 
{
    public function formataInsercao($valor){
    	return sprintf("'%s'",$valor);
    }
    
	public function formataExibicao($valor){
    	return sprintf("%s",$valor);
    }    
    
	/**
	 * Cria um campo texto
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 255,$valor_campo = null) {
    	return sprintf('<input type="text" maxlength="%d" size="50" name="%s" id="%s" value="%s" />',
    					$tamanho,$nome_campo,$nome_campo,$valor_campo);
    }
    
    
	public function valida($legenda,&$valor)
	{
		if (preg_match("/<[a-z]+(\s[a-z]{2,}=['\"]?(.*)['\"]?)+(\s?\/)?>(<\/[a-z]>)?/i", $valor)) {
			return "O campo ".$legenda." não pode ter valores HTML";;
		} else {
			return true;
		}
	}    
    
}

?>