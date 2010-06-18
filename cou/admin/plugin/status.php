<?php
class Plugin_Status extends Sistema_Plugin 
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
    	
    	/**
    	 * @todo Falta filtrar pela tabela status_filtro
    	 */
		$obj = new $this->_classe();
		$where = "";
		if(is_object($obj) && is_subclass_of($obj,'Sistema_Persistencia')){
			$where = sprintf(" WHERE stt_cod IN (SELECT stt_cod FROM status_filtro WHERE  sttflt_tabela='%s')",$obj->getTabela());
		}
		
		$sql = sprintf("SELECT stt_cod,stt_nome FROM status %s",$where);

		
    	$rs = Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);
    	
    	if(count($rs)>0){
    		foreach($rs as $k=>$vet){
    			$sel = ($vet['stt_cod'] == $valor_campo) ? 	' selected="selected" ' : '';
    			$options .= sprintf('<option value="%d" %s >%s</option>',$vet['stt_cod'],$sel,$vet['stt_nome']);
    		}
    		
    	}
    	
    	
    	
    	return sprintf('<select name="%s" id="%s" style="width:100px">%s</select>',
    					$nome_campo,$nome_campo,$options);
    }
    
}

?>