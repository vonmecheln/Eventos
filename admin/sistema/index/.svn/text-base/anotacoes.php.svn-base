<?php
class Sistema_Index_Anotacoes {
	
	
	public function __construct(){}
	
	
	public function getUltimasAnostacoes($qtd=5){
		
		$sql = sprintf("SELECT
						ant_cod,
						ant_titulo,
						date_format(ant_data, '%%d/%%m/%%Y') AS ant_data,
						status.stt_nome 
				FROM anotacoes
				INNER JOIN status ON status.stt_cod = anotacoes.stt_cod
				WHERE usr_cod=%d AND anotacoes.stt_cod=1
				ORDER BY ant_data ASC
				LIMIT 0,%d",$_SESSION['login']['codigo'],$qtd);
		
		$rs = Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);
		
		if(count($rs)>0){
			foreach($rs as $k=>$v){
				$data = (strtotime(Sistema_Util::data($v['ant_data'])) > strtotime(date("Y/m/d")))  ?  $v['ant_data']  : sprintf("<span style='color:red'>%s</span>",$v['ant_data']);
				//$url = SISTEMA_INDEX ."?".MODULO."=perfil&".ACAO."=formanotacoes&ant_cod=".$v['ant_cod'];
				$url = SISTEMA_INDEX ."?".MODULO."=perfil&".ACAO."=CarregaAnotacao&ant_cod=".$v['ant_cod'];
				
				$jan = new Componente_Janela();
				$link = $jan->getJanelaURL($url,$v['ant_titulo']);
				
				
				$retorno .= sprintf('<b>%s</b><br><a href="javascript:%s">%s</a><br>'
									,$data,$link,$v['ant_titulo']);
			}
		}else{
			$retorno = "<b style='color:red'>Nenhuma Anotação em aberto</b>";
		}
		
		return $retorno; 
	}
	
}
?>