<?php

	session_start();
	ob_start();
	ob_start("ob_gzhandler");
	
	require_once("system/connection.php");
	require_once("system/mysql.php");
	require_once("system/functions.php");
	require_once("system/settings.php");
	require_once("system/mobile.detect.php");
	require_once("system/router.php");
	require_once("system/smtp.php");
	require_once("model/required.fields.php");

	onlineSystem();
	
	// Inclui o controle solicitado na URL
	if(router(0) != "")
	{
		// Para inclusão dos arquivos Model
		if(router(0) == "model")
		{
			if(file_exists("model/".router(1).".php") == true)
			{
				include_once("model/".router(1).".php");
			}
			else
			{
				// Carrega o contador sempre que chamar a home
				insertVisitor();
				insertDevice();
				include_once("controller/home.php");
			}
		}
		else // Para inclusão de arquivos de Controller
		{
			if(file_exists("controller/".router(0).".php") == true)
			{
				// Carrega o contador de visitas apenas nos controladores de view
				insertVisitor();
				insertDevice();
				include_once("controller/".router(0).".php");
			}
			else
			{
				include_once("controller/404.php");
			}
		}
	}
	else
	{
		// Carrega o contador sempre que chamar a home
		insertVisitor();
		insertDevice();
		include_once("controller/home.php");
	}

?>