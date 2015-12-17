<?php
	include_once("header.php");

	if(session(@$_SESSION["adminID"]) == true)
	{
		redirPHP(CP."/view/home");
	}
?>
<div class="container login">
	<div class="logo">
		<img src="assets/img/logo-login.png" alt="Logo" />
	</div>
			
	<div class="content">
		<form name="formLogin" class="formLogin" method="post" action="#">
			<input name="nosp" type="hidden" value="" />

			<div class="form-group input-email">
				<input type="text" class="form-control" name="email" placeholder="E-mail" />
			</div>

			<div class="form-group input-password">
				<input type="password" class="form-control" name="password" placeholder="Senha" />
			</div>
									
			<button class="btn btn-primary send-login">
				<span class="fa fa-sign-in"></span> 
				ENTRAR
			</button>
					
			<a href="javascript:;" data-toggle="modal" data-target="#modalForgot">Esqueceu sua senha?</a>
					
			<div class="result"></div>
					
		</form>	
	</div>

</div>		
		
<div class="modal fade" id="modalForgot" tabindex="-1" role="dialog" aria-labelledby="modalForgotLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h1 class="modal-title" id="modalForgotLabel">Esqueceu sua senha?</h1>
			</div>
			<div class="modal-body">
					
				<p>Para redefinir sua senha, digite o e-mail que você utiliza para acessar sua conta.</p>

				<form class="formForgot" name="formForgot" method="post" action="#">
					<input name="nosp" type="hidden" value="" />
							
					<div class="form-group input-emailForgot">
						<input type="text" class="form-control" name="emailForgot" placeholder="E-mail" />
					</div>
							
					<img src="../system/captcha/captcha.php" id="captcha" onclick="captchaReload();" title="Clique para alterar a imagem" />					
					<a href="javascript:;" title="Atualizar imagem" onclick="captchaReload();"><span class="glyphicon glyphicon-refresh"></span> Alterar a imagem</a>
					<div class="form-group input-codigoForgot has-feedback form-group-sm">
						<input type="text" class="form-control" name="codigoForgot" placeholder="Código" style="width: 150px;" />
					</div>

					<button class="btn btn-primary btn-sm send-forgot">
						<span class="fa fa-paper-plane"></span> 
						ENVIAR
					</button>

					<div class="result"></div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
					<span class="fa fa-times-circle"></span>
					FECHAR
				</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		function loginPost(formName, btnSend, btnText, url, icon)
		{
			var enviando = 0;
			$("."+formName+" ."+btnSend).attr("disabled", "true");
			$("."+formName+" ."+btnSend).html("Processando... <span class='fa fa-spinner fa-spin'></span>");

			if(enviando == 0){ 
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
			}

			return false;
		}

		$(".send-login").click(function(e){
			e.preventDefault();
			loginPost("formLogin",  "send-login",  "ENVIAR", "model/login/logar",  "fa fa-sign-in");
		});

		$(".send-forgot").click(function(e){
			e.preventDefault();
			loginPost("formForgot", "send-forgot", "ENVIAR", "model/login/forgot", "fa fa-paper-plane");
		});
	});

	function captchaReload()
	{
		document.getElementById("captcha").src="../system/captcha/captcha.php?"+Math.random(); 
		document.getElementById("codigoForgot").focus();
	}
</script>

<?php
	include_once("footer.php");
?>