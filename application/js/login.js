$(function(){
	$('#submit-login').bind('click', submitLoginForm);

	function submitLoginForm(e) {
		e.preventDefault();
		$('#login-form').validate({
			rules: {
				login: "required",
				password: "required"
			},
			messages: {
				login: "Please enter your email or login username",
				password: "Please enter your password",
			},
			errorPlacement: function(error, element) {
				errorQtip(error,element);
			}
		});
		$('#login-form').submit();
	}

});