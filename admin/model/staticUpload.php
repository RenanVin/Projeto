<?php
	
	// Classe dos paranauê
	@require_once('model/canvas.php');

	extract($_POST);

	if(@router(2) == false)
	{
		exit;
	}

	$cond = router(2);

	// Pasta onde será enviada as fotos
	$pasta     = "../uploads/static/";
	$tipoCorte = $format;
	$qualidade = 100;

	if(!@$_FILES['filesData'])
	{
		echo '<script>swal("Erro!", "Você deve preencher ao menos uma foto.", "error");</script>';
		exit;
	}

	foreach($_FILES['filesData']['tmp_name'] as $key => $tmp_name)
	{
		$fileName = time().$_FILES["filesData"]["name"][$key];
		$fileTmp  = $_FILES["filesData"]["tmp_name"][$key];

		move_uploaded_file($fileTmp, $pasta.$fileName);

		// Verifica se a imagem é menor que o limite máximo, mantem a largura original.
		$realWidth = getImageDimens($pasta.$fileName, "largura");
		if($realWidth < $maxWidth)
		{
			$imageWidth = $realWidth;
		}
		else
		{
			$imageWidth = $maxWidth;
		}

		// Manipula a foto principal
		$img = new canvas();
		$img->carrega($pasta.$fileName);
		$img->redimensiona($imageWidth, 0, $tipoCorte);
		$img->grava($pasta.$fileName, $qualidade);

		// Se solicitado, envia thumb manipulada
		if($thumbs == "Sim")
		{
			$oThumb = new canvas();
			$oThumb->carrega($pasta.$fileName);
			$oThumb->redimensiona($thumbW, $thumbH, $thumbCorte);
			$oThumb->grava($pasta."thumb-".$fileName, $qualidade);
		}

		insert(
			array("cond", "foto"),
			array($cond, $fileName),
			"site_static_fotos"
			);
	}
?>

	<script>
		sweetRedir("Sucesso", "Fotos enviadas com sucesso.", "success", "<?php echo CP; ?>/view/static/<?php echo $cond; ?>", "Voltar");
	</script>

<?php
	exit;
?>