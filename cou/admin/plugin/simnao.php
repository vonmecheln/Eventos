<?php
class Plugin_SimNao extends Sistema_Plugin 
{
    
    public function formataInsercao($valor)   {
    	//$valor = ($valor == 0) ? 0 : 1;
        return sprintf("%d",$valor);
    }
    
    
    public function formataExibicao($valor)
    {
        if (($valor == 't') || ($valor == 'sim') || ($valor=='true') || ($valor=='1') || ($valor==1)) {
            return 'sim';
            //return 1;
        } else 
        if (($valor == 'f') || ($valor == 'não') || ($valor=='false') || ($valor=='0') || ($valor==0)) {
        	//return 0;
            return 'não';
        }
    }    
    
	/**
	 * Cria um campo texto
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {

    	$opcoes = array("Não","Sim");
    	
    	foreach($opcoes as $k=>$v){
    		$sel = ($valor_campo == $k) ? " selected " : "";
    		$options .= sprintf("<option value='%d' %s >%s</option>",$k,$sel,$v);
    	}
    	
    	return sprintf('<select name="%s" id="%s" style="width:80px">%s</select>',
    					$nome_campo,$nome_campo,$options);

    }

    
    public function valida($legenda,$valor) 
    {    	
		if (($valor=="sim") || ($valor =="não") || ($valor == 't') || ($valor == true ) || ($valor == 'f') || ($valor == false) || ($valor == '1') || ($valor == '0')) {
			return true;
		} else {
			return "O campo ".$legenda." não contem um valor válido";
		}
    }    
    
}

?>