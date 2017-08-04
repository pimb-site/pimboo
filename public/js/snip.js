$(document).ready(function() {
	$("#form_create_snip").keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
		});
});

function isValidURL(str) {
   var a  = document.createElement('a');
   a.href = str;
   return (a.host && a.host != window.location.host);
}

$(".input-snip input").on("change", function() {
	var url = $(this).val();

	if(isValidURL(url)) {
		$('.create-snip .input-snip img').css({'display': 'block'});
		$('.create-snip .input-snip input').css({'border': '2px solid #b7c3d9'});
		$(".create-snip .button-snip button, #down_snip").removeAttr("disabled");
	} else {
		$('.create-snip .input-snip img').css({'display': 'none'});
		$('.create-snip .input-snip input').css({'border': '1px solid red'});
		$(".create-snip .button-snip button, #down_snip").attr("disabled");
	}
});

$(".button-snip button, #down_snip").click(function() {
    $('#form_create_snip').ajaxSubmit({
        dataType: "json",
        error: function(){
	        alert('URL unanvaible');
	    },
        success: function (data) {
        	if(data.success == true) {
        		url = "/success"+data.link;
				$( location ).attr("href", url);
        	}
        	else {
        		alert(data.errorText);
        	}
        },
        timeout: 3000 // sets timeout to 3 seconds
    });
});