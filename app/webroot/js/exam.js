var scrollcontainer;
var questions_total = 0;
var questions_correct = 0;
var time_start = new Date();
var time_end;

function checkAll() {
	questions_total = $('.question').get().length;
	questions_correct = 0;
	$('.answers').each(check);
	time_end = new Date();
	showStatistics();
}


/*
 * Überprüft eine einzelne Frage
 */
function check(i,v) {
	var q = $(v);
	q.children('.answer').each(function (idx,elem) {
		// Für jede Antwortmöglichkeit der Frage
		var a = $(elem);
		a.removeClass('wrong correct');
		var inp = a.find('input');
		if (a.attr('data-correct')=='true') {
			a.addClass('correct');
			if (inp.attr('checked'))
				questions_correct++;
		} else if (inp.attr('checked')) {
			a.addClass('wrong');
		}
		inp.attr('disabled',true);
	});
}

// Zeit die Lösung, Kommentare und Materialien einer einzelnen Frage an
function showQuestionDetails(question) {
	question.find('.answers').each(check);
	question.find('.comments').show();
	question.find('.materials').show('fast');
}

function showComments() {
	$('.comments').show();
	$('.materials').show();
}

function previousQuestion() {
//	alert('nextQuestion');
	var currentQuestion = $('div.question.current');
	if (currentQuestion.get().length == 0) {
		currentQuestion = $('div.question:first');
		currentQuestion.addClass('current');
	} else {
		var prevQuestion = currentQuestion.prev('div.question');
		if (prevQuestion.get().length > 0) {
			currentQuestion.removeClass('current');
			prevQuestion.addClass('current');
			currentQuestion = prevQuestion;
		}
	}
	scrollToQuestion(currentQuestion);
}

function nextQuestion() {
//	alert('nextQuestion');
	var currentQuestion = $('div.question.current');
	if (currentQuestion.get().length == 0) {
		currentQuestion = $('div.question:first');
		currentQuestion.addClass('current');
	} else {
		var nextQuestion = currentQuestion.next('div.question');
		if (nextQuestion.get().length > 0) {
			currentQuestion.removeClass('current');
			nextQuestion.addClass('current');
			currentQuestion = nextQuestion;
		}
	}
	scrollToQuestion(currentQuestion);
}

function setCurrentQuestion(question) {
	var currentQuestion = $('div.question.current');
	if (currentQuestion.get().length != 0) {
		currentQuestion.removeClass('current');
	}

	currentQuestion = question;
	currentQuestion.addClass('current');
}

function scrollToQuestion(q) {
	if (scrollcontainer.get(0).tagName == 'BODY') {
	
		scrollcontainer.scrollTop(q.offset().top-30);
	} else {
		scrollcontainer.scrollTop(q.position().top+scrollcontainer.scrollTop()-30);
	}
}


function selectAnswer(index) {
	currentQuestion = $('div.question.current');
	if (currentQuestion.get().length>0) {
		var children = currentQuestion.find("input[type=radio]");
		if (index >= children.get().length)
			return;
		select(children[index]);
		console.log('Antwort ' + index + ' ausgewählt');
	}
}

function select(c) {
	//$(c).attr('checked','checked');
	$(c).click();
	$(c).click();
}

function getTimePassed() {
	var result = "";
	var seconds = time_end.getSeconds() - time_start.getSeconds();
	var minutes = roundDown(seconds/60);
	seconds = seconds - minutes*60;
	if (minutes > 0)
		result += minutes + "min ";
	if (seconds > 0)
		result += seconds + "s ";
	return result;
}

function roundDown(i) {
	return i-(i%1);
}

function showStatistics() {
	var s = $('#statistics');
	var time_passed = getTimePassed();
	s.empty();
	s.append($('<dt>Insgesamt</dt><dd>' + questions_total + '</dd>'));
	s.append($('<dt>Korrekt</dt><dd>' + questions_correct + '</dd>'));
	s.append($('<dt>Anteil</dt><dd>' + ((questions_correct/questions_total)*100) + '%</dd>'));
	s.append($('<dt>Zeit</dt><dd>' + time_passed + '</dd>'));
	s.show();
}


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
			.attr('placeholder', 'Fragestellung')
			.keydown(function(ev) {
				switch (ev.which) {
					case 8:
						// Wenn das Feld leer ist und Backspace betätigt wird,
						// dann wird die Frage gelöscht
						if (this.value == "" && confirm('Frage löschen?')) {
							removeQuestion($(this).parent());
							return false;
						}
						break;
				}
			})
		)
		.append($('<textarea>'+attachment+'</textarea>')
			.attr('name', namebase + '[attachment]')
			.attr('placeholder', 'Anhang (z.b. ein Bild oder eine Tabelle)')
		)
		.append($('<input type="hidden" value="'+question_id+'" name="'+namebase + '[id]" />'))
		.append($('<div class="answers"></div>'))
		.appendTo($('div.questions'))
		.append($('<button>Antwort hinzufügen</button>')
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
		.append($('<label>Richtige Antwort</label>')
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

var viewModeSingle = true;

function toggleViewmode() {
	viewModeSingle = !viewModeSingle;
	switchViewmode(viewModeSingle);	
}	


