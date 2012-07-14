	/*
	 * the layout-specific script has to implement the following functions:
	 * showQuestionSolved
	 * showQuestionUnsolved
	 * onQuestionShown(index)
	 * showIndex
	 * buildIndex
	 * onAnswereChanged (has to call questionSetAnswer)
	 * showSolution
	 * showAllSolutions
	 * selectAnswer(index)
	 * showStatistics
	 * initializeExam()
	 */
	 
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

		oldQuestionIndex = currentQuestionIndex;
		currentQuestionIndex = index;

		$('#question').empty();

		if (exam.Question[index].solved) {
			// must be defined in the respective layout-specific script file
			// (exam_mobile.js, exam_default.js)
			showQuestionSolved(index);
		} else {
			// must be defined in the respective layout-specific script file
			// (exam_mobile.js, exam_default.js)
			showQuestionUnsolved(index);
		}

		onQuestionShown(index, oldQuestionIndex);
	}

	/*
	 * called when an answer has been selected. Updates the exam object
	 * accordingly
	 */
	function questionSetAnswer(question_index, answer_index) {
		var question = exam.Question[question_index];
		question.answered = true;
		for (var i=0;i<question.Answer.length;i++) {
			if (i==answer_index)
				question.Answer[i].checked = true;
			else
				question.Answer[i].checked = false;
		}

		onAnswerChanged(question_index, answer_index);
		submitAnswer(exam.Question[question_index].id, exam.Question[question_index].Answer[answer_index].id);
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
	 * returns, wheter all valid questions have been answered
	 */
	function allValidQuestionsAnswered() {
		for (var i=0; i<exam.Question.length;i++) {
			question = exam.Question[i];
			if (question.valid && !question.answered)
				return false;
		}
		return true;
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
		if (allValidQuestionsAnswered()) {
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
					showStatistics();
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
			correct_invalid : 0,
			correct_valid : 0
		};

		$(exam.Question).each(function (index, question) {
			var answers_marked_correct = 0;

			// if this question has been answered, increase the answered-count
			if (question.answered) {
				result.answered++;
			}

			if (question.valid) {
				result.valid++;
			}

			for (var i=0;i<question.Answer.length;i++) {
				if (question.Answer[i].checked && question.Answer[i].correct) {
					if (question.valid)
						result.correct_valid++;
					else
						result.correct_invalid++;
				}
			}
		});

		return result;
	}
