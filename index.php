<? session_start(); 

require_once "admin/config.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//PT"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
<head>
<title>COU - Congresso de Odontologia da UNIOESTE</title>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>  -->
<meta http-equiv="Content-Type" content="text/html; charset=latin1"/>
<script type="text/javascript">
var SISTEMA_URL ="<?php echo SISTEMA_URL;?>";
</script>

<script type="text/javascript" src="<?php echo SISTEMA_URL; ?>javascript/prototype1.6.js"> </script>
<script type="text/javascript" src="<?php echo SISTEMA_URL; ?>javascript/sistema.js"> </script>
<script type="text/javascript" src="<?php echo SISTEMA_URL; ?>javascript/formulario.js"> </script>
<script type="text/javascript" src="<?php echo SISTEMA_URL; ?>javascript/mascara/mascara.js"> </script>
<script type="text/javascript" src="javascript/inscricao.js"> </script>


<link href="css/layout_grids.css" rel="stylesheet" type="text/css"/>
<!--[if lte IE 7]>
<link href="yalm/yaml_31090120/examples/06_layouts_advanced/css/patches/patch_grids" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body>
<div class="page_margins">
  <div class="page">
    <div id="header" align="center">
      <div id="topnav">
		<?
			$login = Sistema_Login::instanciar();
		?>
        <span>
		<?
			if($login->usuarioLogado()){ echo "<a href='index.php?p=trabalhos/sair'>Sair</a>";}
		?>
	</div>
		<img src="imagens/logocou.jpg"/>
      <h1><? echo EVENTO ?></h1>
      <span>1 a 4 de setembro 2010</span> 
	  </div>
    <!-- begin: main navigation #nav -->
    <div id="nav"> <a id="navigation" name="navigation"></a>
      <!-- skip anchor: navigation -->
      <div class="hlist">
       <? include "menu.php";?>
      </div>
    </div>
    <!-- end: main navigation -->
    <!-- begin: main content area #main -->
    <div id="main">
        <!-- Subtemplate: 2 Spalten mit 50/50 Teilung -->
     <? 
	 
	 $arquivo = $_GET['p'];
	 if(is_file($arquivo . ".php")){
		 include $arquivo . ".php";
	 }else{
		 include 'inicio.php';
	 }
	 
	 ?>
    </div>
    <!-- end: #main -->
    <!-- begin: #footer -->
    <div id="footer">
      <p><? include "rodape.php"; ?></p>
    </div>
    <!-- end: #footer -->
  </div>
</div>
</body>
</html>
