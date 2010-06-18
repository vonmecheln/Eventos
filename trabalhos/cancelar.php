<?php 
	# DOWNLOAD
	# como os arquivos .pdf foram bloqueados no site a fim de evitar que neguinho ficasse 
	require_once("admin/config.php");

	$login = Sistema_Login::instanciar();	
	$trb_cod = Sistema_Variavel::get('trb_cod');
	$usr_cod = $login->getCodigo();
	
	if(Modulo_Trabalho_Funcao::temPermissao($trb_cod, $usr_cod))
	{	
		$sql = "SELECT trb_status FROM trabalho WHERE trb_cod = ".$trb_cod;
		
		$trb_status = Sistema_Conecta::getOne($sql);
		
		if($trb_status != ATIVO){		
			$mensagem = '<div class="clean-error">Este trabalho não pode mais ser cancelado.</div><br/>';
		} else {
			$sql = "UPDATE trabalho SET trb_status = ".CANCELADO." WHERE trb_cod = ".$trb_cod;

			$ret = Sistema_Conecta::Execute($sql);

			if(!$ret){
				$mensagem = '<div class="clean-error">Erro ao cancelar o trabalho.</div><br/>';
			} else {
				$mensagem = '<div class="clean-ok">O trabalho foi cancelado.</div><br/>';
			}
		}

		echo $mensagem;
		echo "<br/><br/><a href='index.php?p=trabalhos/trabalhos'>&laquo; Voltar</a>";
	} else {	
		return false;
	}
?>