function __(s) {
	if (typeof(i18n) != 'undefined' && i18n[s]) {
		if (arguments.length > 1)
			return sprintf(i18n[s], arguments);
		return i18n[s];
	}

	return s;
}

function sprintf(s, args) {
	if (!args)
		args = arguments;
	var bits = s.split('%');
	var out = bits[0];
	var re = /^([ds])(.*)$/;
	for (var i=1; i<bits.length; i++) {
		p = re.exec(bits[i]);
		if (!p || args[i]==null) continue;
		if (p[1] == 'd') {
			out += parseInt(args[i], 10);
		} else if (p[1] == 's') {
			out += args[i];
		}
		out += p[2];
	}
	return out;
}
