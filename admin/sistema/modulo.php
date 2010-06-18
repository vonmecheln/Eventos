<?php
/**
 * @abstract Classe principal para os modulos do 
 * sistema, ela instancia automaticamente o
 * Sistema_Mensagem e o Sistema_Layout, alem de
 * ter uma variavel padrão para a internacionalização
 * 
 * @copyright  -
 * @version    1.0
 * @author     Alexandre
 * @since      10/03/2009
 */
class Sistema_Modulo{
	
	protected $_layout;
	protected $_msg;
	protected $_leng;
	protected $_modulo;
	
	public function __construct(){
		$this->_layout = Sistema_Layout::instanciar();
		$this->_msg = Sistema_Layout::instanciar();
		$linguagem = new Sistema_Linguagem($this->_modulo);
		$this->_leng = $linguagem->getTitulos();
	}
	
}
?>