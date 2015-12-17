<?php
	require_once("header.php");

	require_once("system/template.php");
	use system\template;

	$tpl = new Template("view/home.html");

	$tpl->show();

	require_once("footer.php");
?>