<?php
/**
 * @abstract Monta a listagem em ajax.
 *
 * @copyright  -
 * @version    1.0
 * @author     -
 * @since      11/03/2009
 */
class Componente_Listagem {
	
	/**
	 * @abstract Imagens padrões
	 * @var unknown_type
	 */
	static public $_IMG_ALTERAR  = "imagens/editar.png";
	static public $_IMG_CANCELAR = "imagens/cancel.png";
	
	/**
	 * @abstract Numero de linhas por pagina
	 * @var integer
	 */
	private $_linhas = 100;
	private $_inicio = 0;
	
	/**
	 * @abstract Colunas que irão aparecer na listagem
	 * @example 
	 * 		$_colunas = array("usr_cod"=>"Código","usr_nome"=>"Nome","tamanho"=>50);
	 * @var array
	 */
	private $_colunas = array();
	
	/**
	 * @abstract Sql executada pela listagem
	 * @var String
	 */
	private $_sql 	= null;
	
	/**
	 * @abstract Condição Where
	 * @var String
	 */
	private $_where	= "";	
	
	/**
	 * @abstract Vetor com os botoes
	 * @example
	 * 		$_botoes = array("nome"=>nome do botao,"acao"=>link/funcao,"imagem"=>caminho,"tipo"=>link/javascript); 
	 * @var Array
	 */
	private $_botoes = array();
	
	/**
	 * @abstract Seta o nome do parametro a ser passado
	 * @var String
	 */
	private $_nomeParametro = "null";
	
	/**
	 * @abstract Nome da listagem
	 * @var String
	 */
	private $_nome = null;
	
	/**
	 * @abstract Objeto da sessao
	 * @var Componente_Listagem_Sessao
	 */
	private $_sessao = null;	
	
	/**
	 * @abstract campo que sera selecionado 
	 * @var string
	 */
	private $_selecionado = null;
	
	/**
	 * @abstract Construtor
	 * @return unknown_type
	 */
	public function __construct($nome){
		$this->_nome = $nome;
		$this->_sessao = new Componente_Listagem_Sessao($this->_nome);
		$this->setInicio(0);
	}
	
	
	public function setTabelaCampo($dados){
		$this->_sessao->setDado("tabcampo",$dados);
	}
	
	public function getTabelaDoCampo(){
		return $this->_sessao->getDado("tabcampo");
	}
	
	/**
	 * @abstract Seta uma coluna de retorno
	 * @param $campo
	 * @param $nome
	 * @param $tamanho
	 */
	public function setColuna($campo,$nome,$tamanho=0){
		$this->_colunas[] = array('campo'=>$campo,'nome'=>$nome,'tamanho'=>$tamanho);
	}
	
	public function setSelecionado($campo){
		$this->_selecionado = $campo;
		$this->_sessao->setDado("busca",$this->_selecionado);
		
	}
	
	/**
	 * @abstract Seta a sql para busca
	 * @param $sql
	 */
	public function setSQL($sql){
		$this->_sql = $sql;
		$this->_sessao->setDado("sql",$this->_sql);
	}

	/**
	 * @abstract Nome do parametro
	 * @param $nome
	 */
	public function setNomeParametro($nome,$order="ASC"){
		$this->_nomeParametro = $nome;
		$this->_sessao->setDado("parametro",$this->_nomeParametro);
		$this->_sessao->setDado("order",sprintf(" ORDER BY %s %s",$this->_nomeParametro,$order));
	}
	
	public function setOrdem($nome,$order="ASC"){
		$this->_sessao->setDado("tipoord",$order);
		$this->_sessao->setDado("order",sprintf(" ORDER BY %s %s",$nome,$order));
	}
	
	/**
	 * @abstract Seta um botão de ação para listagem
	 * @param $nome
	 * @param $modulo 
	 * @param $acao
	 * @param $imagem
	 */
	public function setBotaoModuloAcao($nome,$modulo,$acao,$imagem){
		$imagem = SISTEMA_URL . $imagem;
		$acao = SISTEMA_INDEX ."?". MODULO ."=".$modulo."&".ACAO."=".$acao;
		$this->_botoes[] =  array("nome"=>$nome,"acao"=>$acao,"imagem"=>$imagem,"tipo"=>"link");
	}
	
	/**
	 * @abstract Seta um botão de ação para listagem
	 * @param $nome
	 * @param $funcao
	 * @param $tipo
	 */
	public function setBotaoJavascript($nome,$funcao,$imagem){
		$imagem = SISTEMA_URL . $imagem;
		$this->_botoes[] =  array("nome"=>$nome,"acao"=>$funcao,"imagem"=>$imagem,"tipo"=>'javascript');
	}	

	/**
	 * @abstract Seta um botão para janela
	 * @param $nome
	 * @param $funcao
	 * @param $tipo
	 */
	public function setBotaoJanela($nome,$modulo,$acao,$imagem,$id=1){
		$imagem = SISTEMA_URL . $imagem;
		$acao = SISTEMA_INDEX ."?". MODULO ."=".$modulo."&".ACAO."=".$acao;
		$this->_botoes[] =  array("nome"=>$nome,"acao"=>$acao,"imagem"=>$imagem,"tipo"=>'janela',"id"=>$id);
	}	
	
	/**
	 * @abstract Seta uma condição para where
	 * @param $where
	 */
	public function setWhere($where){
		$this->_sessao->setDado("whereajx","");
		$this->_where = sprintf(" WHERE %s ",$where);	
		$this->_sessao->setDado("where",$this->_where);
	}
	
	/**
	 * @abstract Seta uma condição para where vindo de um ajax
	 * @param $where
	 */
	public function setWhereAjax($where){
		$this->_sessao->setDado("whereajx","");
		# Verifica se ja tem um where
		if($this->_sessao->getDado('where') != ""){
			$ajx = sprintf(" AND %s ",$where);
		}else{
			$ajx = sprintf(" WHERE %s ",$where);			
		}
		$this->_sessao->setDado("whereajx",$ajx);
	}
	
	/**
	 * @abstract Retorna o formulario para a tela
	 * @return String
	 */
	public function getForm(){
		
		$this->_sessao->setDado("colunas",$this->_colunas);
		$this->_sessao->setDado("botoes",$this->_botoes);
		
		$layout   = Sistema_Layout::instanciar();
		$layout->includeCss(SISTEMA_URL."componente/listagem/css/listagem.css");
		$layout->includeJavaScript(SISTEMA_URL."componente/listagem/javascript/listagem.js");
		$template = new Sistema_Layout_Tela("componente/listagem/template/formulario.tpl");
		$template->addVar("valor",$this->_sessao->getDado("valor"));
		$template->addVar("options",$this->getOptions());
		$template->addVar("acoes",$this->getAcoes());
		$template->addVar("tabela",$this->getTabela());
		$template->addVar("formid",$this->_nome);
		return $template->getTela();
	}
	
	/**
	 * @abstract Retorna o formulario pelo ajax
	 * @return String
	 */
	public function getFormAjax(){
		
		$this->_colunas = $this->_sessao->getDado("colunas");
		$this->_botoes  = $this->_sessao->getDado("botoes");
		$this->_nomeParametro = $this->_sessao->getDado("parametro");
		
		return $this->getTabela();
	}
	
	/**
	 * Retorna o options para filtrar a busca
	 * @return string
	 */
	private function getOptions(){
		
		$campo = $this->_sessao->getDado("busca");
		
		foreach($this->_colunas as $k=>$v){
			$sel = ($campo == $v['campo']) ? " selected " : "";
			$options .= sprintf('<option value="%s" %s>%s</option>',$v['campo'],$sel,$v['nome']);
		}
		return $options;
	}
	
	/**
	 * Mota a tabela com a listagem
	 * @return String
	 */
	private function getTabela(){
		# Monta a sql
		$sql = $this->getSQL();
		
		$template = new Sistema_Layout_Tela("componente/listagem/template/tabela.tpl");
		$template->addVar("paginas",$this->getPaginas());
		$template->addVar("colunas",$this->getColunas());
		$template->addVar("valores",$this->getValores());
		
		return $template->getTela();
		
		
		return $html;
	}

	
	/**
	 * Retorna a paginacao
	 */
	private function getPaginas(){
		$total = $this->getTotalRegistro();
		if($total > 0 && $this->_linhas < $total ){
			$ppag = $total / $this->_linhas ;
			$ppag = ceil($ppag);
			for($i=0; $i <$ppag; $i++){
				$tmp = $i+1;
				$limit = $i * $this->_linhas;
				$numpag = ( $this->_sessao->getDado("inicio") == $limit) ? "<b>".$tmp."</b>" : $tmp;
				$paginas .= sprintf("<a href='#' onClick='lista.paginas(%d)' title='Página %s' > %s </a>",$limit,$numpag,$numpag);	
			}
			 
		}
		return $paginas; 
	}
	
	/**
	 * @abstract Retorna as colunas
	 * @return unknown_type
	 */
	public function getColunas(){
		# tamanho meno o primeiro
		$tamanho = sprintf("%s",count($this->_colunas));
		
		$prc = ceil(95 / $tamanho);
		$pr1 = 100 - ($prc * $tamanho);
		foreach($this->_colunas as $k=>$v){
			if($k > 0){
				$this->_colunas[$k]['tamanho'] = sprintf("%s%%",$prc);
			}else{
				$this->_colunas[$k]['tamanho'] = sprintf("%s%%",$pr1);
			}
		}
		$this->_colunas = array_merge($this->_colunas,array(array('campo'=>"::botao::",'nome'=>"Ações",'tamanho'=>"5%")));
		
		return $this->_colunas;
	}
	
	/**
	 * @abstract Retorna os botões para ação
	 * @param $cod
	 * @return unknown_type
	 */
	private function getBotoes($cod,$nome=null){

		foreach ($this->_botoes as $k=>$v) {
			# nome , funcao , imagem, tipo
			if ($v['tipo'] == "link") {
				$bt .= sprintf('<a href="%s&%s=%s" title="%s"><img src="%s" style="border:0px"></a> &nbsp;',
								$v['acao'],$this->_nomeParametro,$cod,$v['nome'],$v['imagem']);
			} else if($v['tipo'] == "janela") {
				$jan = new Componente_Janela($cod.$v['id']);
				$titulo = sprintf("<img src='%s'  >",$v['imagem']) . "&nbsp<b>".$nome."</b>";
				$act = $jan->getJanelaURL($v['acao']."&".$this->_nomeParametro."=".$cod,$titulo);
				$bt .= sprintf('<a href="#" onClick="%s" title="%s"><img src="%s" style="border:0px"></a>',$act,$v['nome'],$v['imagem']);				
			} else {
				$bt .= sprintf('<a href="#" onClick="%s(\'%s\')" title="%s"><img src="%s"  style="border:0px"></a>',
								$v['acao'],$cod,$v['nome'],$v['imagem']);
			}
		}
		return  $bt;

	}
	
	/**
	 * @abstract Retorna os valores para a listagem
	 * @return Array
	 */
	public function getValores(){
		$dados = Sistema_Conecta::Execute($this->getSQL(),PDO::FETCH_ASSOC);
		
		if(is_array($dados) && count($dados)>0){	
			foreach($dados as $vet){
				$vt = array();
				foreach ($this->_colunas as $v){
					if($v['campo'] == "::botao::"){
						$vt[] =$this->getBotoes(trim($vet[$this->_nomeParametro]),$vet[$this->_selecionado]);	
					}else{
						$vt[] = trim($vet[$v['campo']]);
					}
					
				}
				$vetor[] =$vt; 
				unset($vt);
			}
		}else{
			return "<h3><b style='color:red'>!</b> Não foi encontrado nenhum registro</h3>";
		}
		
		return $vetor;
		
	}
	
	/**
	 * Seta o inicio
	 * @param $i
	 * @return unknown_type
	 */
	public function setInicio($i){
		$this->_inicio = $i;
		$this->_sessao->setDado('inicio',$this->_inicio);
	}
	
	public function getInicio(){
		return $this->_sessao->getDado("inicio");
	}
	
	public function getLinhas(){
		return $this->_linhas;
	}	
	
	/**
	 * @abstract Retorna a sql
	 * @return String
	 */
	public function getSQL(){
		
		# Carrega o limit
		$limit = sprintf(" limit %d,%d ",$this->_sessao->getDado('inicio'),$this->_linhas);
		$this->_sessao->setDado('limit',$limit);
		
		return $this->_sessao->getDado('sql')	
				.$this->_sessao->getDado('where')
				.$this->_sessao->getDado('whereajx')
				.$this->_sessao->getDado('order')
				.$this->_sessao->getDado('limit');
	}
	
	private function getTotalRegistro(){
		$sql = $this->_sessao->getDado('sql')
				.$this->_sessao->getDado('where')
				.$this->_sessao->getDado('whereajx');
				
		$dados = Sistema_Conecta::Execute($sql);
	
		return sprintf("%d",count($dados));
	}
	
	/**
	 * Retorna as ações para a listagem
	 * @return string
	 */
	private function getAcoes(){
		
		$fim = $this->getTotalRegistro() - $this->_linhas  +1;

		$inicio    = array(0,SISTEMA_URL."componente/listagem/imagens/pg_primeira.png");
		$anterior  = array("a",SISTEMA_URL."componente/listagem/imagens/pg_anterior.png");
		$proximo   = array("p",SISTEMA_URL."componente/listagem/imagens/pg_proxima.png");
		$ultimo    = array($fim,SISTEMA_URL."componente/listagem/imagens/pg_ultima.png");
		$recarregar    = SISTEMA_URL."componente/listagem/imagens/pg_refresh.png";

//		<a href="javascript:lista.acoes(\'%s\');" /><img src="%s" style="border:0px" title="Anterior"/></a>&nbsp;
//		<a href="javascript:lista.acoes(\'%s\');" /><img src="%s" style="border:0px" title="Próxima"/></a>&nbsp;
//		$anterior[0],$anterior[1],
//		$proximo[0],$proximo[1],
		
		
		$html = sprintf('<a href="javascript:lista.paginas(%d);" title="Primeira" ><img src="%s" style="border:0px" /></a>&nbsp;
						<a href="javascript:lista.paginas(%d);" title="Última"><img src="%s" style="border:0px" /></a>&nbsp;
						<a href="javascript:lista.recarrega();" title="Recarregar Listagem"><img src="%s" style="border:0px" /></a>&nbsp;',
						$inicio[0],$inicio[1],
						$ultimo[0],$ultimo[1],
						$recarregar);
		return $html;
	}
	
}
?>