<?php /* Smarty version 2.6.14, created on 2009-05-26 22:02:06
         compiled from C:%5Cxampplite%5Chtdocs%5Cevento%5Cadmin%5Ccomponente/listagem/template/formulario.tpl */ ?>
<div id="tela-listagem">
	<div id="form-listagem">
		<form name='frm' id='frm' onSubmit="lista.busca(); return false;">
		<label> Buscar por </label> 
			<input type="hidden" id="formid" name="formid" value="<?php echo $this->_tpl_vars['formid']; ?>
"/>
			<input type="text" size="30" name="list_busca" id="list_busca" value="<?php echo $this->_tpl_vars['valor']; ?>
" />
			<select name="filtro_busca" id="filtro_busca" style="width:100px">
				<?php echo $this->_tpl_vars['options']; ?>

			</select>
			<input type="submit" class="botaoSaltado" value="Pesquisar" />
			<?php echo $this->_tpl_vars['acoes']; ?>

		</form>
		
	</div>
	<div id="conteudo-listagem">
		<?php echo $this->_tpl_vars['tabela']; ?>

	</div>
</div>