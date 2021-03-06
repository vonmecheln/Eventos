<?php
/**
 * @abstract Plugin para formatar o endere�o para o Pagseguro
 * referentes ao campo endere�o / numero
 * 
 * @author Luiz Felipe Weber
 * @since 07-05-2009
 *
 */
class Plugin_DesformataEndereco extends Sistema_Plugin{

	/**
	 * @abstract M�todo para formatar os dados para retorno no input
	 * @param string $valor Valor a ser retornoado
	 * @param string $tipo Tipo do campo que dever� ser retornado
	 * @return string $valor Valor a ser retornado
	 */
	public function formataExibicao($valor,$tipo='num') {

		// formata o endereco para o pagseguro
		$endereco_format = split(" ",str_replace(","," ",trim($valor)));
		$num = $endereco_format[count($endereco_format)-1];
		$end = implode(" ",$endereco_format);
		if ($tipo == 'end') {
			return $end;
		} else {
			if (is_numeric($num)) {
				return $num;	
			}
		}
	}

	
	/**
	 * @abstract M�todo validar os dados inseridos no formul�ro
	 * @param string $legenda Nome do campo no formulario
	 * @param string $valor Valor a ser passado pelo campo
	 */
	public function valida() {
		
	}

	/**
	 * @abstract Formata o valor do retorno do banco para a visualiza��o na tela
	 * @param string valor Valor vindo do banco
	 * @return string valor Valor a ser vizualisado
	 */
	public function formataInsercao() {
	
	}

	/**
	 * @abstract Cria o campo input para o CNPJ
	 * @param String $nome_campo Nome do campo
	 * @param Integer $tamanho Tamanho do campo
	 * @param String $valor_campo Valor incial do campo
	 * @return String $retorno Campo input formatado
	 */
	public function criaCampo() {

	}
}
?>