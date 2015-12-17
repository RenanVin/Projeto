<?php
	
	if(@router(2) == false)
	{
		exit;
	}

	if(router(2) == "salvar-texto")
	{
		extract($_POST);

		if(!$_POST)
		{
			exit;
		}

		// Salva cada campo por vez
		foreach($_POST as $campo => $valor)
		{	
			// O "cond" para referência no "while" será sempre o "name" do campo
			update("texto", $valor, "site_static", "WHERE cond = '$campo'");
		}

		echo sweetAlert("Sucesso!", "As informações foram atualizadas.", "success");
	}
	
	if(router(2) == "deletar-foto")
	{
		extract($_POST);

		// Captura o nome da foto
		$foto = select("site_static_fotos", "foto", "WHERE ID = '".$fotoID."'");

		// Deleta a foto
		unlink("../uploads/static/thumb-".$foto);
		unlink("../uploads/static/".$foto);

		// echo "../uploads/static/thumb-".$foto;

		// Deleta no banco
		deleteSql("site_static_fotos", "WHERE ID = '".$fotoID."'");
	}
?>