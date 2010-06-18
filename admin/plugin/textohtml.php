<?php
class Plugin_TextoHtml extends Sistema_Plugin 
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
    	return nl2br($valor_campo);
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