<?php /* Smarty version 2.6.14, created on 2009-06-14 23:33:44
         compiled from index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="ROBOTS" CONTENT="NOINDEX" />
<META NAME="ROBOTS" CONTENT="NOFOLLOW" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gerenciador de Eventos
</title>

<script type='text/javascript'>
	var SISTEMA_URL = "<?php echo $this->_tpl_vars['sistema_url']; ?>
";
	this.window.name= 'sistema';
</script>
<?php echo $this->_tpl_vars['cabecalho']; ?>


</head>

<body onload="<?php echo $this->_tpl_vars['onload']; ?>
" >

	<!-- TOPO USUÁRIO -->
	<div id='topo_user'>
		<div id='topo_left'>
			<b style='color:#666;'>::</b>&nbsp;<b>Gerenciador de Eventos</b> <b style='color:#666;'>::</b>&nbsp;
			<?php echo $this->_tpl_vars['infotopo']; ?>

			&nbsp;
		</div>
		<div id='topo_right'>
			<img src='<?php echo $this->_tpl_vars['sistema_url']; ?>
imagens/sair.png' title="SAIR" border=0 align="absmiddle">	
			<a href='<?php echo $this->_tpl_vars['sistema_url']; ?>
sair.php' class='link_sair'>Sair</a>
		</div>	
	</div>

	<!-- MENU -->
	<div id='div-menu'>
		<?php echo $this->_tpl_vars['menu']; ?>

	</div>
	<!-- Barra de Carregando -->
	<div id="mensagemCarregando">
		<img src="<?php echo $this->_tpl_vars['sistema_url']; ?>
imagens/ajax-loader.gif" align="absmiddle" />&nbsp;Carregando 
	</div>
	<!-- mensagem -->
	<div id="layout_mensagens" align="center" class="mensagem<?php echo $this->_tpl_vars['tipo_msg']; ?>
" >
		<div id="mensagem_conteudo"><?php echo $this->_tpl_vars['mensagem']; ?>
</div>
		<div id="mensagem_fechar"><br>
			<a href="#" id="idBotaoMsgFechar" class="link_botao_msg" onclick="$('layout_mensagens').style.display='none';">
			 Fechar
			 </a>
		</div>
	</div>
	<!-- fim mensagem -->
	<div id="layout_botoes">
		<?php echo $this->_tpl_vars['botoes']; ?>

	</div>
	<div id="nome_pagina">
		<img src="<?php echo $this->_tpl_vars['sistema_url']; ?>
imagens/setadir.png" align="absmiddle" />&nbsp;<?php echo $this->_tpl_vars['nome_pagina']; ?>

	</div>
	<!-- conteudo -->
	<div id="layout_conteudo">
	<?php echo $this->_tpl_vars['corpo']; ?>
	
	</div>
	<!-- fim conteudo -->
	<!-- 
	Rodapé
	<div id="layout_rodape">
		<div style="padding:15px 10px 10px 10px">
			<font color='navy'><b><?php echo $this->_tpl_vars['nome_usuario']; ?>
 :</b></font>&nbsp; <b><?php echo $this->_tpl_vars['nome_modulo']; ?>
 &gt; <?php echo $this->_tpl_vars['nome_acao']; ?>
</b>
		</div>
	</div>
	 -->
	<?php echo $this->_tpl_vars['extra']; ?>

	<script type='text/javascript'>
		/* Funções que deverão ficar no fim da página */
		<?php echo $this->_tpl_vars['funcaojs']; ?>
;
	</script>
</body>
</html>