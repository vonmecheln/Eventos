<?php
	# inclui o config
	include '../../config.php';


	
	$valor = substr(strtoupper($_POST['uf']),0,2);
	$sql = sprintf("SELECT cid_cod,cid_nome FROM cidade WHERE est_cod='%s'",$valor);
	$dados = Sistema_Conecta::Execute($sql,PDO::FETCH_ASSOC);
	
	$json = new Sistema_Json();
	
	die($json->encode($dados));
	
	$json = new Sistema_Ajax();
	$json->addVar($dados);
	$json->responde(true);
?>