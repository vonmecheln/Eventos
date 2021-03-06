<?php

class Plugin_Simnao2 extends Sistema_Plugin 
{
    public $aspas     = true;
    public $tipoCampo = "radio";
    public $valores   = array('sim' => 'Sim',
							  'n�o' => 'N�o');
    
    public function formataInsercao($valor) 
    {

        if (($valor == 'sim') || ($valor == 't') || ($valor == 1)) {
            return 't';
        } else {
            return 'f';
        }
    }

    public function valida($legenda,$valor) 
    {    	
		if (($valor=="sim") || ($valor =="n�o") || ($valor == 't') || ($valor == true ) || ($valor == 'f') || ($valor == false)) {
			return true;
		} else {
			return "O campo ".$legenda." n�o contem um valor v�lido";
		}
    }

    public function formataExibicao($valor)
    {
        if (($valor == 't') || ($valor == 'sim') || ($valor=='true')) {
            return 'sim';
        } else 
        if (($valor == 'f') || ($valor == 'n�o') || ($valor=='false')) {
            return 'n�o';
        }
    }    
    
	/**
	 * Cria o Campo SELECT para escolha do Sexo
	 *
	 * Recebe como par�metro o nome do campo que ser� utilizado nos par�metros
	 * name e id
	 * 
	 * @param String $nome_campo
	 * @return String
	 */
    public function criaCampo($nome_campo,$valor_campo = null,$label,$id_campo)
    {
        $retorno = "";    

        $retorno .= "
            <label for='".$id_campo."' id='label_".$id_campo."'>
                <input id='".$id_campo."' type='radio' name='".$nome_campo."' value='".$valor_campo."' ".$selsim." /><span id='span_".$id_campo."'>".$label."</span>
            </label>
        ";       

        return $retorno;
    }
}
?>