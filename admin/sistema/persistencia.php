<?php
/**
 * @abstract Classe responsavel por fazer a persistencia
 * no bando de dados.
 *
 * @copyright  -
 * @version    1.0
 * @author     -
 * @since      10/03/2009
 */
class Sistema_Persistencia {

	/**
	 * @abstract Variavel contendo o nome da classe referente a tabela
	 * @var String
	 */
	protected $_classe = null;

	/**
	 * @abstract Variavel contendo o nome da tabela
	 * @var String
	 */
	protected $_tabela = null;

	/**
	 * @abstract Vertor contendo os campos da tabela
	 * e informações sobre eles.
	 * @example
	 * 			$array = array(campo=>array(label,plugin,tamanho,requerido,valor_padrao));
	 * @var array
	 */
	protected $_campos = array();

	/**
	 * @abstract valor da chave primaria
	 * @var integer
	 */
	private $_codigo = null;

	/**
	 * @abstract chave primaria
	 * @var string
	 */
	protected $_chavepk = null;

	/**
	 * @abstract Campo descritor da classe
	 * @var string
	 */
	protected $_descritor = null;

	/**
	 * @abstract Vetor com os dados a serem alterados/incluidos
	 * @var array
	 */
	private $_dados = array();

	/**
	 * @abstract Vetor com os dados para campos estrangeiros
	 * @var array
	 */
	protected $_estrangeiros = array();

	/**
	 * @abstract Objeto do Sistema_Menssagem
	 * @var Sistema_Mensagem
	 */
	protected $_msg = null;

	/**
	 * @abstract Vetor contendo os formulários especificos
	 * @var array
	 */
	protected $_formulario = array();

	/**
	 * @abstract Vetor contendo os campos que tem valores
	 * unicos na tabela
	 * @var array
	 */
	protected $_unicos = array();

	/**
	 * @abstract Objeto do Sistema_Login
	 * @var Sistema_Login
	 */
	protected $_login = null;

	/**
	 * @abstract Vetor com as tabelas de 1-N
	 * @var Array
	 */
	protected $_umparamuitos = null;

	/**
	 * Construtor da classe
	 * @return Sistema_Persistencia
	 */
	public function __construct($codigo=0){
		$this->_codigo = $codigo;
		$this->_msg = Sistema_Mensagem::instanciar();
		$this->_login = Sistema_Login::instanciar();
	}

	/**
	 * @abstract Retorna o vetor com os campos
	 * @return array
	 */
	public function getCampos(){
		return $this->_campos;
	}

	/**
	 * @abstract Retorna o codigo PK para busca
	 * @return integer
	 */
	public function getCodigo(){
		return $this->_codigo;
	}

	/**
	 * @abstract Seta os dados para alteracao ou inclusao
	 * @example
	 * 			$dados[campo]=valor;
	 * @param $dados
	 */
	public function setDados($dados){
		if(is_array($dados)){
			foreach($dados as $campo=>$valor){
				# verifica se o campos pertence a tabela
				if(array_key_exists($campo,$this->_campos)){

					# Cria o plugin para formatar a inserçao
					$plugin = sprintf("Plugin_".ucwords(strtolower($this->_campos[$campo][1])));
					$p = new $plugin();
					if (is_subclass_of($p,'Sistema_Plugin')) {

						# Verifica se o campo é unico
						if(in_array($campo,$this->_unicos)){

							# Faz a busca no banco para verificar se ja tem
							# o valor salvo em algum registro que não seja
							# o mesmo da chave primaria
							$vlrpk = sprintf("%d",$dados[$this->_chavepk]);
							$sql = sprintf("SELECT %s FROM %s WHERE %s=%s AND %s!=%d LIMIT 0,1",
							$this->_chavepk,$this->_tabela,$campo,$p->formataInsercao($valor),$this->_chavepk,$vlrpk);
							$cod = Sistema_Conecta::getOne($sql);

							if($cod > 0){
								$this->_msg->setErro("O valor do campo <u>".$this->_campos[$campo][0]."</u> ja está cadastrado. Escolha outro");
								$this->_msg->setCampoErro($campo);
							}
						}


						# Instacia a classe do campo
						$p->setClasse($this->_classe);
						# Verifica pode ser vazio
						# -----------------------
						$vazio = $p->verificaVazio($this->_campos[$campo][0],$valor,$this->_campos[$campo][3]);
						if($vazio == FALSE){
							# Verifica se o valor é valido
							# -----------------------
							$valida = $p->valida($this->_campos[$campo][0],$valor);
							if($valida === TRUE){
								$this->_dados[$campo] = $p->formataInsercao($valor);
							}else{
								$this->_msg->setErro($valida);
								$this->_msg->setCampoErro($campo);
							}
							# -----------------------
						}else{
							$this->_msg->setErro($vazio);
							$this->_msg->setCampoErro($campo);
						}
					}
				}
			}
		}
	}

	/**
	 * @abstract Retorna os dados de uma chave primaria
	 * @return array
	 */
	public function getDados(){
		# Retorna os campos
		$cmp = array_keys($this->_campos);
		$campos = implode(",",$cmp);
		# Monta a SQL
		$sql = sprintf("SELECT %s FROM %s WHERE %s=%d",
		$campos,$this->_tabela,$this->_chavepk,$this->getCodigo());

		$rs = Sistema_Conecta::Execute($sql);
		if(count($rs) > 0){
			foreach($rs as $k=>$vet){
				foreach($vet as $campo=>$valor){
					if(array_key_exists($campo,$this->_campos)){
						# Cria o plugin para formatar a inserçao
						$plugin = sprintf("Plugin_".ucwords(strtolower($this->_campos[$campo][1])));
						$p = new $plugin();
						if (is_subclass_of($p,'Sistema_Plugin')) {
							# Instacia a classe do campo
							$p->setClasse($this->_classe);
							$this->_dados[$campo] = $p->formataExibicao($valor);
						}
					}else{
						$this->_dados[$campo] = $valor;
					}
				}
			}
			return $this->_dados;
		}
		return null;
	}

	/**
	 * @abstract Metodo que fara a persistencia no banco
	 */
	public function salvar($grava_historico = true){


		# Verifica se tem acesso a salvar
		//if($this->_login->temPermissao($_GET[ACAO],Sistema_Login::SALVAR)){
				
			$temp = $this->_dados;
			# Verifica se utiliza chave
			# incremental pelo sistema
			if(isset($_POST['acaoform'])){
				$alterar = ($_POST['acaoform'] == "alterar") ? true : false;
			}else{
				$alterar = ($this->_dados[$this->_chavepk]>0) ? true : false;
				unset($temp[$this->_chavepk]);
			}
				
			if(!$this->_msg->temErro()){
				# Verifica se tem valor para chave primaria
				# UPDATE
				if($alterar){
						
					unset($temp[$this->_chavepk]);
					foreach($temp as $k=>$v){
						$sets[] = sprintf(" %s = %s ",$k,$v);
					}
					$set = implode(",",$sets);
					$sql = sprintf("UPDATE %s SET %s WHERE %s=%d",$this->_tabela,$set,$this->_chavepk,$this->_dados[$this->_chavepk]);
						
					$id = Sistema_Conecta::Execute($sql);
					if($id > 0){
						if($grava_historico){
							# Grava no Histórico
							$hist = new Sistema_Historico($_SESSION['ACT_ATUAL']);
							$hist->setHistorico(Sistema_Historico::$OP_ALTERAR,$this->_dados[$this->_chavepk],$this->_tabela);
						}

						$this->_msg->setSucesso("Dados alterados com sucesso");
						return array("id"=>array("campoid"=>$this->_chavepk,"valorid"=>$this->_dados[$this->_chavepk]));
					}else{
						$this->_msg->setErro("Não foi possível alterar os dados");
						return null;
					}
				}else{
					# INSERT

					
					$temp1 = array_keys($temp);
					$campos = implode(",",$temp1);
					$valores = implode(",",$temp);
						
					$sql = sprintf("INSERT INTO %s (%s) VALUES (%s)",$this->_tabela,$campos,$valores);
					
					$id = Sistema_Conecta::Execute($sql);
					if($id > 0){
						if($grava_historico){
							# Grava no Histórico
							$hist = new Sistema_Historico($_SESSION['ACT_ATUAL']);
							$hist->setHistorico(Sistema_Historico::$OP_INSERIR,$id,$this->_tabela);
						}

						$this->_msg->setSucesso("Dados inseridos com sucesso");
						return array("id"=>array("campoid"=>$this->_chavepk,"valorid"=>$id));
					}else{
						
						$this->_msg->setErro("Não foi possível inserir os dados");
						return null;
					}
				}
			}
		//}else{
			//$this->_msg->setErro("Você não tem permissão para alterar ou inserir neste formulário");
		//}
	}

	/**
	 * @abstract Método dinâmico para get e set
	 * @param $nome
	 * @param $valor
	 * @return mixed
	 */
	public function __call($nome,$valor){
		$nome = strtolower($nome);
		$prefixo     = substr($nome, 0, 3);
		if($prefixo == "set"){
			$var = str_replace("set","_",$nome);
			$this->$var = $valor[0];
		}else if($prefixo == "get"){
			$var = str_replace("get","_",$nome);
			return $this->$var;
		}else{
			$this->_msg->setErro('Método da Persistência '.$nome.'() inválido.');
		}

	}

	public function getFormulario($form){
		if(array_key_exists($form, $this->_formulario)){
			return $this->_formulario[$form];
		}else{
			foreach ($this->_campos as $campo=>$vet){
				$cmp[]=$campo;
			}
			return $cmp;
		}
		return array();
	}


}
?>