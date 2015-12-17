<?php
	extract($_POST);

	requiredField("contNome", "Nome", $formName);
	requiredEmail("contEmail", $formName);
	requiredField("contTelefone", "Telefone", $formName);
	requiredField("contCidade", "Cidade",   $formName);
	requiredField("contUf", "UF", $formName);
	requiredTextarea("contMsg", "Mensagem", $formName);

	$msgMail = '
		<div style="font-family: Tahoma; color: #666; font-size: 14px;">
			<div>Resposta para <strong>'.$contEmail.'</strong>.</div>
			<br />
			<div>Nome: <strong>'.utf8_decode($contNome).'</strong></div>
			<div>Telefone: <strong>'.utf8_decode($contTelefone).'</strong></div>
			<div>Cidade: <strong>'.utf8_decode($contCidade).'</strong></div>
			<div>UF: <strong>'.utf8_decode($contUf).'</strong></div>
			<div>Mensagem: <strong>'.utf8_decode($contMsg).'</strong></div>
		</div>
	';

	$sql    = mysql_query("SELECT * FROM sys_emails WHERE page = 'contato'");
	$result = mysql_num_rows($sql);
	if($result == true)
	{
		while($ln = mysql_fetch_object($sql))
		{
			sendMail(getSys("siteName"), $ln->email, $contNome, $contEmail, "Contato recebido pelo site ".getSys("siteName"), $msgMail, "");
		}

		echo '
		<script>
			document.'.$formName.'.reset();
			swal("E-mail enviado!", "Retornaremos em breve.", "success");
		</script>
		';
	}
	else
	{
		saveLog("Nenhum e-mail cadastrado para ser enviado na página de contato");

		echo '
		<script>
			swal("E-mail não enviado!", "Não foi possível enviar o e-mail, tente novamente mais tarde..", "warning");
		</script>
		';
	}
	

	
?>