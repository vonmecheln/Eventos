<?php
/**
 * Sistema_Variavel
 *
 * @abstract Prover uma classe que abstraia algumas questѕes importantes
 * e perigosas que surgem durante o desenvolvimento de sistemas web.
 *
 * A primera questуo щ sobre variсveis, elas podem ser passadas por POST, GET e
 * por SESSION. Essa classe irс simplificar o acesso as mesmas atravщs do
 * mщtodo estсtico get.
 *
 * O segundo mщtodo desta classe fornece seguranчa contra injections URL/SQL
 *
 * @example Para receber a variсvel $_POST['cod']
 * Sistema_Variavel::get('cod');
 *
 * @author anselmo
 * @since 1 - 16/01/2008
 * */
class Sistema_Variavel
{

	/**
	 * get
	 *
	 * @abstract Retorna o valor de uma variсvel independente de onde
	 * ela esteja armazenada.
	 *
	 * @param string variavel Nome da variсvel que estс sendo procurada
	 * @param string local Local onde a variсvel estс armazenada, este parтmetro
	 * por padrуo щ null, porщm se existir duas variсveis com o mesmo nome
	 * mas em dois locais diferentes deve ser especificado o POST, GET ou SESSION
	 * */
	public static function get($variavel,$local=""){
		$msg = Sistema_Mensagem::instanciar();
		$valor = "";
		# acesso com o local sendo informado, usado apenas quando
		if($local){
			switch ($local) {
				case "GET":
					$valor = self::validaParametro($_GET[$variavel]);
					break;
				case "POST":
					$valor = self::validaParametro($_POST[$variavel]);
					break;
				case "SESSION":
					$valor = self::validaParametro($_SESSION[$variavel]);
					break;
				default:
					break;
			}
			return $valor;
		} else {
			$achouVariavel = 0;
			# щ post
			if(!$_POST[$variavel] === false){
				$achouVariavel++;
				$valor = $_POST[$variavel];
			}

			# щ get
			if(!$_GET[$variavel] === false){
				$achouVariavel++;
				$valor = $_GET[$variavel];
			}

			# щ session
			if(!$_SESSION[$variavel] === false){
				$achouVariavel++;
				$valor = $_SESSION[$variavel];
			}

			if($achouVariavel > 1){
				$msg->setErro("ERRO : var duplicated.");
			} else {
				return self::validaParametro($valor);
			}
		}
	}

	/**
	 * validaParametro
	 *
	 * @abstract Faz o tratamento de vetores com relaчуo a sql injection
	 *
	 * @param array vetor Vetor que serс verificado
	 * */
	public static function validaParametro($vetor){
		if(is_array($vetor)){
			foreach ($vetor as $chave => $valor){
				if (is_array($valor)){
					$vetor[$chave] = self::validaParametro($valor);
				} else {
					$vetor[$chave] = self::antiInjection($valor);
				}
			}
		} else {
			return self::antiInjection($vetor);
		}
		return $vetor;
	}

	/**
	 * antiInjection
	 *
	 * @abstract Verifica se existe algum tipo de URL ou SQL injection
	 * no valor que estс sendo analizado
	 *
	 * @param mix valor Valor que estс sendo analizado
	 * */
	public static function antiInjection($str){
		# Remove palavras suspeitas de injection.
		$str = preg_replace(sql_regcase("/(\n|\r|%0a|%0d|Content-Type:|bcc:|to:|cc:|Autoreply:|from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "", $str);
		$str = trim($str);        # Remove espaчos vazios.
		$str = strip_tags($str);  # Remove tags HTML e PHP.
		$str = addslashes($str);  # Adiciona barras invertidas р uma string.
		return $str;
	}
}
?>