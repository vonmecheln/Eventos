<?php
class Componente_Formulario {

	private $_msg = null;
	private $_class = null;
	private $_valores = null;
	private $_form = null;
	private $l = null;

	public function __construct($classe,$form=""){
		$this->_class = $classe;
		$this->_form = $form;
		$this->_msg = Sistema_Mensagem::instanciar();
		$this->l = Sistema_Layout::instanciar();
		$this->l->includeCss(SISTEMA_URL."css/formulario.css");
		$this->l->includeJavaScript(SISTEMA_URL."javascript/formulario.js");

	}


	public function setValores($array){
		$this->_valores = $array;
	}

	/**
	 * Retorna os campos ja pré formatados
	 * @return Array
	 */
	public function getCampos(){
		$mp = $this->_class->getCampos();
		$camposmostra = $this->_class->getFormulario($this->_form);
		$input = array();

		# Verifica se foi passado um valor para o codiog
		if($this->_class->getCodigo() > 0){
			$this->_valores = $this->_class->getDados();
		}

		if(is_array($mp)){
			$i=0;
			# Retorna os campos estrangeiros
			$estrangeiros = $this->_class->getEstrangeiros();
			foreach($mp as $campo=>$dados){
				# $dados[0]: label
				# $dados[1]: plugin
				# $dados[2]: tamanho
				# $dados[3]: requirido
					
				if (in_array($campo, $camposmostra)){
					# Valida o plugin
					$plugin = sprintf("Plugin_".ucwords(strtolower($dados[1])));
					$p = new $plugin();
					if (is_subclass_of($p,'Sistema_Plugin')) {
						# Instacia a classe do campo
						$p->setClasse($this->_class->getClasse());
						# Verifica se é um estrangeiros
						# Seta a classe para ele
						if(is_array($estrangeiros) && array_key_exists($campo,$estrangeiros)){
							$p->setClasseEstrangeira($estrangeiros[$campo]);
						}
							


						# Verifica se é requerido
						if($dados[1]!="chave"){
							$req = ($dados[3]) ? "<b style='color:red'>!</b>" :  "";
							$input[$i]['label']= sprintf("<label for='%s'>%s %s</label>",$campo,$req,$dados[0]);
						}else{
							$input[$i]['label']= "";
						}
						$input[$i]['input'] = $p->criaCampo($campo,$dados[2],$this->_valores[$campo]);
					}

					$i++;
				}
			}
		}
		return $input;
	}

	public function getForm($modulo,$acao){
		$mp = $this->_class->getCampos();
		$camposmostra = $this->_class->getFormulario($this->_form);

		# Verifica se foi passado um valor para o codiog
		if($this->_class->getCodigo() > 0){
			$this->_valores = $this->_class->getDados();
				
			# Pega e mostra o histórico se tiver
			$hist = new Sistema_Historico($_SESSION['ACT_ATUAL']);
				
			$jan = new Componente_Janela();
			$texto_hist = sprintf("<img src='%simagens/historico.png' align=absmiddle> Histórico",SISTEMA_URL);
			$act = $jan->getJanelaConteudo($hist->getHistórico($this->_valores[$this->_class->getChavePK()]),$texto_hist);

			$this->l->setBotoes("Histórico","javascript:".$act,"imagens/historico.png");
				
				
				
		}

		if(is_array($mp)){
			$i=0;
			# Retorna os campos estrangeiros
			$estrangeiros = $this->_class->getEstrangeiros();
			foreach($mp as $campo=>$dados){
				# $dados[0]: label
				# $dados[1]: plugin
				# $dados[2]: tamanho
				# $dados[3]: requirido

				if (in_array($campo, $camposmostra)){
					# Valida o plugin
					$plugin = sprintf("Plugin_".ucwords(strtolower($dados[1])));
					$p = new $plugin();
					if (is_subclass_of($p,'Sistema_Plugin')) {
						# Instacia a classe do campo
						$p->setClasse($this->_class->getClasse());
						# Verifica se é um estrangeiros
						# Seta a classe para ele
						if(is_array($estrangeiros) && array_key_exists($campo,$estrangeiros)){
							$p->setClasseEstrangeira($estrangeiros[$campo]);
						}

						# Verifica se é requerido
						$req = ($dados[3]) ? "<b style='color:red'>!</b>" :  "";
							
						# Verifica se é chave
						if(strtolower($dados[1]) == "chave"){
							if($this->_valores[$campo] > 0){
								$input[$i]['label']= sprintf("%s<label>%s</label>",$req,$dados[0]);
								$input[$i]['input'] = $p->criaCampo($campo,$dados[2],$this->_valores[$campo]);
							}
						}else{
							$input[$i]['label']= sprintf("%s<label>%s</label>",$req,$dados[0]);
							$input[$i]['input'] = $p->criaCampo($campo,$dados[2],$this->_valores[$campo]);
						}
					}

					$i++;
				}
			}

			# Verifica se ira montar um formulario do tipo Um-Para-Muitos
			# alexandre 01/04/2009
			$dadosUPM = $this->_class->getUmParaMuitos();
			if(is_array($dadosUPM)){
				foreach($dadosUPM as $classeUPM=>$vt){
					$_classe = new $classeUPM();
					$plg_upm = new Plugin_UmParaMuitos();
					$plg_upm->setUmParaMuitos($classeUPM,$vt[0],$vt[1]);
					$rttemp = $plg_upm->criaCampo(null,0,$this->_valores[$vt[0]]);
					foreach($rttemp as $k=>$v){
						$input[$i]['label'] = $v['label'];
						$input[$i]['input'] = $v['input'];
						$i++;
					}

				}
			}

				

				
			$tela = new Sistema_Layout_Tela("templates/formulario.tpl");
			$tela->addVar("campos",$input);
			//$tela->addVar("dadoshidden",$this->_hidden);
				
			$modulo = MODULO."=".$modulo;
			$acao   = ACAO."=".$acao;
				
			$form = sprintf('<form id="frmclss" onSubmit="formulario.enviaForm(\'frmclss\',\'%s\',\'%s\'); return false;">
								%s
							</form>
							%s',$modulo,$acao,$tela->getTela(),$formUPM);
				
				
				
				
				
			return $form;
		}else{
			$this->_msg->setErro("Mapa para o Formulário não é valido");
		}




	}



}
?>