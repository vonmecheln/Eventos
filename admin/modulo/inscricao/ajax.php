<?php 
include '../../config.php';
$mod = new Modulo_Inscricao();
$a = $mod->ajaxsalvarsenha();

if($a){
	
	$subject = EVENTO.' - INSCRI��O REALIZADA';
	$mensagem = "
	Sua inscri��o foi realizada com sucesso. Acesse a sess�o Trabalho Cientifico e imprima o seu boleto.<br/>";
	
	$mensagem .= "<b>E-mail:</b> ".$_POST['usr_email']."<br/>";
	$mensagem .= "<b>Senha:</b> ".$_POST['usr_senha']."<br/>";

	/* Configura��o do PHP MAILER -----------------------------*/
	require "../../../phpmailer/class.phpmailer.php";
	$mail = new PHPMailer();
  $mail->SetLanguage("br", "libs/"); // ajusto a lingua a ser utilizadda
  $mail->SMTP_PORT = "587"; // ajusto a porta de smt a ser utilizada. Neste caso, a 587 que o GMail utiliza
  $mail->SMTPSecure = "tls"; // ajusto o tipo de comunica��o a ser utilizada, no caso, a TLS do GMail
  $mail->IsSMTP(); // ajusto o email para utilizar protocolo SMTP
  $mail->Host = "smtp.gmail.com";  // especifico o endere�o do servidor smtp do GMail
  $mail->SMTPAuth = true;  // ativo a autentica��o SMTP, no caso do GMail, � necess�rio
	$mail->Username = EMAIL;
	$mail->Password = EMAIL_SENHA; // senha de SMTP
	$mail->From = $emailCou;
	$mail->FromName = $nomeCou;
	$mail->IsHTML(true);

	// caso queira que o reply seja enviado para outro lugar
	$mail->AddReplyTo(EMAIL_REPLAY_TO,EVENTO);

	$mail->AddAddress($_POST['usr_email'],$_POST['usr_nome']);
	$mail->Body = $mensagem;
	$mail->Subject = $subject;
	
	$mail->Send();
}
?>
