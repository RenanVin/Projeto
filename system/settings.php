<?php

	// Set region of time
	date_default_timezone_set('America/Sao_Paulo');

	// Exibir ou esconder erros do PHP
	@ini_set('display_errors', 1);

	$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === false) ? 'http' : 'https';
	if(!defined('CAMINHO_PRINCIPAL')){ define("CAMINHO_PRINCIPAL", $protocolo.'://'.$_SERVER['HTTP_HOST'].str_replace("/index.php", "", $_SERVER['SCRIPT_NAME'])); }
	if(!defined('CP')){ define("CP", CAMINHO_PRINCIPAL); }
	if(!defined('cp')){ define("cp", CAMINHO_PRINCIPAL); }
	define("DIR", $_SERVER["DOCUMENT_ROOT"].str_replace("index.php", "", $_SERVER['SCRIPT_NAME']));
	define("dir", $_SERVER["DOCUMENT_ROOT"].str_replace("index.php", "", $_SERVER['SCRIPT_NAME']));

	if(!get_magic_quotes_gpc()){ function add_magic($value){ $value = is_array($value) ? array_map('add_magic', $value) : addslashes(str_replace('"', "'", $value)); return $value; } $_POST = array_map('add_magic', $_POST); $_GET = array_map('add_magic', $_GET); }
	if(!get_magic_quotes_gpc()){ function remove_magic($value){ $value = is_array($value) ? array_map('remove_magic', $value) : stripslashes(str_replace('"', "'", $value)); return $value; } }

	// Dados do desenvolvedor
	define("DEVELOPER_EMAIL", "contato@renanv.com.br");
	define("DEVELOPER_NAME",  "Renan Nunes");
	define("DEVELOPER_PHONE", "(44)9948-4724");
	define("DEVELOPER_URL",   "http://renanv.com.br");
?>