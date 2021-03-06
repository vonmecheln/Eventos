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
class Modulo_Programacao extends Sistema_Modulo{

	protected $_modulo = "programacao";

	/**
	 * @abstract A��o que monta o formul�rio para cadastrar/altera a instituicao
	 * @return Form
	 */
	public function acaoFormProgramacao(){
		$objeto = new Classe_Programacao($_GET['prg_cod']);
		$form = new Componente_Formulario($objeto);
		$l = Sistema_Layout::instanciar();
		
		$this->_layout->setBotoes("Nova Programa��o",Sistema_Util::getURL($this->_modulo,"formprogramacao"),"imagens/form.png");
		$this->_layout->setBotoes("Listar Programa��es",Sistema_Util::getURL($this->_modulo,"listarprogramacao"),"imagens/list.png");
		
		$l->setNomePagina("Programa��o");
		$l->setCorpo($form->getForm($this->_modulo,"salvarprogramacao"));
	}
	
	/**
	 * @abstract A��o que altera a senha vinda do formulario
	 * @return JSON
	 */	
	public function ajaxsalvarprogramacao(){
		$obj = new Classe_Programacao();
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
	public function acaolistarprogramacao(){
		$lista = new Componente_Listagem('listaprog');
		$sql = "SELECT
						prg_cod,
						DATE_FORMAT(prg_data, '%d/%m/%Y') as prg_data,
						prg_tema,
						prg_palestrante
				FROM programacao
				";
		$lista->setSQL($sql);
		$lista->setColuna("prg_cod","C�digo","5%");
		$lista->setColuna("prg_data","Data");
		$lista->setColuna("prg_tema","Tema");
		$lista->setColuna("prg_palestrante","Palestrante");

		$lista->setNomeParametro("prg_cod");
		$lista->setBotaoModuloAcao("Alterar",$this->_modulo,"formprogramacao",Componente_Listagem::$_IMG_ALTERAR);


		# Cria o bot�o para novo usu�rio
		$this->_layout->setBotoes("Nova Programa��o",Sistema_Util::getURL($this->_modulo,"formprogramacao"),"imagens/form.png");
		$this->_layout->setNomePagina("Listar Programa��es");
		$this->_layout->setCorpo($lista->getForm());
	}
	
	
	
}
?>