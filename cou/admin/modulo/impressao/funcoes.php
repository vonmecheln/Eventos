<?php

class modulo_impressao_funcoes 
{
	
	/**
	 * getCertificado
	 * 
	 * retorna o texto do certificado
	 * 
	 * @param $tipo
	 * 
	 * @return HTML
	 */
	public static function getCertificado($tipo){
		switch ($tipo) {
			case "congressista":

				$modelo = "
 				Certificamos que <b>%s</b> participou como <b>CONGRESSISTA</b> do VI CONGRESSO DE ODONTOLOGIA DA UNIOESTE - 
 				COU, XI JORNADA ACADÊMICA DE ODONTOLOGIA DA UNIOESTE- JAOU E VI ENCONTRO DE EX-ALUNOS DE 
 				ODONTOLOGIA DA UNIOESTE, realizados entre os dias 29 de setembro a 02 de outubro de 2009.";
				break;
			case "apresentouTrabalho":

				$modelo = "
 				Certificamos que <b>%s</b> apresentou o trabalho <b>%s</b> na forma de <b>%s</b>, tendo como 
 				autores <b>%s</b>, durante o VI CONGRESSO DE ODONTOLOGIA DA UNIOESTE - COU, 
 				XI JORNADA ACADÊMICA DE ODONTOLOGIA DA UNIOESTE - JAOU E VI ENCONTRO DE EX-ALUNOS DE 
 				ODONTOLOGIA DA UNIOESTE, realizados entre os dias 29 de setembro a 02 de outubro de 2009.";
				break;
			case "ministrante":
				
				$modelo = "
      			Certificamos que <b>%s</b> ministrou o %s, durante o 
      			VI CONGRESSO DE ODONTOLOGIA DA UNIOESTE - COU, XI JORNADA ACADÊMICA DE 
      			ODONTOLOGIA DA UNIOESTE - JAOU E VI ENCONTRO DE EX-ALUNOS DE ODONTOLOGIA DA UNIOESTE, 
      			realizados entre os dias 29 de setembro a 02 de outubro de 2009, com carga horária de %s hora(s).";
				break;
				
			case "participante":
				
				$modelo = "				
      			Certificamos que <b>%s</b> participou %s pelo(a) %s durante o 
      			VI CONGRESSO DE ODONTOLOGIA DA UNIOESTE - COU, XI JORNADA ACADÊMICA DE 
      			ODONTOLOGIA DA UNIOESTE - JAOU E VI ENCONTRO DE EX-ALUNOS DE ODONTOLOGIA DA UNIOESTE, 
      			realizados entre os dias 29 de setembro a 02 de outubro de 2009, com carga horária de %s hora(s).";
				break;				
			default:
				;
				break;
		}
		
		/*
		return "
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<div class='txtCertificado'>".$modelo."</div>
				<div class='dataEmissao'>Cascavel, 29 de setembro de 2009. </div>
				<br style='page-break-before: always'/>";
			*/		
		return "
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<div class='txtCertificado'>".$modelo."</div>
			<div class='dataEmissao'>Cascavel, ".date("d")." de ".self::nomeMes(date("m"))." de 2009. </div>
		<br style='page-break-before: always'/>";			
	}

	/**
	 * getCss
	 * 
	 * @abstract retorna o código CSS que irá formatar o certificado  
	 * 
	 * @return HTML
	 */
	public static function getCss()
	{
		$css = "
			<style>
				.txtCertificado{
					font-size: 22px;
					margin-left: 80px;
					margin-right: 80px;
					text-align:justfy;
					font-family:Arial;							
				}
				
				.dataEmissao{
					margin-top: 10px;
					margin-right: 10mm;
					font-size: 22px;
					float: right;	
					font-family:Arial;			
				}
			</style>";
		
		return $css;		
	}
	
	/**
	 * nomeMes
	 *
	 * @param 1 - 12 se for mês
	 */
	public static function nomeMes($numero) 
	{
        $mes['01']  = "Janeiro";
        $mes['02']  = "Fevereiro";
        $mes['03']  = "Março";
        $mes['04']  = "Abril";
        $mes['05']  = "Maio";
        $mes['06']  = "Junho";
        $mes['07']  = "Julho";
        $mes['08']  = "Agosto";
        $mes['09']  = "Setembro";
        $mes['10'] = "Outubro";
        $mes['11'] = "Novembro";
        $mes['12'] = "Dezembro";

		return $mes[$numero];
	}	
}
?>