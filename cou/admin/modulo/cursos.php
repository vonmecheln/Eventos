<?php
/**
 * @abstract Módulo referente as ações do desenvolvimento do sistema
 *
 * @copyright  -
 * @version    1.0
 * @author     Alexandre
 * @since      10/03/2009
 */
class Modulo_Cursos extends Sistema_Modulo{

	protected $_modulo = "cursos";

	/**
	 * Ação responsável pela criação do formulário
	 * para cadastros dos Módulos
	 * @return Form
	 */
	public function acaoFormCursos(){
		$mapa = new Classe_Cursos($_GET['crs_cod']);
		$form = new Componente_Formulario($mapa);

		$this->_layout->setBotoes("Listar Cursos",Sistema_Util::getURL($this->_modulo,"listarcursos"),"imagens/list.png");
		$this->_layout->setBotoes("Novo Curso",Sistema_Util::getURL($this->_modulo,"formcursos"),"imagens/form.png");
		$this->_layout->setNomePagina("Cursos");

		$this->_layout->setCorpo("<div class='mensagemalerta' style='padding: 10px; font-size: 12px;color:#666'>Separe o nome dos professores com ; (ponto e virgula). Caso exista mais de um.</div>");
		$this->_layout->setCorpo($form->getForm($this->_modulo,"salvarcursos"));
	}

	/**
	 * Ação responsável pela criação da listagem
	 * dos Módulos
	 * @return Listagem
	 */
	public function acaoListarCursos()
	{
		$sql = "
		SELECT 
			crs_titulo,
			crs_cod,
			crs_horas,
			crs_professor,
			crs_tipo
		FROM cursos ";

		$lista = new Componente_Listagem('listarcursos');
		$lista->setSQL($sql);

		$lista->setColuna("crs_cod","Código","5%");
		$lista->setColuna("crs_titulo","Curso");
		$lista->setColuna("crs_horas","Horas Totais");
		$lista->setColuna("crs_professor","Professor(es)");
		$lista->setColuna("crs_tipo","Tipo");


		$lista->setNomeParametro("crs_cod");

		$lista->setBotaoModuloAcao("Gerenciar Curso",$this->_modulo,"formcursos",Componente_Listagem::$_IMG_ALTERAR);

		$this->_layout->setBotoes("Novo Curso",Sistema_Util::getURL($this->_modulo,"formcursos"),"imagens/form.png");
		$this->_layout->setNomePagina("Listagem de Cursos");
		$this->_layout->setCorpo($lista->getForm());
	}



	/**
	 * Ação responsável para salvar os dados vindos
	 * do formulário
	 * @return JSON
	 */
	public function ajaxSalvarCursos(){
		$obj = new Classe_Cursos();
		$obj->setDados($_POST);
		$id = $obj->salvar();
		$json = new Sistema_Ajax();
		$json->addVar($id);
		$json->responde();
	}

	/**
	 * Ação responsável pela criação do formulário
	 * para cadastros dos Módulos
	 * @return Form
	 */
	public function acaoFormEntradas(){


		$mapa = new Classe_EntradaCursos();
		$form = new Componente_Formulario($mapa,"form1");
		$this->_layout->setNomePagina("Entrada de Alunos");
		//$this->_layout->setCorpo($form->getForm($this->_modulo,"salvarentradas"));

		$tela = new Sistema_Layout_Tela("templates/formulario.tpl");
		$tela->addVar("campos",$form->getCampos());
		//$tela->addVar("dadoshidden",$this->_hidden);

		$modulo = MODULO."=".$this->_modulo;
		$acao   = ACAO."="."salvarentradas";

		$formulario = sprintf('<form id="frment" onSubmit="formulario.entrada(\'frment\',\'%s\',\'%s\'); return false;">
								%s
							</form>
							%s',$modulo,$acao,$tela->getTela(),$formUPM);		
		$this->_layout->setCorpo($formulario);	
	}

	/**
	 * Ação responsável para salvar os dados vindos
	 * do formulário
	 * @return JSON
	 */
	public function ajaxSalvarEntradas(){
		
		
		
		
		# Verifica se o aluno existe
		$tmp = Sistema_Conecta::Execute("SELECT usr_cod,usr_nome FROM usuario WHERE usr_cod=".$_POST['usr_cod'],PDO::FETCH_ASSOC);
		$usr_cod = $tmp[0]['usr_cod'];
		$usr_nome = $tmp[0]['usr_nome'];
		if($usr_cod>0){
			
			# Verifica se o aluno ja foi dado entrada
			$totalentradas = Sistema_Conecta::getOne("SELECT count(1) FROM entrada_cursos WHERE usr_cod=".$usr_cod." AND crs_cod=".$_POST['crs_cod']);
			if($totalentradas > 1){
				$msg = Sistema_Mensagem::instanciar();
				$msg->setAlerta("Participante com o código <u>".$usr_cod."-".$usr_nome."</u> já <span sytle='color:red'>SAIU</span deste curso");
			}else{
				$obj = new Classe_EntradaCursos();
				$obj->setDados($_POST);
				$id = $obj->salvar();
				if($id>0){
					$msg = Sistema_Mensagem::instanciar();
					$msg->limparMensagem();
					if($totalentradas ==  0){
						$msg->setSucesso("Participante <u>".$usr_cod."-".$usr_nome."</u> deu <span sytle='color:blue'>ENTRADA</span> ao curso");
					}else{
						$msg->setSucesso("Participante <u>".$usr_cod."-".$usr_nome."</u> <span sytle='color:red'>SAIU</span> do curso");
					}
				}
			}
		}else{
			$msg = Sistema_Mensagem::instanciar();
			$msg->setAlerta("Participante com o código ".$_POST['usr_cod']." não cadastrado");
		}
		$json = new Sistema_Ajax();
		//$json->addVar($id);
		$json->responde();
	}


	/**
	 * Ação responsável pela criação da listagem
	 * dos Módulos
	 * @return Listagem
	 */
	public function acaoListarParticipantesCursos()
	{
		$sql = "
		SELECT
			etcr_cod, 
			crs_titulo,
			usr_nome,
			DATE_FORMAT(etcr_data ,'%H:%I:%s - %d/%m/%Y') AS etcr_data
		FROM entrada_cursos	
		INNER JOIN  cursos ON cursos.crs_cod = entrada_cursos.crs_cod
		INNER JOIN usuario ON usuario.usr_cod=entrada_cursos.usr_cod";

		$lista = new Componente_Listagem('listarcursos');
		$lista->setSQL($sql);

		$lista->setColuna("etcr_cod","Código","5%");
		$lista->setColuna("crs_titulo","Curso");
		$lista->setColuna("usr_nome","Participante");
		$lista->setColuna("etcr_data","Data");


		$lista->setNomeParametro("etcr_cod");

		$this->_layout->includeJavaScript(SISTEMA_URL."modulo/cursos/javascript/funcoes.js");
		
		$lista->setBotaoJavascript("Cancelar","fcursos.cancelaPerticipante",Componente_Listagem::$_IMG_CANCELAR);
		
		

		//$this->_layout->setBotoes("Novo Curso",Sistema_Util::getURL($this->_modulo,"formcursos"),"imagens/form.png");
		$this->_layout->setNomePagina("Listagem Participantes dos Cursos");
		$this->_layout->setCorpo($lista->getForm());
	}
	
	public function ajaxCancelarEntrada(){
		if($_POST['cod'] > 0){
			$del = sprintf("DELETE FROM entrada_cursos WHERE etcr_cod = %d",$_POST['cod']);
			if(Sistema_Conecta::Execute($del)){
				echo "ok";
			}else{
				echo "err";
			}
		}
		
		
	}
}
?>