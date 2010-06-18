<?php
class Plugin_UmParaMuitos extends Sistema_Plugin 
{
    
	private $_chaveFK = null;
	private $_classUPM = null;
	private $_formUPM = null;
	
    public function formataInsercao($valor)   {
    	return $valor;
        //return sprintf("%d",$valor);
    }
    
    
    public function setUmParaMuitos($classe,$chaveFK,$formUPM){
    	$this->_classUPM = new $classe();
    	$this->_chaveFK = $chaveFK;
    	$this->_formUPM = $formUPM;
    }
    
	/**
	 * Cria um campo texto
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {
    	
		$form = new Componente_Formulario($this->_classUPM,$this->_formUPM);
		# Pega os dados do formulario
		$dados = $form->getCampos();
		
		$tam = count($dados) + 1;
		
		$lista = sprintf('<table width="500">
						  <tr>
						  	<th width="112" style="border-bottom:1px solid #000000">Idioma</th>
						  	<th width="214" style="border-bottom:1px solid #000000">Descrição</th>
						  	<th width="97" style="border-bottom:1px solid #000000">Remover</th>
						  </tr>
						    <tr>
						  	<td style="border-bottom:1px solid #ccc">Ingl&ecirc;s</th>
						  	<td style="border-bottom:1px solid #ccc">Group</th>
						  	<td style="border-bottom:1px solid #ccc"><div align="center"><b style="color:#FF0000">X</b>
						  	  </th>
							  </div>  	</tr>
						    <tr>
						      <td style="border-bottom:1px solid #ccc">Portugu&ecirc;s    
						      <td style="border-bottom:1px solid #ccc">Grupo    
						      <td style="border-bottom:1px solid #ccc"><div align="center"><b style="color:#FF0000">X</b>
						          </th>    
						      </div>
						    </tr>
						    <tr>
						      <td style="border-bottom:1px solid #ccc">Espanhol    
						      <td style="border-bottom:1px solid #ccc">Grupo    
						      <td style="border-bottom:1px solid #ccc"><div align="center"><b style="color:#FF0000">X</b>
						          </th>    
						      </div>
						    </tr>
						  </table>');
		
		
		$dados[$tam]['label'] = "Listagem";
		$dados[$tam]['input'] = $lista;
		
		return $dados;		

    }
    
    
    
    public function valida($legenda,$valor) 
    {
		
		if (is_numeric($valor)) {
			return TRUE;
		} else {
			return "O campo \"".$legenda."\" não é válida";
		}
    }     
    
}

?>