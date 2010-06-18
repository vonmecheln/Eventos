<?php

	require_once "admin/config.php";
    require_once "selectArray.php";

	// classe de login 
	$login = Sistema_Login::instanciar();

	if (!$login->usuarioLogado()) {
		die("<script type='text/javascript'>window.location='index.php?p=trabalhos/login'</script>");
	}

	if($_POST['trb_cod'] == "")
		unset($_POST['trb_cod']);

	// carregar os dados do projeto
	if(Sistema_Variavel::get('cod')){
		$sql = "SELECT * FROM trabalho WHERE trb_cod = ".Sistema_Variavel::get('cod');
		
		$trb = Sistema_Conecta::Execute($sql);		
		
		foreach($trb[0] as $k=>$v){		
			$_POST[$k] = $v;
		}

		// verifica se o cara que ta logado é o dono do projeto
		if($login->getCodigo() != $_POST['usr_cod']){
			die("Este trablho pertence a outro usuário.");
		}
		
		if (($_POST['trb_status'] != ATIVO) && ($_POST['trb_status'] != ACEITOCOMRESALVAS)){
			die("Este não pode ser editado.");
		}
	}

	// salvar os dados do projeto
	if(Sistema_Variavel::get('salvar'))
	{
		$msg = Sistema_Mensagem::instanciar();

		// verifica se as areas basicas foram escolhidas
		if (($_POST['trb_area'] == "") && ($_POST['trb_areabasica'] == "") && ($_POST['trb_outraqual'] == "")){
			$mensagem = '<div class="clean-error">É necessário escolher a área básica</div><br/>';
		}

		if($_POST['trb_categoria'] != "Pesquisa/Extensão"){
			$autores = explode(";",$_POST['trb_coautor']);
			$orientadores = explode(";",$_POST['trb_orientador']);
			if ((sizeof($autores) > 3) || (sizeof($orientadores) > 2)){
				$mensagem = '<div class="clean-error">Para Casos Clínicos e Revisão de Literatura no máximo 3 co-autores e 2 orientadores</div><br/>';
			}
		}

		$palavraschave = explode(";",$_POST['trb_palavraschave']);
		if ((sizeof($palavraschave) != 3) && (sizeof($palavraschave) != 4)){
			$mensagem = '<div class="clean-error">Informe 3 ou 4 palavras chaves separadas por ; (ponto e virgula)</div><br/>';
		}
		
		if (($_FILES['arquivo']['name'] == "") && ($_POST['trb_cod'] == "")){
			$mensagem = '<div class="clean-error">Por favor anexe o arquivo</div><br/>';		
		}

		if ($mensagem == ""){
			$trabalho = new Classe_Trabalho();
			
			// seta os dados do post
			$_POST['trb_status'] = ATIVO;
			$_POST['usr_cod'] = $login->getCodigo();
			
			$trabalho->setDados($_POST);
			$aux = $trabalho->salvar();
			
			if($_POST['trb_cod'] == "") {
				// pra nao atualizar
				$_POST['trb_cod'] = $aux['id']['valorid'];	
			}
			
			if(!$msg->temErro())
			{
				// se mandou o arquivo então
				if($_FILES['arquivo']['name'] != ""){

					// se salvou o projeto então salva o arquivo que foi enviado caso ele esteja nas regras	
					// tamanho do arquivo
					if($_FILES['arquivo']['size'] > 4000000){
						$msg->setErro("O tamanho do arquivo deve ser menor do que 2MB, caso necessite enviar um arquivo maior entre em contato.");
					}
					
					// extensao do arquivo
					$ext = explode(".",$_FILES['arquivo']['name']);
					$ext = strtoupper($ext[(sizeof($ext)-1)]);

					if (($ext != "PDF") && ($ext != "DOC")){
						$msg->setErro("O arquivo deve estar no formato PDF ou DOC");
					} else {
						// se não tiver erro então salva o arquivo
						if(!$msg->temErro()){
							// salvar o arquivo em pdf dentro da pasta files			
							$uploadfile = UPLOAD_DIR.$_POST['trb_cod'].".".$ext;
							
							if (!move_uploaded_file($_FILES['arquivo']['tmp_name'],$uploadfile)){
								$msg->setErro("Erro ao realizar o upload do arquivo.");
							}
						}
					}
				}

				// se tudo deu certo então 
				if(!$msg->temErro()){
					$mensagem = '<div class="clean-ok">Trabalho salvo com sucesso '.$alerta.'.</div><br/>';
				} else {
					$mensagem = '<div class="clean-error">'.$msg->getMensagem().'</div><br/>';
				}
			} else {
				$mensagem = '<div class="clean-error">'.$msg->getMensagem().'</div><br/>';
			}
		}
	}
	
	if($mensagem){
		$mensagem .= "<a href='index.php?p=trabalhos/trabalhos'>&laquo; Voltar</a><br/>";
	}

	// vetor com as categorias
	$vetCategoria['Pesquisa/Extensão'] = 'Pesquisa/Extensão';
	$vetCategoria['Caso Clínico'] = 'Caso Clínico';
	$vetCategoria['Revisão de Literatura'] = 'Revisão de Literatura';

	// vetor com os tipos de apresentação
	$vetApresentacao['Resumo'] = 'Resumo';
	$vetApresentacao['Trabalho Completo'] = 'Trabalho Completo';
	$vetApresentacao['Painel'] = 'Painel';

?>
<script type='text/javascript'>
	function esconde(){
		document.getElementById('divBasicaQual').style.display = 'none';
		document.getElementById('divOutraQual').style.display = 'none';
	}

	function exibe(id, input){
		esconde();
		
		document.getElementById('trb_areabasica').value = '';
		document.getElementById('trb_outraqual').value = '';

		document.getElementById(id).style.display = 'block';
		document.getElementById(input).focus();
	}

	function contar(){
		document.getElementById('caracteres').innerHTML = document.forms[0].trb_resumo.value.length
	}

</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>



	<div class="subcolumns">
          <div class="c62l">
            <div class="subcl">
       
 

<? 

echo $mensagem ?>

<form name="frmLogin" action="index.php?p=trabalhos/gerenciarTrabalho" method="post" class='yform' enctype="multipart/form-data">

	<input type='hidden' name='salvar' value='1'/>

	<input type='hidden' name='trb_cod' value='<? echo $_POST['trb_cod']?>'/>
	
	<fieldset>
		<legend>Adicionar Trabalho</legend>
		<div><span class="style1">*</span> Apenas as iniciais em maiúscula</div>
		<div class="type-text">
			<label for="trb_titulo"><b style='color:red'>!</b> Título</label>
			<input type="text" name="trb_titulo" id="trb_titulo" size="40" value="<? echo $_POST['trb_titulo']?>"/>
		</div>
		
		<div class="type-text">
			<label for="trb_apresentador"><b style='color:red'>!</b> Apresentador</label>
			<input type="text" name="trb_apresentador" id="trb_apresentador" size="50" value="<? echo $_POST['trb_apresentador']?>"/>
		</div>
		
		<div class="type-text">
			<label for="trb_coautor">Co-Autores</label>
			<input type="text" name="trb_coautor" id="trb_coautor" size="50" value="<? echo $_POST['trb_coautor']?>"/> <em>Caso haja mais de um Co-autor separar com ; (ponto e vírgula) os seus nomes</em>
		</div>
		
		<div class="type-text">
			<label for="trb_orientador"><b style='color:red'>!</b> Orientadores</label>
			<input type="text" name="trb_orientador" id="trb_orientador" size="50" value="<? echo $_POST['trb_orientador']?>"/> <em>Caso haja mais de um Orientador separar com ; (ponto e vírgula) os seus nomes</em>
		</div>

		<div class="type-check">
			<label><b style='color:red'>!</b> Área</label> <br/>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Dentística") echo "checked "; ?> name="trb_area" value="Dentística" type="radio"> <label>Dentística</label><br/>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Cirurgia/Implante") echo "checked "; ?>name="trb_area" value="Cirurgia/Implante" type="radio"> Cirurgia/Implante</label><br>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Saúde Coletiva") echo "checked "; ?>name="trb_area" value="Saúde Coletiva" type="radio"> Saúde Coletiva</label><br>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Endodontia") echo "checked "; ?>name="trb_area" value="Endodontia" type="radio"> Endodontia</label><br>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Periodontia") echo "checked "; ?>name="trb_area" value="Periodontia" type="radio"> Periodontia</label><br>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Estomatologia/Patologia") echo "checked "; ?>name="trb_area" value="Estomatologia/Patologia" type="radio"> Estomatologia/Patologia</label><br>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Ortodontia") echo "checked "; ?>name="trb_area" value="Ortodontia" type="radio"> Ortodontia</label><br>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Odontopediatria") echo "checked "; ?>name="trb_area" value="Odontopediatria" type="radio"> Odontopediatria</label><br>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Prótese") echo "checked "; ?>name="trb_area" value="Prótese" type="radio"> Prótese</label><br>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Oclusão/DTM") echo "checked "; ?>name="trb_area" value="Oclusão/DTM" type="radio"> Oclusão/DTM</label><br>
			<label onclick='esconde()'><input <? if($_POST['trb_area'] === "Radiologia") echo "checked "; ?>name="trb_area" value="Radiologia" type="radio"> Radiologia</label><br>
			<?
				if($_POST['trb_areabasica'] != "") {
					$checkedAreabasica = "checked";
					$displayAreabasica = "display:block";
				} else {
					$displayAreabasica = "display:none";
				}

				if($_POST['trb_outraqual'] != "") {
					$checkedOutraqual = "checked";
					$displayOutraqual = "display:block";
				} else {
					$displayOutraqual = "display:none";
				}	
			?>
			<label onclick='exibe("divBasicaQual","basica_qual")'>
				<input name="trb_area" <? echo $checkedAreabasica ?> value="" type="radio"> Área Básica. Qual?</label>
				<div class='type-text' id='divBasicaQual' style='<? echo $displayAreabasica ?>'>
					<input name="trb_areabasica" id="trb_areabasica" size="30" maxlength="90" value="<? echo $_POST['trb_areabasica']?>">
				</div>
			<br/><label onclick='exibe("divOutraQual","outra_qual")'>
				<input name="trb_area" <? echo $checkedOutraqual ?>  value="" type="radio"> Outra</label>
				<div class='type-text' id='divOutraQual' style='<? echo $displayOutraqual ?>'>
					<input name="trb_outraqual" id="trb_outraqual"  size="30" maxlength="90" value="<? echo $_POST['trb_outraqual']?>">
				</div>
		</div>
		
		<div class="type-select">
			<label for="trb_categoria"><b style='color:red'>!</b> Categoria</label>
			<? echo selectArray::getHtmlSelect($vetCategoria,'trb_categoria',$_POST['trb_categoria'])?>
		</div>
		
		<!--
		<div class="type-text">
			<label for="trb_resumo"><b style='color:red'>!</b> Observa&ccedil;&atilde;o (200 a 250 caracteres)</label>
			<textarea onKeyDown="contar()" onKeyUp="contar()" name="trb_resumo" id="trb_resumo" cols="30" rows="7"><? echo $_POST['trb_resumo']?></textarea>
			<b>Quantidade de Caracteres:</b> <em id='caracteres'>
			<?
				echo strlen($_POST['trb_resumo']);
			?>
			</em>
		</div>		
		-->
		<div class="type-select">
			<label for="trb_frmapresentacao"><b style='color:red'>!</b> Forma de Apresentação</label>
			<? echo selectArray::getHtmlSelect($vetApresentacao,'trb_frmapresentacao',$_POST['trb_frmapresentacao'])?>
		</div>

		<div class="type-text">
			<label for="referencia"><b style='color:red'>!</b> Referências Bibliográficas (citar 2 ou 3)</label>
			<input type="text" name="trb_referencia1" id="trb_referencia1" size="50" value="<? echo $_POST['trb_referencia1']?>"/>
			<input type="text" name="trb_referencia2" id="trb_referencia2" size="50" value="<? echo $_POST['trb_referencia2']?>"/>
			<input type="text" name="trb_referencia3" id="trb_referencia3" size="50" value="<? echo $_POST['trb_referencia3']?>"/>
		</div>		
		
		<div class="type-text">
			<label for="trb_palavraschave"><b style='color:red'>!</b> Palavras Chave</label>
			<input type="text" name="trb_palavraschave" id="trb_palavraschave" size="50" value="<? echo $_POST['trb_palavraschave']?>"/> <em>Separadas com ; (ponto e vírgula)</em>
		</div>		

		<div class="type-text">
			<label for="arquivo">Anexar Arquivo</label>
		</div>		
			<input type="file" name="arquivo" id="arquivo" size="50"/> <em>Somente serão aceitos arquivos do tipo PDF e com no máximo 2MB</em>

		
		<div class='type-button'>
			<input type="submit" value="Salvar Trabalho" id="submit" name="submit" />
			<input type="reset" value="Cancelar / Voltar" id="reset" name="reset" onClick="window.location='index.php?p=trabalhos/trabalhos'"/>
		</div>
	</fieldset>
</form>

           </div>
          </div>

          <div class="c38r">
            <div class="subcr">
                <div class="info">
		            <?php include'menuTrabalhos.php'; ?>
		        </div>      
				<div class="info">
					<?php include'./downloads.php'; ?>
				</div>
			</div>
		</div>
	</div>
