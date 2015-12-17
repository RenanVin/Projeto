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