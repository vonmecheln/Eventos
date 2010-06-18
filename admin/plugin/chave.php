<?php
class Plugin_Chave extends Sistema_Plugin 
{
        
    public function formataInsercao($valor)   {
        return sprintf("%d",$valor);
    }
    
	/**
	 * Cria um campo texto
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 0,$valor_campo = null) {
    	
    	$valor_texto = $valor_campo;
    	/*if(is_null($valor_texto) && is_string($this->_classe)){
			# Instancia a classe do objeto
			$obj = new $this->_classe();
			if(is_object($obj) && is_subclass_of($obj,'Sistema_Persistencia')){
				$sql = sprintf("SELECT MAX(%s) FROM %s ",$obj->getChavePK(),$obj->getTabela());
				$valor_texto = Sistema_Conecta::getOne($sql) + 1;
			}
		}*/
    	
    	return sprintf('<input type="hidden"  name="%s" id="%s" value="%s" />%s',
    					$nome_campo,$nome_campo,$valor_campo,$valor_campo);
    }

    public function valida($legenda,$valor) 
    {
					
    	if($valor == "") return true;
    	
		if (is_numeric($valor)) {
			return TRUE;
		} else {
			return "O campo \"".$legenda."\" não é um Código válido";
		}
    }     
    

    
}

?>