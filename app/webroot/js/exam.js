var scrollcontainer;
var questions_total = 0;
var questions_correct = 0;
var time_start = new Date();
var time_end;
var finished = false;

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

function showCommentField(target) {
	var field = $('#comment-field');
	field.hide();
	field.appendTo(target);
	field.slideDown('fast');
}

function hideCommentField() {
	$('#comment-field').hide('fast');
}	

function submitComment() {
	var field = $('#comment-field');
	deactivateElement(field);
	if (field.parents('.answer').get().length > 0) {
		var par = field.parents('.answer');
		$.ajax({
			url : '/fragenkatalog/answers_comments/add/useRH:true/.json',
			type: 'POST',
			data: {
				'AnswersComment' : {
					'answer_id' : par.attr('data-id'),
				},
				'Comment' : {
					'comment' : field.find('textarea').val()
				}
			},
			success: function(data) {
				onCommentSubmitted(data,par.find('.comments'));
			}
		});
	} else if (field.parents('.question').get().length > 0) {
		var par = field.parents('.question');
		$.ajax({
			url : '/fragenkatalog/questions_comments/add/useRH:true/.json',
			type: 'POST',
			data: {
				'QuestionsComment' : {
					'question_id' : par.attr('data-id'),
				},
				'Comment' : {
					'comment' : field.find('textarea').val()
				}
			},
			success: function(data) {
				onCommentSubmitted(data,par.children('.comments'));
			}
		});
	} else {
		alert('Ungültige Geschichte');
		reactivateElement(field);
	}
}

function onCommentSubmitted(data, target) {
	var field = $('#comment-field');

	console.log(data);

	examAddComment(data, target);

	$(field).find('textarea').val("");
	reactivateElement(field);
	$(field).slideUp('fast');
}

function examAddComment(comment, target) {
	$("<p class='comment'></p>")
		.text(comment.Comment.comment + " ")
		.append($('<span class="comment-author"></span>')
			.text(comment.Comment.User.username)
		)
		.appendTo(target);
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
	updateQuestionCounter();
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
	updateQuestionCounter();
}

function setCurrentQuestion(question) {
	var currentQuestion = $('div.question.current');
	if (currentQuestion.get().length != 0) {
		currentQuestion.removeClass('current');
	}

	currentQuestion = question;
	currentQuestion.addClass('current');
	updateQuestionCounter();
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



var viewModeSingle = true;

function toggleViewmode() {
	viewModeSingle = !viewModeSingle;
	switchViewmode(viewModeSingle);	
}	

function updateQuestionCounter() {
	var answeredQuestionsCount = $('.question input:checked').get().length;
	questions_total = $('.question').get().length;
	$('#questions-answers-count').text(answeredQuestionsCount);
	$('#questions-total-count').text(questions_total);

	// Alle Fragen beantwortet, Sitzung beeendet
	if (answeredQuestionsCount == questions_total) {
		finishSession();
	}
}

function addQuestionCounter(el, className) {
	$('<div class="' + className + '"></div>')
		.append("Frage ")
		.append($('<span id="questions-answers-count">0</span>'))
		.append(" von ")
		.append($('<span id="questions-total-count">0</span>'))
		.appendTo($(el));
}

function submitAnswer(question_id, answer_id) {
	$.ajax({
		url:"/fragenkatalog/examsessions_questions/add_or_save/useRH:true.json",
		type:"POST",
		data: {'ExamsessionsQuestion' : { 
			'answer_id' : answer_id,
			'question_id' : question_id
		}},
		complete: function(jqXHR, textStatus) {
		}
	});
}

function finishSession() {
	if (!finished) {
		$.ajax({
			url:"/fragenkatalog/examsessions/finish/useRH:true.json",
			type:"POST",
			complete: function (jqXHR, textStatus) {
			}
		});
		finished = true;
		alert("Fertig!");
	}
}

$(document).ready(function() {
	$('#textarea-comment').keydown(function(e) {
		//e.preventDefault();
		e.stopPropagation();
	});
});
