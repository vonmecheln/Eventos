<?php
/**
 * @abstract Modulo responsavel pela gerancia das institui��es participantes
 * 
 * @copyright  -
 * @version    1.0
 * @author     Alexandre Semmer
 * @since      10/03/2009 
 * 
 */
class Modulo_Instituicao extends Sistema_Modulo{

	protected $_modulo = "instituicao";

	/**
	 * @abstract A��o que monta o formul�rio para cadastrar/altera a instituicao
	 * @return Form
	 */
	public function acaoFormInstituicao(){
		$objeto = new Classe_Instituicao($_GET['inst_cod']);
		$form = new Componente_Formulario($objeto);
		$l = Sistema_Layout::instanciar();
		
		$this->_layout->setBotoes("Nova Institui��o",Sistema_Util::getURL($this->_modulo,"forminstituicao"),"imagens/form.png");
		$this->_layout->setBotoes("Listar Institui��es",Sistema_Util::getURL($this->_modulo,"listarinstituicoes"),"imagens/list.png");
		
		$l->setNomePagina("Institui��o participante");
		$l->setCorpo($form->getForm($this->_modulo,"salvarinstituicao"));
	}
	
	/**
	 * @abstract A��o que altera a senha vinda do formulario
	 * @return JSON
	 */	
	public function ajaxsalvarinstituicao(){
		$obj = new Classe_Instituicao();
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
	public function acaolistarinstituicoes(){
		$lista = new Componente_Listagem('listainstitu');
		$sql = "SELECT
						inst_cod,
						inst_nome,
						inst_contato,
						inst_telefone
				FROM instituicao
				";
		$lista->setSQL($sql);
		$lista->setColuna("inst_cod","C�digo","5%");
		$lista->setColuna("inst_nome","Nome");
		$lista->setColuna("inst_contato","Contato");
		$lista->setColuna("inst_telefone","Telefone");

		$lista->setNomeParametro("inst_cod");
		$lista->setBotaoModuloAcao("Alterar",$this->_modulo,"forminstituicao",Componente_Listagem::$_IMG_ALTERAR);


		# Cria o bot�o para novo usu�rio
		$this->_layout->setBotoes("Nova Institui��o",Sistema_Util::getURL($this->_modulo,"forminstituicao"),"imagens/form.png");
		$this->_layout->setNomePagina("Listar Institui��es");
		$this->_layout->setCorpo($lista->getForm());
	}
	
	
	
}
?>