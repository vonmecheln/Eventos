<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="ROBOTS" CONTENT="NOINDEX" />
<META NAME="ROBOTS" CONTENT="NOFOLLOW" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gerenciador de Eventos
</title>

<script type='text/javascript'>
	var SISTEMA_URL = "{$sistema_url}";
	this.window.name= 'sistema';
</script>
{$cabecalho}

</head>

<body onload="{$onload}" >

	<!-- TOPO USUÁRIO -->
	<div id='topo_user'>
		<div id='topo_left'>
			<b style='color:#666;'>::</b>&nbsp;<b>Gerenciador de Eventos</b> <b style='color:#666;'>::</b>&nbsp;
			{$infotopo}
			&nbsp;
		</div>
		<div id='topo_right'>
			<img src='{$sistema_url}imagens/sair.png' title="SAIR" border=0 align="absmiddle">	
			<a href='{$sistema_url}sair.php' class='link_sair'>Sair</a>
		</div>	
	</div>

	<!-- MENU -->
	<div id='div-menu'>
		{$menu}
	</div>
	<!-- Barra de Carregando -->
	<div id="mensagemCarregando">
		<img src="{$sistema_url}imagens/ajax-loader.gif" align="absmiddle" />&nbsp;Carregando 
	</div>
	<!-- mensagem -->
	<div id="layout_mensagens" align="center" class="mensagem{$tipo_msg}" >
		<div id="mensagem_conteudo">{$mensagem}</div>
		<div id="mensagem_fechar"><br>
			<a href="#" id="idBotaoMsgFechar" class="link_botao_msg" onclick="$('layout_mensagens').style.display='none';">
			 Fechar
			 </a>
		</div>
	</div>
	<!-- fim mensagem -->
	<div id="layout_botoes">
		{$botoes}
	</div>
	<div id="nome_pagina">
		<img src="{$sistema_url}imagens/setadir.png" align="absmiddle" />&nbsp;{$nome_pagina}
	</div>
	<!-- conteudo -->
	<div id="layout_conteudo">
	{$corpo}	
	</div>
	<!-- fim conteudo -->
	<!-- 
	Rodapé
	<div id="layout_rodape">
		<div style="padding:15px 10px 10px 10px">
			<font color='navy'><b>{$nome_usuario} :</b></font>&nbsp; <b>{$nome_modulo} &gt; {$nome_acao}</b>
		</div>
	</div>
	 -->
	{$extra}
	<script type='text/javascript'>
		/* Funções que deverão ficar no fim da página */
		{$funcaojs};
	</script>
</body>
</html>