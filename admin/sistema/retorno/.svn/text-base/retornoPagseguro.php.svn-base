<?php

session_start();
error_reporting(0);
include_once $_SERVER ['DOCUMENT_ROOT'] . "/config.php";
include_once $_SERVER ['DOCUMENT_ROOT'] . "/sistema/conecta.php";
include_once $_SERVER ['DOCUMENT_ROOT'] . "/modulo/clientes/venda.php";

/**
 * Classe que trata o retorno da transação de pagamento com o Pagseguro
 *
 */
class retornoPagseguro {
	
	public function __construct(){
		session_start();
	}
	
	/**
	 * Método que verifica se foi passado o id da transação ou não para poder redirecionar para o comprovante 
	 * ou gravação dos dados
	 *
	 */	
	public function verificaTransacao() {
		if (!isset ( $_POST ['TransacaoID'] )) {		
			//die($_SESSION['id_pagamento']);	
			retornoPagseguro::redirecionaComprovante ();
		} else {
			retornoPagseguro::capturarDados ();
		}
		/*retornoPagseguro::capturarDados ();
		retornoPagseguro::redirecionaComprovante ();*/
		die ();
	}
	
	public function capturarDados() {
		
		$token = 'DB48615D5BDC24C9EA59D626C98760F3';

		// RECEBE O POST ENVIADO PELA PagSeguro E ADICIONA OS VALORES PARA VALIDAÇÃO DOS DADOS
		$PagSeguro = 'Comando=validar';
		$PagSeguro .= '&Token=' . $token; // token de retorno do pagseguro	

		// para cada variavel do Post verifica e retorna para verificação
		foreach ( $_POST as $key => $value ) {
			$value = urlencode ( stripslashes ( $value ) );
			$PagSeguro .= "&$key=$value";
		}

		$post1 = $_POST;
		
		$ch = curl_init (); // ENVIA DE VOLTA PARA A PagSeguro OS DADOS PARA VALIDAÇÃO
		curl_setopt ( $ch, CURLOPT_URL, 'https://pagseguro.uol.com.br/Security/NPI/Default.aspx' );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $PagSeguro );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, false );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, true );

		$msg_erro = '/VERIFICADO/i';
		$erro = '';
		$cont = 0;
		$max_req = 10; //max de requisições para o site dos correios		

		while ( $cont < $max_req ) {
			$resp = curl_exec ( $ch );
			if (! preg_match ( $msg_erro, $resp, $erro )) {
				break;
			} else {
				$cont ++;
			}
		}		
		curl_close ( $ch );
		
		if ($resp) {

			// recebe os dados enviados pelo pagseguro e grava no banco
			$post1['free']			= 'Bazar';
			$post1['status'] 		= $_POST['StatusTransacao'];
			$post1['parcelas']		= 1;
			$post1['tipo_pagamento']= $_POST['TipoPagamento'];
			$post1['valor_original']= $_POST['ProdValor_1'];
			$post1['valor_loja']	= $_POST['ProdValor_1'];
			$post1['cliente_nome'] 	= $_POST['CliNome'];						
			$post1['data_transacao']= date('d/m/Y');
			$post1['tipo_pagamento']= $_POST['TipoPagamento'];
			$post1['id_transacao']	= $_POST['TransacaoID'];

			// remove quaisquer valores da variavel cpf para poder fazer a busca no banco pelo nome do individuo
			unset($post1['cliente_cpf']);
		
			$vendaobj = new Modulo_Clientes_Venda ( );
			// Loop para retornar dados dos produtos
		//	for($x = 1; $x <= $qtde_produtos; $x ++) {

				$produto_codigo 	= $_POST ['item_codigo_' . $x];
				$produto_descricao	= $_POST ['item_descricao_' . $x];
				$produto_qtde 		= $_POST ['item_qtde_' . $x];
				$produto_valor 		= $_POST ['item_valor_' . $x];
				//$produto_extra 		= $_POST ['item_extra_' . $x];
				/*
				 Após obter as variáveis dos produtos, grava no banco de dados.
				 Se produto já existe, atualiza os dados, senão cria novo pedido.
				 */
				# Grava os dados no banco				
				$id = $vendaobj->gravaVendas ( $post1 );
				if ($id){
					$_SESSION['id_pagamento'] = $id;
				}				
			//}
			# mostra o layout do comprovante
			//echo $vendaobj->mostraComprovante ($_SESSION['id_pagamento']);		
			
		} else {
			if (strcmp ( $res, "FALSO" ) == 0) {
				// LOG para investigação manual
				die ( 'deu erro' );
			}
		}
	
	}
	
	public function redirecionaComprovante() {
		// verifica se redireciona para a finalização do pedido		
		# mostra o layout do comprovante
		$vendaobj = new Modulo_Clientes_Venda ( );
		echo $vendaobj->mostraComprovante ( $_SESSION ['id_pagamento'] );		
		unset($_SESSION['id_pagamento']);		
	}

}

$conexao = Sistema_Conecta::getConexao();
// faz a captura dos dados do Pagseguro
$pagseguro = new retornoPagseguro();
$pagseguro->verificaTransacao();
?>