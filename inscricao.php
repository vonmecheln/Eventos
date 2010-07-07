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
								<option value="Acadêmico">Acadêmico</option>
								<option value="Profissional">Profissional</option>
							</select>
						</div>');
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_desc" id="nome_desc">Universidade</label>
							<input type="text" name="tpp_desc" id="tpp_desc" value=""/>
						</div>');
						
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_cracha" id="tpp_cracha">Nome no Crachá</label>
							<input type="text" name="tpp_cracha" id="tpp_cracha" value=""/>
						</div>');

$campos_form .= sprintf('<div class="type-text">
							<label for="trabalho1" id="trabalho1">Trabalho 1</label>
              <select name="trabalho1" id="trabalho1">
                <option>Não Enviarei </option>
                <option>Poster + R$ 20,00</option>
                <option>Tema Livre + R$ 30,00</option>                                
							</select>
						</div>');

$campos_form .= sprintf('<div class="type-text">
							<label for="trabalho2" id="trabalho2">Trabalho 2</label>
							<select name="trabalho2" id="trabalho2">
                <option>Não Enviarei </option>
                <option>Poster + R$ 20,00</option>
                <option>Tema Livre + R$ 30,00</option>                                
							</select>
						</div>');

$campos_form .= sprintf('<div class="type-text">
							<label for="trabalho3" id="trabalho3">Trabalho 3</label>
							<select name="trabalho3" id="trabalho3">
                <option>Não Enviarei </option>
                <option>Poster + R$ 20,00</option>
                <option>Tema Livre + R$ 30,00</option>                                
							</select>
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
				<h3>Instruções</h3>
				( <b style="color: red;">! </b> ) Campo Obrigatório
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
			<h2>Inscrição</h2>
			<table width="100%" border="0">
				<tr>
					<th>Taxa de Adesão</th>
					<th>até 01/agosto</th>
					<th style='color:red'>até 17 de agosto</th>
					<th>no evento</th>
				</tr>
				<tr>
					<td>Acadêmicos</td>
					<td>R$ 50,00</td>
					<td>R$ 65,00</td>
					<td>R$ 80,00</td>
				</tr>
				<tr>
					<td>Profissionais</td>
					<td>R$ 70,00</td>
					<td>R$ 85,00</td>
					<td>R$ 100,00</td>
				</tr>
			</table>
			</div>
		</div>
	</div>
</div>

