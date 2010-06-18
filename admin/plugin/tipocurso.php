<?php
class Plugin_TipoCurso extends Sistema_Plugin 
{
    
    public function formataInsercao($valor)   {
        return sprintf("'%s'",$valor);
    }
    
	/**
	 * Cria um campo texto
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {
    	
    	
    	$rs = array("CONFERÊNCIA","CURSO");
    	
    	if(count($rs)>0){
    		foreach($rs as $k=>$vet){
    			$sel = ($vet == $valor_campo) ? 	' selected="selected" ' : '';
    			$options .= sprintf('<option value="%s" %s >%s</option>',$vet,$sel,$vet);
    		}
    		
    	}
    	
    	
    	
    	return sprintf('<select name="%s" id="%s" style="width:150px">%s</select>',
    					$nome_campo,$nome_campo,$options);
    }
    
}

?>