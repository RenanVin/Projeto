<?php
	$ip  = $_GET["ip"];
	$url = $_GET["url"];

	//Verifica se existe uma sessão criada e se a mesma está no banco
	if(@$_SESSION["usuariosOnline"]["sessao"] == true)
	{
		$idSessao = $_SESSION['usuariosOnline']['sessao'];
		$_SESSION['usuariosOnline']['url'] = $url;
		$_SESSION['usuariosOnline']['timeEnd'] = time()+15;
		if(@mysql_num_rows(mysql_query("SELECT * FROM sys_visitors_online WHERE sessao = '".$_SESSION["usuariosOnline"]["sessao"]."'")) == true)
		{
			update(
				array(
					"timeEnd", 
					"url", 
					"sessao", 
					"ip"
					), 
				array(
					$_SESSION['usuariosOnline']['timeEnd'], 
					$url, $_SESSION['usuariosOnline']['sessao'], 
					$_SERVER["REMOTE_ADDR"]
					), 
				"sys_visitors_online", 
				"WHERE sessao = '$idSessao'"
				);
		}
		else
		{
			insert(
				array(
					"timeEnd", 
					"url", 
					"sessao", 
					"ip"
					), 
				array(
					$_SESSION['usuariosOnline']['timeEnd'], 
					$url, 
					$_SESSION['usuariosOnline']['sessao'], 
					$_SERVER["REMOTE_ADDR"]), 
				"sys_visitors_online"
				);
		}		
	}

	// Verifica se já existe uma sessão para esse visitante
	if(empty($_SESSION["usuariosOnline"]["sessao"]))
	{

		// Se não existir, cria as sessões e insere no banco
		$_SESSION["usuariosOnline"]["sessao"]  = session_id();
		$_SESSION["usuariosOnline"]["ip"]      = $ip;
		$_SESSION["usuariosOnline"]["url"]     = $url;
		$_SESSION["usuariosOnline"]["timeEnd"] = time()+15;
		insert(
			array(
				"sessao", 
				"ip", 
				"url", 
				"timeEnd"
				), 
			array(
				$_SESSION["usuariosOnline"]["sessao"], 
				$ip, 
				$url, 
				$_SESSION["usuariosOnline"]["timeEnd"]
				), 
			"sys_visitors_online"
			);

	}
	else
	{

		// Caso já exista, atualiza o time no banco e a página que o visitante está no momento
		$idSessao = $_SESSION['usuariosOnline']['sessao'];
		$_SESSION['usuariosOnline']['url'] = $url;
		$_SESSION['usuariosOnline']['timeEnd'] = time()+15;
		update(
			array(
				"timeEnd", 
				"url"
				), 
			array(
				$_SESSION['usuariosOnline']['timeEnd'], 
				$url
				), 
			"sys_visitors_online", 
			" WHERE sessao = '$idSessao'"
			);

   }

   	$rowsOnlineAtual = mysql_num_rows(mysql_query("SELECT * FROM sys_visitors_online"));
	$rowsMaxAtual    = mysql_num_rows(mysql_query("SELECT * FROM sys_max_visitors_online WHERE data = CURDATE()"));

	if($rowsMaxAtual == false)
	{
		insert(
			array(
				"maximo", 
				"data"
				), 
			array(
				"1", 
				date("Y-m-d")
				), 
			"sys_max_visitors_online"
			);
	}

	$totalMaxAtual = mysql_fetch_object(mysql_query("SELECT SUM(maximo) AS maximo FROM sys_max_visitors_online WHERE data = CURDATE()"));
	if($rowsOnlineAtual > $totalMaxAtual->maximo)
	{
		update(
			array(
				"maximo"
				), 
			array(
				$rowsOnlineAtual
				), 
			"sys_max_visitors_online", 
			"WHERE data = '".date("Y-m-d")."'"
			);
	}
?>