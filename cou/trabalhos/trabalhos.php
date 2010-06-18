<?php
	/*
		Status do trabalho
		
		O trabalho pode estar em um dos seguintes estados
		- Ativo
		- Bloquado
		- Cancelado
		- Em análise
		- Aceito
		- Aceito com Resalvas
		- Rejeitado

		O acadêmico somente poderá editar o trablho se ele estiver no status Ativo ou Aceito com Resalvas, nos demais casos ele não poderá fazer nada com o trablaho
	*/
	require_once "admin/config.php";
 
	// classe de login 
	$login = Sistema_Login::instanciar();
	
	if (!$login->usuarioLogado()) {
		die("<script type='text/javascript'>window.location='index.php?p=login'</script>");
	}
	
	// situacao da inscricao
	$sql = "SELECT stt_nome FROM comprovante c INNER JOIN status s ON s.stt_cod = c.stt_cod WHERE usr_cod = ".$login->getCodigo();
	$situacaoInscricao = Sistema_Conecta::getOne($sql);
	
	if($situacaoInscricao == ""){
		$situacaoInscricao = "<em style='yellow'>Aguardando a Submissão do Comprovante</em>";
	}
	
	// todos os trabalhos de um aluno
	$sql = "
	SELECT
		*
	FROM trabalho
		INNER JOIN status ON
			trabalho.trb_status = status.stt_cod
	WHERE
		usr_cod = ".$login->getCodigo();

	$trabalhos = Sistema_Conecta::Execute($sql);
	
	if(!is_array($trabalhos))
		$trabalhos = array();	
?>
        <!-- Subtemplate: 2 Spalten mit 50/50 Teilung -->
      
	<div class="subcolumns">
          <div class="c62l">
            <div class="subcl">
                  <h2>Inscrição</h2>
                  <p><strong>Nome Participante:</strong> <?=Sistema_Login::getNome() ?> </p>
                  <p><strong>Situação da Inscrição:</strong> <?=$situacaoInscricao?> </p> 
				  
				  <h2>Trabalhos Submetidos</h2>
				  
				  <table style='width: 500px'>
					<thead>
						<tr>
							<th>Título</th>
							<th width='150'>Categoria</th>
							<th width='80'>Situação</th>
							<th width='90'>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<? foreach($trabalhos as $k=>$v)
						{
							$editar = "";
							$cancelar = "";
							$observacao = "";
							$salvarArquivo = "";

							if(($v['trb_status'] == ATIVO) ||($v['trb_status'] == ACEITOCOMRESALVAS)){
								$editar = "<a href='index.php?p=trabalhos/gerenciarTrabalho&cod=".$v['trb_cod']."'><img src='imagens/pencil.png'/>Editar</a> <br/>";
							}

							if($v['trb_status'] == ATIVO){
								$cancelar = "<a href='index.php?p=trabalhos/cancelar&trb_cod=".$v['trb_cod']."'><img src='imagens/cancel.png'/>Cancelar</a><br/>";
							}
							
							$file = UPLOAD_DIR.$v['trb_cod'].".PDF";
							if(file_exists($file)){
								$salvarArquivo = "<a href='trabalhos/download.php?trb_cod=".$v['trb_cod']."'><img src='imagens/book.png'/>Download</a> <br/>";					
							}

							$file = UPLOAD_DIR.$v['trb_cod'].".DOC";
							if(file_exists($file)){
								$salvarArquivo = "<a href='trabalhos/download.php?trb_cod=".$v['trb_cod']."'><img src='imagens/book.png'/>Download</a> <br/>";					
							}
							
							if($v['trb_observacao']){
								$observacao = "<a href='index.php?p=trabalhos/observacao&trb_cod=".$v['trb_cod']."'><img src='imagens/comment.png'/>Comentários</a>";
							}
							
							echo "
							<tr>
								<td>".$v['trb_cod']." - ".$v['trb_titulo']."</td>
								<td>".$v['trb_categoria']."</td>
								<td>".$v['stt_nome']."</td>
								<td> 
									".$editar."
									".$salvarArquivo."
									".$cancelar."
									".$observacao."
								</td>
							</tr>";
						}
						?>
					</tbody>
				  </table>
            </div>
          </div>

          <div class="c38r">
            <div class="subcr">
                <div class="info">
		            <?php include'menuTrabalhos.php'; ?>
		        </div>      
				<div class="info">
					<?php include'./downloads.php'; ?>
				</div>
			</div>
		</div>
	</div>

