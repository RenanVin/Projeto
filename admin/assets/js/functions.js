$(document).ready(function(){

	// Style PHP ucWords in JavaScript
	$(".ucWordsJs").keyup(function(){
		var txt = $(this).val();
		$(this).val(txt.replace(/^(.)|\s(.)/g, function($1){ 
			return $1.toUpperCase( ); 
		}));
	});

	// Tooltip bootstrap
	$('[data-toggle="tooltip"]').tooltip({
		html : true
	});

	$('[data-toggle="popover"]').popover({
		html : true
	});

	// Masks
	$(".maskTelefones").mask("(99) 9999-9999?9");
	$(".maskHorarioAtendimento").mask("99h às 99h");
	$(".maskCeps").mask("(99) 9999-9999?9");

});

function sweetRedir(titulo, msg, tipo, url, btnText)
{
	if(tipo == "error")
	{
		var btnColor = "#F27474";
	}
	else if(tipo == "success")
	{
		var btnColor = "#A5DC86";
	}
	else if(tipo == "warning")
	{
		var btnColor = "#F8C086";
	}

	swal({
		title : titulo,
		text  : msg,
		type  : tipo,
		confirmButtonColor : btnColor,
		confirmButtonText  : btnText,
	}, function() {
		location.href= url; 
	});
}

function sweetAlert(titulo, msg, tipo, btnText)
{
	if(tipo == "error")
	{
		var btnColor = "#F27474";
	}
	else if(tipo == "success")
	{
		var btnColor = "#A5DC86";
	}
	else if(tipo == "warning")
	{
		var btnColor = "#F8C086";
	}

	if(btnText != "")
	{
		var textBtn = btnText;
	}
	else
	{
		var textBtn = "Voltar";
	}

	swal({
		title : titulo,
		text  : msg,
		type  : tipo,
		confirmButtonColor : btnColor,
		confirmButtonText  : textBtn,  
		}, 
	function(){ 
		swal.close;
	});
}

// All letters to uppercase
function upCase(lstr)
{
	var str = lstr.value;
	lstr.value = str.toUpperCase();
}

// All letters to lowcase
function lowCase(lstr)
{
	var str = lstr.value;
	lstr.value = str.toLowerCase();
}

function upCase(lstr)
{
	var str = lstr.value;
	lstr.value = str.toUpperCase();
}

// Dependency System.bootbox.js
function confirmBox(msg, destino)
{
	bootbox.confirm(msg, function(result) {
		if(result == true)
		{
			location.href = destino;
			return true;
		}
	}); 
}

// Dependency System.bootbox.js
function alertBox(msg)
{
	bootbox.alert(msg);
}