<?php
/**
 * @abstract Monta o componente relatorio
 *
 * @copyright  Webgenium System
 * @version    1.0
 * @author     Luiz Felipe Weber
 * @since      14/05/2009
 */
class Componente_Relatorio {
	
	
	/**
	 * @abstract Colunas que irão aparecer n
	 * @example 
	 * 		$_colunas = array("usr_cod"=>"Código","usr_nome"=>"Nome","tamanho"=>50);
	 * @var array
	 */
	private $_colunas = array();
	
	/**
	 * @abstract Filtros para a busca no relatório
	 * @example 
	 * 		$_colunas = array("usr_cod"=>"Código","usr_nome"=>"Nome","valores"=>array);
	 * @var array
	 */
	private $_filtros = array();
	
	/**
	 * @abstract Sql executada pela listagem
	 * @var String
	 */
	private $_sql 	= null;
	
	/**
	 * @abstract Condição Where
	 * @var String
	 */
	private $_where	= array();
	
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
	 * @abstract Html do filtro da listagem de relatorios
	 * @var html
	 */
	private $_filtroHtml = null;
	
	/**
	 * @abstract Objeto da sessao
	 * @var Componente_Listagem_Sessao
	 */
	private $_sessao = null;
	
	/**
	 * @abstract Objeto do layout
	 * @var contém o layout do sistema
	 */
	public $layout = null;
	
	/**
	 * @abstract Template do html de busca
	 * @var contém o template de html de busca
	 */
	public $template_html = null;

	/**
	 * @abstract Select do filtro de busca
	 * @var contém o select do filtro de busca
	 */
	public $select_filtro = null;
	
	/**
	 * @abstract Construtor
	 * @return unknown_type	 
	 */
	public function __construct($nome,$modulo,$acao){
		
		$this->_nome 			= $nome;
		$this->_sessao 			= new Componente_Listagem_Sessao($this->_nome);
		$this->template_html 	= "<form action=\"%s\" method=\"post\"> Buscar por %s <input type=\"submit\" value=\"OK\"/>&nbsp;<input type='image' src='/componente/relatorio/imagens/printer.png' onclick=\"window.print();\"/></form>";
		$this->select_filtro 	= "<select name=\"filtro_busca\" class=\"filtro-busca\" id=\"filtro_busca\">%s</select>";

		$this->layout   = Sistema_Layout::instanciar();

		$this->layout->includeCss(SISTEMA_URL."componente/relatorio/css/print.css");
		$this->layout->includeCss(SISTEMA_URL."componente/relatorio/css/relatorio.css");
		$this->layout->includeCss(SISTEMA_URL."componente/relatorio/javascript/tablekit/table.css");
		$this->layout->includeJavaScript(SISTEMA_URL."componente/relatorio/javascript/relatorio.js");
		$this->layout->includeJavaScript(SISTEMA_URL."componente/relatorio/javascript/tablekit/fabtabulous.js");
		$this->layout->includeJavaScript(SISTEMA_URL."componente/relatorio/javascript/tablekit/tablekit.js");
		

		$this->setUrlBusca($modulo,$acao); // seta a url de busca do relatorio

	}

	/**
	 * @abstract Seta uma coluna de retorno
	 * @param $campo
	 * @param $nome
	 */
	public function setColuna($campo,$nome) {
		$this->_colunas[] = array('campo'=>$campo,'nome'=>$nome);
	}

	public function setSelecionado($campo) {
		$this->_selecionado = $campo;
		$this->_sessao->setDado("busca",$this->_selecionado);
	}

	/**
	 * @abstract seta os filtros para o form do relatorio
	 * @param $campo
	 * @param $nome
	 * @param $valores
	 * @param $tipo select ou input
	 */
	public function setFiltro($campo,$nome,$valores) {
		$this->_filtros[] = array('campo'=>$campo,'nome'=>$nome,'valores'=>$valores);
	}

	/**
	 * @abstract Seta a sql para busca
	 * @param $sql
	 */
	public function setSQL($sql){
		$this->_sql = $sql;
	}

	/**
	 * @abstract Nome do parametro
	 * @param $nome
	 */
	public function setNomeParametro($nome,$order="DESC"){
		$this->_nomeParametro = $nome;
		$this->_sessao->setDado("parametro",$this->_nomeParametro);
		$this->_sessao->setDado("order",sprintf(" ORDER BY %s %s",$this->_nomeParametro,$order));
	}

	public function setOrdem($nome,$order="DESC"){
		$this->_sessao->setDado("tipoord",$order);
		$this->_sessao->setDado("order",sprintf(" ORDER BY %s %s",$nome,$order));
	}

	public function setUrlBusca($modulo,$acao) {
		return $this->_urlBusca = sprintf('?mod=%s&act=%s',$modulo,$acao);
	}

	/**
	 * Método que seta o where do sql de acordo com os parametros passados por post
	 *
	 */
	public function setWhere($campo,$valor) {
		$this->_where[] = $campo.' like \'%'.$valor.'%\'';		
	}

	/**
	 * Retorna a sql do relatorio
	 *
	 * @return sql
	 */
	public function getSqlRelatorio() {
		$condicoes = $this->getWhere();		
		return sprintf($this->_sql,$condicoes);		
	}

	/**
	 * Método que retorna os where do sql implodidos por and
	 */
	public function getWhere() {		
		$where = (count($this->_where)>0)?('WHERE '.implode(' and ',$this->_where)):'';				
		return $where;
	}

	public function getUrlBusca() {
		return $this->_urlBusca;
	}

	public function getCamposFiltro() {
		return $this->_filtros;
	}

	public function getFiltro() {
		return $this->_filtroHtml;
	}

	public function processaFiltro() {
		
			$options_filtro = '';
			$html 			= '';	
			$template_html  = $this->template_html;		
			$select_filtro  = $this->select_filtro;
	
			foreach($this->getCamposFiltro() as $k=>$v) {
				// verifica se foi passado um parametro para o filtro
				if (isset($_POST['filtro_busca'])) {
					if ($_POST['filtro_busca'] == $v['campo']) {
						$sel = 'selected';	
						$this->setWhere($v['campo'],$_POST['filtro_valor']);// seta um parametro para o sql
					} else {
						$sel = '';
					}						
				}
				$options_filtro .= sprintf("<option %s value=\"%s\">%s</option>",$sel,$v['campo'],$v['nome']);						
			}
	
			$html .= "&nbsp;";		
			$html .= sprintf($select_filtro,$options_filtro); // coloca as opções dentro do select de filtro
	
			$valor_filtro 		= (isset($_POST['filtro_valor']))?$_POST['filtro_valor']:''; // verifica se foi setado um valor para o filtro		
			$html 			    .= sprintf("<input name=\"filtro_valor\" id=\"filtro_valor\" class=\"filtro-valor\" value=\"%s\"/>",$valor_filtro); // cria o select

			$this->_filtroHtml 	= sprintf($template_html,$this->getUrlBusca(),$html); // cria o campo para o formulario de busca


	}
	
	public function getListaRelatorio() {

		$linhas = '';
		$header = '';
		
		$this->processaFiltro(); // chama o método que processa os filtros em formato de select

		foreach($this->_colunas as $j=>$i) {
			$header.= sprintf("<th style=\"font-size:13px; height: 50px\">%s</th>",$i['nome']);
		}
		
		$sql 	= $this->getSqlRelatorio();
		$rs 	= Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);

		foreach($rs as $k=>$v) {
			$linhas .= "<tr>";
			foreach($this->_colunas as $j=>$i) {
				$campo_tabela = $v[$i['campo']]; 
				$linhas 	 .= sprintf("<td style='font-size:13px;border-top:1px solid #000' align='center'>%s</td>",$campo_tabela);	
			}
			$linhas .= "</tr>";
		}

		return sprintf('<div style="font-family: \'Courier New\', Courier, monospace;" id="container_relatorio">
							<div id="busca-relatorio">
								%s
							</div>		
							<table width="100%%" cellspacing="1" class="sortable">
								<thead>
									<tr>%s</tr>
								</thead>	
								<tbody>
									%s
								</tbody>
								<tfooter><tr><td>
								%s
								</td></tr></tfooter>
							</table>
						</div>',						
						$this->getFiltro(),
						$header,
						$linhas,
						('Cascavel'.date(', d-m-Y')));

	}

}
?>