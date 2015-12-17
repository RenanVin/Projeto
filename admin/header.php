<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

	<link rel="shortcut icon" href="assets/img/icon.png">

	<title>Painel Administrativo</title>

	<base href="<?php echo CP; ?>/">

	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/datatables/datatables.min.js"></script>
	<script src="assets/js/datatables/chinese-string.js"></script>
	<script src="assets/js/jquery.form.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/bootbox.js"></script>
	<script src="assets/js/sweetalert2/sweetalert2.js"></script>
	<script src="assets/js/maskinput.js"></script>
	<script src="assets/js/functions.js"></script>

	
	<link href="assets/css/style.css" rel="stylesheet">
		
</head>
	
	<body>
	
	<?php
	if(session(@$_SESSION["adminID"]) == true):

		$defaultMenu = array(
			"<i class='fa fa-home'></i> Inicial"  => "view/home",
			"<i class='fa fa-archive'></i> Produtos" => array(
				"Listar produto"    => "view/seguros/lista/1",
				"Cadastrar novo"    => "view/seguros/inserir/1",
				"divider"           => "divider",
				"Categorias"        => "view/seguros/lista/1",
				"Cadastrar nova"    => "view/seguros/inserir/1"
				),
			"<i class='fa fa-plus'></i> Mais"     => array(
				"Página de contato" => "view/static/contato"
				)
		);
	?>
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Menu</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Administração</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<?php
						foreach($defaultMenu as $name => $url)
						{
							if(is_array($url))
							{
								echo '<li class="dropdown">'."\n";
									echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$name.' <b class="caret"></b></a>'."\n";
									echo '<ul class="dropdown-menu">'."\n";
										foreach($url as $subName => $subUrl)
										{
											if($subName == "divider")
											{
												echo '<li class="divider"></li>'."\n";
											}
											else
											{
												echo '<li><a href="'.$subUrl.'">'.$subName.'</a></li>'."\n";
											}
										}
									echo '</ul>'."\n";
								echo '</li>'."\n";
							}
							else
							{
								echo '<li><a href="'.$url.'">'.$name.'</a></li>'."\n";
							}
						}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="../" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Ver site"><i class="hidden-xs fa fa-external-link"></i><span class="visible-xs"><i class="fa fa-external-link"></i> Ir para o site</span></a></li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" title="Configurações" role="button" aria-haspopup="true" aria-expanded="false"><i class="hidden-xs fa fa-cogs"></i><span class="visible-xs"><i class="fa fa-cogs"></i> Configurações</span></a>
						<ul class="dropdown-menu">
							<li><a href="view/static/configuracoes"><i class="fa fa-info-circle"></i> Informações do site</a></li>
							<li><a href="view/users"><i class="fa fa-user"></i> Administradores</a></li>
							<li><a href="view/relatorios"><i class="fa fa-flag"></i> Relatórios</a></li>
						</ul>
					</li>
					<li><a href="view/logout" data-toggle="tooltip" data-placement="bottom" title="Sair"><i class="hidden-xs fa fa-sign-out"></i> <span class="visible-xs"><i class="fa fa-sign-out"></i> Sair</span></a></li>
				</ul>
			</div>
		</div>
	</nav>
	<?php
	endif;
	?>

	<header>
		<div class="bar">
			
		</div>
	</header>