<div id="tela-listagem">
	<div id="form-listagem">
		<form name='frm' id='frm' onSubmit="lista.busca(); return false;">
		<label> Buscar por </label> 
			<input type="hidden" id="formid" name="formid" value="{$formid}"/>
			<input type="text" size="30" name="list_busca" id="list_busca" value="{$valor}" />
			<select name="filtro_busca" id="filtro_busca" style="width:100px">
				{$options}
			</select>
			<input type="submit" class="botaoSaltado" value="Pesquisar" />
			{$acoes}
		</form>
		
	</div>
	<div id="conteudo-listagem">
		{$tabela}
	</div>
</div>