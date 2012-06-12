$(document).ready(function() {
	$('#UserPassword, #UserPasswordConfirm')
		.change(confirmPassword)
		.keyup(confirmPassword);
	$('#UserRegisterForm').submit(function() {
		if (!confirmPassword())
			return false;
	});
});

function confirmPassword() {
	if ($('#UserPassword').attr('value') != $('#UserPasswordConfirm').attr('value')) {
		$('#PasswordWrong').show('normal');
		return false;
	} else {
		$('#PasswordWrong').hide('normal');
		return true;
	}
}
