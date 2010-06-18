<?php
/**
 * @abstract Plugin para tratar e v�lidar os dados
 * referentes ao campo CNPJ
 * 
 * @author Alexandre
 * @since 19-03-2009
 *
 */
class Plugin_Cnpj extends Sistema_Plugin{

	/**
	 * @abstract M�todo para formatar os dados para inser��o no banco
	 * @param string $valor Valor a ser inserido
	 * @return string $valor Valor a ser retornado
	 */
	public function formataInsercao($valor){
		return sprintf("'%s'",$valor);
	}

	
	/**
	 * @abstract M�todo validar os dados inseridos no formul�ro
	 * @param string $legenda Nome do campo no formulario
	 * @param string $valor Valor a ser passado pelo campo
	 */
	public function valida($legenda,$valor){
		
		if ((substr($valor,3,1) != '.') || (substr($valor,7,1) != '.') 
			|| (substr($valor,11,1) != '/') || (substr($valor,16,1) != '-')) {
			return "O primeiro valor do campo ".$legenda." deve ter tr�s digitos!";
		}

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
		for( $i = 0; $i < 13; $i++ )
		{
			$k = $k == 1 ? 9 : $k;
			$soma2 += ( $cnpj{$i} * $k );
			$k--;
			if($i < 12)
			{
				if($k == 1)
				{
					$k = 9;
					$soma1 += ( $cnpj{$i} * $k );
					$k = 1;
				}
				else
				{
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
	}

	/**
	 * @abstract Formata o valor do retorno do banco para a visualiza��o na tela
	 * @param string valor Valor vindo do banco
	 * @return string valor Valor a ser vizualisado
	 */
	public function formataExibicao($valor)	{
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
		$layout->includeJavaScript("javascripts/mascara/mascara.js");

		$retorno = sprintf("<input type='text' name='%s' id='%s' value='%s' size='20' maxlength='19' onkeypress='return mascara(null,\"%s\",\"999.999.999/9999-99\",event);' />",
							$nome_campo,$nome_campo,$valor_campo,$nome_campo);
		
		return $retorno;
	}
}
?>