<?php
class Plugin_Email extends Sistema_Plugin 
{
    public function formataInsercao($valor){
    	return sprintf("'%s'",strtolower($valor));
    }
    
	public function formataExibicao($valor){
    	return $valor;
    }    
    
	/**
	 * Cria um campo E-mail
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {
    	return sprintf('<input type="text" maxlength="150" size="50" name="%s" id="%s" value="%s" />',
    					$nome_campo,$nome_campo,$valor_campo);
    }
    
    public function valida($legenda,$valor) 
    {
        if (strlen($valor) > 0) {
            if (!preg_match("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,4}$/i", $valor)) {
    			return "O campo ".$legenda." não contem um email válido";
    		}
        }
		return true;
    }    
    
}

?>