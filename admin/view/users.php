<?php 
	@require_once("header.php"); 

	$sql	= mysql_query("SELECT * FROM sys_admin ORDER BY nome ASC");
	$result = mysql_num_rows($sql);
?>

<?php 
	// Ativa o datatable apenas se o total for maior que 5 registros
	if($result > 5): 
?>
<script>
	$(document).ready(function() {
		$('#tableList').dataTable( {
			columnDefs: [{ type: 'chinese-string', targets: 0 }]
		});
	});
</script>
<?php endif; ?>

<div class="container">
	
	<div class="row">
		<div class="col-md-6 text-left">
			<h1>ADMINISTRADORES DO SISTEMA</h1>
		</div>
		<div class="col-md-6 text-right">
			<a href="javascript:;" data-toggle="modal" data-target="#inserirModal" class="btn btn-success btn-sm anima"><i class="fa fa-plus-circle"></i> CADASTRAR NOVO</a>
		</div>
	</div>
	<hr />
	
	<?php
	if($result > 0):
	?>
	<table id="tableList" class="table table-striped table-hover" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Nome</th>
				<th>E-mail</th>
				<th>Status</th>
				<th class="text-right">Ação</th>
			</tr>
		</thead>
		<?php 
		if($result > 5): 
		?>
		<tfoot>
			<tr>
				<th>Nome</th>
				<th>E-mail</th>
				<th>Status</th>
				<th class="text-right">Ação</th>
			</tr>
		</tfoot>
		<?php endif; ?>
	   	<tbody>
	   		<?php
	   		while($ln = mysql_fetch_object($sql)):
	   		?>
			<tr>
				<td><?php echo $ln->nome; ?></td>
				<td><?php echo $ln->email; ?></td>
				<td><?php echo $ln->status; ?></td>
				<td class="text-right">
					<a href="" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Editar</a>
					<a href="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Deletar</a>
				</td>
			</tr>
			<?php
			endwhile;
			?>
		</tbody>
	</table>
	<?php
	else:
		echo '
			<br />
			<div class="alert text-center alert-info">
				Nenhum registro cadastrado para ser exibido.
			</div>
		';
	endif;
	?>
</div>

<div class="modal fade" id="inserirModal" tabindex="-1" role="dialog" aria-labelledby="inserirLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="inserirLabel">Cadastrar novo</h4>
			</div>
			<form name="formInsert" class="formInsert" method="post" action="#">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group input-nome">
								<input type="text" name="nome" class="form-control input-sm" placeholder="Nome">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group input-email">
								<input type="text" name="email" class="form-control input-sm" placeholder="E-mail">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group input-password">
								<input type="password" name="password" class="form-control input-sm" placeholder="Senha">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group input-passwordRep">
								<input type="password" name="passwordRep" class="form-control input-sm" placeholder="Repita a senha">
							</div>
						</div>
						<div class="col-md-12 result"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-sm btn-send"><span class="fa fa-floppy-o"></span> SALVAR</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		function sendPost(formName, btnSend, btnText, url, icon)
		{
			var enviando = 0;
			$("."+formName+" ."+btnSend).attr("disabled", "true");
			$("."+formName+" ."+btnSend).html("Processando... <span class='fa fa-spinner fa-spin'></span>");

			if(enviando == 0){ 
				enviando = 1;

				$("."+formName).ajaxSubmit({
					url     : url+"/"+formName,
					type    : "POST",
					success : function(data){ 
						$("."+btnSend).html('<span class="'+icon+'"></span> '+btnText);
						$("."+formName+" ."+btnSend).removeAttr("disabled");
						$("."+formName+" .result").html(data);
						enviando = 0;
					}
				});
			}

			return false;
		}

		$(".btn-send").click(function(e){
			e.preventDefault();
			sendPost("formInsert",  "btn-send",  "SALVAR", "model/users/insert",  "fa fa-floppy-o");
		});
	});
</script>
<?php
	@require_once("footer.php");	
?>