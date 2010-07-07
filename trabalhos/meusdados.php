<?php
require_once 'selectArray.php';
// verifica se está logado
$login = Sistema_Login::instanciar();

$form = new Componente_Formulario(new Classe_Usuario($login->getCodigo()),"inscricao");
$campos = $form->getCampos();

foreach($campos as $k=>$v){
	// nao mostra a senha
	if($k != 9){
	$campos_form .= sprintf('<div class="type-text">
							%s
							%s
						</div>',$v['label'],$v['input']);
	}
}

$sql = "SELECT * FROM participante WHERE usr_cod=".$login->getCodigo();
$rs = Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);
$rs = $rs[0];

//$campos_form .= selectArray::getHtmlSelect();
// Tipo do paticipante
$vetTpPart = array("Acadêmico"=>"Acadêmico","Profissional"=>"Profissional","THD / ACD"=>"THD / ACD");
$select = selectArray::getHtmlSelect($vetTpPart,'tpp_nome',$rs['tpp_nome']);
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_nome">Sou</label>
							%s
						</div>',$select);
						
$tpp_desc = ($rs['tpp_nome']=="Acadêmico") ? "Universidade" : "Inscrição feita pela secretaria de saúde do município de";						
					
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_desc" id="nome_desc">%s</label>
							<input type="text" name="tpp_desc" id="tpp_desc" value="%s"/>
						</div>',$tpp_desc,$rs['tpp_desc']);
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_cracha" id="tpp_cracha">Nome no Crachá</label>
							<input type="text" name="tpp_cracha" id="tpp_cracha" value="%s"/>
						</div>',$rs['tpp_cracha']);

$vetTpPart = array(""=>"Não Enviarei","Tema Livre"=>"Tema Livre + R$ 30,00","Poster"=>"Poster + R$ 20,00");

$select = selectArray::getHtmlSelect($vetTpPart,'tpp_trabalho1',$rs['tpp_trabalho1']);
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_nome">Sou</label>
							%s
						</div>',$select);

$select = selectArray::getHtmlSelect($vetTpPart,'tpp_trabalho2',$rs['tpp_trabalho2']);
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_nome">Sou</label>
							%s
						</div>',$select);

$select = selectArray::getHtmlSelect($vetTpPart,'tpp_trabalho3',$rs['tpp_trabalho3']);
$campos_form .= sprintf('<div class="type-text">
							<label for="tpp_nome">Sou</label>
							%s
						</div>',$select);
?>
			<div id="layout_mensagens" align="center" class="mensagem{$tipo_msg}"	style="display: none">
				<div id="mensagem_conteudo"></div>
				<div id="mensagem_fechar"><br>
				<a href="#" id="idBotaoMsgFechar" class="link_botao_msg" onclick="$('layout_mensagens').style.display='none';"> Fechar </a>
				</div>
			</div>
	<div class="subcolumns">
          <div class="c62l">
            <div class="subcl">
            		<!-- CONTEÚDO PRINCIPAL DO LADO ESQUERDO -->
					<fieldset>
						<form id="frmInscricao" class='yform' onSubmit="formulario.enviaFormInscricao('frmInscricao'); return false;">
								<input type="hidden" name="usr_cod" id="usr_cod" value="<? echo $login->getCodigo(); ?>"/>
								<legend>Dados do Participante</legend>
									<?php echo $campos_form; ?>
									<div class='type-button'><input type="submit" value="Salvar" /></div>
						</form>            		
					</fieldset>
              </div>
          </div>

          <div class="c38r">
            <div class="subcr">
            	
				<div class="info">
		            <?php include'menuTrabalhos.php'; ?>
		        </div>             	
				<div class="info">
					<?php include'downloads.php'; ?>
				</div>
			</div>
		</div>
	</div>
