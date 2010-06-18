<?php /* Smarty version 2.6.14, created on 2009-05-26 22:01:36
         compiled from C:%5Cxampplite%5Chtdocs%5Cevento%5Cadmin%5Ctemplates/formulario.tpl */ ?>
    <table cellpadding="0" cellspacing="3" width="95%" class="form_tabela">
         <?php $_from = $this->_tpl_vars['campos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['campo']):
?>
        <tr>
            <td width="150" class="form_td_label">
            	<?php echo $this->_tpl_vars['campo']['label']; ?>

            </td>
            <td>
            	<?php echo $this->_tpl_vars['campo']['input']; ?>

            </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
    <tr>
        <td>&nbsp;</td>
        <td class="form_td_botao">
        	<input type="submit" id="btsubt" value="Salvar" class="botaoSaltado" />
        </td>
    </tr>
    </table>
    <?php $_from = $this->_tpl_vars['dadoshidden']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['campo'] => $this->_tpl_vars['valor']):
?>
    <input type="hidden" name="<?php echo $this->_tpl_vars['campo']; ?>
" value="<?php echo $this->_tpl_vars['valor']; ?>
" id="<?php echo $this->_tpl_vars['campo']; ?>
" class="formulario_hidden" />
    <?php endforeach; endif; unset($_from); ?>