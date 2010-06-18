<?php
class Plugin_Cpf extends Sistema_Plugin 
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
    	
    			$layout = Sistema_Layout::instanciar();
		$layout->includeJavaScript("javascripts/mascara/mascara.js");
    	
    	return sprintf('<input type="text" size="15" maxlength="15" name="%s" id="%s" value="%s" onkeypress="return mascara(null, \'%s\', \'999.999.999-99\', event);" />',
    					$nome_campo,$nome_campo,$valor_campo,$nome_campo);
    }
    
		    
	public function valida($legenda,$valor)
	{
		
		if($valor == "") return true;

		
		$cpf =  ereg_replace("-","",ereg_replace("[.//_]","",$valor));// tira tudo que nao for números
			
		// verificar se o CPF esta dos que são mais utilizados e que atendem a fórmula
		$nulos  = array(
            "12345678909","11111111111","33333333333",
            "44444444444","55555555555","66666666666","77777777777",
            "88888888888","99999999999","00000000000");
		if (in_array($cpf,$nulos)) {
			return "O campo ".$legenda." não é um CPF válido";
		}
		if (strlen($cpf) == 10) {
			$cpf = "0".$cpf;
		}
		if (strlen($cpf) <> 11) {
			return "O campo ".$legenda." não é um CPF válido";
		}

		//PEGA O DIGITO VERIFIACADOR
		$dv_informado = substr($cpf, 9,2);

		for($i=0; $i<=8; $i++) {
			$digito[$i] = substr($cpf, $i,1);
		}

		//CALCULA O VALOR DO 10º DIGITO DE VERIFICAÇÂO
		$posicao = 10;
		$soma = 0;

		for($i=0; $i<=8; $i++) {
			$soma = $soma + $digito[$i] * $posicao;
			$posicao = $posicao - 1;
		}

		$digito[9] = $soma % 11;

		if($digito[9] < 2) {
			$digito[9] = 0;
		}
		else {
			$digito[9] = 11 - $digito[9];
		}

		//CALCULA O VALOR DO 11º DIGITO DE VERIFICAÇÃO
		$posicao = 11;
		$soma = 0;

		for ($i=0; $i<=9; $i++) {
			$soma = $soma + $digito[$i] * $posicao;
			$posicao = $posicao - 1;
		}

		$digito[10] = $soma % 11;

		if ($digito[10] < 2) {
			$digito[10] = 0;
		}
		else {
			$digito[10] = 11 - $digito[10];
		}

		//VERIFICA SE O DV CALCULADO É IGUAL AO INFORMADO
		$dv = $digito[9] * 10 + $digito[10];
		if ($dv != $dv_informado) {
			return "O campo ".$legenda." não é um CPF válido";
		}else{
			return TRUE;
		}
		 
		if ($digito[9] == $cpf[9] && $digito[10] == $cpf[10]) {
			return TRUE;
		} else {
			return "O campo ".$legenda." não é um CPF válido";
		}
	}    
    
    
}

?>