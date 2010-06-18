<?php
	$login = Sistema_Login::instanciar();

	if (!$login->usuarioLogado()) {
		die("<script type='text/javascript'>window.location='index.php?p=trabalhos/login'</script>");
	}


	


	// salvar os dados do projeto
	if(Sistema_Variavel::get('salvar'))
	{
		if(($_POST['nova_senha'] != "" && $_POST['senha_atual'] != "") && ($_POST['nova_senha'] == $_POST['repet_nova_senha'])){
			$usr = new Classe_Usuario($login->getCodigo());
			$d = $usr->getDados();
			if(sha1($_POST['senha_atual']) == $d['usr_senha']){
				unset($usr);
				$usr = new Classe_Usuario();
				$usr->setDados(array("usr_cod"=>$login->getCodigo(),"usr_senha"=>($_POST['nova_senha'])));
				if($usr->salvar()){
					$mensagem = '<div class="clean-ok">Senha Alterada com Sucesso</div><br/>';
				}
			}else{
				$mensagem = '<div class="clean-error">Senha Atual esta incorreta</div><br/>';
			}
		}else{
				$msg = ($_POST['senha_atual'] != "") ? "Digite a mesma senha nos dois campos" : "Digite uma senha";
				$mensagem = '<div class="clean-error">'.$msg.'</div><br/>';
			
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

<form name="frmLogin" action="index.php?p=trabalhos/alterarsenha" method="post" class='yform' >
	<fieldset>
		<legend>Alterar Senha</legend>
		<input type="hidden" name="salvar" id="salvar" value="1" />

		<div class="type-text">
			<label for="senha_atual">Senha Atual</label>
			<input type="password" name="senha_atual" id="senha_atual" size="30" value=""/>
		</div>	
		
		<div class="type-text">
			<label for="nova_senha">Nova Senha</label>
			<input type="password" name="nova_senha" id="nova_senha" size="30" value=""/>
		</div>		
	
		<div class="type-text">
			<label for="repet_nova_senha">Repetir Nova Senha</label>
			<input type="password" name="repet_nova_senha" id="repet_nova_senha" size="30" value=""/>
		</div>	
		
		<div class='type-button'>
			<input type="submit" value="Enviar" id="submit" name="submit" />
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