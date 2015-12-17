<?php

	session_start();
	ob_start();
	ob_start("ob_gzhandler");

	require_once("../system/connection.php");
	require_once("../system/mysql.php");
	require_once("../system/functions.php");
	require_once("../system/settings.php");
	require_once("../system/router.php");
	require_once("../system/smtp.php");
	require_once("../model/required.fields.php");
	require_once("model/session.php");

	// Inclui o controle solicitado na URL
	$pasta  = @router(0);
	$page   = @router(1).".php";

	if(($pasta && $page) != "")
	{
		if(file_exists("$pasta/".$page) == true)
		{
			// Não exige session caso a solicitação for para as páginas abaixo.
			if($page == "login.php" or $page == "forgot.php" or $page == "new-password.php")
			{
				include_once("$pasta/".$page);
			}
			else
			{
				//Verifica se está logado
				if(session(@$_SESSION["adminID"]) == true)
				{
					include_once("$pasta/".$page);
				}
				else
				{
					include_once("view/login.php");
				}
			}
		}
		else
		{
			include_once("view/login.php");
		}
	}
	else
	{
		include_once("view/login.php");
	}

?>