<?php
class Plugin_Incremento extends Sistema_Plugin
{

	public function formataInsercao($valor)   {

		if($_POST['acaoform'] == "alterar"){
			return sprintf("%d",$valor);
		}else{
			if(is_string($this->_classe)){

				# Instancia a classe do objeto
				$obj = new $this->_classe();
				if(is_object($obj) && is_subclass_of($obj,'Sistema_Persistencia')){
					$sql = sprintf("SELECT MAX(%s) FROM %s ",$obj->getChavePK(),$obj->getTabela());
					$valor = Sistema_Conecta::getOne($sql) + 1;
				}
				
			}
			return sprintf("%d",$valor);
		}


		
	}

	/**
	 * Cria um campo texto
	 * @param String $nome_campo
	 * @return String
	 */
	public function criaCampo($nome_campo,$tamanho = 0,$valor_campo = null) {
			
			
			
		if(is_null($valor_campo) && is_string($this->_classe)){
			# Instancia a classe do objeto
			$obj = new $this->_classe();
			if(is_object($obj) && is_subclass_of($obj,'Sistema_Persistencia')){
				$sql = sprintf("SELECT MAX(%s) FROM %s ",$obj->getChavePK(),$obj->getTabela());
				$valor_campo = Sistema_Conecta::getOne($sql) + 1;
			}
			$acaoform = '<input type="hidden" name="acaoform" id="acaoform" value="inserir" />';
		}else{
			$valor_campo = $valor_campo;
			$acaoform = '<input type="hidden" name="acaoform" id="acaoform" value="alterar" />';
		}
			
		return sprintf('<input type="hidden"  name="%s" id="%s" value="%s" />%s%s',
		$nome_campo,$nome_campo,$valor_campo,$valor_campo,$acaoform);
	}

	public function valida($legenda,$valor)
	{

		if (is_numeric($valor)) {
			return TRUE;
		} else {
			return "O campo \"".$legenda."\" n�o � um C�digo v�lido";
		}
			

			

	}

}

?>