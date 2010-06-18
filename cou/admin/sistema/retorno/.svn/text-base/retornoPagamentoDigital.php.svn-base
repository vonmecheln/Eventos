<?php

//error_reporting(E_ALL);

include_once $_SERVER ['DOCUMENT_ROOT'] . "/config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sistema/conecta.php";
include_once $_SERVER['DOCUMENT_ROOT']."/modulo/clientes/venda.php";

class retornoPagamentoDigital {
	
	public static function capturarDados() {

		// Variáveis de retorno			

		// Obtenha seu TOKEN entrando no menu Ferramentas do Pagamento Digital
		$token = "79959701D0D99B078B7C";

		/* Montando as variáveis de retorno */
		$post1 = $_POST;

		$id_transacao 			= $_POST ['id_transacao'];
		$data_transacao 		= $_POST ['data_transacao'];
		$data_credito 			= $_POST ['data_credito'];
		$valor_original 		= $_POST ['valor_original'];
		$valor_loja 			= $_POST ['valor_loja'];
		$tipo_pagamento 		= $_POST ['tipo_pagamento'];
		$parcelas 				= $_POST ['parcelas'];
		$cliente_nome 			= $_POST ['cliente_nome'];
		$cliente_email 			= $_POST ['cliente_email'];
		$cliente_cpf 			= $_POST ['cliente_cpf'];
		$cliente_endereco 		= $_POST ['cliente_endereco'];
		$cliente_complemento 	= $_POST ['cliente_complemento'];
		$status 				= $_POST ['status'];
		$cod_status 			= $_POST ['cod_status'];
		$cliente_bairro 		= $_POST ['cliente_bairro'];
		$cliente_cidade 		= $_POST ['cliente_cidade'];
		$cliente_estado 		= $_POST ['cliente_estado'];
		$cliente_cep 			= $_POST ['cliente_cep'];
		$frete 					= $_POST ['frete'];
		$tipo_frete 			= $_POST ['tipo_frete'];
		$informacoes_loja 		= $_POST ['informacoes_loja'];
		$id_pedido 				= $_POST ['id_pedido'];
		$free 					= $_POST ['free'];

		/* Essa variável indica a quantidade de produtos retornados */
		$qtde_produtos = $_POST ['qtde_produtos'];		

		$params = array ("transacao" => $id_transacao, "status" => $status, "valor_original" => $valor_original, "valor_loja" => $valor_loja, "token" => $token );

		$postdata = http_build_query ( $params );
		$enderecoPost = "https://www.pagamentodigital.com.br/checkout/verify/";
		$opts = array ('http' => array ('method' => 'POST', 'header' => "Content-type: application/x-www-form-urlencoded \r\n", 'content' => $postdata ) );

		$context = stream_context_create ( $opts );
		$resposta = file_get_contents ( $enderecoPost, false, $context );

		if (trim ( $resposta ) == "VERIFICADO") {
			$vendaobj = new Modulo_Clientes_Venda ( );
			// Loop para retornar dados dos produtos
			for($x = 1; $x <= $qtde_produtos; $x ++) {

				$produto_codigo = $_POST ['produto_codigo_' . $x];
				$produto_descricao = $_POST ['produto_descricao_' . $x];
				$produto_qtde = $_POST ['produto_qtde_' . $x];
				$produto_valor = $_POST ['produto_valor_' . $x];
				$produto_extra = $_POST ['produto_extra_' . $x];

				/*
				 Após obter as variáveis dos produtos, grava no banco de dados.
				 Se produto já existe, atualiza os dados, senão cria novo pedido.
				 */
				# Grava os dados no banco
				$id = $vendaobj->gravaVendas ( $post1 );
			}
			# mostra o layout do comprovante
			echo $vendaobj->mostraComprovante ( $id );
		}
		die ();
	}
}

// instancia a classe que chama o retorno do Pagamento Digital
retornoPagamentoDigital::capturarDados();

?>