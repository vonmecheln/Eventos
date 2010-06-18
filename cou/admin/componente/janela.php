<?php
class Componente_Janela {
	
	private $_layout = null;
	private $_codigo = null;
	
	public function __construct($cod=null){
		$this->_codigo = $cod;
		# Instancia o Layout
		$this->_layout = Sistema_Layout::instanciar();

		$this->carregaJavaScripts();
		$this->carregaCss();
	}
	
	/**
	 * @abstract Faz o carregamento dos javaScripta 
	 * necessсrios para a criaчуo da janela
	 */
	private function carregaJavaScripts(){
		$this->_layout->includeJavaScript(SISTEMA_URL."componente/janela/javascripts/window.js");		
		$this->_layout->includeJavaScript(SISTEMA_URL."componente/janela/javascripts/effects.js");
		$this->_layout->includeJavaScript(SISTEMA_URL."componente/janela/javascripts/window_effects.js");
	}
	
	/**
	 * @abstract Faz o carregamento dos estilos 
	 * css necessсrios para a criaчуo da janela
	 */
	private function carregaCss(){
		$this->_layout->includeCss(SISTEMA_URL."componente/janela/themes/default.css");		
		$this->_layout->includeCss(SISTEMA_URL."componente/janela/themes/alphacube.css");
	}	
	
	/**
	 * @abstract Retorna uma janela contendo a URL passada
	 * @param $url
	 * @param $titulo
	 * @return string	 * 
	 */
	public function getJanelaURL($url,$titulo=""){
		$nome = (is_null($this->_codigo)) ? rand(0,999) : $this->_codigo;
		//showEffect:Effect.Appear, hideEffect: Effect.Fade,
		$javascript = sprintf('var winURL_%s = new Window({className: \'alphacube\', 
													title: \'%s\', 
													width:850,height:500,
													url: \'%s\'});
								',addslashes($nome),addslashes($titulo),$url);
		
		// nуo passa mais para a variavel porque se for usado com paginaчуo, o mщtodo nуo щ carregado
		//$this->_layout->setFuncoesJS($javascript);	
		
		return sprintf($javascript." winURL_%s.showCenter();",$nome);
	}
	
	/**
	 * @abstract Retorna uma janela contendo um valor passado como parametro
	 * @param $conteudo
	 * @param $titulo
	 * @return string
	 */
	public function getJanelaConteudo($conteudo,$titulo=""){
		$nome = (is_null($this->_codigo)) ? rand(0,999) : $this->_codigo;
		//showEffect:Effect.Appear, hideEffect: Effect.Fade,
		$javascript = sprintf('var winConteudo_%s = new Window({className: "alphacube", 
													title: "%s",
													width:600,height:400});
							   winConteudo_%s.getContent().innerHTML= "%s"	;				
								',$nome,$titulo,$nome,str_replace('\"','"',$conteudo));
		$this->_layout->setFuncoesJS($javascript);
		return sprintf("winConteudo_%s.showCenter();",$nome);
	}

	/**
	 * @abstract Retorna uma janela com o modulo e aчуo formatado para janela
	 * @param $modulo
	 * @param $acao 
	 * @param $titulo
	 * @return string
	 */
	public function getJanelaModuloAcao($modulo,$acao,$titulo=""){
		$url = SISTEMA_INDEX."?".MODULO."=".$modulo."&".ACAO."=".$acao."&".JANELA."=true";
		$nome = (is_null($this->_codigo)) ? rand(0,999) : $this->_codigo;
		$javascript = sprintf('var winModuloAcao_%s = new Window(
								{className: "alphacube", 
								title: "%s", 
								showEffect:Effect.Appear, hideEffect: Effect.Fade,
								width:600,height:400,
								url: "%s"});',$nome,$titulo,$url);
		$this->_layout->setFuncoesJS($javascript);
		return sprintf("winModuloAcao_%s.showCenter();",$nome);
		/*
		$nome =rand(0,999);
		$javascript = sprintf('var winModuloAcao_%s = new Window({className: "alphacube", 
													title: "%s", 
													showEffect:Effect.BlindDown, hideEffect: Effect.SwitchOff,
													width:600,height:400});
								',$nome,$titulo,$nome);
		
		$this->_layout->setFuncoesJS($javascript);
		return sprintf("winModuloAcao_%s.setAjaxContent('%s',{method: 'get'});	",$nome,$url);
		*/
	}	
}
?>