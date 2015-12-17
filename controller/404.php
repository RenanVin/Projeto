<?php
	require_once("system/template.php");
	use system\template;

	$tpl = new Template("view/404.html");

	$tpl->show();
?>