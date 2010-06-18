<!-- onLoad="$('produto_valor_1').focus()" -->
<body >

<div style="padding:5px;margin:5px;">
	<img src="{$sistema_url}imagens/Apple.png" align="middle"/>
	<span style="color:#CCC;font-size:32px;font-wheigth:bold">Fechar Venda</span>
</div>

<!--<form name="pagamentodigital" action="{$sistema_url}index.php?mod=clientes&act=venda" method="post">-->
<!--<form name="form_pagamento" action="https://www.pagamentodigital.com.br/checkout/pay/" method="post">-->
<form name="form_pagamento" action="https://pagseguro.uol.com.br/security/webpagamentos/webpagto.aspx" method="post" id='form_pagamento'>
  

    <table cellpadding="0" cellspacing="3" width="95%" class="form_tabela">
    
		<!-- cpf/cnpj -->
         <tr>
            <td width="150" class="form_td_label">
            	CPF / CNPJ 
            </td>
            <td>
            	{$campo_cpf_cnpj}
            </td>
        </tr>    
    
		<!-- cliente -->
         <tr>
            <td width="150" class="form_td_label">
            	Cliente 
            </td>
            <td>
            	{$campo_cliente}
            </td>
        </tr>    
    
     	<!-- Valor -->
         <tr>
            <td width="150" class="form_td_label">
            	Valor Total 
            </td>
            <td>
            	{$valor_produto}
            </td>
        </tr>
        
        <!-- separador -->
        <tr>
            <td width="150" class="form_td_label" colspan='2'>
            	<hr color='#efefef' size='1'/>           	
            </td>            
        </tr>
        
        <tr>
            <td class="form_td_label" align='left'>Escolha a forma de pagamento</td>
            <td></td>
        </tr> 
        <!-- formas de pagamento -->
         <tr>
            <td class="form_td_label" colspan='2' align='center'>
            	<table cellpaddin='0' cellspacing='0' border='0' width='450'>
            	<tr>
            		<td width='50%' align='center'>{$td_pagseguro}</td>
            		<td width='50%' align='center'>{$td_pagamento_digital}</td>
            	</tr>
            	</table>
            </td>	           	            	
        </tr>
        
        <!-- separador -->
        <tr>
            <td width="150" class="form_td_label" colspan='2'>
            	<hr color='#efefef' size='1'/>
            	<br />            	
            </td>            
        </tr>
        
         <!-- botao -->
         <tr>
            <td width="150" class="form_td_label">
            </td>
            <td>
            <input type="image" src="/imagens/pagar.jpg" value="Pagar" alt="Pagar" border="0" align="absbottom" style='border:0px' />
            </td>
        </tr>        
    </table>
    <!-- HIDDEN -->
    
    <!-- pagamento digital -->
	<input name="email_loja" type="hidden" value="{$email_loja}">
	<input name="produto_codigo_1" type="hidden" value="{$produto_codigo}">
	<input name="produto_descricao_1" type="hidden" value="{$produto_descricao}">
	<input name="produto_qtde_1" type="hidden" value="{$produto_qtde}">	
	<input name="tipo_integracao" type="hidden" value="{$tipo_integracao}">
	<input name="frete" type="hidden" value="{$produto_frete}">
	
    <!-- pagseguro -->
    <input type="hidden" name="email_cobranca" value="{$email_loja}" />	
	<input type="hidden" name="tipo" value="{$tipo}" />
	<input type="hidden" name="moeda" value="{$moeda}" />		
	<input type="hidden" id="item_id_1" name="item_id_1" value="{$produto_codigo}" />
	<input type="hidden" id="item_descr_1" name="item_descr_1" value="{$produto_descricao}" />
	<input type="hidden" id="item_quant_1" name="item_quant_1" value="{$produto_qtde}">	  	
	<!--<input type="hidden" id="item_valor_1" name="item_valor_1" value="10.00">-->	  	


	<!-- Dados do Cliente para Pagamento Digital -->
	<input name="email" type="hidden" value="{$email}" />
	<input name="nome" type="hidden" value="{$nome}" />
	<input name="cpf" type="hidden" value="{$cpf}" />
	<input name="telefone" type="hidden" value="{$telefone}" />
	<input name="endereco" type="hidden" value="{$endereco}" />
	<input name="complemento" type="hidden" value="{$complemento}" />
	<input name="bairro" type="hidden" value="{$bairro}" />
	<input name="cidade" type="hidden" value="{$cidade}" />
	<input name="estado" type="hidden" value="{$estado}" />
	<input name="numero" type="hidden" value="{$numero}" />
	<input name="cep" type="hidden" value="{$cep}" />
	<input name="rg" type="hidden" value="{$rg}" />
	<input name="sexo" type="hidden" value="M" />
	<input name="data_nascimento" type="hidden" value="{$data_nascimento}" />
	<input name="free" type="hidden" value="{$free}" />
	<input name="redirect" type="hidden" value="true" />
	<input name="url_retorno" type="hidden" value="{$url_retorno}" />
	
	<!-- Dados do Cliente para Pagseguro -->
	<input name="cpf_cnpj" type="hidden" readonly="True" id="cpf_cnpj" value="{$cpf}"/>
	<input type="hidden" name="cliente_nome" value="{$nome}" />	
	<input type="hidden" name="cliente_tel" value="{$cliente_telefone}" />
	<input type="hidden" name="cliente_ddd" value="{$cliente_ddd}" />	
	<input type="hidden" name="cliente_end" value="{$cliente_endereco}" />
	<input type="hidden" name="cliente_num" value="{$cliente_numero}" />
	<input type="hidden" name="cliente_compl" value="{$complemento}" />
	<input type="hidden" name="cliente_bairro" value="{$bairro}" />
	<input type="hidden" name="cliente_cep" value="{$cep}" />
	<input type="hidden" name="cliente_cidade" value="{$cidade}" />
    <input type="hidden" name="cliente_uf" value="{$estado}" />
    <input type="hidden" name="cliente_pais" value="{$cliente_pais}" />
    <input type="hidden" name="cliente_email" value="{$email}" />

</form> 
<br>
<!--<iframe src="https://www.pagamentodigital.com.br/sistema/selo_reputacao.php?chave_primeira=46868&chave_segunda=318953&chave_terceira=184x120" width="184" height="120" scrolling="no" frameborder="0" marginheight="0" marginwidth="0"></iframe>-->
{$js}
</body>
