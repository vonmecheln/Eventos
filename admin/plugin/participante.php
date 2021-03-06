<?php
/**
 * Mostra o usuario que esta logado no sistema
 */
class Plugin_Participante extends Sistema_Plugin 
{
    public function formataInsercao($valor){
    	return $valor;
    }
    
	public function aux($valor)
	{
		$sql = "
		SELECT
			usr_nome
		FROM usuario 
		WHERE
			usr_cod = ".$valor;
		
		$nome = Sistema_Conecta::getOne($sql);

		return $nome;
    }    
    
	/**
	 * Cria um campo texto
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$tamanho = 255,$valor_campo = null) 
	{   
		$nome = $this->aux($valor_campo);
    	return sprintf('<input type="hidden" id="%s" name="%s" value="%d"/><i>%s</i>',$nome_campo,$nome_campo,$valor_campo,$nome);
    }
    
    
	public function valida($legenda,&$valor)
	{
		return true;
	}
}

?>