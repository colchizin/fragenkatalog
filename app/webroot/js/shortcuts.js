var shortcuts_enabled = true;

$(document).ready(function() {
	$(document).keydown(function (eventObject) {
		if (shortcuts_enabled) {
			switch(eventObject.which) {
				case 37:
				case 38:
					showPreviousQuestion();
					return false;
				case 39:
				case 40:
					showNextQuestion();
					return false;
				case 13:
					showQuestionDetails($(".question.current"));
					/*if (confirm("Wirklich alle Lösungen anzeigen?")) {
						showAllQuestions();
						showAllSolutions();
						doStatistics();
					}*/
					return false;
					break;
				/*default:
					alert(eventObject.which);*/
			}
		}
	});

	$(document).keypress(function (eventObject) {
		if (eventObject.target.nodeName.toLowerCase() == "textarea") {
			return;
		}
		switch(eventObject.charCode) {
			case 32:	// Leertaste
				showNextQuestion(); return false;
			case 110:	// n 
				showNextQuestion();
				break;
			case 112:	// p
				showPreviousQuestion();
				break;
			case 97:	// a
			case 49:	// 1
				selectAnswer(0); break;
			case 98:	// b
			case 50:	// 2
				selectAnswer(1); break;
			case 99:	// c
			case 51:	// 3
				selectAnswer(2); break;
			case 100:	// d
			case 52:	// 4
				selectAnswer(3); break;
			case 101:	// e
			case 53:	// 5
				selectAnswer(4); break;
			case 54:	// 6
				selectAnswer(5); break;
			case 55:	// 7
				selectAnswer(6); break;
			case 56:	// 8
				selectAnswer(7); break;
			case 118:	// v
				toggleDisplayType(); break;
			case 102:	// f
				toggleFullscreen(); break;
			/*default:
				alert(eventObject.charCode);*/
		}
	});
});
