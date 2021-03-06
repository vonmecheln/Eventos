<?php
/**
 * @abstract M�dulo referente as a��es para os cadastros
 * e ger�nciamento de usuarios, grupos e permiss�s ao
 * sistema
 *
 * @copyright  -
 * @version    1.0
 * @author     Alexandre Semmer
 * @since      10/03/2009
 */
class Modulo_Usuarios extends Sistema_Modulo{

	protected $_modulo = "usuarios";


	/**
	 * @abstract A��o que monta o formul�rio de cadastro/altera��o
	 * dos usu�rios do sistema
	 * @return String
	 */
	public function acaoFormUsuario(){

		$objeto = new Classe_Usuario($_GET['usr_cod']);
		$form = new Componente_Formulario($objeto);

		$this->_layout->setNomePagina("Cadastrar Usu�rio");
		# Cria o bot�o para novo usu�rio
		$this->_layout->setBotoes("Novo Usu�rio",Sistema_Util::getURL("usuarios","formusuario"),"imagens/form.png");
		# Cria o bot�o para listar usu�rios
		$this->_layout->setBotoes("Listar Usu�rios",Sistema_Util::getURL("usuarios","listarusuarios"),"imagens/list.png");
		$this->_layout->setCorpo($form->getForm($this->_modulo,"salvarusuarios"));
	}

	/**
	 * @abstract A��o que lista os usu�rios cadastros no sistema
	 * @return Strig
	 */
	public function acaoListarUsuarios(){

		$lista = new Componente_Listagem('listusuarios');
		$sql = "SELECT
						usuario.usr_cod,
						usuario.usr_nome,
						participante.tpp_desc,
						grupo.grp_nome,
						status.stt_nome
				FROM usuario
				LEFT JOIN comprovante ON comprovante.usr_cod = usuario.usr_cod
				LEFT JOIN participante ON participante.usr_cod = usuario.usr_cod
				LEFT JOIN status ON  status.stt_cod = comprovante.stt_cod
				INNER JOIN grupo ON grupo.grp_cod = usuario.grp_cod
				";
		$lista->setSQL($sql);

		$lista->setColuna("usr_cod","C�digo","5%");
		$lista->setColuna("usr_nome","Nome");
		$lista->setColuna("tpp_desc","Institui��o");
		$lista->setColuna("grp_nome","Grupo");
		$lista->setColuna("stt_nome","Status");

		$lista->setTabelaCampo(array("usr_cod"=>"usuario","usr_nome"=>"usuario","grp_nome"=>"grupo","status"=>"stt_nome"));
		
		# N�o ir� listar o usuario desenvolvedor
		$lista->setWhere(" usuario.grp_cod != ".DESENVOLVEDOR." AND usuario.stt_cod != 2");

		$lista->setNomeParametro("usr_cod");
		$lista->setBotaoModuloAcao("Alterar",$this->_modulo,"formusuario",Componente_Listagem::$_IMG_ALTERAR);
		$lista->setBotaoModuloAcao("Comprovante",$this->_modulo,"comprovante","imagens/comprovante.png");

		
		# Cria o bot�o para novo usu�rio
		$this->_layout->setBotoes("Novo Usu�rio",Sistema_Util::getURL("usuarios","formusuario"),"imagens/form.png");
		$this->_layout->setNomePagina("Listagem de Usu�rios");
		$this->_layout->setCorpo($lista->getForm());
	}

	public function acaocomprovante(){
	
		$sql = sprintf("SELECT * FROM comprovante WHERE usr_cod=%d",$_GET['usr_cod']);
		$rs = Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);
		$rs = $rs[0];
	
		$sql = sprintf("SELECT tpp_nome,usr_nome 
						FROM participante 
						INNER JOIN usuario ON usuario.usr_cod = participante.usr_cod
						WHERE participante.usr_cod=%d",$_GET['usr_cod']);
		$rt = Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);
		$rt = $rt[0];
		
		
		$msg = sprintf("Participante <b>%s</b> � um(a) <b>%s</b>",$rt['usr_nome'],$rt['tpp_nome']);
		
		
		
		$objeto = new Classe_Comprovante($rs['cmp_cod']);
		$form = new Componente_Formulario($objeto,"form1");
		$frm = $form->getCampos();

		
		$this->_layout->setNomePagina("Comprovante do Usu�rio");
		# Cria o bot�o para listar usu�rios
		$this->_layout->setBotoes("Listar Usu�rios",Sistema_Util::getURL("usuarios","listarusuarios"),"imagens/list.png");
		
		
		$this->_layout->setCorpo("<div class='mensagemalerta' style='padding: 10px; font-size: 12px;color:#666'>".$msg."</div>");		
		$this->_layout->setCorpo($form->getForm($this->_modulo,"salvarcomprovante"));
	
	}
	
	
	public function ajaxsalvarcomprovante(){
		$obj = new Classe_Comprovante();
		$obj->setDados($_POST);
		$id = $obj->salvar();
		$json = new Sistema_Ajax();
		$json->addVar($id);
		$json->responde();
	}
	
	/**
	 * @abstract A��o responsavel por salvar as informa��es
	 * vindas do formul�rio
	 * @return JSON
	 */
	public function ajaxSalvarUsuarios(){
		$obj = new Classe_Usuario();
		$obj->setDados($_POST);
		$id = $obj->salvar();
		$json = new Sistema_Ajax();
		$json->addVar($id);
		$json->responde();
	}

	/**
	 * @abstract A��o que monta o formul�rio de cadastro/altera��o
	 * dos grupos de usu�rios do sistema
	 * @return String
	 */
	public function acaoFormGrupo(){
		$objeto = new Classe_Grupo($_GET['grp_cod']);
		$form = new Componente_Formulario($objeto);
		
		$this->_layout->setNomePagina("Cadastro de Grupos");
		# Cria o bot�o para novo usu�rio
		$this->_layout->setBotoes("Novo Grupo",Sistema_Util::getURL("usuarios","formgrupo"),"imagens/form.png");
		# Cria o bot�o para listar usu�rios
		$this->_layout->setBotoes("Listar Grupos",Sistema_Util::getURL("usuarios","listargrupos"),"imagens/list.png");
		$this->_layout->setCorpo($form->getForm($this->_modulo,"salvargrupo"));
	}

	/**
	 * @abstract A��o que lista os grupos cadastros no sistema
	 * @return Strig
	 */
	public function acaoListarGrupos(){
		$lista = new Componente_Listagem('listgrupos');
		$sql = "SELECT grp_cod,grp_nome
				FROM grupo";
		$lista->setSQL($sql);
		$lista->setColuna("grp_cod","C�digo","5%");
		$lista->setColuna("grp_nome","Grupo");

		# N�o lista o grupo do desenvolvedor
		$lista->setWhere(" grupo.grp_cod != ".DESENVOLVEDOR);

		$lista->setNomeParametro("grp_cod");
		$lista->setBotaoModuloAcao("Alterar",$this->_modulo,"formgrupo",Componente_Listagem::$_IMG_ALTERAR);
		$lista->setBotaoModuloAcao("Permiss�es",$this->_modulo,"formpermissoes","imagens/permissoes.png");
		
		# Cria o bot�o para novo usu�rio
		$this->_layout->setBotoes("Novo Grupo",Sistema_Util::getURL("usuarios","formgrupo"),"imagens/form.png");
		$this->_layout->setNomePagina("Listagem de Grupos");
		$this->_layout->setCorpo($lista->getForm());
	}

	/**
	 * @abstract A��o responsavel por salvar as informa��es
	 * vindas do formul�rio
	 * @return JSON
	 */
	public function ajaxSalvarGrupo(){
		$obj = new Classe_Grupo();
		$obj->setDados($_POST);
		$id = $obj->salvar();
		$json = new Sistema_Ajax();
		$json->addVar($id);
		$json->responde();
	}

	/**
	 * @abstract A��o que monta o formul�rio com as
	 * permiss�es para o grupo
	 * @return String
	 */
	public function acaoformpermissoes(){
		$codigo = sprintf("%d",$_GET['grp_cod']);
		$per = new Modulo_Usuarios_Permissoes();
		
		# Pega e mostra o hist�rico se tiver
		$hist = new Sistema_Historico($_SESSION['ACT_ATUAL']);
		$jan = new Componente_Janela();
		$texto_hist = sprintf("<img src='%simagens/historico.png' align=absmiddle> Hist�rico",SISTEMA_URL);
		$act = $jan->getJanelaConteudo($hist->getHist�rico($codigo),$texto_hist);

		$this->_layout->setBotoes("Hist�rico","javascript:".$act,"imagens/historico.png");

		$this->_layout->setNomePagina("Ger�nciar Permiss�es");
		$this->_layout->setCorpo($per->getFormulario($codigo));
	}

	/**
	 * @abstract A��o responsavel por salvar as informa��es
	 * vindas do formul�rio
	 * @return JSON
	 */
	public function ajaxsalvarpermissao(){
		$per = new Modulo_Usuarios_Permissoes();
		$per->salvar($_POST);
		$json = new Sistema_Ajax();
		$json->responde();
	}

}
?>