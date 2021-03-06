<?php
/**
 * @abstract Plugin para tratar e v�lidar os dados
 * referentes ao campo Hidden
 * 
 * @author Alexandre
 * @since 19-03-2009
 *
 */
class Plugin_Hidden extends Sistema_Plugin{

    /**
	 * @abstract M�todo para formatar os dados para inser��o no banco
	 * @param string $valor Valor a ser inserido
	 * @return string $valor Valor a ser retornado
	 */
    public function formataInsercao($valor){
        return sprintf("'%s'",$valor);
    }
    
    /**
	 * @abstract Cria o campo hidden
	 * @param String $nome_campo Nome do campo
	 * @param Integer $tamanho Tamanho do campo
	 * @param String $valor_campo Valor incial do campo
	 * @return String $retorno Campo input formatado
	 */
	public function criaCampo($nome_campo,$tamanho = 100,$valor_campo = null) {
        $retorno = sprintf("<input type='hidden' name='%s' id='%s' value='%s' />",$nome_campo,$nome_campo,$valor_campo);
        return $retorno;
    }
}
?>