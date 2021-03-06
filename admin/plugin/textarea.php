<?php
class Plugin_Textarea extends Sistema_Plugin 
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
    	
    	
    	return sprintf('<textarea id="%s" name="%s" cols="50" rows="10">%s</textarea>',
    					$nome_campo,$nome_campo,$valor_campo);
    }
    
    
	public function valida($legenda,&$valor)
	{
		if (preg_match("/<[a-z]+(\s[a-z]{2,}=['\"]?(.*)['\"]?)+(\s?\/)?>(<\/[a-z]>)?/i", $valor)) {
			return "O campo ".$legenda." n�o pode ter valores HTML";;
		} else {
			# vErifica o tamanho 
			if(strlen($valor) > 255){
				return "O campo ".$legenda." n�o pode ter mais que 255 caracteres";
			}
			return true;
		}
	}    
    
}

?>