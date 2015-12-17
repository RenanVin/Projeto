<?php
	require_once("header.php");
	
	require_once("system/template.php");
	use system\template;

	$tpl = new Template("view/contato.html");
	
	$tpl->TITULO = "Entre em contato";
	$tpl->TEXTO  = getStatic("contato_texto", "texto");

	$tpl->show();

	require_once("footer.php");
?>