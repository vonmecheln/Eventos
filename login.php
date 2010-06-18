<?	
	require_once "admin/config.php";
 
	// classe de login 
	$login = Sistema_Login::instanciar();

	$email = Sistema_Variavel::get('email');
	$senha = Sistema_Variavel::get('senha');
	
	if ($login->logar($email,$senha) || ($login->usuarioLogado())) {
		$url = "index.php?p=trabalhos/trabalhos";
		die("<script type='text/javascript'>window.location='".$url."'</script>");
	} elseif($email != ""){
		$msg = '<div class="clean-error">E-mail ou senha inválidos</div><br/>';
	}
	
	echo $msg;
?>

<form name="frmLogin" action="index.php?p=login" method="post" class='yform'>
	<fieldset>
		<legend>Acesso ao Sistema</legend>
		<div class="type-text">
			<label for="email">E-mail</label>
			<input type="text" name="email" id="email" size="20" />
		</div>
		<div class="type-text">
			<label for="senha">Senha</label>
			<input type="password" name="senha" id="senha" size="15" />
		</div>
		<div class='type-button'>
			<input type="submit" value="Acessar" id="submit" name="submit" />			
			<input type="reset" value="Cancelar / Voltar" id="reset" name="reset" onClick="window.location='index.php?p=inicio'"/>		
		</div>
		<div>
			<a href="index.php?p=senha">Esqueci minha senha</a>
		</div>
	</fieldset>
	<a style='color:red' href="index.php?p=inscricao">Para submeter trabalhos é necessário primeiro fazer a inscrição no evento <b>clicando aqui</b>!.</a>	
</form>