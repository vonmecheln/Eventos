<?php
// verifica se esta logado
$form = new Componente_Formulario(new Classe_Usuario(),"inscricao");
$campos = $form->getCampos();

foreach($campos as $k=>$v){

	$campos_form .= sprintf('<div class="type-text">
							%s
							%s
						</div>',$v['label'],$v['input']);
}

// Tipo do paticipante
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_nome">Sou</label>
							<select name="tpp_nome" id="tpp_nome" onChange="insc.tipoParticipante(this.value)">
								<option value="Acad�mico">Acad�mico</option>
								<option value="Profissional">Profissional</option>
								<option value="THD / ACD">THD / ACD</option>
							</select>
						</div>');
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_desc" id="nome_desc">Universidade</label>
							<input type="text" name="tpp_desc" id="tpp_desc" value=""/>
						</div>');
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_cracha" id="tpp_cracha">Nome no Crach�</label>
							<input type="text" name="tpp_cracha" id="tpp_cracha" value=""/>
						</div>');							
?>

<div class="subcolumns">
	<div class="c62l">
		<div class="subcl">
			<div id="layout_mensagens" align="center" class="mensagem{$tipo_msg}"	style="display: none">
				<div id="mensagem_conteudo"></div>
				<div id="mensagem_fechar"><br>
				<a href="#" id="idBotaoMsgFechar" class="link_botao_msg" onclick="$('layout_mensagens').style.display='none';"> Fechar </a>
				</div>
			</div>
		<div class="mensagemalerta"	style="padding: 10px; font-size: 12px; padding-left: 10px;">
				<h3>Instru��es</h3>
				( <b style="color: red;">! </b> ) Campo Obrigat�rio
				<br>
				Utilize seu e-mail como login</div>
		<form id="frmInscricao" class='yform' onSubmit="return formulario.enviaFormInscricao('frmInscricao'); return false;">
			<fieldset>
				<legend>Dados do Participante</legend>
					<?php echo $campos_form; ?>

					<div class='type-button'><input type="submit" value="Salvar" id="submit" name="submit"  /></div>
					
			</fieldset>
		</form>
		</div>
	</div>

	<div class="c38r">
		<div class="subcr">
			<div class="info">
			<h2>Ades�o</h2>
			<table width="100%" border="0">
				<tr>
					<th>Taxa de Ades�o</th>
					<th>at� 01/agosto</th>
					<th style='color:red'>at� 26/setembro</th>
					<th>no evento</th>
				</tr>
				<tr>
					<td>Acad�micos</td>
					<td>R$ 45,00</td>
					<td>R$ 50,00</td>
					<td>R$ 60,00</td>
				</tr>	
				<tr>
					<td>Profissionais</td>
					<td>R$ 65,00</td>
					<td>R$ 75,00</td>
					<td>R$ 90,00</td>
				</tr>							
				<tr>
					<td>ACD/THD</td>
					<td>R$ 20,00</td>
					<td>R$ 25,00</td>
					<td>R$ 30,00</td>
				</tr>											
			</table>
				<p>*A ades�o dar� direito ao congressista a participar de todas as atividades cient�ficas</p>
				
				<h2>Pagamento</h2>
				<h3> O Pagamento da taxa de inscri��o deve ser feito atrav�s de dep�sito banc�rio <br/> <br/> 
				<b>Banco:</b>Caixa Econ�mica Federal <br/>
				<b>Ag�ncia :</b>3181 <br/>
				<b>Conta Corrente:</b> 61-0<br/>
				<b>Opera��o:</b> 003
				<br/><br/>
				Para validar a inscri��o tire uma fotografia ou escaneie o comprovante de dep�sito e envie <a href='index.php?p=login'>clicando aqui</a>.
			</div>
		</div>
	</div>
</div>

