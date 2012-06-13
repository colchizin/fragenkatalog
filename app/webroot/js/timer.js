function addTimer(par, className) {
	var timer = $('<div class="' + className + '"></div>')
		.addClass('timer')
		.append($('<span class="timer-hours">00</span>'))
		.append($('<span class="separator">:</span>'))
		.append($('<span class="timer-minutes">00</span>'))
		.append($('<span class="separator">:</span>'))
		.append($('<span class="timer-seconds">00</span>'))
	;
	$(par).append(timer);

	var startTime = new Date();
	var minutes = 0;
	var hours = 0;

	setInterval(function() {
		var time = new Date();
		var seconds =  time.getSeconds() - startTime.getSeconds();
		if (seconds < 0)
			seconds += 60;
		if (seconds == 0)
				minutes++;
		if (minutes == 60) {
			minutes = 0;
			hours++;
		}

		timer.children('.timer-hours').text((hours<10)?"0"+hours:hours);
		timer.children('.timer-minutes').text((minutes<10)?"0" + minutes : minutes);
		timer.children('.timer-seconds').text((seconds<10)? "0" + seconds : seconds);
	},
	1000);
}
