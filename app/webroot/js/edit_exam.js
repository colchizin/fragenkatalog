
function addQuestion(json) {
	var prevNr = $('.questions .question:last').attr('data-nr');
	var nr;
	if (prevNr)
		nr = parseInt(prevNr) + 1;
	else
		nr = 0;
	
	var id = "quesion_" + nr;
	var namebase = 'data[Question]['+nr+']';

	var question = "";
	var question_id = 0;
	var attachment = "";
	var answers = null;

	if (json) {
		question_id = json.id;
		question = json.question;
		attachment = json.attachment;
		answers = json.Answer;
	}

	var div = $('<div></div>')
		.attr('id',id)
		.attr('data-nr',nr)
		.addClass('question input')
		.append($('<textarea>'+question+'</textarea>')
			.attr('name',namebase + '[question]')
			.attr('placeholder', __('Question'))
			.keydown(function(ev) {
				switch (ev.which) {
					case 8:
						// Wenn das Feld leer ist und Backspace betätigt wird,
						// dann wird die Frage gelöscht
						if (this.value == "" && confirm(__('confirm remove question'))) {
							removeQuestion($(this).parent());
							return false;
						}
						break;
				}
			})
		)
		.append($('<textarea>'+attachment+'</textarea>')
			.attr('name', namebase + '[attachment]')
			.attr('placeholder', __("attachment placeholder"))
		)
		.append($('<input type="hidden" value="'+question_id+'" name="'+namebase + '[id]" />'))
		.append($('<div class="answers"></div>'))
		.appendTo($('div.questions'))
		.append($('<button>')
			.text(__('add answer'))
			.click(function() {
				addAnswer($(this).parent());
				return false;
			})
		);
	div.find('textarea:first').focus();

	if (answers && answers.length > 0) {
		$(answers).each(function(i,answer) {
			addAnswer(div, answer);
		});
	}
}

function addAnswer(question, json) {
	var qnr = question.attr('data-nr');

	// Die Nummer dieser Antwort ist die Nummer der vorherigen Antwort erhöht
	// um eins
	var prevNr = question.find('.answer:last').attr('data-nr');
	var nr;
	if (prevNr)	// es gibt eine vorige Antwort und sie hat eine Nummer
		nr = parseInt(prevNr) + 1;
	else // Erste Antwort, also Nummer 0
		nr = 0;

	var id = 'answer_' + qnr + '_' + nr;
	var namebase = 'data[Question]['+qnr+'][Answer][' + nr + ']';

	answer_id	= 0;
	answer		= "";
	correct		= false;

	if (json) {
		answer_id= json.id;
		answer = json.answer;
		correct = json.correct;
		if (correct == 'on' || correct==true || correct==1)
			correct = true;
		else
			correct = false;
	}

	var div = $('<div class="answer"></div')
		.attr('id', id)
		.attr('data-nr',nr)
		.append($('<input type="text" />')
			.attr('name', namebase + '[answer]')
			.attr('value', answer)
			.keypress(function(ev) {
				switch (ev.which) {
					case 13:
						addAnswer(question); return false;
				}
			})
			.keydown(function(ev) {
				switch (ev.which) {
					case 8:
						// Wenn das Feld leer ist und Backspace betätigt wird,
						// dann wird die Antwort gelöscht
						if (this.value == "") {
							removeAnswer($(this).parent());
							return false;
						}
						break;
				}
			})
		)
		.append($('<input type="hidden" value="'+answer_id+'" name="'+namebase + '[id]" />'))
		.append($('<input type="checkbox" />')
			.attr('name', namebase + '[correct]')
			.attr('id', id + '_correct')
			.attr('checked', correct)
		)
		.append($('<label>')
			.text(__('correct answer'))
			.attr('for', id + '_correct'))
		.appendTo(question.children('.answers'));
	div.find('input[type=text]').focus();
}

function removeQuestion(question) {
	question.prev('.question').find('textarea').focus();
	question.remove();
}

function removeAnswer(answer) {
	var prev = answer.prev('.answer');
	if (prev.get().length >0) {
		prev.find('input[type=text]').focus();
	} else {
		answer.parents('.question').find('textarea').focus();
	}
	answer.remove();
}

function switchViewmode(a) {
	if (a) {
		$('.question').hide();
		$('.question.current').show();
	} else {
		$('.question').show();
		scrollToQuestion($('.question.current'));
	}
}
