<?php
/**
 * @abstract Faz todo o controle dos pedidos de pсginas feitas
 * pelo sistema, validaчѕes de permissѕes e de dados.
 *
 * @copyright  -
 * @version    1.0
 * @author     -
 * @since      10/03/2009
 */
class Sistema_Controle{

	/**
	 * @abstract Variavel que irс conter o
	 * objeto SingleTon da classe Controle
	 * @var Sistema_Controle
	 */
	static private $_instancia = null;

	/**
	 * @abstract Variavel contendo o objeto
	 * da classe Login
	 * @var Sistema_Login
	 */
	private $_login;

	/**
	 * @abstract Variavel contendo o objeto
	 * da classe Mensagem
	 * @var Sistema_Mensagem
	 */
	private $_msg;

	/**
	 * @abstract Variavel contendo o caminho
	 * a partir da raiz do sistema
	 * @var String
	 */
	private $_diretorioSistema = '';

	/**
	 * @abstract Construtor impossibilita a instancia
	 * da classe, somente se for utilizado o metodo
	 * statico instanciar
	 * @return Sistema_Controle
	 */
	private function __construct(){
		# Instancia o objeto Login
		$this->_login = Sistema_Login::instanciar();
		# Verifica se esta logado
		if(!$this->_login->usuarioLogado()){
		
			if(strstr($_SERVER['HTTP_USER_AGENT'],'MSIE')){
				die("Para acessar a сrea administrativa use o Firefox");
			} else {
				# Chama a tela de login
				$l = Sistema_Layout::instanciar();
				$l->includeCSS(SISTEMA_URL."css/login.css");
				$l->includeJavaScript(SISTEMA_URL."javascript/formulario.js");
				$l->exibir('login.tpl');
				die();
			}
		}
		# Instancia a classe Mensagem
		$this->_msg = Sistema_Mensagem::instanciar();
		
	}

	/**
	 * @abstract Fornece o objeto SingleTon da classe
	 * @return Sistema_Controle
	 */
	public static function instanciar()	{
		# Verifica se a classe ja foi instanciada uma vez
		if (!self::$_instancia instanceof self) {
			# Instancia a classe
			self::$_instancia = new self();
		}
		# Retorna a instancia
		return self::$_instancia;
	}

	/**
	 * @abstract Mщtodo que executa uma funчуo para a pсgina
	 */
	public function executar(){
		
		# Recebe os parametros validados
		$parametros = $this->getParametros();

		# Monta os dados referente ao parametros
		if(!is_null($parametros)){
			$tipoJanela = $parametros[JANELA];
			$nomeModulo = $parametros[MODULO];
			$nomeMetodo = ucwords(strtolower($parametros[ACAO]));
			$metodoModulo = sprintf("acao%s",$nomeMetodo);
			$classModulo = $this->getClasseModulo($nomeModulo);
			# Verifica se tem permissao para a aчуo
			$this->temPermissao($nomeMetodo);					
		}else{
			# Os parametros sуo invсlidos 
			# Mostra a classe default
			$classModulo = new Sistema_Index();		
			$metodoModulo = "principal";	
		}
		

		
		# Retorno em ajax
		$ajax = false;
		# Verifica se mщtodo aчуo existe para a classe
		if (!method_exists($classModulo,$metodoModulo)) {
			$metodoModulo = sprintf("ajax%s",$nomeMetodo);
			# Verifica se existe o mщtodo ajax
			if(!method_exists($classModulo,$metodoModulo)){
				$this->_msg->setErro("Aчуo ".$nomeMetodo." щ invсlida");
			}else{
				# Trata os textos
				$_POST = $this->trataUTF8($_POST);
				$ajax = true;
			}
		}else{
			# Carrega os modulos e acoes da ultima requiziчao
			# Utilizado para o histѓrico
			$_SESSION['MOD_ATUAL']  = strtolower($parametros[MODULO]);
			$_SESSION['ACT_ATUAL'] = strtolower($parametros[ACAO]);
		}
		
		# Verifica se teve erros
		if($this->_msg->temErro()){
			return;
		}else{
			# Executa o Mщtodo
			$classModulo->$metodoModulo();
			# Se for ajax termina a sessуo
			if($ajax) die();
			# Se for para mostrar somenta na janela
			# retorna o conteudo
			if($tipoJanela == "true"){
				$l = Sistema_Layout::instanciar();
				$l->exibir("janela.tpl");
				die();
			}
		}

	}

	/**
	 * @abstract Trava os dados vindo do ajax
	 * @param $post
	 * @return Array
	 */
	private function trataUTF8($post){
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
	 * @abstract Vсlida e retorna os parametros
	 * @return Array
	 */
	private function getParametros(){

		# Retorna os dados dos tipos $_POST ou $_GET
		//$dados = (isset($_GET) && count($_GET) > 0) ? $_POST : $_GET;
		$dados = $_GET;
		# Verifica se existem os indices para os parametros
		# modulo
		if(!array_key_exists(MODULO,$dados)){
			return null;
		}
		# acao
		if(!array_key_exists(ACAO,$dados)){
			return null;
		}		

		return $dados;
	}

	/**
	 * @abstract Retorna a instancia do modulo
	 * @param $modulo
	 * @return Sistema_Modulo
	 */
	private function getClasseModulo($modulo){
		# Monta o nome da classe modulo
		# Modulo_Nome
		$classeNome = sprintf("Modulo_%s",ucfirst(strtolower($modulo)));
		# Instancia a classe
		$classe = new $classeNome();
		# Verifica se o modulo existe
		if (!is_subclass_of($classe,'Sistema_Modulo')) {
			$this->_msg->setErro("Mѓdulo ".$dados[MODULO]." nуo щ vсlido");
		}else{
			return $classe;
		}
	}
	
	/**
	 * @abstract Verifica se o usuario tem acesso a aчуo chamado
	 * @param $acao
	 */
	private function temPermissao($acao){
		# Verifica se tem aчуo total
		if($this->_login->temPermissao($acao)){
			return true;
		}else{
			$this->_msg->setErro("Vocъ nуo tem acesso a esta aчуo ");
		}
	}
	


}
?>