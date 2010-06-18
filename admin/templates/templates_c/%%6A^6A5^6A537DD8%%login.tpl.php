<?php /* Smarty version 2.6.14, created on 2009-05-26 22:12:30
         compiled from login.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="ROBOTS" CONTENT="NOINDEX" />
<META NAME="ROBOTS" CONTENT="NOFOLLOW" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login do Sistema</title>

<script type='text/javascript'>
	var SISTEMA_URL = "<?php echo $this->_tpl_vars['sistema_url']; ?>
";
	this.window.name= 'sistema';
	
</script>
<?php echo $this->_tpl_vars['cabecalho']; ?>


</head>

<body onLoad="$('usuario').focus()">

<div id="caixatopo"><b>::</b> Sistema de Gestão de Eventos</div>
<div id="caixalogin" >
	<div id="msg"></div>
	<h1> Acesso Restrito </h1>
	<form name='frmlogin' id='frmlogin' onSubmit="formulario.login('frmlogin');return false;" >
	usuário <br>
	<input type="text" size="30" name="usuario" id="usuario"  /><br>
	senha <br>
	<input type="password" size="30" name="senha" id="senha" /><br>
	<input type="submit" class="botaoSaltado" value="Entrar" /><br>
	<a href="#" > Esqueci minha senha</a>
	</form>
</div>

</body>
</html>