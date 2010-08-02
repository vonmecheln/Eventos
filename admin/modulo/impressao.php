<?php
/**
 * @abstract Modulo responsavel pela gerancia das impressões de documentos
 * Crachás e Certificados do sistema
 *
 * @copyright  -
 * @version    1.0
 * @author     Anselmo Battisti
 * @since      08/08/2009
 *
 */
class Modulo_Impressao extends Sistema_Modulo {

	protected $_modulo = "impressao";

	/**
	 * @abstract Ação que monta o formulário para cadastrar/altera a instituicao
	 * @return Form
	 */
	public function acaoImprimircrachas()
	{
		$this->_layout->setBotoes("Imprimir","printDiv(\"layout_conteudo\",\"".SISTEMA_URL."index.php?mod=impressao&act=imprimircrachas\")","imagens/printer.png", false);
		$this->_layout->includeJavascript(SISTEMA_URL."javascript/printdiv.js");

		// seleciona todos os inscritos cujos comprovantes estão marcados como aceitos (5)
		$sql = "
		SELECT
			u.usr_cod,
			tpp_cracha,
			usr_nome
		FROM comprovante c 
			INNER JOIN usuario u ON
				u.usr_cod = c.usr_cod
			INNER JOIN participante p ON
				p.usr_cod = u.usr_cod
		WHERE
			c.stt_cod = 5
		ORDER BY usr_nome ASC";

		$participantes = Sistema_Conecta::Execute($sql);

		$cracha = "<div id='paginaCracha'>";

		foreach($participantes as $participante)
		{
			$cracha .= "<div class='cracha'>";
			# se tiver nome para por no crachá
			if($participante['tpp_cracha']){
				$cracha .= "<b class='nome'>".ucwords(strtolower($participante['tpp_cracha']))."</b><br/>";
			} else {
				$abrevi = explode(" ",$participante['usr_nome']);
				$cracha .= "<b class='nome'>".ucwords(strtolower($abrevi[0]." ".substr($abrevi[1],0,1)."."))."</b><br/>";
			}

			$cracha .= "<b class='nomeCompleto'>".ucwords(strtolower($participante['usr_nome']))."</b><br/><br/>";
			$cracha .= "<b class='numero'>".ucwords($participante['usr_cod'])."</b>";
			$cracha .= "</div>";
		}
		$cracha .= "</div>";

		$cracha .= "
		<style type='text/css'>
			.paginaCracha{
				width: 200mm;
				height: 279mm;
			}
			
			.cracha{
				margin: 5px;
				width: 80mm;
				height: 40mm;
				border: 1px solid #333;
				float:left;
				padding: 5px;
				text-align: center;
			}
			
			.cracha .nome {
				font-size: 20px;
				margin-bottom: 25px;
			}
			
			.cracha .nomeCompleto {
				font-size: 12px;	
				font-style:italic;
			}
			
			.cracha .numero {
				font-size: 25px;	
			}
		</style>";

		// escreve a tabela na tela
		$this->_layout->setCorpo($cracha);
	}

	/**
	 * imprimirCertificado
	 *
	 * @abstract Realiza a impressão dos certificados dos cursos
	 *
	 * @return html
	 */
	public function acaoImprimircertificadocongresso()
	{
		$imprimir = Sistema_Variavel::get('imprimir');

		# formulário
		if(!$imprimir){
			$html = "
			<h1>Imprimir Certificado de Participação no Congresso</h1><br/>
			<form method='post' action='".SISTEMA_URL."index.php?mod=impressao&act=imprimircertificadocongresso'>
				<label>Participante: <input type='text' name='usr_cod' id='usr_cod'/></label> <em>Deixe em branco para imprimir todos os certificados.</em>
				<input type='hidden' value='1' name='imprimir'/>
				<br/>
				<br/>
				<input type='submit' value='Gerar Certificado(s)'/>
			</form>";

			$this->_layout->setCorpo($html);
		} else {
			$this->_layout->setBotoes("Imprimir","printDiv(\"layout_conteudo\",\"".SISTEMA_URL."index.php?mod=impressao&act=imprimircrachas\")","imagens/printer.png", false);
			$this->_layout->includeJavascript(SISTEMA_URL."javascript/printdiv.js");

			# se passar o usuario gera apenas o certificado apenas dele senão pega o geral
			$usr_cod = Sistema_Variavel::get('usr_cod');

			if($usr_cod){
				$sqlWhere .= " AND u.usr_cod = ".$usr_cod;
			}

			$sql = "
			SELECT
				u.usr_cod,
				tpp_cracha,
				usr_nome
			FROM comprovante c 
				INNER JOIN usuario u ON
					u.usr_cod = c.usr_cod
				INNER JOIN participante p ON
					p.usr_cod = u.usr_cod
			WHERE
				c.stt_cod = 5
				".$sqlWhere."
			ORDER BY usr_nome ASC";

			$participantes = Sistema_Conecta::Execute($sql);

			$htmlCertificado = modulo_impressao_funcoes::getCss();

			if(is_array($participantes)){
				foreach($participantes as $participante){
					$htmlCertificado .= sprintf(modulo_impressao_funcoes::getCertificado('congressista'),ucwords($participante['usr_nome']));
				}
				$this->_layout->setCorpo($htmlCertificado);
			} else {
				$this->_msg->setErro("Nenhum certificado foi localizado.");
			}
		}
	}

	/**
	 * acaoImpremirCertificadoTrabalhos
	 *
	 * @abstract Imprime os certificados referentes aos trabalhos aceitos no eventos
	 *
	 * @return HTML
	 */
	public function acaoImprimircertificadoapresentacao()
	{
		$imprimir = Sistema_Variavel::get('imprimir');

		# formulário
		if(!$imprimir){
			$html = "
			<h1>Imprimir Certificado de Apresentação de Trabalhos</h1><br/>
			<form method='post' action='".SISTEMA_URL."index.php?mod=impressao&act=imprimircertificadoapresentacao'>
				<label>Trabalho: <input type='text' name='trb_cod' id='trb_cod'/></label> <em>Deixe em branco para imprimir todos os certificados.</em>
				<input type='hidden' value='1' name='imprimir'/>
				<br/>
				<br/>
				<input type='submit' value='Gerar Certificado(s)'/>
			</form>";

			$this->_layout->setCorpo($html);
		} else {
			$this->_layout->setBotoes("Imprimir","printDiv(\"layout_conteudo\",\"".SISTEMA_URL."index.php?mod=impressao&act=imprimircrachas\")","imagens/printer.png", false);
			$this->_layout->includeJavascript(SISTEMA_URL."javascript/printdiv.js");

			# se passar o usuario gera apenas o certificado apenas dele senão pega o geral
			$trb_cod = Sistema_Variavel::get('trb_cod');

			if($trb_cod){
				$sqlWhere .= " AND t.trb_cod = ".$trb_cod;
			}

			$sql = "
			SELECT
				UCASE(trb_apresentador) as trb_apresentador,
				UCASE(trb_titulo) as trb_titulo,
				UCASE(trb_frmapresentacao) as trb_frmapresentacao,
				trb_coautor
			FROM trabalho t 
			WHERE
				(
					trb_status = 5 OR
					trb_status = 6 
				) 
				".$sqlWhere."
			ORDER BY trb_apresentador ASC";

			$trabalhos = Sistema_Conecta::Execute($sql);

			$htmlCertificado = modulo_impressao_funcoes::getCss();

			if(is_array($trabalhos)){
				foreach($trabalhos as $trabalho){

					# se for painel eh painel caso contratio eh qualquer outra coisa
					$frmApresentacao = ($trabalho['trb_frmapresentacao'] != "PAINEL") ? "APRESENTACAO ORAL" : "PAINEL";

					$htmlCertificado .= sprintf(
					modulo_impressao_funcoes::getCertificado('apresentouTrabalho'),
					$trabalho['trb_apresentador'],
					$trabalho['trb_titulo'],
					$frmApresentacao,
					$trabalho['trb_coautor']);

				}
				$this->_layout->setCorpo($htmlCertificado);
			} else {
				$this->_msg->setErro("Nenhum certificado foi localizado.");
			}
		}
	}

	/**
	 * acaoImprimircertificadoministrante
	 *
	 * @abstract imprime o certificado dos ministrantes dos trabalhos
	 *
	 * @return HTML
	 */
	public function acaoImprimircertificadoministrante()
	{

		$this->_layout->setBotoes("Imprimir","printDiv(\"layout_conteudo\",\"".SISTEMA_URL."index.php?mod=impressao&act=imprimircrachas\")","imagens/printer.png", false);
		$this->_layout->includeJavascript(SISTEMA_URL."javascript/printdiv.js");

		$sql = "
		SELECT
			*
		FROM cursos";

		$cursos = Sistema_Conecta::Execute($sql);

		$htmlCertificado = modulo_impressao_funcoes::getCss();

		if(is_array($cursos)){

			foreach($cursos as $curso){

				$autores = explode(";",$curso['crs_professor']);

				$titulo = $curso['crs_tipo']. " - ".$curso['crs_titulo'];

				# se tiver so um professor joga num array pra simplificar o codigo
				if(!is_array($autores)){
					$autores[] = $curso['crs_professor'];
				}

				foreach($autores as $autor){
					$htmlCertificado .= sprintf(
					modulo_impressao_funcoes::getCertificado('ministrante'),
					$autor,
					$titulo,
					$curso['crs_horas']);
				}
			}

			$this->_layout->setCorpo($htmlCertificado);
		} else {
			$this->_msg->setErro("Nenhum certificado foi localizado.");
		}
	}

	public function acaoImprimirCertificadoCurso()
	{
		$imprimir = Sistema_Variavel::get('imprimir');

		# formulário
		if(!$imprimir){

			$sql = "SELECT * FROM cursos";
			$cursos = Sistema_Conecta::Execute($sql);

			$option = "<option value=''> -- Escolha o Curso -- </option>";
			foreach($cursos as $curso){
				$option .= "<option value='".$curso['crs_cod']."'>".$curso['crs_titulo']."</option>";
			}

			$html = "
			<h1>Imprimir Certificado de Participação em Cursos e Conferências</h1><br/>
			<form method='post' action='".SISTEMA_URL."index.php?mod=impressao&act=imprimircertificadocurso'>
				<label>Curso: <select name='crs_cod'>".$option."</select></label> <em>Deixe em branco para imprimir todos os certificados.</em> <br/>
				<label>Participante: <input type='text' name='usr_cod' id='usr_cod'/></label> <em>Deixe em branco para imprimir todos os certificados.</em>
				<input type='hidden' value='1' name='imprimir'/>
				<br/>
				<br/>
				<input type='submit' value='Gerar Certificado(s)'/>
			</form>";

			$this->_layout->setCorpo($html);
		} else {
			$this->_layout->setBotoes("Imprimir","printDiv(\"layout_conteudo\",\"".SISTEMA_URL."index.php?mod=impressao&act=imprimircrachas\")","imagens/printer.png", false);
			$this->_layout->includeJavascript(SISTEMA_URL."javascript/printdiv.js");

			# se passar o usuario gera apenas o certificado apenas dele senão pega o geral
			$usr_cod = Sistema_Variavel::get('usr_cod');
			$crs_cod = Sistema_Variavel::get('crs_cod');

			if($usr_cod){
				$sqlWhere .= " AND u.usr_cod = ".$usr_cod;
			}

			if($crs_cod){
				$sqlWhere .= " AND c.crs_cod = ".$crs_cod;
			}

			$sql = "
			SELECT
				UCASE(usr_nome) as usr_nome,
				UCASE(crs_titulo) as crs_titulo,
				crs_horas,
				crs_tipo,
				crs_professor
			FROM entrada_cursos ec
				INNER JOIN cursos c ON
					c.crs_cod = ec.crs_cod
				INNER JOIN usuario u ON
					u.usr_cod = ec.usr_cod
			WHERE
				1 = 1 
				".$sqlWhere."
			ORDER BY u.usr_nome ASC";

			$participantes = Sistema_Conecta::Execute($sql);

			$htmlCertificado = modulo_impressao_funcoes::getCss();

			if(is_array($participantes)){

				foreach($participantes as $participante){

					if($participante['crs_tipo'] == "	CURSO"){
						$titulo = " do Curso - ".$participante['crs_titulo'].", ministrado ";
					} else {
						$titulo = " da Conferência - ".$participante['crs_titulo'].", ministrada";
					}

					$htmlCertificado .= sprintf(
					modulo_impressao_funcoes::getCertificado('participante'),
					$participante['usr_nome'],
					$titulo,
					$participante['crs_professor'],
					$participante['crs_horas']);
				}
				$this->_layout->setCorpo($htmlCertificado);
			} else {
				$this->_msg->setErro("Nenhum certificado foi localizado.");
			}
		}
	}

	public function acaoImprimeBoleto(){

		$nosso_numero = Sistema_Variavel::get('nosso_numero');

		$sql = "SELECT bol_cod FROM boleto WHERE bol_nossonumero = '$nosso_numero' ";

		$bol_cod = Sistema_Conecta::getOne($sql);

		if($bol_cod){
			$boleto = new Classe_Boleto($bol_cod);
			$dados = $boleto->getDados();
				
			$v = explode("/", $dados['bol_datavencimento']);
				
			if($v[2].$v[1].$v[0] < date("Ymd")){
				$vet_boleto_dados = Modulo_Inscricao_Funcoes::CalculaValorBoleto($nosso_numero);
				$arr_dados['bol_valordocumento'] = $vet_boleto_dados['bol_valordocumento'];
				$arr_dados['bol_datavencimento'] = $vet_boleto_dados['bol_datavencimento'];
				$boleto->setDados($arr_dados);
				$boleto->salvar();
				echo("<pre>");print_r($boleto);echo("</pre>");die();
			}
				
			// DADOS DO BOLETO PARA O SEU CLIENTE
			$valor_cobrado = str_replace(",", ".",$dados['bol_valordocumento']);
			$valor_boleto=number_format($valor_cobrado, 2, ',', '');

			$dadosboleto["inicio_nosso_numero"] = "80";  // Carteira SR: 80, 81 ou 82  -  Carteira CR: 90 (Confirmar com gerente qual usar)
			$dadosboleto["nosso_numero"] = $nosso_numero;  // Nosso numero sem o DV - REGRA: Máximo de 8 caracteres!
			$dadosboleto["numero_documento"] = $nosso_numero;	// Num do pedido ou do documento
			$dadosboleto["data_vencimento"] = $dados['bol_datavencimento']; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
			$dadosboleto["data_documento"] = $dados['bol_datadocumento']; // Data de emissão do Boleto
			$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
			$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

			// DADOS DO SEU CLIENTE
			$dadosboleto["sacado"] = "Nome do seu Cliente";
			$dadosboleto["endereco1"] = "Endereço do seu Cliente";
			$dadosboleto["endereco2"] = "Cidade - Estado -  CEP: 00000-000";

			// INFORMACOES PARA O CLIENTE
			$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Nonononono";
			$dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon";
			$dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";

			// INSTRUÇÕES PARA O CAIXA
			$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
			$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
			$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br";
			$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

			// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
			$dadosboleto["quantidade"] = "";
			$dadosboleto["valor_unitario"] = "";
			$dadosboleto["aceite"] = "";
			$dadosboleto["especie"] = "R$";
			$dadosboleto["especie_doc"] = "";


			// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


			// DADOS DA SUA CONTA - CEF
			$dadosboleto["agencia"] = "1565"; // Num da agencia, sem digito
			$dadosboleto["conta"] = "13877"; 	// Num da conta, sem digito
			$dadosboleto["conta_dv"] = "4"; 	// Digito do Num da conta

			// DADOS PERSONALIZADOS - CEF
			$dadosboleto["conta_cedente"] = "87000000414"; // ContaCedente do Cliente, sem digito (Somente Números)
			$dadosboleto["conta_cedente_dv"] = "3"; // Digito da ContaCedente do Cliente
			$dadosboleto["carteira"] = "SR";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

			// SEUS DADOS
			$dadosboleto["identificacao"] = "BoletoPhp - Código Aberto de Sistema de Boletos";
			$dadosboleto["cpf_cnpj"] = "";
			$dadosboleto["endereco"] = "Coloque o endereço da sua empresa aqui";
			$dadosboleto["cidade_uf"] = "Cidade / Estado";
			$dadosboleto["cedente"] = "Coloque a Razão Social da sua empresa aqui";

			// NÃO ALTERAR!
			//echo("<pre>");print_r($dadosboleto);echo("</pre>");
			include("impressao/include/funcoes_cef.php");
			include("impressao/include/layout_cef.php");

		} else {
			echo("<pre>");print_r('Boleto não encontrado!');echo("</pre>");
		}

		die();


	}
}
?>