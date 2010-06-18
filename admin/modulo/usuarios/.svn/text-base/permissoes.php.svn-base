<?php
/**
 * @abstract Classe responsável pelo tratamento
 * das funcionalidade sobre a gerencia das 
 * permissões
 * @author Alexandre
 * @copyright  -
 * @version    1.0
 * @since      24/03/2009
 */
class Modulo_Usuarios_Permissoes {
	
	/**
	 * @abstract Atributo com os codigos dos modulos
	 * que não poderão ser atribuidos a um usuario,
	 * módulos referentes ao desenvolvimento
	 * @var array
	 */
	private $MOD_DESENV = array(1);
	
	public function __construct(){
		
		
		
	}
	
	/**
	 * @abstract Monta o formulário em cima do grupo selecionado
	 * @param $grp_cod
	 * @return String
	 */
	public function getFormulario($grp_cod){
		
		$l = Sistema_Layout::instanciar();
		$l->includeCss(SISTEMA_URL."css/formulario.css");
		$l->includeJavaScript(SISTEMA_URL."javascript/formulario.js");		
		
		# Cria as restricoes para os modulos de desenvolvimento
		$where = implode(" OR modulo.mdl_cod !=",$this->MOD_DESENV);
		$restricoes = sprintf(" WHERE (modulo.mdl_cod!=%s)",$where);
		# Pega as ações do sistema menos as ações administrativas
		$sql = sprintf("SELECT acao.acao_cod,acao.acao_titulo,
							   modulo.mdl_titulo
						FROM acao
						INNER JOIN modulo ON modulo.mdl_cod = acao.mdl_cod
						 %s",$restricoes);

		
		$act = Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);

		# Pega as permissões do grupo
		$sql = sprintf("SELECT acao_cod,prm_cod,prm_salvar,prm_exibir,prm_inativa
						FROM permissoes WHERE grp_cod=%d",$grp_cod);
		$prm = Sistema_Conecta::Execute($sql);
		# Percorre todas as permissões ja salvas
		if(is_array($prm)){
			foreach($prm as $k=>$v){
				$permissoes_salvas[$v['acao_cod']] = array($v['prm_exibir'],$v['prm_salvar'],$v['prm_inativa']);
			}
		}
		
		$dados_acoes = array();
		# Carrega as açoes
		if(is_array($act)){
			foreach($act as $k=>$v){
				
				# Exibir
				$check1 = ($permissoes_salvas[$v['acao_cod']][0] > 0) ? " checked " : "";
				# Salvar
				$check2 = ($permissoes_salvas[$v['acao_cod']][1] > 0) ? " checked " : "";
				# Inativar
				$check3 = ($permissoes_salvas[$v['acao_cod']][2] > 0) ? " checked " : "";
				
				
				
				# Exibir
				$campo = sprintf('<label><input type="checkbox" name="prm_exibir_%d" value="%d" %s />&nbsp;Exibir</label> &nbsp;',$v['acao_cod'],$v['acao_cod'],$check1);
				# Salvar
				$campo .= sprintf('<label><input type="checkbox" name="prm_salvar_%d" value="%d" %s />&nbsp;Salvar</label> &nbsp;',$v['acao_cod'],$v['acao_cod'],$check2);
				# Inativar
				$campo .= sprintf('<label><input type="checkbox" name="prm_inativa_%d" value="%d" %s />&nbsp;Inativar</label> &nbsp;',$v['acao_cod'],$v['acao_cod'],$check3);
												
				$dados_acoes[$v['mdl_titulo']][] = array("label"=>$v['acao_titulo'],"campo"=>$campo);
				$campo = null;
			}
		}
		
		
		# Intancia o template
		$template = new Sistema_Layout_Tela("modulo/usuarios/templates/permissoes.tpl");
		$template->addVar("grp_cod",$grp_cod);
		$grupo = new Classe_Grupo($grp_cod);
		$dados_grupo = $grupo->getDados();
		$template->addVar("grp_descricao",$dados_grupo['grp_descricao']);
		$template->addVar("modulos",$dados_acoes);

		$modulo = MODULO."=usuarios";
		$acao   = ACAO."=salvarpermissao";
		
		return sprintf('<form id="frmprm" onSubmit="formulario.enviaForm(\'frmprm\',\'%s\',\'%s\'); return false;">
								%s
							</form>',$modulo,$acao,$template->getTela());		
		
	}
	
	/**
	 * @abstract Trata os dados vindo do formulario
	 * @param $post
	 * @return Array
	 */
	public function trataDados($post){
		$arr['grp_cod'] = $post['grp_cod'];
		unset($post['grp_cod']);
		if(is_array($post)){
			foreach($post as $k=>$v){
				$tmp = explode("_",$k);
				$tipo = $tmp[0]."_".$tmp[1];
				$arr['acoes'][$v][$tipo] = true;
			}
		}
		return $arr;
	}
	
	
	/**
	 * @abstract Metodo que irá salvar as permissoes
	 * @param $post
	 * @return unknown_type
	 */
	public function salvar($post){
		$arr_campos = array("prm_salvar"=>1,"prm_exibir"=>1,"prm_inativa"=>1);
		$dados = $this->trataDados($post);
		# Exclui todos os registros anteriores
		$del = sprintf("DELETE FROM permissoes WHERE grp_cod=%d",$dados['grp_cod']);
		if(Sistema_Conecta::Execute($del)){
			if(is_array($dados['acoes'])){
				# percorre cada acao
				foreach($dados['acoes'] as $acao_cod=>$vetor){
					$temp_campos = $arr_campos;
					$obj = new Classe_Permissoes();
					
					$ds['grp_cod'] = $dados['grp_cod'];
					$ds['acao_cod'] = $acao_cod;
					
					# percorre cada campo
					foreach($vetor as $campo=>$valor){
						$ds[$campo] =$valor;
						unset($temp_campos[$campo]);
					}
					# cria os campos nao selecionados como false
					if(is_array($temp_campos)){
						foreach($temp_campos as $v=>$vv){
							$ds[$v] =0;
						}
					}
					$obj->setDados($ds);
					$obj->salvar(false);
					unset($obj);
				}
				# Grava no Histórico
				$hist = new Sistema_Historico($_SESSION['ACT_ATUAL']);
				$hist->setHistorico(Sistema_Historico::$OP_ALTERAR,$dados['grp_cod'],'permissoes');	
			}
		}
	}
	
}
?>