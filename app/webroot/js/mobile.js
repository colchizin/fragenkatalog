
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

