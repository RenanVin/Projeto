<?php 
	include_once ('system/class.thumb.php');

	// @tipo = fill ou crop

	if(isset($_GET["tipo"]))
	{
		$img     = $_GET["img"];
		$largura = $_GET["w"];
		$altura  = $_GET["h"];
		$oImg    = new m2brimagem($img);
		$valida  = $oImg->valida();
			
		if($valida == 'OK')
		{
			$oImg->rgb( 255, 255, 255 );
			$oImg->redimensiona($largura, $altura, $_GET["tipo"]);
			$oImg->grava();
		}
		else
		{
			die($valida);
		}
		exit;
	} 
?>