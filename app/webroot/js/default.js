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
		// $('#content').get(0).webkitRequestFullScreen();
	} else {
		$('#content').removeClass('full_width full_height','fast');
		$('#header').slideDown('fast');
		$('#footer').show('fast');
		// $('#content').get(0).webkitCancelFullScreen();
	}
}

function toggleFullscreen () {
	switchFullscreen($('#header').css('display')!='none');
}

/* 
 * Legt über ein Element einen grauen Schleier, der es unbenutzbar macht und
 * signalisiert, dass hier gerade etwas passiert. Das Element muss dabei die
 * CSS-Eigenschaft 'position' auf 'relative' oder 'absolute' haben
 */
function deactivateElement(elem) {
	if (elem.length > 1) {
		elem.each(function(i,v) { deactivateElement($(v));});
	} else {
		elem.append($('<div class="deactivator"></div>')
			.hide()
			.fadeIn('slow')
		);
	}
}

function reactivateElement(elem) {
	elem.find('div.deactivator').fadeOut('slow', function() { elem.find('div.deactivatior').remove(); });
}

