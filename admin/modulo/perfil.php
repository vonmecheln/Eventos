<?php
/**
 * @abstract Modulo responsavel pela a��es extras
 * dos usu�rios do sitema.
 * 
 * @copyright  -
 * @version    1.0
 * @author     Alexandre Semmer
 * @since      10/03/2009 
 * 
 */
class Modulo_Perfil extends Sistema_Modulo{

	protected $_modulo = "perfil";

	/**
	 * @abstract A��o que monta o formul�rio para altera��o
	 * da senha do usu�rio que est� logado
	 * @return Form
	 */
	public function acaoTrocarSenha(){
		$objeto = new Classe_Usuario();
		$form = new Componente_Formulario($objeto,'trocarsenha');

		$l = Sistema_Layout::instanciar();
		$l->setNomePagina("Trocar senha");
		$l->setCorpo($form->getForm($this->_modulo,"salvarsenha"));
	}
	
	/**
	 * @abstract A��o que altera a senha vinda do formulario
	 * @return JSON
	 */	
	public function ajaxsalvarsenha(){
		$obj = new Classe_Usuario();
		$_POST['usr_cod'] = $_SESSION['login']['codigo'];
		$obj->setDados($_POST);
		$id = $obj->salvar();
		$json = new Sistema_Ajax();
		$json->addVar($id);
		$json->responde();
	}
	
	/**
	 * @abstract A��o que lista as anota��es do sistema
	 * @return Strig
	 */	
	public function acaolistaranotacoes(){
		$lista = new Componente_Listagem('listanotacoes');
		$sql = "SELECT
						ant_cod,
						ant_titulo,
						date_format(ant_data, '%d/%m/%Y') AS ant_data,
						status.stt_nome 
				FROM anotacoes
				INNER JOIN status ON status.stt_cod = anotacoes.stt_cod";
		$lista->setSQL($sql);

		$lista->setWhere(" anotacoes.usr_cod = ".$_SESSION['login']['codigo']);
		$lista->setColuna("ant_cod","C�digo","5%");
		$lista->setColuna("ant_titulo","Titulo");
		$lista->setColuna("ant_data","Data");
		$lista->setColuna("stt_nome","Status");

		$lista->setNomeParametro("ant_cod");
		$lista->setBotaoModuloAcao("Alterar",$this->_modulo,"formanotacoes",Componente_Listagem::$_IMG_ALTERAR);


		# Cria o bot�o para novo usu�rio
		$this->_layout->setBotoes("Nova Anota��o",Sistema_Util::getURL($this->_modulo,"formanotacoes"),"imagens/form.png");
		$this->_layout->setNomePagina("Listar Anota��es");
		$this->_layout->setCorpo($lista->getForm());
	}
	
	
	/**
	 * @abstract A��o responsavel por salvar as informa��es
	 * vindas do formul�rio
	 * @return JSON
	 */
	public function ajaxsalvaranotacao(){
		$obj = new Classe_Anotacoes();
		$obj->setDados($_POST);
		$id = $obj->salvar();
		$json = new Sistema_Ajax();
		$json->addVar($id);
		$json->responde();
	}	
	
	/**
	 * @abstract A��o que monta o formul�rio de cadastro/altera��o
	 * das anota��es
	 * @return String
	 */
	public function acaoFormAnotacoes(){
		$objeto = new Classe_Anotacoes($_GET['ant_cod']);
		$form = new Componente_Formulario($objeto);
		
		$this->_layout->setNomePagina("Cadastrar Anota��es");
		$this->_layout->setBotoes("Nova Anota��o",Sistema_Util::getURL($this->_modulo,"formanotacoes"),"imagens/form.png");
		$this->_layout->setBotoes("Listar Anota��es",Sistema_Util::getURL($this->_modulo,"listaranotacoes"),"imagens/list.png");
		$this->_layout->setCorpo($form->getForm($this->_modulo,"salvaranotacao"));
	}

	public function ajaxCarregaAnotacao(){
		$objeto = new Classe_Anotacoes($_GET['ant_cod']);
		$dados = $objeto->getDados();
		$url = SISTEMA_INDEX ."?".MODULO."=perfil&".ACAO."=formanotacoes&ant_cod=".$_GET['ant_cod'];
		echo sprintf("<a href='%s' target='_parent' style='color:#000;text-decoration:none'>editar</a>",$url);
		echo "<hr>";
		echo sprintf("<i>%s</i><br>",$dados['ant_data']);
		echo sprintf("<b>%s</b><br>",$dados['ant_titulo']);
		echo nl2br($dados['ant_texto']);
		
		die();
	}
	
}
?>