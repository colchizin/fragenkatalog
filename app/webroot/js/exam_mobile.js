	function initializeExam() {

	}

	function onQuestionShown(index) {
		if (index > 0) {
			$('#button-previous-question').removeClass('ui-disabled');
		} else {
			$('#button-previous-question').addClass('ui-disabled');
		}

		if (index < (exam.Question.length-1)) {
			$('#button-next-question').removeClass('ui-disabled');
		} else {
			$('#button-next-question').addClass('ui-disabled');
		}
	}

	/*
	 * show the unsolved question defined by the provided index
	 */
	function showQuestionUnsolved(index) {
		var question = exam.Question[index];
		var answers = $('<fieldset class="answers"></fieldset>')
			.attr('data-role', "controlgroup")
			.attr('data-direction','vertical')
		;

		$(question.Answer).each(function(idx, elem) {
			var checked = "notchecked";
			if (elem.checked)
				checked = "checked";

			answers.append($('<div class="answer"></div>')
				.attr('data-correct', elem.correct)
				.append($('<input type="radio"></input>')
					.click(function(e) {
						questionSetAnswer(index, idx);
					})
					.attr('name','question_' + question.id) 
					.attr('id', 'answer_' + elem.id)
					.attr(checked, checked)
					.val(idx)
				)
				.append($('<label></label>')
					.attr('for', 'answer_' + elem.id)
					.text(elem.answer)
				)
			);
		});

		$('#question')
			.append($("<p class='question-text'></p>")
				.append($('<span class="counter"></span>')
					.text((index+1) + ". ")
				)
				.append(question.question)
			)
			.append($("<p class='question-attachment'></p>").html(question.attachment))
			.append(answers);
		;
		answers.find('input[type=radio]').checkboxradio();
		answers.controlgroup();
		$('#button-show-solution').removeClass('ui-disabled');
	}

	function showQuestionSolved(index) {
		var question = exam.Question[index];
		var answers = $('<ul class="answers"></ul>').attr('data-inset',true);	
		
		$(question.Answer).each(function (idx, answer) {
			var li = $("<li class='answer'></li>")
				.append($("<span class='answer-text'></span>")
					.html(answer.answer)
				)
			;
			if (answer.checked) {
				li.addClass('checked');
				if (!answer.correct)
					li.addClass('wrong');
			}
			if (answer.correct)
				li.addClass('correct');

			var comments = $("<div class='comments'></div>").appendTo(li);
			$(answer.Comment).each(function (i, comment) {
				// Append comment to comments-div
				appendComment(comments,comment);
			});
			answers.append(li);
		});
		var comments = $('<div class="comments"></div>');
		$(question.Comment).each(function (idx, comment) {
			// Append comment to comments-div
			appendComment(comments,comment);
		});
		var materials = $('<ul class="materials"></ul>');
		$(question.Material).each(function (idx, material) {
			materials.append($('<li class="material"></li>')
				.append($('<a></a>')
					.text(material.title)
					.attr('href', '/fragenkatalog/materials/view/' + material.id)
				)
			);
		});

		$('#question')
			.append($("<p class='question-text'></p>")
				.append($('<span class="counter"></span>')
					.text((index+1) + ". ")
				)
				.append(question.question)
			)
			.append($("<p class='question-attachment'></p>").html(question.attachment))
			.append(answers)
			.append(comments)
			.append(materials)
		;
		answers.listview();
		materials.listview({inset:true});
		$('#button-show-solution').addClass('ui-disabled');
	}

	function showIndex() {
			$.mobile.changePage('#question-index');
	}


	function appendComment(target,comment) {
		target.append($("<p class='comment'></p>")
			.html(comment.comment)
			.append($("<span class='comment-author'></span>")
				.text((comment.User.username) ? comment.User.username : "unbekannt")
			)
		);
	}

	/*
	 * called whenever an answer is selected.
	 * sets the corresponing answer of the current question as checked and
	 * sets the 'answered'-property of the current question to true. Finally
	 * submits the answer to the server
	 */
	function onAnswerChanged(question_index, answer_index) {
		$('#question-index-list-' + question_index).addClass('answered');
	}

	/*
	 * sets the 'solved'-property of the current question to true and rebuilds
	 * the question view
	 */
	function showSolution() {
		exam.Question[currentQuestionIndex].solved = true;
		showQuestion(currentQuestionIndex);
		if (isQuestionAnsweredCorrectly(currentQuestionIndex)==0)
			$('#question-index-list #question-index-list-' + currentQuestionIndex).addClass('wrong');
	}

	/*
	 * sets the 'solved'-property of all questions to trueand rebulds the
	 * question view
	 */
	function showAllSolutions() {
		$(exam.Question).each(function(idx, question) {
			question.solved = true;

			if (isQuestionAnsweredCorrectly(idx)==0)
				$('#question-index-list #question-index-list-' + idx).addClass('wrong');
		});
		showQuestion(currentQuestionIndex);
		showStatistics();
	}


	/*
	 * creates the index of the questions. Answered questions are marked with
	 * the corresponding css class
	 */
	function buildIndex() {
		$('#question-index').remove();
		$("body").append($("<div data-role='page' id='question-index'></div>")
			.append($("<div data-role='header'></div>")
				.append($("<h1>Fragen</h1>"))
			)
			.append($("<div data-role='content'></div>")
				.append($("<ul data-role='listview' id='question-index-list'></ul>"))
			)
		);
		var qi = $('#question-index');
		var qil = $('#question-index-list');
		$(exam.Question).each(function(idx, question) {
			var li = $("<li></li>")
				.append($('<a></a>')
					.click(function() {
						$.mobile.changePage('#page-main');
						showQuestion(idx);
					})
					.text((idx+1) + ". " + question.question)
				)
				.attr('id', 'question-index-list-' + idx)
				.appendTo(qil)
			;
			if (question.answered) {
				li.addClass('answered');
			}
		});
		qil.trigger('create');
	}


	function selectAnswer(index) {
		if (index < exam.Question[currentQuestionIndex].Answer.length)
			$('#question input')[index].click();
	}
	

	function showStatistics() {
		var statistics = doStatistics();
		$('#dialog-statistics').remove();
		$('<div data-role="dialog" id="dialog-statistics"></div>')
			.append($('<div data-role="header"><h1>Statistik</h1></div>'))
			.append($('<div data-role="content"></div>')
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
				.append("<p>Ein Frage gilt als <strong>gültig</strong>, wenn es genau <strong>1</strong> als korrekt eingetragene Antwortmöglichkeit gibt. Das Ergebnis berücksichtigt nur gültige Fragen.</p>")
			)
			.appendTo('body')
			.dialog();
		$.mobile.changePage('#dialog-statistics', 'slide-down', true, true);
	}
