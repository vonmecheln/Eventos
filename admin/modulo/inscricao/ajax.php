<?php 
include '../../config.php';
$mod = new Modulo_Inscricao();
$a = $mod->ajaxsalvarsenha();

if($a){
	
	$subject = EVENTO.' - INSCRIÇÃO REALIZADA';
	$mensagem = "
	Sua inscrição foi realizada com sucesso, após o pagamento da inscrição acesse a área Trabalhos Científicos e 
	envie o comprovante. <br/>";
	
	$mensagem .= "<b>E-mail:</b> ".$_POST['usr_email']."<br/>";
	$mensagem .= "<b>Senha:</b> ".$_POST['usr_senha']."<br/>";

	/* Configuração do PHP MAILER -----------------------------*/
	require "../../../phpmailer/class.phpmailer.php";
	$mail = new PHPMailer();
	$mail->IsHTML(true); // envio como HTML se 'true'
	$mail -> IsSMTP();
	$mail->WordWrap = 50; // Definição de quebra de linha
	$mail->IsSMTP(); // send via SMTP
	$mail->SMTPAuth = true; // 'true' para autenticação
	$mail->Mailer = "smtp"; //Usando protocolo SMTP
  $mail ->Host = 'ssl://smtp.gmail.com';
  $mail ->Port = 465;
	$mail->Username = EMAIL;
	$mail->Password = EMAIL_SENHA; // senha de SMTP
	$mail->From = $emailCou;
	$mail->FromName = $nomeCou;

	// caso queira que o reply seja enviado para outro lugar
	$mail->AddReplyTo(EMAIL_REPLAY_TO,EVENTO);

	$mail->AddAddress($_POST['usr_email'],$_POST['usr_nome']);
	$mail->Body = $mensagem;
	$mail->Subject = $subject;
	
	$mail->Send();
	
	echo "<pre>";
	print_r($mail);
	die("anselmo");
}
?>
