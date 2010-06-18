<?php
class Plugin_Senha extends Sistema_Plugin 
{
    public function formataInsercao($valor){
    	return sprintf("'%s'",sha1($valor));
    }
    
	public function formataExibicao($valor){
    	return sprintf("%s",$valor);
    }    
    
	/**
	 * Cria um campo senha
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {
    	
    	if(strlen($valor_campo) > 0){
    		return "";
    	}else{
	    	return sprintf('<input type="password" maxlength="%d" name="%s" id="%s" value="%s" />',
    					$tamanho,$nome_campo,$nome_campo,$valor_campo);
    		
    	}
    }
    
}

?>