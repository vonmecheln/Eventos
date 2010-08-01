<?php
session_start();
/**
 * @abstract Classe que trata as funções de login do sistema.
 *
 * @copyright  -
 * @version    1.0
 * @author     -
 * @since      10/03/2009
 */
class Sistema_Login{

	/**
	 * Constantes para tipo de acesso
	 * @var String
	 */
	const SALVAR  = 'salvar';
	const EXIBIR  = 'exibir';
	const REMOVER = 'remover';

	/**
	 * @abstract Variavel que irá conter o
	 * objeto SingleTon da classe Login
	 * @var Sistema_Login
	 */
	static private $_instancia = null;

	/**
	 * @abstract  Vetor que Armazena os dados
	 * de Login do Usuário Logado
	 * @var Array
	 */
	private $_dadosLogin = null;

	/**
	 * @abstract Construtor impossibilita a instancia
	 * da classe, somente se for utilizado o metodo
	 * statico instanciar
	 * @return Sistema_Login
	 */
	private function __construct(){
		if(isset($_SESSION['login'])){
			$this->_dadosLogin = $_SESSION['login'];
		}
	}

	/**
	 * @abstract Fornece o objeto SingleTon da classe
	 * @return Sistema_Login
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
	 * @abstract Verifica se a sessão `login` está setada.
	 * @return Boolean
	 */
	public function usuarioLogado()	{
		if(!isset($_SESSION['login'])) {
			return false;
		} else {
			return true;
		}
	}


	/**
	 * @abstract Verica se o usuário tem permissão ao acesso
	 * de uma determinada ação
	 * @param $acao
	 * @param $tipo
	 * @return Boolean
	 */
	public function temPermissao($acao,$tipo=null){
		$acao = strtolower($acao);

		# Se não foi passado o tipo
		# Verifica se tem somente acesso a acao
		if(is_array($_SESSION['permissoes'])){
			if(is_null($tipo)){

				return (array_key_exists($acao,$_SESSION['permissoes']));
			}else{
				if(array_key_exists($acao,$_SESSION['permissoes'])){
					return (in_array($tipo,$_SESSION['permissoes'][$acao]));
				}else{
					return false;
				}
			}
		}else{
			return false;
		}
		

	}

	
	public function recuperar($email){
		# Retira os espaços extras se houver
		$email = trim($email);
		$email = str_replace("'","",$email);
		# Cria nova senhaUtiliza a criptografia sha1
		$nova  = date("his").rand(1,99);
		//$senha = sha1($nova);
		# Monta a SQL
		$sql = sprintf("SELECT usr_cod FROM usuario WHERE usr_email='%s' ",$email);
		$usr_cod = Sistema_Conecta::getOne($sql);
		if($usr_cod > 0){
			$usr = new Classe_Usuario();
			$usr->setDados(array("usr_cod"=>$usr_cod,"usr_senha"=>$nova));
			if($usr->salvar()){
			
			$subject = EVENTO . 'RECUPERAÇÃO DE SENHA';
			$mensagem = "<b>E-mail:</b> ".$email."<br/>";
			$mensagem .= "<b>Nova Senha:</b> ".$nova."<br/>";
			$mensagem .= "Acesse <a href='".SISTEMA_URL."index.php?p=login'> LOGIN </a> e altere sua senha<br/>";


			/* Configuração do PHP MAILER -----------------------------*/
			$emailCou = EMAIL."@yahoo.com.br";
			$nomeCou = EVENTO;

			require "phpmailer/class.phpmailer.php";
			$mail = new PHPMailer();
			$mail->IsHTML(true); // envio como HTML se 'true'
			$mail->WordWrap = 50; // Definição de quebra de linha
			$mail->IsSMTP(); // send via SMTP
			$mail->SMTPAuth = true; // 'true' para autenticação
			$mail->Mailer = "smtp"; //Usando protocolo SMTP
			$mail->Host = "smtp.mail.yahoo.com"; //seu servidor SMTP
			$mail->Username = EMAIL;
			$mail->Password = EMAIL_SENHA; // senha de SMTP
			$mail->From = $emailCou;
			$mail->FromName = $nomeCou;

			// caso queira que o reply seja enviado para outro lugar
			//$mail->AddReplyTo($email,$nome);

			$mail->AddAddress($email,$nome);
			$mail->Body = $mensagem;
			$mail->Subject = $subject;

			if(!$mail->Send()){
			   return '<div class="clean-error">Erro ao enviar a mensagem</div><br/>';
			} else {
			   return "<div class='mensagemalerta' style='padding:10px;font-size:14px' >Sua nova senha foi enviada para o e-mail <b>".$email."</b> </div>" ;
			}
			
				
			}
		}else{
			return "<div class='mensagemerro' style='padding:10px;font-size:14px' >E-mail <u>".$email."</u> não foi encontrado </div>";
		}
		
						
						
	}
	
	/**
	 * @abstract Método que executa o login do sistema
	 * @param $login
	 * @param $senha
	 * @return Boolean
	 */
	public function logar($login,$senha){
		# Retira os espaços extras se houver
		$login = trim($login);
		$senha = trim($senha);
		# retira as aspas ' para previnir SQLInject
		$login = str_replace("'","",$login);
		# Utiliza a criptografia sha1
		$senha = sha1($senha);
		# Monta a SQL
		$sql = sprintf("SELECT
							usuario.usr_cod,
							usuario.usr_nome,
							usuario.usr_login,
							usuario.usr_email,
							usuario.usr_senha,
							usuario.stt_cod,
							grupo.grp_cod,
							grupo.grp_nome,
							tpp_cod
						FROM usuario 
						  LEFT JOIN participante p ON
                p.usr_cod = usuario.usr_cod
						INNER JOIN grupo ON grupo.grp_cod = usuario.grp_cod
						WHERE 
							usuario.usr_login='%s' 
							AND usuario.usr_senha='%s'",$login,$senha);

		# Executa a SQL
		$rs = Sistema_Conecta::Execute($sql);

		# Verifica se encontrou algum registro
		if(count($rs)>0){
			# Mosta os dados na sessão
			$_SESSION['login']['codigo']	 = $rs[0]['usr_cod'];
			$_SESSION['login']['login'] 	 = $rs[0]['usr_login'];
			$_SESSION['login']['nome'] 		 = $rs[0]['usr_nome'];
			$_SESSION['login']['grupo_cod']	 = $rs[0]['grp_cod'];
			$_SESSION['login']['grupo'] 	 = $rs[0]['grp_nome'];
			$_SESSION['login']['status'] 	 = $rs[0]['stt_cod'];
			$_SESSION['login']['tpp_cod'] 	 = $rs[0]['tpp_cod'];

			# Carrega as permissões
			$this->carregaPermissoes();
			# Carrega o menu
			$this->carregaMenu();
			return true;
		}
		return false;
	}

	/**
	 * @abstract Monta na sessao as permissoes do grupo do usuario
	 */
	private function carregaPermissoes(){
		
		$_SESSION['permissoes'] = null;
		unset($_SESSION['permissoes']);
		
		
		# Verifica se é desenvolvedor
		if(DESENVOLVEDOR == $_SESSION['login']['grupo_cod']){
			# Terá acesso total ao sistema
			$sql = sprintf("SELECT
							 acao.acao_cod,
							 acao.acao_nome
						FROM acao");
			$rs = Sistema_Conecta::Execute($sql);
			

			
			if(count($rs)>0){
				# Percorre todas as permissoes
				foreach($rs as $k=>$vet){
					# Joga na sessao os dados
					$_SESSION['permissoes'][strtolower($vet['acao_nome'])] =  array("salvar","exibir","remover");
				}
			}
		}else{
			
			$sql = sprintf("SELECT
							 permissoes.prm_salvar,
							 permissoes.prm_exibir,
							 permissoes.prm_inativa,
							 acao.acao_cod,
							 acao.acao_nome
						FROM permissoes 
						INNER JOIN acao ON acao.acao_cod = permissoes.acao_cod
						WHERE permissoes.grp_cod = %d",$_SESSION['login']['grupo_cod']);
			$rs = Sistema_Conecta::Execute($sql);

			

			
			if(count($rs)>0){
				# Percorre todas as permissoes
				foreach($rs as $k=>$vet){
					$tipo_acao = array();
					$tipo_acao[] = ($vet['prm_salvar'] > 0)  ? "salvar" : "";
					$tipo_acao[] = ($vet['prm_exibir'] > 0 )  ? "exibir" : "";
					$tipo_acao[] = ($vet['prm_inativa'] > 0)  ? "remover" : "";
					# Joga na sessao os dados
					# $_SESSION['permissoes']['formcliente'] = array("salvar","exibir");
					$_SESSION['permissoes'][strtolower($vet['acao_nome'])] = $tipo_acao;
					unset($tipo_acao);
				}
			}

			
		}


	}

	/**
	 * @abstract Monta na sessao o menu visivel para o usuario
	 */
	private function carregaMenu(){
		$sql = "SELECT
					modulo.mdl_nome,
					modulo.mdl_titulo,
					acao.acao_nome,
					acao.acao_titulo,
					acao.acao_separador,
					menu.mnu_nome
				FROM menu
				INNER JOIN modulo ON modulo.mnu_cod = menu.mnu_cod
				INNER JOIN acao ON acao.mdl_cod = modulo.mdl_cod
				WHERE acao.acao_ordem != 0
				ORDER BY menu.mnu_ordem,modulo.mdl_ordem,acao.acao_ordem";
		$rs = Sistema_Conecta::Execute($sql);
		# Percorre todos os modulos
		foreach($rs as $k=>$v){
			# Verifica se tem permissao para a acao
			# total ou exibicao
			if($this->temPermissao($v['acao_nome'],self::EXIBIR)){
				$link = sprintf("%s?%s=%s&%s=%s",SISTEMA_INDEX,MODULO,$v['mdl_nome'],ACAO,$v['acao_nome']);
				$classcss = "";
				$menu[$v['mnu_nome']][$v['mdl_titulo']][] = array("link"=>$link,"nome"=>$v['acao_titulo'],"css"=>$classcss,"separador"=>(bool)$v['acao_separador']);
			}
			
			
		}
		$_SESSION['menu'] = serialize($menu);
	}
	
	/**
	  * getNome
	  * 
	  * @abstract retorna o nome do usuário que está logado
	  */
	public static function getNome()
	{
		return $_SESSION['login']['nome'];
	}
	
	/**
	  * getCodigo
	  * 
	  * @abstract retorna o codigo do usuário logado
	  */
	public static function getCodigo()
	{
		return $_SESSION['login']['codigo'];
	}
	
}
?>
