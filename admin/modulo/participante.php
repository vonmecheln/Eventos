<?php
/**
 * @abstract M�dulo referente as a��es para os cadastros
 * e ger�nciamento de participantes
 *
 * @copyright  -
 * @version    1.0
 * @author     Luis Henrique Manosso Von Mecheln
 * @since      06/07/2010
 */
class Modulo_Participante extends Sistema_Modulo{

	protected $_modulo = "participante";

	public function acaoListarParticipante(){

		$lista = new Componente_Listagem('lista_participante');
		$sql = "
		SELECT
			u.usr_cod,
			u.usr_nome,
			p.tpp_desc,
			s.stt_nome
		FROM 
			usuario u
		INNER JOIN participante p ON
			p.usr_cod = u.usr_cod
		LEFT JOIN comprovante c ON 
			c.usr_cod = u.usr_cod
		LEFT JOIN status s ON 
			s.stt_cod = u.stt_cod
		";
		$lista->setSQL($sql);

		$lista->setColuna("usr_cod","C�digo","5%");
		$lista->setColuna("usr_nome","Nome");
		$lista->setColuna("tpp_desc","Institui��o");
		$lista->setColuna("stt_nome","Status");

		$lista->setTabelaCampo(array("usr_cod"=>"usuario","usr_nome"=>"usuario","grp_nome"=>"grupo","status"=>"stt_nome"));
		
		# N�o ir� listar o usuario desenvolvedor
		$lista->setWhere(" u.grp_cod != ".DESENVOLVEDOR." AND u.stt_cod != 2");

		$lista->setNomeParametro("usr_cod");
		$lista->setBotaoModuloAcao("Alterar",'usuarios',"formusuario",Componente_Listagem::$_IMG_ALTERAR);
		
		# Cria o bot�o para novo usu�rio
		$this->_layout->setBotoes("Novo Usu�rio/Participante",Sistema_Util::getURL("usuarios","formusuario"),"imagens/form.png");
		$this->_layout->setNomePagina("Listagem de Usu�rios");
		$this->_layout->setCorpo($lista->getForm());
	}
	

}
?>