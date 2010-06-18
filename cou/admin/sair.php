<?php
	session_start();
	unset($_SESSION['login']);
	unset($_SESSION['permissao']);
	unset($_SESSION['menu']);
	include_once 'config.php';
	# Limpa a sessão no servidor
	header("location:".SISTEMA_URL);
?>