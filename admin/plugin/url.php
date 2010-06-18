<?php
/**
 * @abstract Plugin para tratar e válidar os dados
 * referentes a URL
 * 
 * @author Alexandre
 * @since 19-03-2009
 *
 */
class Plugin_Url extends Sistema_Plugin{
    
	
	/**
	 * @abstract Método para formatar os dados para inserção no banco
	 * @param string $valor Valor a ser inserido
	 * @return string $valor Valor a ser retornado
	 */		
    public function formataInsercao($valor) {
        return strtolower($valor);
    }

    
	/**
	 * @abstract Método validar os dados inseridos no formuláro
	 * @param string $legenda Nome do campo no formulario
	 * @param string $valor Valor a ser passado pelo campo
	 */    
    public function valida($legenda,$valor){
    	
        $url_val      = $valor;
        $url_pattern  = "http\:\/\/[[:alnum:]\-\.]+(\.[[:alpha:]]{2,4})+";
		$url_pattern .= "(\/[\w\-]+)*"; // folders like /val_1/45/
		$url_pattern .= "((\/[\w\-\.]+\.[[:alnum:]]{2,4})?"; // filename like index.html
		$url_pattern .= "|"; // end with filename or ?
		$url_pattern .= "\/?)"; // trailing slash or not
		$error_count = 0;
		if (strpos($url_val, "?")) {
			$url_parts = explode("?", $url_val);
			if (!preg_match("/^".$url_pattern."$/", $url_parts[0])) {
				$error_count++;
			}
			if (!preg_match("/^(&?[\w\-]+=\w*)+$/", $url_parts[1])) {
				$error_count++;
			}
		} else {
			if (!preg_match("/^".$url_pattern."$/", $url_val)) {
				$error_count++;
			}
		}
		if ($error_count > 0) {
            return "O campo ".$legenda." não é uma URL válida";
		} else {
			return true;
		}
    }
    
    /**
	 * @abstract Cria o campo para URL
	 * @param String $nome_campo Nome do campo
	 * @param Integer $tamanho Tamanho do campo
	 * @param String $valor_campo Valor incial do campo
	 * @return String $retorno Campo input formatado
	 */
	public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {
		$retorno = sprintf("<input type='text' name='%s' id='%s' value='%s' size='150' maxlength='150' />",
							$nome_campo,$nome_campo,$valor_campo);
        return $retorno;
    }
}

?>