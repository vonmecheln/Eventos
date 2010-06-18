<?	
       // este eh um teset
	require_once "admin/config.php";
 
	// classe de login 
	$login = Sistema_Login::instanciar();

	$email = Sistema_Variavel::get('email');

	if(!is_null($email) && $email != ""){
		echo $login->recuperar($email);
	}
?>

<form name="frmLogin" action="index.php?p=senha" method="post" class='yform'>
	<fieldset>
		<legend>Recuperar Senha</legend>
		<div class="type-text">
			<label for="email">Digite seu E-mail</label>
			<input type="text" name="email" id="email" size="20" />
		</div>

		<div class='type-button'>
			<input type="submit" value="Enviar" id="submit" name="submit" />			
			<input type="reset" value="Cancelar / Voltar" id="reset" name="reset" onClick="window.location='index.php?p=inicio'"/>		
		</div>
	</fieldset>
	
</form>