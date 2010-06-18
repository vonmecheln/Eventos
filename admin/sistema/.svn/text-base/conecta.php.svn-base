<?php
/**
 * @abstract Estabelece conexão com o banco de dados
 *
 * @copyright  -
 * @version    1.0
 * @author     -
 * @since      10/03/2009
 */

class Sistema_Conecta {
	/**
	 * @abstract Variavel que irá conter o
	 * objeto SingleTon da classe Controle
	 * @var Sistema_Conecta
	 */
	static private $_instancia = null;

	/**
	 * @abstract Instancia do Objeto
	 * @var Sistema_Conecta
	 */
	public $conexao = null;

	/**
	 *	__construct()
	 *
	 *	Impossibilita a criação de uma nova classe
	 *
	 */
	private function __construct()
	{
		$usuario  = USUARIO;
		$senha    = PSWORD;
		$servidor = LOCALHOST;
		$base     = BASE;
		
		$dsn   = 'mysql:host='.$servidor.';dbname='.$base;

		try {
			$db = new PDO($dsn, $usuario, $senha,$param );
		} catch (PDOException $e) {
			die('<b>Erro na conexão:</b> ' . $e->getMessage());
		}
		$db->query('SET NAMES LATIN1');
		
		$this->conexao = $db;
	}

	public static function getConexao()
	{
		if (!self::$_instancia instanceof self) {
			self::$_instancia = new self();
		}
		$conn = self::$_instancia;
		return $conn->conexao;
	}

	/**
	 * @abstract Função responsável por executar todas
	 * as SQL do sistema, ela fará o tratamento de execessoes
	 *
	 * @param string Sql que será executada
	 * @param array PDO.. tipo de retorno
	 * PDO::FETCH_OBJ: retorna um objeto
	 * PDO::FETCH_BOTH: retorna como indice um numero e a chave
	 * PDO::FETCH_ASSOC: retorna como indice a chave
	 * */
	public static function Execute($sql,$PDO=false)
	{
		$con = self::getConexao();

		# Verifica se é uma SELECT
		$temp = strpos(strtoupper('X'.$sql),"SELECT");
		$pers = $con->prepare($sql);

		if($temp == true){
			try{
				$resultado  = $con->query($sql);

				# verifica se tem algum erro
				$erros = $con->errorInfo();
				if($erros[0] != 0){
					$mensagem = sprintf("Erro ao executar a SQL <br/> <i style='color:red'>%s</i><br/> <b>MENSAGEM DO BANCO :</b> %s",$sql, $erros[2]);
					throw new Sistema_Excessoes($erros[2],4);
				} else {
					if(!$PDO){
						return $resultado->fetchAll();
					}else{
						return $resultado->fetchAll($PDO);
					}
				}
			} catch(Sistema_Excessoes $e){
				$msg = Sistema_Mensagem::instanciar();
				$msg->setErro($e);
			}
		}else{
			$con->beginTransaction();
			$pers->execute();

			$erros = $pers->errorInfo();
			if($erros[0] != 0){
				$con->rollBack();
				$mensagem = sprintf("Erro ao executar a SQL <br/> <i style='color:red'>%s</i><br/> <b>MENSAGEM DO BANCO :</b><br> %s",$sql, $erros[2]);
				//throw new Sistema_Excessoes($erros[2],4);
				$msg = Sistema_Mensagem::instanciar();
				$msg->setErro($mensagem);
			} else {
				$resultado = true;
				if(strpos(strtoupper('X'.$sql),"INSERT") == true){
					$resultado = $con->lastInsertId();
				}
				$con->commit();

				return $resultado;
			}
		}
	}

	/**
	 * @abstract Retorna somente um valor
	 * @param $sql
	 * @return String
	 */
	public static function getOne($sql)
	{
		$con = self::getConexao();

		$con->beginTransaction();
		$rs = $con->query($sql);
		$erros = $con->errorInfo();
		if($erros[0] != 0){
			$con->rollBack();
			$mensagem = sprintf("Erro ao executar a SQL <br/> <i style='color:red'>%s</i><br/> <b>MENSAGEM DO BANCO :</b> %s",$sql, $erros[2]);
			throw new Sistema_Excessoes($erros[2],4);
		}
		$row = $rs->fetch();
		$con->commit();
		return $row[0];
	}
}
?>