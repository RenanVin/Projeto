<?php

	if(@router(2) == false)
	{
		exit;
	}

	if(router(2) == "insert")
	{
		extract($_POST);

		if(!$_POST)
		{
			exit;
		}

		$formName = @router(3);

		requiredField("nome", "Nome", $formName);
		requiredEmail("email", $formName);
		requiredField("password", "Senha", $formName);
		requiredField("passwordRep", "Repita a senha", $formName);
		passwordComparer("password", "passwordRep", $formName);

		$consulta = mysql_num_rows(mysql_query("SELECT * FROM sys_admin WHERE email = '".$email."'"));

		if($consulta == true)
		{
			echo jsScript('$(".'.$formName.' .input-email input").focus();');
			echo sweetAlert("Atenção!", "Este e-mail já está cadastrado.", "warning");
		}

		insert(
			array(
				"nome",
				"email",
				"password"
				),
			array(
				$nome,
				$email,
				md5($password)
				),
			"sys_admin"
			);

		exit;
		// Salva cada campo por vez
		foreach($_POST as $campo => $valor)
		{	
			
		}

	}
	
	if(router(2) == "update")
	{
		extract($_POST);

		if(!$_POST)
		{
			exit;
		}
	}
?>