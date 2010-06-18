<?php
	$login = Sistema_Login::instanciar();

	if (!$login->usuarioLogado()) {
		die("<script type='text/javascript'>window.location='index.php?p=trabalhos/login'</script>");
	}

	$sql = sprintf("SELECT cmp_cod,usr_cod,cmp_obs,stt_nome,cmp_data,cmp_img 
					FROM comprovante 
					INNER JOIN status ON status.stt_cod = comprovante.stt_cod
					WHERE usr_cod=%d",$login->getCodigo());
	$cmp = Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);		
	
	$msg = Sistema_Mensagem::instanciar();
	if(count($cmp)>0){
		// Já foi enviado um comprovante
		foreach($cmp as $k=>$v){
			$mensagem = '<div class="clean-ok">Seu comprovante foi enviado e está com Status de <u>'.$v['stt_nome'].'</u></div><br/>';
			$_POST['cmp_obs'] = $v['cmp_obs'];
		}
	}else{
		// Não foi enviado um comprovante
	}
	


	// salvar os dados do projeto
	if(Sistema_Variavel::get('salvar'))
	{
		$mensagem = "";
		if (($_FILES['arquivo']['name'] == "")){
			$mensagem = '<div class="clean-error">Por favor anexe o arquivo</div><br/>';		
		}

		if ($mensagem == ""){

			
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
					$extensoes = array("JPG","JPEG","GIF","PNG");
					if(!in_array($ext,$extensoes)) {
						$msg->setErro("O arquivo deve estar no formato JPG,JPEG,GIF ou PNG");
					} else {
						// se não tiver erro então salva o arquivo
						if(!$msg->temErro()){
							$nome_arq = $login->getCodigo().".".strtolower($ext);
							// salvar o arquivo em pdf dentro da pasta files			
							$uploadfile = COMPROVANTE_DIR.$nome_arq;
							
							if (!move_uploaded_file($_FILES['arquivo']['tmp_name'],$uploadfile)){
								$msg->setErro("Erro ao realizar o upload do arquivo.");
							}else{
								$comprovante = new Classe_Comprovante();
								// seta os dados do post
								$_POST['stt_cod'] = EMANALISE;
								$_POST['usr_cod'] = $login->getCodigo();
								$_POST['cmp_obs'] = str_replace("'", "&#39;", $_POST['cmp_obs'] );
								/*$_POST['cmp_data']= date("Y-m-d H:i:s");*/
								$_POST['cmp_img'] = $nome_arq;
								$comprovante->setDados($_POST);
								$aux = $comprovante->salvar();
								if($aux){
									$msg->setSucesso("Seu comprovante foi enviado e está em <u>Análise</u>");
								}else{
									unlink($uploadfile);
								}
							}
						}
					}
				}

				// se tudo deu certo então 
				if(!$msg->temErro()){
					$mensagem = '<div class="clean-ok">Seu comprovante foi enviado e está em <u>Análise</u></div><br/>';
				} else {
					$mensagem = '<div class="clean-error">'.$msg->getMensagem().'</div><br/>';
				}
			} else {
				$mensagem = '<div class="clean-error">'.$msg->getMensagem().'</div><br/>';
			}
		}
	}
	
	/*if($mensagem){
		$mensagem .= "<a href='index.php?p=trabalhos/enviarComprovante'>&laquo; Voltar</a><br/>";
	}*/

?>

	<div class="subcolumns">
          <div class="c62l">
            <div class="subcl">

<? echo $mensagem ?>

<form name="frmLogin" action="index.php?p=trabalhos/enviarComprovante" method="post" class='yform' enctype="multipart/form-data">
	<fieldset>
		<legend>Enviar Comprovante</legend>
		<input type="hidden" name="salvar" id="salvar" value="1" />
		<div class="type-text">
			<label for="arquivo">Anexar Arquivo</label>
		</div>		
			<input type="file" name="arquivo" id="arquivo" size="50"/> 
		<div class="mensageminfo" style="font-size:10px; font-weight:normal">
			<em>Envie uma imagem LEGIVEL em JPG,JPEG,GIF ou PNG do comprovante de depósito com no máximo 2MB de tamanho do arquivo <br/>
			<b style='color:red'>*</b> Escaneie ou tire uma foto digital com os dados do recibo
			</em>
		</div>	

		<div class="type-text">
			<label for="trb_resumo"> Observação</label>
			<textarea name="cmp_obs" id="cmp_obs" cols="30" rows="7"><? echo $_POST['cmp_obs']; ?></textarea>
		</div>	

		
		<div class='type-button'>
			<input type="submit" value="Enviar" id="submit" name="submit" />
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