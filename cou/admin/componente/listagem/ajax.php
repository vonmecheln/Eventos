<?php
	# inclui o config
	include '../../config.php';
	
	
	# Verifica se irá recarregar a paágina
	if(isset($_POST['recarrega']) && $_POST['recarrega'] == "true"){
		$se = new Componente_Listagem_Sessao($_POST['formid']);
		$se->setDado("whereajx","");
	}else{
		# para fazer filtro com acento
		$_POST = Sistema_Util::trataUTF8($_POST);
		
		$listagem = new Componente_Listagem($_POST['formid']);
		# Verifica se foi clicado na paginacao
		if(isset($_POST['limit']) && is_numeric($_POST['limit'])){
			$listagem->setInicio($_POST['limit']);
		}
		
		# verifica se terá que fazer ordenaçao
		if(isset($_POST['ordem']) && strlen($_POST['ordem']) > 0 && $_POST['ordem'] != "::botao::"){
			$se = new Componente_Listagem_Sessao($_POST['formid']);
			$ord = ($se->getDado('tipoord') == "DESC") ? "ASC" : "DESC";
			$listagem->setOrdem($_POST['ordem'],$ord);
		}
		
		$filtro = $_POST['filtro'];
		$tmp = $listagem->getTabelaDoCampo();
		if(is_array($tmp)){
			if(array_key_exists($_POST['filtro'],$tmp)){
				$filtro = sprintf("%s.%s",$tmp[$_POST['filtro']],$_POST['filtro']);
			}
		}
		
		$where = sprintf(" %s LIKE '%%%s%%' ",$filtro,$_POST['busca']);
		$listagem->setWhereAjax($where);
		echo $listagem->getFormAjax();
	}
?>