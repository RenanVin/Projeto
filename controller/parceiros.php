<?php
	require_once("header.php");	

	require_once("system/template.php");
	use system\template;

	$tpl = new Template("view/parceiros.html");
	
	$tpl->TITULO    = "Nossos parceiros";
	$tpl->TEXT_MORE = "Mostrar mais";

	$result = mysql_query("SELECT * FROM site_parceiros ORDER BY ID DESC");
	while($linha = mysql_fetch_array($result)){
		$tpl->NOME = $linha["nome"];
		$tpl->LOGO = $linha["logo"];
		$tpl->SITE = $linha["site"];
		$tpl->block("BLOCK_PARCEIROS");
	}

	$tpl->show();

	require_once("footer.php");
?>