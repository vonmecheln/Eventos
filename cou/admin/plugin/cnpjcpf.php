<?php
/** 
 * @abstract Plugin para tratar e v�lidar os dados
 * referentes ao campo CNPJ e CPF juntos
 * 
 * @author Laira
 * @since 01/04/2009
 *
 */
class Plugin_CnpjCpf extends Sistema_Plugin {

	/**
	 * @abstract M�todo para formatar os dados para inser��o no banco
	 * @param string $valor Valor a ser inserido
	 * @return string $valor Valor a ser retornado
	 */
	public function formataInsercao($valor){
		$valor = str_replace("/","",str_replace("-","",str_replace(".","",$valor)));
		return sprintf("'%s'",$valor);
	}

	
	/**
	 * @abstract M�todo validar os dados inseridos no formul�ro
	 * @param string $legenda Nome do campo no formulario
	 * @param string $valor Valor a ser passado pelo campo
	 */
	public function valida($legenda,$valor){
		
		$conteudo = preg_replace( "@[./-]@", "", $valor );
		if (strlen($conteudo) > 11) {
			# valida��o do cnpj
/*			if ((substr($valor,3,1) != '.') || (substr($valor,7,1) != '.') 
				|| (substr($valor,11,1) != '/') || (substr($valor,16,1) != '-')) {
				return "O primeiro valor do campo ".$legenda." deve ter tr�s digitos!";
			}*/
			$cnpj = preg_replace( "@[./-]@", "", $valor );
			if(strlen($cnpj)==15) {
				$cnpj = substr($cnpj,1);
			}
	
			if(strlen( $cnpj ) <> 14 or !is_numeric( $cnpj ) or ($cnpj == '00000000000000')){
				return "O campo ".$legenda." n�o � um CNPJ v�lido ";
			}
			 
			$k = 6;
			$soma1 = "";
			$soma2 = "";
			for( $i = 0; $i < 13; $i++ ){
				$k = $k == 1 ? 9 : $k;
				$soma2 += ( $cnpj{$i} * $k );
				$k--;
				if($i < 12)	{
					if($k == 1)	{
						$k = 9;
						$soma1 += ( $cnpj{$i} * $k );
						$k = 1;
					}
					else {
						$soma1 += ( $cnpj{$i} * $k );
					}
				}
			}
	
			$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
			$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;
			 
			if ($cnpj{12} == $digito1  and  $cnpj{13} == $digito2 ) {
				return true;
			} else {
				return "O campo ".$legenda." n�o � um CNPJ v�lido";
			}
		} else { //cpf
			if($valor == "") return true;
			$cpf =  ereg_replace("-","",ereg_replace("[.//_]","",$valor));// tira tudo que nao for n�meros
			// verificar se o CPF esta dos que s�o mais utilizados e que atendem a f�rmula
			$nulos  = array(
	            "12345678909","11111111111","33333333333",
	            "44444444444","55555555555","66666666666","77777777777",
	            "88888888888","99999999999","00000000000");
			if (in_array($cpf,$nulos)) {
				return "O campo ".$legenda." n�o � um CPF v�lido";
			}
			if (strlen($cpf) == 10) {
				$cpf = "0".$cpf;
			}
			if (strlen($cpf) <> 11) {
				return "O campo ".$legenda." n�o � um CPF v�lido";
			}
	
			//PEGA O DIGITO VERIFIACADOR
			$dv_informado = substr($cpf, 9,2);
	
			for($i=0; $i<=8; $i++) {
				$digito[$i] = substr($cpf, $i,1);
			}
	
			//CALCULA O VALOR DO 10� DIGITO DE VERIFICA��O
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
	
			//CALCULA O VALOR DO 11� DIGITO DE VERIFICA��O
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
	
			//VERIFICA SE O DV CALCULADO � IGUAL AO INFORMADO
			$dv = $digito[9] * 10 + $digito[10];
			if ($dv != $dv_informado) {
				return "O campo ".$legenda." n�o � um CPF v�lido";
			}else{
				return TRUE;
			}
			 
			if ($digito[9] == $cpf[9] && $digito[10] == $cpf[10]) {
				return TRUE;
			} else {
				return "O campo ".$legenda." n�o � um CPF v�lido";
			}
		}
	}

	/**
	 * @abstract Formata o valor do retorno do banco para a visualiza��o na tela
	 * @param string valor Valor vindo do banco
	 * @return string valor Valor a ser vizualisado
	 */
	public function formataExibicao($valor)	{
		
//		            return mascara(null, nomecampo, '999.999.999-99', evtKeyPress);
//        } else {
//            doc.setAttribute('maxlength','19');
//            return mascara(null, nomecampo, '999.999.999/9999-99', evtKeyPress);
		
		 
		 $t = $valor;
		 # CNPJ
         if(strlen($t) > 14){
         	$valor = sprintf("%s.%s.%s/%s-%s",
         				substr($t,0,3),substr($t,3,3),substr($t,6,3),
         				substr($t,9,4),substr($t,13,2));
         }else{
         	# CPF
         	$valor = sprintf("%s.%s.%s-%s",
         				substr($t,0,3),substr($t,3,3),substr($t,6,3),
         				substr($t,9,2));
         }   
            
		return $valor;
	}

	/**
	 * @abstract Cria o campo input para o CNPJ
	 * @param String $nome_campo Nome do campo
	 * @param Integer $tamanho Tamanho do campo
	 * @param String $valor_campo Valor incial do campo
	 * @return String $retorno Campo input formatado
	 */
	public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {
		
		$layout = Sistema_Layout::instanciar();
		$layout->includeJavaScript("javascript/mascara/mascara.js");
		$layout->includeJavaScript("javascript/mascara/cpfcnpjtamanho.js");

		$retorno = sprintf('<input type="text" name="%s" id="%s" value="%s" size="20" maxlength="19" onkeypress="return mascaraCpfCnpj(event,\'%s\');" />',   
							$nome_campo,$nome_campo,$valor_campo,$nome_campo, $nome_campo);
	
		return $retorno;
	}
}
?>