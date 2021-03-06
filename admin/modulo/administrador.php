<?php
/**
 * @abstract M�dulo referente as a��es do desenvolvimento do sistema
 * 
 * @copyright  -
 * @version    1.0
 * @author     Alexandre
 * @since      10/03/2009
 */
class Modulo_Administrador extends Sistema_Modulo{
	
	protected $_modulo = "administrador";

	/**
	 * A��o respons�vel pela cria��o do formul�rio
	 * para cadastros dos M�dulos
	 * @return Form
	 */
	public function acaoFormModulo(){
		$mapa = new Classe_Modulo($_GET['mdl_cod']);
		$form = new Componente_Formulario($mapa);

		$this->_layout->setBotoes("Novo M�dulo",Sistema_Util::getURL($this->_modulo,"formmodulo"),"imagens/form.png");
		$this->_layout->setBotoes("Listar M�dulo",Sistema_Util::getURL($this->_modulo,"listarmodulo"),"imagens/list.png");
		$this->_layout->setNomePagina($this->_leng['formmodulo']);
		$this->_layout->setCorpo($form->getForm($this->_modulo,"salvarmodulo"));
	}

	/**
	 * A��o respons�vel pela cria��o da listagem
	 * dos M�dulos
	 * @return Listagem
	 */
	public function acaoListarModulo(){
		$sql = "SELECT mdl_cod,mdl_nome,mdl_titulo FROM modulo";
		
		$lista = new Componente_Listagem('listmodulo');
		$lista->setSQL($sql);
		$lista->setColuna("mdl_cod","C�digo","5%");
		$lista->setColuna("mdl_nome","Nome");
		$lista->setColuna("mdl_titulo","Titulo");
		$lista->setNomeParametro("mdl_cod");
		$lista->setBotaoModuloAcao("Alterar",$this->_modulo,"formmodulo",Componente_Listagem::$_IMG_ALTERAR);
		
		$this->_layout->setBotoes("Novo M�dulo",Sistema_Util::getURL($this->_modulo,"formmodulo"),"imagens/form.png");
		$this->_layout->setNomePagina($this->_leng['listarmodulo']);
		$this->_layout->setCorpo($lista->getForm());
	}

	/**
	 * A��o respons�vel para salvar os dados vindos
	 * do formul�rio
	 * @return JSON
	 */
	public function ajaxSalvarModulo(){
		$obj = new Classe_Modulo();
		$obj->setDados($_POST);
		$id = $obj->salvar();
		$json = new Sistema_Ajax();
		$json->addVar($id);
		$json->responde();
	}	
	
	/**
	 * A��o respons�vel pela cria��o do formul�rio
	 * para cadastros das A��es
	 * @return Form
	 */
	public function acaoFormAcao(){
		$mapa = new Classe_Acao($_GET['acao_cod']);
		$form = new Componente_Formulario($mapa);
		
		$this->_layout->setBotoes("Nova A��o",Sistema_Util::getURL($this->_modulo,"formacao"),"imagens/form.png");
		$this->_layout->setBotoes("Listar A��es",Sistema_Util::getURL($this->_modulo,"listaracao"),"imagens/list.png");		
		
		$this->_layout->setNomePagina("Cadastrar A��es");
		$this->_layout->setCorpo($form->getForm($this->_modulo,"salvaracao"));
	}

	/**
	 * A��o respons�vel para salvar os dados vindos
	 * do formul�rio
	 * @return JSON
	 */	
	public function ajaxSalvarAcao(){
		$obj = new Classe_Acao();
		$obj->setDados($_POST);
		$id = $obj->salvar();
		$json = new Sistema_Ajax();
		$json->addVar($id);
		$json->responde();
	}	
	
	/**
	 * A��o respons�vel pela cria��o da listagem
	 * das A��es
	 * @return Listagem
	 */	
	public function acaoListarAcao(){
		$lista = new Componente_Listagem('listacao');
		$sql = "SELECT acao_cod,acao_nome,acao_titulo,
					   mdl_titulo,acao_ordem 
				FROM acao 
				INNER JOIN modulo ON modulo.mdl_cod = acao.mdl_cod";
		$lista->setSQL($sql);
		$lista->setColuna("acao_cod","C�digo","5%");
		$lista->setColuna("acao_nome","Nome");
		$lista->setColuna("acao_titulo","Titulo");
		$lista->setColuna("mdl_titulo","M�dulo");
		$lista->setColuna("acao_ordem","Ordem","10%");
		$lista->setNomeParametro("acao_cod");
		$lista->setBotaoModuloAcao("Alterar",$this->_modulo,"formacao",Componente_Listagem::$_IMG_ALTERAR);
		
		$this->_layout->setBotoes("Nova A��o",Sistema_Util::getURL($this->_modulo,"formacao"),"imagens/form.png");
		$this->_layout->setNomePagina("Listar A��es");
		$this->_layout->setCorpo($lista->getForm());
	}	
	
	/**
	 * A��o respons�vel pela cria��o do formul�rio
	 * para cadastros dos Menus
	 * @return Form
	 */
	public function acaoFormMenu(){
		$menu = new Classe_Menu($_GET['mnu_cod']);
		$form = new Componente_Formulario($menu);

		$this->_layout->setBotoes("Novo Menu",Sistema_Util::getURL($this->_modulo,"formmenu"),"imagens/form.png");
		$this->_layout->setBotoes("Listar Menus",Sistema_Util::getURL($this->_modulo,"listarmenu"),"imagens/list.png");			
		
		$this->_layout->setNomePagina("Cadastrar Menu");
		$this->_layout->setCorpo($form->getForm($this->_modulo,"salvarmenu"));
	}

	/**
	 * A��o respons�vel pela cria��o da listagem
	 * dos menus
	 * @return Listagem
	 */	
	public function acaoListarMenu(){
		$lista = new Componente_Listagem('listmenu');
		$sql = "SELECT mnu_cod,mnu_nome FROM menu";
		$lista->setSQL($sql);
		$lista->setColuna("mnu_cod","C�digo","5%");
		$lista->setColuna("mnu_nome","Nome");
		$lista->setNomeParametro("mnu_cod");
		$lista->setBotaoModuloAcao("Alterar",$this->_modulo,"formmenu",Componente_Listagem::$_IMG_ALTERAR);
		
		$this->_layout->setBotoes("Novo Menu",Sistema_Util::getURL($this->_modulo,"formmenu"),"imagens/form.png");
		$this->_layout->setNomePagina("Listagem de Menus");
		$this->_layout->setCorpo($lista->getForm());
	}

	/**
	 * A��o respons�vel para salvar os dados vindos
	 * do formul�rio
	 * @return JSON
	 */	
	public function ajaxSalvarMenu(){
		$obj = new Classe_Menu();
		$obj->setDados($_POST);
		$id = $obj->salvar();
		$json = new Sistema_Ajax();
		$json->addVar($id);
		$json->responde();
	}	
	
	
	
	
	/**
	 * A��o para testes
	 * @return String
	 */	
	public function acaoTeste(){
		
		//$teste = sha1(123);
		
		
		$mapa = new Classe_GrupoOp();
		$form = new Componente_Formulario($mapa);
		$this->_layout->setNomePagina("Teste");
		$this->_layout->setCorpo($form->getForm($this->_modulo,"salvarmodulo"));
		
		//$this->_layout->setNomePagina("Testes");
		//$this->_layout->setCorpo($teste);
	}	
	
	
	
	
}
?>