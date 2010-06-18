<div id="list-div-resultados">
	<div id="list-div-paginacao">
		{$paginas}
	</div>
	<table cellpadding="3" cellspacing="0" width="100%"  class="list-tabela">
	    <tr>
    {foreach key=k item=d from=$colunas}
            <td class="list-td-coluna" width="{$d.tamanho}">
            	<a href="javascript:lista.ordem('{$d.campo}')">
            	{$d.nome}
            	</a>
            </td>
	{/foreach}
	    </tr>   
	<tbody id="list-tbody-resultados">
	{foreach key=key item=campo from=$valores}
	    <tr>
	    	{foreach  key=i item=v from=$campo}
	        	<td class="list-td-resultado" nowrap="nowrap" >{$v}</td>
	        {/foreach}
	    </tr>
	{/foreach}	    
	</tbody>	
	</table>
	<em style='text-align:right'>Total de Registros: {$totalRegistros}</em>
</div>