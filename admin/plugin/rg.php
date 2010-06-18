<?php
class Plugin_Rg extends Sistema_Plugin 
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
    	return sprintf('<input type="text" maxlength="18" size="20" name="%s" id="%s" value="%s" />',
    					$nome_campo,$nome_campo,$valor_campo);
    }
    
}

?>