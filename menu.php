<?php

$menu = array("Inicial"=>"inicio","Apresenta��o"=>"apresentacao",
			"Normas"=>"normas","Programa��o"=>"programacao",
			"Patroc�nio & Apoio"=>"expositores","Inscri��o"=>"inscricao",
			"Trabalhos Cient�ficos" => "trabalhos/trabalhos",
			"Comiss�o"=>"comissao","Contatos"=>"contatos");

$pagina = (isset($_GET['p'])) ? $_GET['p'] : "inicio";
			
foreach($menu as $k=>$v){
	$li .= ($pagina == $v) ? sprintf('<li class="active"><strong>%s</strong></li>',$k)
			: sprintf('<li><a href="index.php?p=%s">%s</a></li>',$v,$k);
}			

echo ('<ul>'.$li.'</ul>');
?>