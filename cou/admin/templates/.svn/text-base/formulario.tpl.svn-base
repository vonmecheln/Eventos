    <table cellpadding="0" cellspacing="3" width="95%" class="form_tabela">
         {foreach key=key item=campo from=$campos}
        <tr>
            <td width="150" class="form_td_label">
            	{$campo.label}
            </td>
            <td>
            	{$campo.input}
            </td>
        </tr>
        {/foreach}
    <tr>
        <td>&nbsp;</td>
        <td class="form_td_botao">
        	<input type="submit" id="btsubt" value="Salvar" class="botaoSaltado" />
        </td>
    </tr>
    </table>
    {foreach key=campo  item=valor from=$dadoshidden}
    <input type="hidden" name="{$campo}" value="{$valor}" id="{$campo}" class="formulario_hidden" />
    {/foreach}
