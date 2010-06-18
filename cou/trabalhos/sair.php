<?
	session_start();
	unset($_SESSION['login']);
	unset($_SESSION['permissao']);
	unset($_SESSION['menu']);

	require_once ("admin/config.php");

	die("<script type='text/javascript'>window.location='".SISTEMA_SITE."'</script>");
?>