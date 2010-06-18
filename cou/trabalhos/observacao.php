<?php 
	# DOWNLOAD
	# como os arquivos .pdf foram bloqueados no site a fim de evitar que neguinho ficasse 
	require_once("admin/config.php");

	$msg = Sistema_Mensagem::instanciar();	

	$login = Sistema_Login::instanciar();	
	$trb_cod = Sistema_Variavel::get('trb_cod');
	$usr_cod = $login->getCodigo();
	
	if(Modulo_Trabalho_Funcao::temPermissao($trb_cod, $usr_cod)){	
		$sql = "SELECT * FROM trabalho WHERE trb_cod = ".$trb_cod;
			
		$trabalho = Sistema_Conecta::Execute($sql);
		
		echo "<b>Observações</b><br/><br/>";
		echo $trabalho[0]['trb_observacao'];
		echo "<br/><br/><a href='index.php?p=trabalhos/trabalhos'>&laquo; Voltar</a>";
		
	} else {	
		return false;
	}
?>