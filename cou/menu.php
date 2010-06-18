<?php

$menu = array("Inicial"=>"inicio","Apresentação"=>"apresentacao",
			"Normas"=>"normas","Programação"=>"programacao",
			"Patrocínio & Apoio"=>"expositores","Inscrição"=>"inscricao",
			"Trabalhos Científicos" => "trabalhos/trabalhos",
			"Comissão"=>"comissao","Contatos"=>"contatos");

$pagina = (isset($_GET['p'])) ? $_GET['p'] : "inicio";
			
foreach($menu as $k=>$v){
	$li .= ($pagina == $v) ? sprintf('<li class="active"><strong>%s</strong></li>',$k)
			: sprintf('<li><a href="index.php?p=%s">%s</a></li>',$v,$k);
}			

echo ('<ul>'.$li.'</ul>');
?>