<?php
/**
 * @abstract Modulo responsavel pela ações extras
 * dos usuários do sitema.
 * 
 * @copyright  -
 * @version    1.0
 * @author     Alexandre Semmer
 * @since      10/03/2009 
 * 
 */
class Modulo_Inscricao extends Sistema_Modulo{

	protected $_modulo = "inscricao";

	
	/**
	 * @abstract Ação que altera a senha vinda do formulario
	 * @return JSON
	 */	
	public function ajaxsalvarsenha(){
		
		
		$_POST = Sistema_Util::trataUTF8($_POST);
		
		// Grupo Participante
		$_POST['grp_cod'] = 3;
		// Status Ativo
		$_POST['stt_cod'] = 1;
		// Login igual ao email
		$_POST['usr_login'] = $_POST['usr_email'];
		
		$obj = new Classe_Usuario();
		$obj->setDados($_POST);
		$id = $obj->salvar();
		
		
		$dados['usr_cod']=$id['id']['valorid'];
		
		$sql = sprintf("SELECT tpp_cod FROM participante WHERE usr_cod=%d",$dados['usr_cod']);
		$tpp_cod = Sistema_Conecta::getOne($sql);
		if($tpp_cod > 0){
			$dados['tpp_cod']=$tpp_cod;
		}
		
		$dados['tpp_nome']=$_POST['tpp_nome'];
		$dados['tpp_desc']=$_POST['tpp_desc'];
		$dados['tpp_cracha']=$_POST['tpp_cracha'];
    $dados['tpp_trabalho1']=$_POST['tpp_trabalho1'];
    $dados['tpp_trabalho2']=$_POST['tpp_trabalho2'];
    $dados['tpp_trabalho3']=$_POST['tpp_trabalho3'];        

		$part = new Classe_Participante();
		$part->setDados($dados);
		$a = $part->salvar();
		
		$json = new Sistema_Ajax();
		$json->addVar("id",$dados['usr_cod']);
		$json->responde();
		return $dados['usr_cod'];
	}
	
	
	
}
?>
