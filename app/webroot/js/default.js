$(document).ready(function() {
	$('.xdebug-var-dump, .cake-error').append(
		$('<a>close</a>')
			.addClass('error-overlay-close')
			.click(function() {
				$(this).parent().fadeOut('fast');
			})
	).addClass('error-overlay');

});

function switchFullscreen(fullscreen) {
	if (fullscreen) {
		$('#content').addClass('full_width full_height','fast');
		$('#header').slideUp('fast');
		$('#footer').hide('fast');
	} else {
		$('#content').removeClass('full_width full_height','fast');
		$('#header').slideDown('fast');
		$('#footer').show('fast');

	}
}

function toggleFullscreen () {
	switchFullscreen($('#header').css('display')!='none');
}
