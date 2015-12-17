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

});


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

// Dependency bootbox.js
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

// Dependency bootbox.js
function alertBox(msg)
{
	bootbox.alert(msg);
}