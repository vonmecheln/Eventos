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
			trim(usr_nome) as usr_nome
		FROM usuario u
			LEFT JOIN participante p ON
				p.usr_cod = u.usr_cod
		-- WHERE
			-- u.stt_cod = 5
		ORDER BY usr_nome ASC";
		
		$participantes = Sistema_Conecta::Execute($sql);
		
		/*
		$cracha = "<table id='paginaCracha' border=0 cellpadding=0 cellspacing=0>\n\n<tr>\n"; 
		foreach($participantes as $k=>$participante)
		{
			$cracha .= "<td class='cracha'>";			
			
			# se tiver nome para por no crachá
			if($participante['tpp_cracha']){
				$cracha .= "<b class='nome'>".ucwords(strtolower($participante['tpp_cracha']))."</b><br/>\n";
			} else {
				$abrevi = explode(" ",$participante['usr_nome']);
				$cracha .= "<b class='nome'>".ucwords(strtolower($abrevi[0]." ".substr($abrevi[1],0,1)."."))."</b><br/>\n"; 
			}

			$cracha .= "<b class='nomeCompleto'>".ucwords(strtolower($participante['usr_nome']))."</b><br/><br/>\n"; 
			$cracha .= "<b class='numero'>".ucwords($participante['usr_cod'])."</b>\n"; 
			$cracha .= "</td>\n";

			if(($k%2)==1){
				$cracha .= "</tr><tr>\n\n";	
			}			
		}
		$cracha .= "</table>";	
		*/
		
		//$cracha = "<table id='paginaCracha' border=0 cellpadding=0 cellspacing=0>\n\n<tr>\n";
		$cracha .= "<div width='600px'>"; 
		foreach($participantes as $k=>$participante)
		{
			$cracha .= "<div class='cracha'>";			
			
			# se tiver nome para por no crachá
			if($participante['tpp_cracha']){
				$cracha .= "<b class='nome'>".ucwords(strtolower($participante['tpp_cracha']))."</b><br/>\n";
			} else {
				$abrevi = explode(" ",$participante['usr_nome']);
				$cracha .= "<b class='nome'>".ucwords(strtolower($abrevi[0]." ".substr($abrevi[1],0,1)."."))."</b><br/>\n"; 
			}

			$cracha .= "<b class='nomeCompleto'>".ucwords(strtolower($participante['usr_nome']))."</b><br/><br/>\n"; 
			$cracha .= "<b class='numero'>".ucwords($participante['usr_cod'])."</b>\n"; 
			$cracha .= "</div>\n";

			/*
			if(($k%19)==0){
				$cracha .= "<br style='clear:both'>";	
			}			
			if(($k%2)==0){
				$cracha .= "<br style='clear:both'>";	
			}	
			*/		
		}
		$cracha .= "</div>";
		//$cracha .= "</table>";	

		$cracha .= "
		<style type='text/css'>
			#paginaCracha{
				margin-left: 5mm;
			}

			.cracha{
				width: 87mm;
				height: 30mm;
				margin: 0mm 6mm 1mm 0mm;
				text-align: center;
				font-family:arial;	
				float:left;		
				border:1px solid #000;			
			}
			
			.cracha .nome {
				font-size: 20px;
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
		die($cracha);
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
				$sqlWhere .= " AND usr_cod = ".$usr_cod;
			}
	
			$sql = "
			SELECT
				usr_nome
			FROM usuario
			WHERE
				stt_cod = 5
				".$sqlWhere."
			ORDER BY usr_nome ASC";
	
			$participantes = Sistema_Conecta::Execute($sql);

			$htmlCertificado = modulo_impressao_funcoes::getCss();

			if(is_array($participantes)){
				foreach($participantes as $participante){				
					$htmlCertificado .= sprintf(modulo_impressao_funcoes::getCertificado('congressista'),ucwords($participante['usr_nome']));
				}
				//$this->_layout->setCorpo($htmlCertificado);
				die($htmlCertificado);
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
					$frmApresentacao = ($trabalho['trb_frmapresentacao'] != "PAINEL") ? "APRESENTAÇÃO ORAL" : "PAINEL";
					 
					$htmlCertificado .= sprintf(
					modulo_impressao_funcoes::getCertificado('apresentouTrabalho'),
					$trabalho['trb_apresentador'],
					$trabalho['trb_titulo'],
					$frmApresentacao,
					$trabalho['trb_coautor']);

				}
				//$this->_layout->setCorpo($htmlCertificado);
				die($htmlCertificado);
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
			//$this->_layout->setCorpo($htmlCertificado);
			die($htmlCertificado);
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
					 				
					if($participante['crs_tipo'] == "CURSO"){
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
				
				//$this->_layout->setCorpo($htmlCertificado);
				die($htmlCertificado);
			} else {
				$this->_msg->setErro("Nenhum certificado foi localizado.");
			}
		}
	}
}
?>