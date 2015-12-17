<?php	
	@require_once("header.php");

	$cond = router(2);

	$configs = array(
		"contato" => array(  // Array chave
			"title"  => "PÁGINA DE CONTATO",
			"fotos"  => array(
				"ativo"      => "Sim",  // Sim ou Nao
				"maxWidth"   => 800, // Largura máxima
				"tipoCorte"  => "proporcional", // proporcional, crop ou preenchimento
				"thumbs"     => "Sim", // Sim ou Nao
				"thumbCorte" => "crop", // proporcional, crop ou preenchimento
				"thumbW"     => 200,
				"thumbH"     => 150
				), 
			"textos" => array(
				"contato_telefone" => array(
					"nomeCampo" => "contato_telefone", 
					"nomeExib"  => "Telefone principal", 
					"require"   => true, // true ou false
					"htmlType"  => "text", // Textarea o Text
					"htmlClass" => "col-md-6",
					"aditionalClass" => "maskTelefones" // Ex: Mascáras
					),
				"contato_telefone2"  => array(
					"nomeCampo"      => "contato_telefone2", 
					"nomeExib"       => "Telefone secundário", 
					"require"        => true, // true ou false
					"htmlType"       => "text", // Textarea o Text
					"htmlClass"      => "col-md-6",
					"aditionalClass" => "maskTelefones" // Ex: Mascáras
					),
				"contato_horario"  => array(
					"nomeCampo"      => "contato_horario", 
					"nomeExib"       => "Horário de atendimento", 
					"require"        => true, // true ou false
					"htmlType"       => "text", // Textarea o Text
					"htmlClass"      => "col-md-12",
					"aditionalClass" => "maskHorarioAtendimento" // Ex: Mascáras
					)
				)
			),
		"configuracoes" => array(  // Array chave
			"title"  => "INFORMAÇÕES DO SITE",
			"fotos"  => array(
				"ativo"      => "Nao",  // Sim ou Nao
				), 
			"textos" => array(
				"configs_texto" => array(
					"nomeCampo" => "site_titulo", 
					"nomeExib"  => "Título do site", 
					"require"   => true, // true ou false
					"htmlType"  => "text", // Textarea o Text
					"htmlClass" => "col-md-12"
					),
				"configs_palavras" => array(
					"nomeCampo"   => "site_palavras", 
					"nomeExib"    => "Palavras chave", 
					"require"     => true, // true ou false
					"htmlType"    => "text", // Textarea o Text
					"htmlClass"   => "col-md-12",
					"maxCaracter" => "30"
					),
				)
			)
		);

	if(@$configs["$cond"] == false)
	{
		exit;
	}
?>

<script type="text/javascript">
	$(document).ready(function(){

		// Salvar texto
		var enviando = 0;
		$(".save-text").click(function(e){
			e.preventDefault();

			var cont = 0;

			// Validação dos campos
			$(".row-textos .col input, .row-textos .col textarea").each(function(val) {
				var require = $(this).attr("data-require");
				var name    = $(this).attr("name-exib");
				var campo   = $(this).val();

				if(require == 1 && campo == "")
				{
					$(this).focus();

					swal({
						title : "Atenção!",
						html  : "O campo (<strong>"+name+"</strong>) deve ser preenchido.",
						type  : "warning",   
						confirmButtonColor : "#F8C086",   
						confirmButtonText  :  "Fechar",   
					}, 
					function(){ 
						swal.close;
					});

					cont++;
					return false;
				}
			});

			if(cont == 0)
			{
				var formName = "formStatic";
				$("."+formName+" .save-text").addClass("disabled");
				$("."+formName+" .save-text").html("Processando... <span class='fa fa-spinner fa-spin'></span>");

				if(enviando == 0)
				{
					enviando = 1;
					$("."+formName).ajaxSubmit({
						url     : "model/static/salvar-texto/<?php echo $cond ?>",
						type    : "POST",
						success : function(data){ 
							$(".save-text").html('<span class="fa fa-floppy-o"></span> SALVAR');
							$("."+formName+" .result").html(data);
							$("."+formName+" .save-text").removeClass("disabled");

							enviando = 0;
						}
					});
				}
			}
		});

	});	
</script>

<div class="container">
	<h1><?php echo $configs["$cond"]["title"]; ?></h1>

	<div class="row row-textos">
		<form name="formStatic" class="formStatic" method="post" action="#">
			<?php
				// Edição dos textos
				foreach($configs["$cond"]["textos"] as $campos)
				{
					// Busca as informações dos campos
					$sqlDados = mysql_query("SELECT * FROM site_static WHERE cond = '".$campos["nomeCampo"]."'");

					// Verifica se o campo existe no banco. Caso não, cadastra e atualiza a página.
					if(mysql_num_rows($sqlDados) == 0)
					{
						insert(array("cond"), array($campos["nomeCampo"]), "site_static");
						header("Location: ".CP."/view/static/$cond");
					}

					$lnDados = @mysql_fetch_object($sqlDados);

					if($campos["htmlType"] == "text")
					{
						echo '
							<div style="margin-bottom: 15px;" class="'.$campos["htmlClass"].' col"">
								<div>'.$campos["nomeExib"].'</div>
								<input maxlength="'.@$campos["maxCaracter"].'" data-require="'.$campos["require"].'" name-exib="'.$campos["nomeExib"].'" name-require="'.$campos["require"].'" type="text" class="form-control '.@$campos["aditionalClass"].'" name="'.$campos["nomeCampo"].'" value="'.$lnDados->texto.'" />
							</div>
						';
					}
					else if($campos["htmlType"] == "textarea")
					{
						echo '
							<div style="margin-bottom: 15px;" class="'.$campos["htmlClass"].' col"">
								<div>'.$campos["nomeExib"].'</div>
								<textarea maxlength="'.@$campos["maxCaracter"].'" data-require="'.$campos["require"].'" name-exib="'.$campos["nomeExib"].'" class="form-control" name="'.$campos["nomeCampo"].'">'.$lnDados->texto.'</textarea>
							</div>
						';
					}
					else if($campos["htmlType"] == "select")
					{
						echo '
							<div style="margin-bottom: 15px;" class="'.$campos["htmlClass"].' col"">
								<div>'.$campos["nomeExib"].'</div>
								<select data-require="'.$campos["require"].'" name-exib="'.$campos["nomeExib"].'" class="form-control" name="'.$campos["nomeCampo"].'">
						';
						foreach($campos["typeSelect"] as $value => $campo)
						{
							echo '<option value="'.$value.'" '.(($value == $lnDados->texto) ? 'selected' : '').'>'.$campo.'</option>';
						}
						echo '
								<select>
							</div>
						';
					}
					
				}
			?>
			<div style="margin-bottom: 15px;" class="col-md-12">
				<button class="btn btn-primary btn-sm save-text"><span class="fa fa-floppy-o"></span> SALVAR</button>
			</div>
			<div class="col-md-12 result"></div>
		</form>
	</div>
	<hr />
</div>

<?php
	if(@$configs["$cond"]["fotos"]["ativo"] == "Sim"):

	$sql    = mysql_query("SELECT * FROM site_static_fotos WHERE cond = '$cond'");
	$result = mysql_num_rows($sql);
?>
<script>

$(document).ready(function(){

	// Enviar fotos // Esse método de post requer o jquery.forms
	var options = { 
		uploadProgress: function(event, position, total, percentComplete) 
		{
			// Adiciona o process bar
			$(".formStaticGaleria .result").html('<br /><div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: '+percentComplete+'%;">'+percentComplete+'%</div>');
			$(".formStaticGaleria .send-fotos").hide(0);
		},
		success: function() 
		{
			$(".formStaticGaleria .result").html('<br /><div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>');
		},
		complete: function(response) 
		{
			// Captura a respota do post
			$(".formStaticGaleria .result").html(response.responseText);
			$(".formStaticGaleria .send-fotos").show(0);
	    }
	}; 

	$(".formStaticGaleria").ajaxForm(options);

	// Deletar foto
	$(".deletar-foto").click(function(){
		// Captura o ID da foto
		var fotoID = $(this).attr("data-id");

		// Desativa o botão pra não ser clicado novamente
		$(this).addClass("disabled");

		// Elimina o TR da foto
		$(".trFoto"+fotoID).fadeOut("fast");

		// Envia o POST para ser apagado no MYSQL
		$.post("model/static/deletar-foto", {fotoID : fotoID});
	});

});
</script>

<style>
	.MultiFile-label{
		text-align: left;
		float: none;
		clear: both!important;
		margin-bottom: 5px;
		margin-top: 5px;
		padding: 10px;
		background-color: #eee;
		width: 100%;
	}

</style>

<div class="container">
	<h1>GALERIA DE FOTOS</h1>
	<hr />
		
	<div class="row">
		<div class="col-md-12 text-center">
			
			<form name="formStaticGaleria" class="formStaticGaleria" method="post" action="<?php echo CP; ?>/model/staticUpload/<?php echo $cond; ?>">

				<input type="hidden" name="maxWidth"   value="<?php echo $configs["$cond"]["fotos"]["maxWidth"]; ?>" />
				<input type="hidden" name="format"     value="<?php echo $configs["$cond"]["fotos"]["tipoCorte"]; ?>" />
				
				<input type="hidden" name="thumbs"     value="<?php echo $configs["$cond"]["fotos"]["thumbs"]; ?>" />
				<input type="hidden" name="thumbW"     value="<?php echo $configs["$cond"]["fotos"]["thumbW"]; ?>" />
				<input type="hidden" name="thumbH"     value="<?php echo $configs["$cond"]["fotos"]["thumbH"]; ?>" />
				<input type="hidden" name="thumbCorte" value="<?php echo $configs["$cond"]["fotos"]["thumbCorte"]; ?>" />
				
				<div class="row">
					<div class="col-md-12 text-center input-file">
						<input style="margin: 0 auto; margin-bottom: 15px;" name="filesData[]" type="file" multiple="multiple" class="multifile-upload multi with-preview" />
					</div>
					<div class="col-md-12" style="margin-top: 15px;">
						<button class="btn btn-primary btn-sm send-fotos"><span class="fa fa-paper-plane"></span> ENVIAR FOTOS</button>
					</div>
					<div class="col-md-12 result"></div>
				</div>			

			</form>

			<hr />
		</div>

	</div>

	<div class="row list-images">
		<?php
		while($ln = mysql_fetch_object($sql)): ?>
		<div class="col-md-3 text-center trFoto<?php echo $ln->ID; ?>" style="margin-bottom: 30px;">
			<div style="background-color: #f5f5f5; padding: 8px;">
				<img src="../thumb.php?tipo=crop&amp;w=200&amp;h=150&amp;img=uploads/static/<?php echo $ln->foto; ?>" width="100%;" alt="" />
				<a style="margin-top: 5px;" title="Deletar foto" href="javascript:;" data-id="<?php echo $ln->ID; ?>" class="btn btn-danger btn-sm deletar-foto"><span class="fa fa-trash-o"></span> Deletar</a>
			</div>
		</div>
		<?php endwhile; ?>
	</div>

</div>

<script>
	$(document).ready(function(){
		$(".multifile-upload").MultiFile({
    		max: 20,
    		accept: 'jpg|png|gif|jpeg',
    		maxfile: 7100,
  		});
	});
</script>
<script src="assets/js/upload/jquery.MetaData.js"></script>
<script src="assets/js/upload/jquery.MultiFile.js"></script>

<?php
	endif;
?>


<?php
	require_once("footer.php");	
?>
