<?php
	include_once("header.php");

	if(session(@$_SESSION["adminID"]) == true)
	{
		redirPHP(CP."/view/home");
	}

	if(@router(2) == false)
	{
		echo '
		<div class="container login">
			<br />
			<div class="alert text-center alert-warning">
				Token inválido ou fora do prazo de validade.
				<div>
					<a href="view/login" class="alert-link">Recupere sua senha clicando aqui</a>
				</div>
			</div>
		</div>
		';
		include_once("footer.php");
		exit;
	}

	$consulta = @mysql_fetch_object(mysql_query("SELECT * FROM sys_admin WHERE token = '".router(2)."'"));

	if($consulta == false)
	{
		echo '
		<div class="container login">
			<br />
			<div class="alert text-center alert-warning">
				Token inválido ou fora do prazo de validade.
				<div>
					<a href="view/login" class="alert-link">Recupere sua senha clicando aqui</a>
				</div>
			</div>
		</div>
		';
		include_once("footer.php");
		exit;
	}
?>
<div class="container login">
	<div class="logo">
		<img src="assets/img/logo-login.png" alt="Logo" />
	</div>
			
	<div class="content">
		<div class="text-left"><h4>Crie uma nova senha</h4></div>
		<form name="formNewPass" class="formNewPass" method="post" action="#">
			<input name="nosp" type="hidden" value="" />
			<input name="token" type="hidden" value="<?php echo router(2); ?>" />

			<div class="form-group input-password">
				<input type="password" class="form-control" name="password" placeholder="Nova senha" />
			</div>

			<div class="form-group input-passwordRep">
				<input type="password" class="form-control" name="passwordRep" placeholder="Repita senha" />
			</div>
									
			<button class="btn btn-primary send-pass">
				<span class="fa fa-pencil-square-o"></span> 
				ALTERAR SENHA
			</button>

			<a href="view/login">Voltar para login</a>
					
			<div class="result"></div>
					
		</form>	
	</div>

</div>		

<script>
	$(document).ready(function(){
		function loginPost(formName, btnSend, btnText, url, icon)
		{
			enviando = 0;
			$("."+formName+" ."+btnSend).attr("disabled", "true");
			$("."+formName+" ."+btnSend).html("Processando... <span class='fa fa-pencil-square-o'></span>");

			if(enviando == 1){ return false; }
			enviando = 1;

			$("."+formName).ajaxSubmit({
				url     : url,
				type    : "POST",
				success : function(data){ 
					$("."+btnSend).html('<span class="'+icon+'"></span> '+btnText);
					$("."+formName+" ."+btnSend).removeAttr("disabled");
					$("."+formName+" .result").html(data);
					enviando = 0;
				}
			});

			return false;
		}

		$(".send-pass").click(function(e){
			e.preventDefault();
			loginPost("formNewPass",  "send-pass",  "ALTERAR SENHA", "model/login/newPass",  "fa fa-pencil-square-o");
		});

	});
</script>

<?php
	include_once("footer.php");
?>