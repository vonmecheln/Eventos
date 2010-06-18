<?
	// manda o mail pra coordenação
	if($_POST['salvar']){

		$nome = Sistema_Variavel::get('nome');
		$email = Sistema_Variavel::get('email');
		$telefone = Sistema_Variavel::get('telefone');
		$motivo = Sistema_Variavel::get('motivo');
		$texto = Sistema_Variavel::get('texto');
		
		$subject = 'COU - CONTATO - '.$motivo;
		$mensagem = "<b>Nome:</b> ".$nome."<br/>";
		$mensagem .= "<b>E-mail:</b> ".$email."<br/>";
		$mensagem .= "<b>Telefone:</b> ".$telefone."<br/>";
		$mensagem .= "<b>Motivo:</b> ".$motivo."<br/>";
		$mensagem .= "<b>Texto:</b><br/>";
		$mensagem .= $texto."<br/><br/>";

		/* Configuração do PHP MAILER -----------------------------*/
		$emailCou = EMAIL."@yahoo.com.br";
		$nomeCou = "COU - UNIOESTE";

		require "phpmailer/class.phpmailer.php";
		$mail = new PHPMailer();
		$mail->IsHTML(true); // envio como HTML se 'true'
		$mail->WordWrap = 50; // Definição de quebra de linha
		$mail->IsSMTP(); // send via SMTP
		$mail->SMTPAuth = true; // 'true' para autenticação
		$mail->Mailer = "smtp"; //Usando protocolo SMTP
		$mail->Host = "smtp.mail.yahoo.com"; //seu servidor SMTP
		$mail->Username = EMAIL;
		$mail->Password = EMAIL_SENHA; // senha de SMTP
		$mail->From = $emailCou;
		$mail->FromName = $nomeCou;

		// caso queira que o reply seja enviado para outro lugar
		$mail->AddReplyTo($email,$nome);

		$mail->AddAddress($emailCou,$nomeCou);
		$mail->Body = $mensagem;
		$mail->Subject = $subject;

		if(!$mail->Send()){
		   $mensagem = '<div class="clean-error">Erro ao enviar a mensagem</div><br/>';
		} else {
		   $mensagem = '<div class="clean-ok">Mensagem enviada com sucesso. Em breve entraremos em contato.</div><br/>';
		}
	}
	
	echo $mensagem;
?>

<form name="frmContato" action="index.php?p=contatos" method="post" class='yform'>

	<input type='hidden' name='salvar' value='1'/>

	<fieldset>
		<legend>Contato</legend>
		<div class="type-text">
			<label for="nome"><b style='color:red'>!</b> Nome</label>
			<input type="text" name="nome" id="nome" size="40"/>
		</div>
		
		<div class="type-text">
			<label for="email">E-mail</label>
			<input type="text" name="email" id="email" size="50"/>
		</div>
		
		<div class="type-text">
			<label for="telefone">Telefone</label>
			<input type="text" onkeypress="return mascara(null, 'telefone', '(99) 9999-9999', event);" value="" id="telefone" name="telefone" size="15" maxlength="15"/>
		</div>

		<div class="type-text">
			<label for="motivo">Motivo do Contato</label>
			<input type="text" name="motivo" id="motivo" size="50"/>
		</div>		
		
		<div class="type-text">
			<label for="texto"><b style='color:red'>!</b> Texto</label>
			<textarea name="texto" id="texto" cols="30" rows="7"></textarea>			
		</div>		

		<div class='type-button'>
			<input type="submit" value="Enviar" id="submit" name="submit" />
			<input type="reset" value="Cancelar / Voltar" id="reset" name="reset" onClick="window.location='index.php?p=trabalhos/trabalhos'"/>
		</div>
	</fieldset>
</form>