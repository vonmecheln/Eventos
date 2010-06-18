    
    <table cellpadding="0" cellspacing="1" width="95%" class="form_tabela" style="padding-left:25px">
    	<tr>
    		<td colspan="2" ><h2>Grupo : <span style="color:navy"> {$grp_descricao} </span></h2></td>
    	</tr>
    
    	{foreach key=key item=att from=$modulos}
    		 <tr>
	            <td width="150" class="form_td_label" style="background-color:#EEE;padding:5px;border:1px solid #ccc;">
	            	Módulo {$key}
	            </td>
	            <td style="border-bottom:1px solid #ccc;padding:5px">
	            	&nbsp;
	            </td>
	        </tr>
	         {foreach key=key item=cp from=$att}
	        <tr>
	            <td width="150" class="form_td_label" style="padding:5px;border-bottom:1px solid #CCC;">
	            	{$cp.label}
	            </td>
	            <td style="padding:5px;border-bottom:1px solid #EEE;">
	            	{$cp.campo}
	            </td>
	        </tr>
	        {/foreach}
        {/foreach}
    <tr>
        <td>&nbsp;</td>
        <td class="form_td_botao">
        	<input type="submit" id="btsubt" value="Salvar" class="botaoSaltado" />
        </td>
    </tr>
    </table>
    <input type="hidden" name="grp_cod" value="{$grp_cod}" id="grp_cod" class="formulario_hidden" />
