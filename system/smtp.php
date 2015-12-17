<?php
	
	function sendMail($nomeDestino, $emailDestino, $nomeRemetente, $emailRemetente, $assunto, $msg, $arquivo = "")
	{

		require_once(str_replace("admin/", "", DIR)."system/PHPMailer/PHPMailer.php");
		#$nomeDestino = Nome de quem vai receber
		#$emailDestino = E-mail de quem vai receber
		#$nomeRemetente = Nome de quem está enviando
		#$emailRemetente = E-mail de quem está enviando
		#$assunto = Assunto do e-mail
		#$msg = Mensagem do e-mail

		$montaMsg = '<div style="text-align: left"><img src="'.str_replace("admin", "", CP).'/assets/img/header_mail.jpg" alt="Header" /></div>';
		$montaMsg .= '<br /><div style="font-family: Arial; color: #666; font-size: 14px;">'.$msg.'<br /><br />';

		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->SMTPDebug   = 0;
		$mail->Debugoutput = 'html';
		$mail->Host        = getSys("smtpHost"); 
		$mail->Port        = getSys("smtpPort"); 
		$mail->SMTPAuth    = true;
		$mail->Username    = getSys("smtpLogin"); 
		$mail->Password    = getSys("smtpPass"); 
		$mail->SetFrom(getSys("smtpLogin"), $nomeRemetente);
		$mail->addReplyTo($emailRemetente, $nomeRemetente);
		$mail->AddAddress($emailDestino, $nomeDestino);
		$mail->Subject = $assunto;
		$mail->msgHTML($montaMsg);
		if($arquivo == true)
		{
			$mail->AddAttachment($arquivo);
		}

		if(!$mail->send())
		{
			return false;
		}
		else
		{
			return true;
		}
	}
?>