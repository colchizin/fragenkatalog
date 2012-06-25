
	/*
	 * the exam-object as provided by the server
	 */
	var exam;

	/*
	 * the index of the currently displayed question
	 */
	var currentQuestionIndex = 0;

	/*
	 * stores wheter the exam has already been finished
	 */
	var finished = false;

	/*
	 * Show the question defined by the provided index.
	 * If the solution for the question has already been shown, show the
	 * solution.Otherwise, show the unsolved question.
	 */
	function showQuestion(index) {
		if (index >= exam.Question.length) {
			throw "Array Index out of bounds";
		}

		currentQuestionIndex = index;
		$('#question').empty();

		if (exam.Question[index].solved) {
			showQuestionSolved(index);
		} else {
			showQuestionUnsolved(index);
		}

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
						onAnswerChanged(index,idx);
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

	function questionSetAnswer(question_index, answer_index) {
		var question = exam.Question[question_index];
		question.answered = true;
		for (var i=0;i<question.Answer.length;i++) {
			if (i==answer_index)
				question.Answer[i].checked = true;
			else
				question.Answer[i].checked = false;
		}
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
		questionSetAnswer(question_index, answer_index);
		$('#question-index-list-' + question_index).addClass('answered');
		submitAnswer(exam.Question[question_index].id, exam.Question[question_index].Answer[answer_index].id);
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
	 * checks wheter a question has been answered and whether it has been
	 * answered correctly.
	 * @return	1 if answered correctly, 0 if answered incorrectly and
	 * 			-1 if the question has not been answered at all
	 */
	function isQuestionAnsweredCorrectly(question_index) {
		var question = exam.Question[question_index];
		
		for (var i=0;i<question.Answer.length;i++) {
			if (question.Answer[i].checked) {
				if (question.Answer[i].correct)
					return 1;
				else
					return 0;
			}
		}
		return -1;
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

	function showNextQuestion() {
		if (currentQuestionIndex<exam.Question.length-1)
			showQuestion(currentQuestionIndex+1);
	}

	function showPreviousQuestion() {
		if (currentQuestionIndex>0)
			showQuestion(currentQuestionIndex-1);
	}

	function showNextUnansweredQuestion() {
		for (var i=0; i<exam.Question.length; i++) {
			if (!exam.Question[(i+currentQuestionIndex)%exam.Question.length].answered) {
				showQuestion((i+currentQuestionIndex)%exam.Question.length);
				return;
			}
		}
		showQuestion(0);
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

	/*
	 * Submit the Answer to the server and store it in the current exa,-session
	 */
	function submitAnswer(question_id, answer_id) {
		$.ajax({
			url:"/fragenkatalog/examsessions_questions/add_or_save.json",
			type:"POST",
			data: {'ExamsessionsQuestion' : { 
				'answer_id' : answer_id,
				'question_id' : question_id
			}},
			success: function(data) {
				console.log(data);
				updateQuestionCounter();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				if (jqXHR.status == 403) {
					alert('Sitzung abgelaufen. Neu anmelden');
					location.reload();
				} else {
					alert("Fehler: " + textStatus + " (" + errorThrown + ")");
				}
			},
		});
	}

	/*
	 * returns the count of answered questions by iterating through all
	 * questions checking whether their answered-property has been set to true
	 */
	function getAnsweredQuestionsCount() {
		var count = 0;
		for (var i=0; i<exam.Question.length;i++) {
			if (exam.Question[i].answered)
				count++;
		}
		return count;
	}

	/*
	 * Updates the Counter-Display, displaying the count of answered questions
	 * and the total question count.
	 * When all questions have been answered finishSession() is called
	 */
	function updateQuestionCounter() {
		var answeredQuestionsCount = getAnsweredQuestionsCount();
		$('#questions-answers-count').text(answeredQuestionsCount);
		$('#questions-total-count').text(exam.Question.length);

		// Alle Fragen beantwortet, Sitzung beeendet
		if (answeredQuestionsCount == exam.Question.length) {
			finishSession();
		}
	}

	function finishSession() {
		if (!finished) {
			$.ajax({
				url:"/fragenkatalog/examsessions/finish/useRH:true.json",
				type:"POST",
				success: function() {
					showAllSolutions();
					finished = true;
					alert('fertig');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					if (jqXHR.status == 403) {
						alert('Sitzung abgelaufen. Neu anmelden');
						location.reload();
					}
				}
			});
		}
	}

	function selectAnswer(index) {
		if (index < exam.Question[currentQuestionIndex].Answer.length)
			$('#question input')[index].click();
	}
	
	/*
	 * Iterates throug the Question-Array and determines, whether the questions
	 * - have been answered
	 * - have been answered correctly
	 * - are valid
	 */
	function doStatistics() {
		var result = {
			total : exam.Question.length,
			answered : 0,
			valid : 0,
			correct : 0
		};

		$(exam.Question).each(function (index, question) {
			var answers_marked_correct = 0;

			// if this question has been answered, increase the answered-count
			if (question.answered) {
				result.answered++;
			}

			// Iterate through all answers to check, whether multiple answers
			// have been marked as correct
			for (var i=0;i<question.Answer.length;i++) {
				if (question.Answer[i].correct) {
					answers_marked_correct++;
				}
			}

			// the quesiton is if only one answer has been marked as correct.
			// If this is the case, check whether the selected answer is
			// correct and increase the correct-count
			if (answers_marked_correct == 1) {
				result.valid++;

				for (var i=0;i<question.Answer.length;i++) {
					if (question.Answer[i].checked && question.Answer[i].correct) {
						result.correct++;
					}
				}
			}
		});

		return result;
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
					.append($('<dt>Korrekt</dt>'))
					.append($('<dd>' + statistics.correct + '</dd>'))
					.append($('<dt>Ergebnis</dt>'))
					.append($('<dd>' + Math.round((statistics.correct/statistics.valid)*100) + ' %</dd>'))
				)
				.append("<p>Ein Frage gilt als <strong>gültig</strong>, wenn es genau <strong>1</strong> als korrekt eingetragene Antwortmöglichkeit gibt.</p>")
			)
			.appendTo('body')
			.dialog();
		$.mobile.changePage('#dialog-statistics', 'slide-down', true, true);
	}
