<?php
/**
 * @abstract Módulo referente as ações do desenvolvimento do sistema
 * 
 * @copyright  -
 * @version    1.0
 * @author     Alexandre
 * @since      10/03/2009
 */
class Modulo_Trabalho extends Sistema_Modulo{
	
	protected $_modulo = "trabalho";

	/**
	 * Ação responsável pela criação do formulário
	 * para cadastros dos Módulos
	 * @return Form
	 */
	public function acaoFormtrabalho(){
		$mapa = new Classe_Trabalho($_GET['trb_cod']);
		$form = new Componente_Formulario($mapa);
		
		$this->_layout->setBotoes("Listar Trabalhos",Sistema_Util::getURL($this->_modulo,"listartrabalho"),"imagens/list.png");
		$this->_layout->setNomePagina("Gerenciar Trabalho");
		$this->_layout->setCorpo($form->getForm($this->_modulo,"salvartrabalho"));
	}

	/**
	 * Ação responsável pela criação da listagem
	 * dos Módulos
	 * @return Listagem
	 */
	public function acaoListartrabalho()
	{
		$sql = "
		SELECT 
			trb_cod, 
			concat(substring(trb_titulo,1,80),'...') as trb_titulo, 
			usr_nome,
			trb_categoria,
			stt_nome
		FROM trabalho 
			INNER JOIN usuario ON
				usuario.usr_cod = trabalho.usr_cod
			INNER JOIN status ON
				status.stt_cod = trabalho.trb_status";
		
		$lista = new Componente_Listagem('listartrabalho');
		$lista->setSQL($sql);

		$lista->setColuna("trb_cod","Código","5%");
		$lista->setColuna("usr_nome","Nome Participante");
		$lista->setColuna("trb_titulo","Titulo Trabalho");
		$lista->setColuna("trb_categoria","Categoria");
		$lista->setColuna("stt_nome","Status");
		
		$lista->setNomeParametro("trb_cod");
		
		$lista->setBotaoModuloAcao("Gerenciar",$this->_modulo,"Formtrabalho",Componente_Listagem::$_IMG_ALTERAR);
		$lista->setBotaoModuloAcao("Download",$this->_modulo,"download","imagens/page_white_acrobat.png");

		$this->_layout->setNomePagina("Listagem de Trabalhos Submetidos");
		$this->_layout->setCorpo($lista->getForm());
	}
	
	public function acaodownload()
	{
		$trb_cod = Sistema_Variavel::get('trb_cod');

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
		
		if($arq != ""){
			header("Content-Type: application/save");
			header("Content-Length:".filesize($arq)); 
			header('Content-Disposition: attachment; filename="'.Sistema_Variavel::get('trb_cod').$ext); 
			header("Content-Transfer-Encoding: binary");
			header('Expires: 0'); 
			header('Pragma: no-cache'); 
				
			// nesse momento ele le o arquivo e envia
			$fp = fopen("$arq", "r"); 
			fpassthru($fp); 
			fclose($fp);
		} else {
			$msg = Sistema_Mensagem::instanciar();
			$msg->setErro("Não foi submetido arquivo para este trabalho");
		}
	}

	/**
	 * Ação responsável para salvar os dados vindos
	 * do formulário
	 * @return JSON
	 */
	public function ajaxSalvartrabalho(){
		$obj = new Classe_Trabalho();
		$obj->setDados($_POST);
		$id = $obj->salvar();
		$json = new Sistema_Ajax();
		$json->addVar($id);
		$json->responde();
	}
	
	/**
	 * Ação para testes
	 * @return String
	 */	
	public function acaoGerarmidia()
	{
		$sql = "
		SELECT
			*
		FROM trabalho t
			INNER JOIN usuario u ON
				t.usr_cod = u.usr_cod
		WHERE
			t.trb_status = ".ACEITO." OR 
			t.trb_status = ".ACEITOCOMRESALVAS;
			
		$trabalhos = Sistema_Conecta::Execute($sql);
			
		// limpar os arquivos da pasta		
		$dir_aceitos = SISTEMA_DIR."cd\\trabalhos_aceitos\\";
		$dir_enviados = UPLOAD_DIR;
		
		Modulo_Trabalho_Funcao::funlinkRecursive($dir_arquivos,false);
		
		# percorre os trabalhos que foram aceitos
		foreach($trabalhos as $trabalho)
		{
			$a  = '{"ID":"'.$trabalho['trb_cod'].'",';
			$a .= '"TITULO":"'.$trabalho['trb_titulo'].'",';
			$a .= '"AUTOR":"'.$trabalho['usr_nome'].'",';
			$a .= '"AREA":"'.$trabalho['trb_area'].'",';
			$a .= '"DESCRICAO":"'.$trabalho['trb_resumo'].'"}';
			
			$aux[] = utf8_encode(strtoupper(strtr($a,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")));
			
			// copiar os arquivos dos trabalhos que foram aceitos para a pasta do CD
			$arquivoName = $trabalho['trb_cod'].".pdf";			
			
			$arquivo_aceito = $dir_aceitos.$arquivoName;
			
			if(!file_exists($arquivo_aceito)){
				die("O arquivo do trabalho ".$trabalho['trb_cod']." não foi localizado.");
			}

			$arquivo_enviado = $dir_enviados.$arquivoName;
			copy($arquivo_enviado,$arquivo_aceito);
		}
		
		$texto = implode(",",$aux);			
		$conteudo = 'var json = ['.$texto.']; var trabalhos = new TAFFY(json);';
		
		// grava o arquivo
		$filename = SISTEMA_DIR.'cd\base.js';
		
		// Primeiro vamos ter certeza de que o arquivo existe e pode ser alterado
		if (is_writable($filename)) {
		    if (!$handle = fopen($filename, 'w')) {
		         echo "Não foi possível abrir o arquivo ($filename)";
		         exit;
		    }
		    // Escreve $conteudo no nosso arquivo aberto.
		    if (fwrite($handle, $conteudo) === FALSE) {
		        echo "Não foi possível escrever no arquivo ($filename)";
		        exit;
		    }
			$msg = Sistema_Mensagem::instanciar();
			$msg->setSucesso("Midia gerada com sucesso.");
		    fclose($handle);
		} else {
		    echo "O arquivo $filename não pode ser alterado";
		}
	}
}
?>