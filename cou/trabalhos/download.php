<?php 
	# DOWNLOAD
	# como os arquivos .pdf foram bloqueados no site a fim de evitar que neguinho ficasse 
	require_once("../admin/config.php");
	
	$login = Sistema_Login::instanciar();	
	$trb_cod = Sistema_Variavel::get('trb_cod');
	$usr_cod = $login->getCodigo();
	
	if(Modulo_Trabalho_Funcao::temPermissao($trb_cod, $usr_cod)){	
		$file = UPLOAD_DIR.$trb_cod.".PDF";
		if(file_exists($file)){
			$arq = $file;
			$ext = ".pdf";
		}
		$file = UPLOAD_DIR.$trb_cod.".DOC";
		if(file_exists($file)){
			$arq = $file;
			$ext = ".doc";
		}
		
		header("Content-Type: application/save");
		header("Content-Length:".filesize($arq)); 
		header('Content-Disposition: attachment; filename="'.$trb_cod.$ext); 
		header("Content-Transfer-Encoding: binary");
		header('Expires: 0'); 
		header('Pragma: no-cache'); 
			
		// nesse momento ele le o arquivo e envia
		$fp = fopen("$arq", "r"); 
		fpassthru($fp); 
		fclose($fp);
	} else {	
		return false;
	}
?>