<?php
/*
CREATE TABLE `spol`.`historico` (
`hist_cod` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`usr_cod` INT NOT NULL ,
`hist_tipo` VARCHAR( 100 ) NOT NULL ,
`hist_acao` VARCHAR( 100 ) NOT NULL ,
`hist_ip` VARCHAR( 25 ) NOT NULL ,
`hist_chave` INT NOT NULL ,
`hist_tabela` VARCHAR( 60 ) NOT NULL ,
`hist_data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = MYISAM 
 */

/**
 * @abstract Classe que faz o tratamento dinâmico 
 * das ações feitas no sistema, para que uma ação
 * entre no histórico esta classe deverá ser 
 * chamada. Ela irá persistir no banco sobre a 
 * tabela historico, gravando a ação executada,
 * o usuário que a fez, qual a tela, o registro
 * alterado/inserido e a data da ação.
 * 
 * historico
 * | hist_cod | usr_cod | hist_tipo | hist_acao | hist_data | hist_ip |	hist_chave | hist_tabela
 * 
 * 
 * @author Alexandre
 * @since 27/03/2009
 */
class Sistema_Historico {
	
	/**
	 * Tipos de ações executadas
	 * @var string
	 */
    public static $OP_INSERIR    = 'Inseriu';
    public static $OP_ALTERAR    = 'Alterou';
    public static $OP_EXCLUIR    = 'Excluiu';
	
	/**
	 * Tela acessada
	 * @var string
	 */
	private $_acao = null;
	
	/**
	 * Instancia da classe login
	 * @var Sistema_Login
	 */
	private $_login = null;
	
	/**
	 * Construtor recebe o nome da ação da tela
	 * @param $acao
	 */
	public function __construct($acao){
		$this->_acao = $acao;
		$this->_login = Sistema_Login::instanciar();
	}
	
	
	/**
	 * Seta uma entrada no histórico
	 * @param $tipo
	 * @param $chave
	 * @param $tabela
	 */
	public function setHistorico($tipo,$chave,$tabela){
		# pega o IP
		$ip = $_SERVER["REMOTE_ADDR"];
		# pega a data
		# Data eh gravada direto pelo banco no formato TIMESTAMP
		
		# pega a acao da tela
		$acao = $this->_acao;
		# Codigo do usuario
		$usr_cod = $_SESSION['login']['codigo'];
		# Monta a SQL
		$ins = sprintf("INSERT INTO historico 
						(hist_ip,hist_acao,usr_cod,hist_tipo,hist_chave,hist_tabela)
						VALUES
						('%s','%s','%s','%s','%s','%s')",
						$ip,$acao,$usr_cod,$tipo,$chave,$tabela);
		# Executa a inserção				
		if(!Sistema_Conecta::Execute($ins)){
			$msg = Sistema_Mensagem::instanciar();
			$msg->setErro("Não foi possível gravar o histórico para a ação ".$acao);
		}
	}
	
	/**
	 * Retorna o histórico referente a ação e ao código
	 * @param $chave
	 * @return String
	 */
	public function getHistórico($chave){
		$sql = sprintf("SELECT 
							historico.hist_data,
							historico.hist_tipo,
							usuario.usr_nome	
					   FROM historico
					   INNER JOIN usuario ON usuario.usr_cod = historico.usr_cod
					   WHERE
					   historico.hist_chave=%d AND historico.hist_acao='%s'
					   ORDER BY historico.hist_cod DESC",$chave,$this->_acao);
		$rs = Sistema_Conecta::Execute($sql);
		if(count($rs) > 0){
			foreach($rs as $k=>$v){
				$data = date("d/m/Y \á\s H:i:s",strtotime($v['hist_data']));
				//$data = $v['hist_data'];
				$tipo = ucfirst(strtolower($v['hist_tipo']));
				$linha[trim($v['usr_nome'])][] = sprintf(" %s em %s.",$tipo,$data);
			}
			# Monta o resultado
			foreach($linha as $usr=>$vtxt){
				$rt .= sprintf("<b>%s</b><br>",$usr);
				foreach($vtxt as $txt){
					$rt .= sprintf("%s <br>",$txt);
				}
			}
			return $rt;
		}else{
			return "<h3> Nenhum histórico para está ação </h3>";
		}
	}
}
?>