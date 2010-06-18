<?php /* Smarty version 2.6.14, created on 2010-06-17 22:05:51
         compiled from /var/www/cou/admin/componente/listagem/template/tabela.tpl */ ?>
<div id="list-div-resultados">
	<div id="list-div-paginacao">
		<?php echo $this->_tpl_vars['paginas']; ?>

	</div>
	<table cellpadding="3" cellspacing="0" width="100%"  class="list-tabela">
	    <tr>
    <?php $_from = $this->_tpl_vars['colunas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['d']):
?>
            <td class="list-td-coluna" width="<?php echo $this->_tpl_vars['d']['tamanho']; ?>
">
            	<a href="javascript:lista.ordem('<?php echo $this->_tpl_vars['d']['campo']; ?>
')">
            	<?php echo $this->_tpl_vars['d']['nome']; ?>

            	</a>
            </td>
	<?php endforeach; endif; unset($_from); ?>
	    </tr>   
	<tbody id="list-tbody-resultados">
	<?php $_from = $this->_tpl_vars['valores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['campo']):
?>
	    <tr>
	    	<?php $_from = $this->_tpl_vars['campo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['v']):
?>
	        	<td class="list-td-resultado" nowrap="nowrap" ><?php echo $this->_tpl_vars['v']; ?>
</td>
	        <?php endforeach; endif; unset($_from); ?>
	    </tr>
	<?php endforeach; endif; unset($_from); ?>	    
	</tbody>	
	</table>
	<em style='text-align:right'>Total de Registros: <?php echo $this->_tpl_vars['totalRegistros']; ?>
</em>
</div>