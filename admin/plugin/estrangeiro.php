<?php
class Plugin_Estrangeiro extends Sistema_Plugin 
{
    
    public function formataInsercao($valor)   {
        return sprintf("%d",$valor);
    }
    
	/**
	 * Cria um campo texto
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {
    	
    	# Instancia a classe
    	if(is_null($this->_classeEstrangeira)){
    		$this->_msg->setErro("Não foi informado uma classe válida para o Plugin_Select");
    		return;
    	}
    	
    	$classe = new $this->_classeEstrangeira();
    	
    	# Se for grupo
    	$where = ($classe->getTabela() == "grupo") ? " WHERE grp_cod != ".DESENVOLVEDOR : ""; 
    	
    	$sql = sprintf("SELECT %s,%s FROM %s %s",$classe->getChavePK(),$classe->getDescritor(),$classe->getTabela(),$where);
    	
    	$rs = Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);
    	
    	if(count($rs)>0){
    		foreach($rs as $k=>$vet){
    			
    			$sel = ($vet[$classe->getChavePK()] == $valor_campo) ? 	' selected="selected" ' : '';
    			$options .= sprintf('<option value="%d" %s >%s</option>',$vet[$classe->getChavePK()],$sel,$vet[$classe->getDescritor()]);
    		}
    		
    	}
    	
    	
    	
    	return sprintf('<select name="%s" id="%s" >%s</select>',
    					$nome_campo,$nome_campo,$options);
    }
    
    
    
    public function valida($legenda,$valor) 
    {
		
		if (is_numeric($valor)) {
			return TRUE;
		} else {
			return "O campo \"".$legenda."\" não é válida";
		}
    }     
    
}

?>