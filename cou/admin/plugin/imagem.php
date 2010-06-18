<?php
class Plugin_Imagem extends Sistema_Plugin 
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
		$click = sprintf('window.open(\'%s%s\',\'img\',\'menubar=1,resizable=1,width=650,height=450\'); ',COMPROVANTE_URL,$valor_campo);
    	return sprintf('<a href="#" onClick="%s"><img src="%s%s" width="150px" /></a>',$click,COMPROVANTE_URL,$valor_campo);
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