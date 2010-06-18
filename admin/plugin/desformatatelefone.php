<?php
/**
 * @abstract Plugin para formatar o telefone para passar para o pagseguro
 * referentes ao campo telefone
 * 
 * @author Luiz Felipe Weber
 * @since 07-05-2009
 *
 */
class Plugin_DesformataTelefone extends Sistema_Plugin{

	/**
	 * @abstract M�todo para formatar os dados para retorno no input
	 * @param string $valor Valor a ser retornoado
	 * @param string $tipo Tipo do campo que dever� ser retornado
	 * @return string $valor Valor a ser retornado
	 */
	public function formataExibicao($valor,$tipo='ddd') {

		$valor = str_replace(")","",$valor);
		$valor = str_replace("(","",$valor);
		$valor = str_replace("-","",$valor);
		$valor = str_replace(" ","",$valor);

		$telefone 	= substr($valor,2,strlen($valor));
		$ddd 		= substr($valor,0,2);
		if($tipo=="tel") {
			return $telefone;
		} else {
			return $ddd;
		}

	}

	
	/**
	 * @abstract M�todo validar os dados inseridos no formul�ro
	 * @param string $legenda Nome do campo no formulario
	 * @param string $valor Valor a ser passado pelo campo
	 */
	public function valida(){
		
	}

	/**
	 * @abstract Formata o valor do retorno do banco para a visualiza��o na tela
	 * @param string valor Valor vindo do banco
	 * @return string valor Valor a ser vizualisado
	 */
	public function formataInsercao()	{
	
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