$(document).ready(function () {
	$("#register-submit").on('click', function() {
		var jqxhr = $.post( "/register", { name: $("#register_first_name").val(), email: $("#register_email").val(), password: $("#register_password").val(), password_confirmation: $("#register_confirm_password").val(), _token: $("#register_token").val() })
		jqxhr.always(function( data ) {
			if (jqxhr.status == 422) {
				json = JSON.parse(jqxhr.responseText);
				$( "#register-modal .modal-body .form .alerts" ).html( '' );
				$.each( json ,function( key, value ) {
				  $( "#register-modal .modal-body .form .alerts" ).append( '<div class="alert">' + value +  '</div>' );
				});
			}
			if (jqxhr.status == 200) {
				window.location.href = "/home"
			}
		});
	});
});