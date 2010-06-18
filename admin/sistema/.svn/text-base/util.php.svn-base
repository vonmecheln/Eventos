<?php
/**
 * @abstract Classe contendo funcionalidades uteis para
 * utilização no desenvolvimento
 * 
 * @copyright  -
 * @version    1.0
 * @author     Alexandre M. Semmer
 * @since      25/03/2009
 */
class Sistema_Util {
	
	
	public static function data($data,$t="/"){
		$data_nova=split($t,$data);
   		return $data_nova[2] .$t. $data_nova[1] .$t. $data_nova[0];
	}
	
   /**
     * char2html
     *
     * @abstract converte todos os caracteres especiais para seus correspondentes em HTML
     *
     * */
    function char2html($str,$espaco = 0) {

        $caractere = Array('"','&','<','>','©','®','TM','´','«','»','¡','¿','À','à','Á','á','Â','â','Ã','ã','Ä','ä','Å','å','Æ','æ','Ç','ç','Ð','ð','È','è','É','é','Ê','ê','Ë','ë','Ì','ì','Í','í','Î','î','Ï','ï','Ñ','ñ','Ò','ò','Ó','ó','Ô','ô','Õ','õ','Ö','ö','Ø','ø','Ù','ù','Ú','ú','Û','û','Ü','ü','Ý','ý','ÿ','Þ','þ','ß','§','¶','µ','¦','±','·','¨','¸','ª','º','¬','­','¯','°','¹','²','³','¼','½','¾','×','÷','¢','£','¤','¥');

        $htmlentidade = Array('&quot;','&amp;','&lt;','&gt;','&copy;','<sup>&reg;</sup>','<font size="-1"><sup>TM</sup></font>','&acute;','&laquo;','&raquo;','&iexcl;','&iquest;','&Agrave;','&agrave;','&Aacute;','&aacute;','&Acirc;','&acirc;','&Atilde;','&atilde;','&Auml;','&auml;','&Aring;','&aring;','&AElig;','&aelig;','&Ccedil;','&ccedil;','&ETH;','&eth;','&Egrave;','&egrave;','&Eacute;','&eacute;','&Ecirc;','&ecirc;','&Euml;','&euml;','&Igrave;','&igrave;','&Iacute;','&iacute;','&Icirc;','&icirc;','&Iuml;','&iuml;','&Ntilde;','&ntilde;','&Ograve;','&ograve;','&Oacute;','&oacute;','&Ocirc;','&ocirc;','&Otilde;','&otilde;','&Ouml;','&ouml;','&Oslash;','&oslash;','&Ugrave;','&ugrave;','&Uacute;','&uacute;','&Ucirc;','&ucirc;','&Uuml;','&uuml;','&Yacute;','&yacute;','&yuml;','&THORN;','&thorn;','&szlig;','&sect;','&para;','&micro;','&b&nbsp;rvbar;','&plusmn;','&middot;','&uml;','&cedil;','&ordf;','&ordm;','&not;','&shy;','&macr;','&deg;','&sup1;','&sup2;','&sup3;','&frac14;','&frac12;','&frac34;','&times;','&divide;','&cent;','&pound;','&curren;','&yen;');

        $remonta = "";

        $remonta = str_replace($caractere,$htmlentidade,$str);
        if($espaco != 0) $remonta = str_replace(' ','&nbsp;',$remonta);

        return $remonta;
    }


	/**
	 * @abstract Trava os dados vindo do ajax
	 * @param $post
	 * @return Array
	 */
	public static function trataUTF8($post){
		if(is_array($post)){
			foreach($post as $k=>$v){
				if(is_array($v)){
					$r = $this->trataUTF8($v);
				}
				$r[$k] = utf8_decode($v);	
			}
		}
		return $r;
	}  
/**
	 * Remover os acentos de uma string
	 *
	 * @param string $str
	 * @return string
	 */
	public static function removerAcento($str){
	  $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç';
	  $to   = 'AAAAEEIOOOUUCaaaaeeiooouuc';
	
	  return strtr($str, $from, $to);
	}
	
	/**
	 * 
	 */
    /**
     * uppercaseOtimizado
     * 
     * @abstract Converte uma string em maiúsculos corrigindo o problema dos
     * acentos que não são cobertos pelo strtoupper não faz.
     * 
     * @return String em maiúsculo
     * */
    public static function uppercaseOtimizado($valor){
        
        $valor = str_replace("ç","Ç",$valor);
    	$valor = str_replace("ã","Ã",$valor);
    	$valor = str_replace("à","À",$valor);
    	$valor = str_replace("â","Â",$valor);
    	$valor = str_replace("á","Á",$valor);
    	$valor = str_replace("é","É",$valor);
    	$valor = str_replace("ê","Ê",$valor);
    	$valor = str_replace("í","Í",$valor);
    	$valor = str_replace("õ","Õ",$valor);
    	$valor = str_replace("ô","Ô",$valor);
    	$valor = str_replace("ó","Ó",$valor);    
    	$valor = str_replace("ú","Ú",$valor);
    	$valor = str_replace("ü","Ü",$valor);

    	return strtoupper($valor);
    }

    /**
     * @abstract Retorna a url padrão para chamar
     * um modulo e acção
     * @param $modulo
     * @param $acao
     * @return string
     */
    public static function getURL($modulo,$acao){
    	return sprintf("%s?%s=%s&%s=%s",SISTEMA_INDEX,MODULO,$modulo,ACAO,$acao);
    }
	
}
?>