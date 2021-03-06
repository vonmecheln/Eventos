<?php
class Plugin_Modulo extends Sistema_Plugin 
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
    	
    	$sql = sprintf("SELECT mdl_cod,mdl_titulo FROM modulo");

    	$rs = Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);
    	
    	if(count($rs)>0){
    		foreach($rs as $k=>$vet){
    			
    			$sel = ($vet['mdl_cod'] == $valor_campo) ? 	' selected="selected" ' : '';
    			$options .= sprintf('<option value="%d" %s >%s</option>',$vet['mdl_cod'],$sel,$vet['mdl_titulo']);
    		}
    		
    	}
    	
    	return sprintf('<select name="%s" id="%s" >%s</select>',
    					$nome_campo,$nome_campo,$options);
    }
    
}

?>