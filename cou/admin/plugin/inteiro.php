<?php
class Plugin_Inteiro extends Sistema_Plugin 
{
    
    public function formataInsercao($valor)   {
        return sprintf("%d",$valor);
    }
    
	/**
	 * Cria um campo texto
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 9,$valor_campo = null) {
    	
        $layout = Sistema_Layout::instanciar();
        $layout->includeJavaScript("javascript/mascara/mascara.js");    	
    	
    	return sprintf('<input type="text" maxlength="%d" size="12" name="%s" id="%s" value="%s" onkeypress="return mascara(null, \'%s\', \'999999999999\', event);"  />',
    					$tamanho,$nome_campo,$nome_campo,$valor_campo,$nome_campo);
    }
    
    public function valida($legenda,$valor) 
    {        
        if($valor == 'null' || $valor == "") {
            return true;
        }

//        // limite do campo inteiro do postgres
//        if ($valor > 2147483647) {
//        	return "O campo ".$legenda." - ".$valor." é muito grande para este campo.";
//        }

   		if (!is_numeric($valor)) {
			return "O campo ".$legenda." - ".$valor." não é um número válido";
		}
		return true;
    }    
    
}

?>