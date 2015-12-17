<?php
	
	function requiredField($field, $nomeExib, $formName)
	{
		if(@$_POST["$field"] == false)
		{
			echo jsScript('$(".'.$formName.' .input-'.$field.' input").focus();');
			echo sweetAlert("Atenção!", "Por favor, preencha o campo (<strong>$nomeExib</strong>).", "error");
			exit;
		}
	}

	function requiredEmail($field, $formName)
	{

		if($_POST["$field"] == false)
		{
			echo jsScript('$(".'.$formName.' .input-'.$field.' input").focus();');
			echo sweetAlert("Atenção!", "Por favor, preencha o e-mail.", "error");
			exit;
		}
		elseif(filter_var($_POST["$field"], FILTER_VALIDATE_EMAIL) == false)
		{
			echo jsScript('$(".'.$formName.' .input-'.$field.' input").focus();');
			echo sweetAlert("Atenção!", "Por favor, preencha um e-mail válido.", "error");
			exit;
		}
	}

	function requiredTextarea($field, $nomeExib, $formName)
	{
		if(@$_POST["$field"] == false)
		{
			echo jsScript('$(".'.$formName.' .input-'.$field.' textarea").focus();');
			echo sweetAlert("Atenção!", "Por favor, preencha o campo ($nomeExib).", "error");
			exit;
		}
	}

	function passwordComparer($pass, $pass2, $formName)
	{
		if(@$_POST["$pass"] <> @$_POST["$pass2"])
		{
			echo sweetAlert("Atenção!", "As senhas digitadas não conferem.", "warning");
			exit;
		}
	}
?>