<?

class Modulo_Trabalho_Funcao {

	/**
	 * temPermissao
	 *
	 * @abstract verifica se o usuário é o dono do traboho que ele está tetando baixar
	 *
	 * @param $trb_cod Código do trabalho
	 * @param $usr_cod Cóidigo do usuário
	 */
	public static function temPermissao($trb_cod, $usr_cod)
	{
		$sql = "SELECT usr_cod FROM trabalho WHERE trb_cod = ".$trb_cod;

		$trb_usr_cod = Sistema_Conecta::GetOne($sql);

		if($usr_cod == $trb_usr_cod) {
			return true;
		} else {
			return false;
		}	
	}
	
	public static function funlinkRecursive($dir, $deleteRootToo)
	{
	    if(!$dh = @opendir($dir))
	    {
	        return;
	    }
	    while (false !== ($obj = readdir($dh)))
	    {
	        if($obj == '.' || $obj == '..')
	        {
	            continue;
	        }

	        if (!@unlink($dir . '/' . $obj))
	        {
	            unlinkRecursive($dir.'/'.$obj, true);
	        }
	    }

	    closedir($dh);
	   
	    if ($deleteRootToo)
	    {
	        @rmdir($dir);
	    }
	   
	    return;
	} 
}
?>