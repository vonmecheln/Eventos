<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="ROBOTS" CONTENT="NOINDEX" />
<META NAME="ROBOTS" CONTENT="NOFOLLOW" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISTEMA .:. {$nome_modulo} - {$nome_acao}
</title>

<script type='text/javascript'>
	var SISTEMA_URL = "{$sistema_url}";
	this.window.name= 'sistema';
</script>
{$cabecalho}

<script type='text/javascript'>
	/* Funções extras */
	{$funcaojs}
</script>

</head>

<body onload="{$onload}" >

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

	<div id="nome_pagina">
		<img src="{$sistema_url}imagens/setadir.png" align="absmiddle" />&nbsp;{$nome_pagina}
	</div>
	<!-- conteudo -->
	<div id="layout_conteudo">
	{$corpo}	
	</div>
	<!-- fim conteudo -->
	{$extra}
</body>
</html>