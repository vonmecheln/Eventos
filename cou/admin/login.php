<?php
	# Limpa a sessão no servidor
	unset($_SESSION);
	
	include 'config.php';
	$login = Sistema_Login::instanciar();
	if($login->logar($_POST['usuario'],$_POST['senha'])){
		echo "ok";	
	}else{
		echo "erro";
	}
?>