<?php
/*
 * selectArray
 
 * @auth Anselmo Battisti
 * @mail anselmobattisti@gmail.com
 *
 * @version 1.0
 *
 * @example 
 
  require_once "selectArray.php";
  
 $fruit[0] = 'Lemon';
 $fruit[1] = 'Banana';
 $fruit[2] = 'Orange';
 
 echo selectArray::getHtmlSelect($fuit,'fruit',$_POST['fuit']);
  */
class selectArray
{
	/**
	  * getHtmlSelect
	  * 
	  * @abstract Gera um SELECT html em função de um vetor, a chave do vetor é o value e o option
	  */
	static function getHtmlSelect($array, $name, $selected, $null = false)
	{
		if(!is_array($array)){
			$html = "Erro ao gerar o select";
		} else {
			$html = '<select name="'.$name.'" id="'.$name.'" size="1">';
			
			if($null) {
				$html .= "<option value=''>-----</value>";
			}
			
			foreach($array as $k=>$v){
				unset($s);
				if($k == $selected) $s = "selected = 'true'";

				$html .= '<option value="'.$k.'" '.$s.'>'.$v.'</option>';
			}			
			$html .= '</select>';
		}
		return $html;
	}
} 
?>