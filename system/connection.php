<?php
	// P = Produção
	// D = Desenvolvimento
	define("TYPE_CONNECTION", "D");

	if(TYPE_CONNECTION == "D")
	{
		define("DB_HOST", "localhost");
		define("DB_BANCO", "framework");
		define("DB_USER",  "root");
		define("DB_PASS",  "");
	}
	else
	{
		define("DB_HOST", "localhost");
		define("DB_BANCO", "renanvco_framework");
		define("DB_USER",  "renanvco_user");
		define("DB_PASS",  "RvsnNunes@10");
	}

	$Connect = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die (mysql_error());
	$Select  = mysql_select_db(DB_BANCO) or die (mysql_error());

	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');

?>