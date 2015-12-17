<?php
	
	if(router(2) == false)
	{
		exit;
	}

	if(router(2) == "logar")
	{
		extract($_POST);

		if($nosp <> "")
		{
			exit;
		}
		
		requiredEmail("email", "formLogin");
		requiredField("password", "senha", "formLogin");

		$consulta = mysql_query("SELECT * FROM sys_admin WHERE email = '".noInject($email)."' AND password = '".noInject(md5($password))."'") or die (mysql_error());
		$result   = mysql_num_rows($consulta);

		if($result == true)
		{
			$ln = mysql_fetch_object($consulta);
			$_SESSION["adminID"] = $ln->ID;

			jsRedir(CP."/view/home");
		}
		else
		{
			echo sweetAlert("Erro!", "E-mail e/ou senha incorretos.", "error");
			exit;
		}
	}

	if(router(2) == "forgot")
	{
		extract($_POST);

		if($nosp <> "")
		{
			exit;
		}

		requiredEmail("emailForgot", "formForgot");
		requiredField("codigoForgot", "Código", "formForgot");

		if($codigoForgot <> $_SESSION["captcha"])
		{
			echo sweetAlert("Erro!", "Código incorreto, tente novamente.", "error");
			echo jsScript("document.getElementById('captcha').src='../system/captcha/captcha.php?'+Math.random();");
			exit;
		}

		$consulta = mysql_query("SELECT * FROM sys_admin WHERE email = '$emailForgot'");
		$result   = mysql_num_rows($consulta);

		if($result == true)
		{
			$ln = mysql_fetch_object($consulta);

			// Gera o token de segurança
			$token   = sha1(md5(time()));

			// Data de expiração do token
			$dataExp = date('Y-m-d H:i:s', strtotime("+1 day"));

			// Insere o token no cadastro do usuário
			update(
				array(
					"token",
					"tokenExp"
					),
				array(
					$token,
					$dataExp
					),
				"sys_admin",
				"WHERE ID = '".$ln->ID."'"
				);

			$msg = '
			<div>
				Olá, '.$ln->nome.', uma nova senha foi solicitada no site <strong>'.getSys("siteName").'</strong>.
			</div
			<br />
			<div>Clique no link abaixo para criar uma nova senha:</div>
			<div>
				<a href="'.CP.'/view/new-password/'.$token.'" target="_blank"><strong>Criar nova senha</strong></a>
			</div>
			<br />
			<div>
				<small>Desconsidere essse e-mail caso não tenha solicitado uma nova senha.</small>
			</div>
			';

			sendMail(
				$ln->nome, 
				$ln->email, 
				getSys("siteName"), 
				getSys("smtpLogin"),
				"Recupere sua senha - ".getSys("siteName"), 
				utf8_decode($msg)
				);

			echo sweetAlert("Sucesso!", "Você receberá um e-mail com informações para recuperar sua senha.", "success");
			echo jsScript("
				document.getElementById('captcha').src='../system/captcha/captcha.php?'+Math.random();
				document.formForgot.reset();
				");
			
			exit;
		}
		else
		{
			echo sweetAlert("Erro!", "E-mail não cadastrado no sistema.", "error");
			echo jsScript("document.getElementById('captcha').src='../system/captcha/captcha.php?'+Math.random();");
			exit;
		}
	}
	
	if(router(2) == "newPass")
	{
		extract($_POST);

		if($nosp <> "")
		{
			exit;
		}

		$consulta = mysql_query("SELECT * FROM sys_admin WHERE token = '".$token."'");
		$result   = mysql_num_rows($consulta);

		if($result == false)
		{
			echo sweetAlert("Erro!", "Link inválido ou fora do prazo de validade.", "error");
			exit;
		}

		$ln = mysql_fetch_object($consulta);

		if($ln->tokenExp < date("Y-m-d H:i:s"))
		{
			echo sweetAlert("Erro!", "Link inválido ou fora do prazo de validade.", "error");
			exit;
		}

		requiredField("password", "senha", "formNewPass");

		if(strlen($password) < 5)
		{
			echo sweetAlert("Atenção!", "Sua deve deve conter no mínimo 5 caracteres.", "warning");
			exit;
		}

		requiredField("passwordRep", "(Repita a senha)", "formNewPass");
		
		if($password <> $passwordRep)
		{
			echo sweetAlert("Atenção!", "As senhas digitadas não conferem.", "warning");
			exit;
		}

		update(
			array(
				"token",
				"tokenExp",
				"password"
				),
			array(
				"",
				"",
				md5($password)
				),
			"sys_admin",
			"WHERE ID = '".$ln->ID."'"
			);

		$_SESSION["adminID"] = $ln->ID;		

		echo sweetRedir(
			"Sucesso!", 
			"Sua senha foi atualizada.", 
			"success", 
			CP."/view/home"
			);
	}	
?>