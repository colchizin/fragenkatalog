var scrollcontainer;

function initializeExam() {
	addQuestionCounter($('#info-area'), 'info-area-element');
	updateQuestionCounter();
	buildQuestions();
	$('#textarea-comment').keydown(function(e) {
		//e.preventDefault();
		e.stopPropagation();
		switch (e.which) {
		  case 13:
			// Eingabetaste gedrückt
			// wenn NICHT zusätzlich die shift-Taste gedrückt wird, dann den
			// Kommentar abschicken
			if (!e.shiftKey)
				submitComment(); return false;
			break;
		  case 27:	// ESC-Taste
			hideCommentField(); break;	
		}
	});
}

function buildQuestions() {
	if (exam != null) {
		$(exam.Question).each(function (index, question) {
			addQuestion(index,$('#questions'));
		});
	} else {
		alert("Empty exam");
	}
}

function showQuestionSolved(index) {
	// scrollToQuestion(index);
}

function showQuestionUnsolved(index) {
	// scrollToQuestion(index);
}

function onQuestionShown(index, oldQuestionIndex) {
	scrollToQuestion(index);
	$('#question_' + exam.Question[oldQuestionIndex].id).removeClass('current');
	$('#question_' + exam.Question[index].id).addClass('current');
}

function showIndex() {

}

function buildIndex() {

}

function onAnswerChanged(question_index, answer_index) {

}

function showSolution(index) {
	exam.Question[index].solved = true;	
	$(exam.Question[index].Answer).each(function (idx, answer) {
		if (answer.correct) {
			$('#answer_' + answer.id + '_div').addClass('correct');
		}

		if (answer.checked && ! answer.correct) {
			$('#answer_' + answer.id + '_div').addClass('wrong');
		}
	});
	$('#question_' + exam.Question[index].id)
		.addClass('solved')
		.find('.answer input[type=radio]').attr('disabled',true)
	;
}

function showAllSolutions() {
	for (var i=0; i<exam.Question.length;i++) {
		showSolution(i);
	}
}

function selectAnswer(index) {
	$('#question_' + exam.Question[currentQuestionIndex].id).find('.answer input[type=radio]')[index].click();
}

function showStatistics() {
	var statistics = doStatistics();

	var dialog = getDialog(
		$('<div>')
			.append($('<h3>Ergebnisse</h3>'))
			.append($('<dl></dl>')
				.append($('<dt>Gesamt</dt>'))
				.append($('<dd>' + statistics.total + '</dd>'))
				.append($('<dt>Gültig</dt>'))
				.append($('<dd>' + statistics.valid + '</dd>'))
				.append($('<dt>Beantwortet</dt>'))
				.append($('<dd>' + statistics.answered + '</dd>'))
				.append($('<dt>Korrekt (gültig)</dt>'))
				.append($('<dd>' + statistics.correct_valid + '</dd>'))
				.append($('<dt>Korrekt (ungültig)</dt>'))
				.append($('<dd>' + statistics.correct_invalid + '</dd>'))
				.append($('<dt>Ergebnis</dt>'))
				.append($('<dd>' + Math.round((statistics.correct_valid/statistics.valid)*100) + ' %</dd>'))
			)
	);
	$('#container').append(dialog);
	dialog.show();
}

function scrollToQuestion(index) {
	q = $('#question_' + exam.Question[index].id);
	if (scrollcontainer.get(0).tagName == 'BODY') {
		scrollcontainer.scrollTop(q.offset().top-30);
	} else {
		scrollcontainer.scrollTop(q.position().top+scrollcontainer.scrollTop()-30);
	}
}

/*
 *	Comments 
 */

function showCommentField(target) {
	var field = $('#comment-field');
	field.hide();
	field.appendTo(target);
	field.slideDown('fast');
	field.find('#textarea-comment').val("").focus();
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
			url : '/fragenkatalog/answers_comments/add.json',
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
			},
			error: function(jqXHR, textStatus, errorThrown) {
				if (jqXHR.status == 403) {
					alert('Sitzung abgelaufen. Neu anmelden');
					location.reload();
				}
			}
		});
	} else if (field.parents('.question').get().length > 0) {
		var par = field.parents('.question');
		$.ajax({
			url : '/fragenkatalog/questions_comments/add.json',
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
			},
			error: function(jqXHR, textStatus, errorThrown) {
				if (jqXHR.status == 403) {
					alert('Sitzung abgelaufen. Neu anmelden');
					location.reload();
				}
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
	if (comment.Comment)
		comment = comment.Comment;

	$("<p class='comment'></p>")
		.html(comment.comment + " ")
		.append($('<span class="comment-author"></span>')
			.text(comment.User.username)
		)
		.appendTo(target);
}

function addQuestionCounter(el, className) {
	$('<div class="' + className + '"></div>')
		.append("Frage ")
		.append($('<span id="questions-answers-count">0</span>'))
		.append(" von ")
		.append($('<span id="questions-total-count">0</span>'))
		.appendTo($(el));
}

/*
 * adds the provided question to the provided target container
 */
function addQuestion(index, target) {
	var question = exam.Question[index];
	var answers = $('<fieldset class="answers"></fieldset>');
	var comments = $('<div class="comments"></div>');
	var materials = $('<div class="materials"></div>');

	$(question.Answer).each(function(idx, ans) {
		var checked = "notchecked";
		if (ans.checked)
			checked = "checked";

		var comments = $('<div class="comments"></div>');
		$(ans.Comment).each(function(idx2, comment) {
			examAddComment(comment, comments)
		});

		var answer = $('<div class="answer"></div>')
			.attr('data-id', ans.id)
			.attr('id', 'answer_' + ans.id + '_div')
			.append($('<input type="radio" />')
				.attr('name', 'question_' + question.id)
				.attr('id', 'answer_' + ans.id)
				.click(function(e) {
					questionSetAnswer(index, idx);
				})
				.attr(checked, checked)
			)
			.append($('<label></label>')
				.attr('for', 'answer_' + ans.id)
				.append($('<a>Kommentieren</a>')
					.addClass('btn-add-comment')
					.click(function() { showCommentField(comments); })
				)
				.append(ans.answer)
			)
		;
		answer.append(comments);
		answers.append(answer);
	});

	$(question.Comment).each(function (idx, comment) {
		examAddComment(comment, comments);
	});



	$(question.Material).each(function (idx, material) {
		examAddMaterial(material, materials);
	});

	$('<div class="question"></div>')
		.attr('data-id', question.id)
		.attr('id','question_' + question.id)
		.append($('<p class="question-text"></p>')
			.text((index+1) + ". " + question.question)
		)
		.append($('<p class="attachment"></p>')
			.html(question.attachment)
		)
		.append($('<a></a>')
			.text('Lösung')
			.click(function() { showSolution(index); })
			.addClass('button btn-show-solution')
		)
		.append($('<a></a>')
			.append($('<img src="/fragenkatalog/img/editor.gif"></img>')
				.attr('title','Frage bearbeiten')
			)
			.attr('title','Frage bearbeiten')
			.attr('href','/fragenkatalog/questions/edit/' + question.id)
			.attr('target', '_blank')
			.addClass('button btn-edit-question')
		)
		.addClass((question.valid) ? "valid" : "invalid")
		.append(answers)
		.append($('<a>Frage Kommentieren</a>')
			.addClass('btn-add-comment')
			.click(function() { showCommentField(comments); })
		)
		.append(comments)
		.append(materials)
		.click(function(e) {
			if (currentQuestionIndex != index)
				showQuestion(index);
		})
	.appendTo(target);
}

function getDialog(content) {
	var modal = $('<div class="dialog-modal"></div>');
	var div_content = $('<div class="dialog-modal-content"></div>')
		.append(content)
		.append($('<a class="dialog-modal-btn-close button"></a>')
			.text('close')
			.click(function() {
				modal.hide();
			})
		)
		.appendTo(modal)
	;
	return modal;
}
