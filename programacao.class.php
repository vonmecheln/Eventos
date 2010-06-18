<?
include 'admin/config.php';
include 'admin/sistema/conecta.php';

class Programacao {

	public function __construct(){
	}

	public function getDados(){


		$sql = "SELECT prg_cod,DATE_FORMAT(prg_data, '%d/%m/%Y') as prg_data,
					   prg_tema, prg_hora,prg_palestrante,prg_descricao
				FROM programacao	Order By prg_data";
		
		return Sistema_Conecta::Execute($sql);	
	}
	
	public function getDadosProximoDia(){
	
		$rs = $this->getDados();
		$programacao = array();
		foreach($rs as $k=>$v){
			if( (int)str_replace("/","",$v['prg_data']) >= (int)date("dmY")){
			
			$programacao[$v['prg_data']] .= sprintf('	
														 <div style="padding-top:5px;">
														 	<h4>%s</h4>
														  </div>
														 <div><strong>%s</strong></div>
														 <hr />
													 ',
													 $v['prg_tema'],
													 $v['prg_palestrante']);

			}
		}		
		
		foreach($programacao as $k=>$v){
			$tema .= sprintf('<div style="padding-top:20px;"><h3>%s</h3>%s</div>',$k,$v);
			break;
		}	
		
		return $tema;
	}
	
	public function getDivDados(){
		$rs = $this->getDados();
		$programacao = array();
		foreach($rs as $k=>$v){
			$programacao[$v['prg_data']] .= sprintf('	<hr />
														 <div style="padding-top:5px;">
														 <h4><em>%s</em> - %s</h4></div>
														 <div><strong>%s</strong></div>
														 <div>%s</div>
													 ',
													 $v['prg_hora'],$v['prg_tema'],
													 $v['prg_palestrante'],nl2br($v['prg_descricao']));
		
		}		
		
		foreach($programacao as $k=>$v){
			$tema .= sprintf('<div style="padding-top:20px;"><h2>%s</h2>%s</div>',$k,$v);
		}	
		
		return $tema;
	}
	
}
?>