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
			<a href="" class="btn btn-success btn-sm anima"><i class="fa fa-plus-circle"></i> CADASTRAR NOVO</a>
		</div>
	</div>
	<hr />
	
	<?php
	if($result > 0):

	$colunas = array("Nome", "E-mail", "Status", "Ação");
	?>
	<table id="tableList" class="table table-striped table-hover" cellspacing="0" width="100%">
		<thead>
			<tr>
				<?php
				foreach($colunas as $val)
				{
					echo '<th>'.$val.'</th>'."\n";
				}
				?>
			</tr>
		</thead>
		<?php 
		if($result > 5): 
		?>
		<tfoot>
			<tr>
				<?php
				foreach($colunas as $val)
				{
					echo '<th>'.$val.'</th>'."\n";
				}
				?>
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
				<td class="hidden-xs"><?php echo $ln->status; ?></td>
				<td>
					<a href="" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o"></i> Editar</a>
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
				Nenhum usuário cadastrado para ser exibido.
			</div>
		';
	endif;
	?>
</div>

<?php
	@require_once("footer.php");	
?>