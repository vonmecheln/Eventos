<?php
class Plugin_Cidade extends Sistema_Plugin 
{
    
    public function formataInsercao($valor)   {
        return sprintf("%d",$valor);
    }
    
	/**
	 * Cria um campo texto
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {
    	
    	# Pega a cidade de cascavel por padrão
    	$valor_campo = ($valor_campo >  0) ? $valor_campo : 1155;
    	
    	$dados = array();
    	if($valor_campo > 0){
    		$sql = sprintf("SELECT cid_cod,cid_nome,est_cod FROM cidade WHERE cid_cod=%d",$valor_campo);
    		$dados = Sistema_Conecta::Execute($sql);
    		$dados = $dados[0];
    	}

    	
    	$estado = Sistema_Conecta::Execute("SELECT est_cod,est_nome FROM estado");
    	$cidade = Sistema_Conecta::Execute(sprintf("SELECT cid_cod,cid_nome FROM cidade WHERE est_cod='%s'",$dados['est_cod'])); 
    	
    	
    	
    	
    	 # Estado
    	 $options = "<option value='0'>Seleciona um Estado</option>";
    	 foreach($estado as $k=>$vet){
    	 	$sel = ($vet['est_cod'] == $dados['est_cod']) ? 	' selected="selected" ' : '';
    		$options .= sprintf('<option value="%s" %s >%s</option>',$vet['est_cod'],$sel,$vet['est_nome']);
    	 }
    	
    	 $select .= sprintf('<select name="est_cod" id="est_cod" onChange="formulario.getCidade(this.value);" style="width:200px">%s</select>
    	 					<div style="height:5px;"></div>',$options);
    	 unset($options);
    	 
         # Cidade
    	 foreach($cidade as $k=>$vet){
    	 	$sel = ($vet['cid_cod'] == $valor_campo) ? 	' selected="selected" ' : '';
    			$options .= sprintf('<option value="%d" %s >%s</option>',$vet['cid_cod'],$sel,$vet['cid_nome']);
    	 }    	 
    	 
    	 $select .= sprintf('<select name="cid_cod" id="cid_cod" style="width:200px" >%s</select>',$options);
    	
    	
    	return $select;
    }
    
    public function valida($legenda,$valor) 
    {
		
		if (is_numeric($valor)) {
			return TRUE;
		} else {
			return "O campo \"".$legenda."\" não é uma Cidade válida";
		}
    } 
    
}

?>