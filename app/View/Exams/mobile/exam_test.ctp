<?php
	echo $this->Html->script('exam');
	echo $this->Html->script('shortcuts');
	echo $this->Html->script('timer');
	echo $this->Js->buffer("
		
	");
?>
<script language="javascript">
	var exam = <?php echo json_encode($exam);?>;
	var currentQuestionIndex;

	function showQuestion(index) {
		currentQuestionIndex = index;
		if (index >= exam.Question.length) {
			throw "Array Index out of bounds";
		}

		var question = exam.Question[index];
		var answers = $('<fieldset class="answers"></fieldset>')
			.attr('data-role', "controlgroup")
			.attr('data-direction','vertical')
		;
		$(question.Answer).each(function(idx, elem) {
			answers.append($('<div class="answer"></div>')
				.attr('data-correct', elem.correct)
				.append($('<input type="radio"></input>')
					.attr('name','question_' + question.id) 
					.attr('id', 'answer_' + elem.id)
					.val(idx)
				)
				.append($('<label></label>')
					.attr('for', 'answer_' + elem.id)
					.text(elem.answer)
				)
			);
		});

		$('#question').empty();
		$('#question')
			.append($("<p class='question-text'></p>")
				.append($('<span class="counter"></span>')
					.text((index+1) + ". ")
				)
				.append(question.question)
			)
			.append(answers);
		;
		answers.find('input[type=radio]').checkboxradio();
		answers.controlgroup();
		// answers.trigger('create');
	}

	$(document).ready(function() {
		showQuestion(0);
	});

	function showSolution() {
		$('#question').find('div.answer[data-correct=true]').addClass('correct');
		var selectedAnswer = $('#question').find(':checked');
		var selectedIndex = selectedAnswer.val()
		if (!exam.Question[currentQuestionIndex].Answer[selectedIndex].correct)
			selectedAnswer.parents('.answer').addClass('wrong');
	}

	function showNextQuestion() {
		if (currentQuestionIndex<exam.Question.length-2)
			showQuestion(currentQuestionIndex+1);
	}

	function showPreviousQuestion() {
		if (currentQuestionIndex>0)
			showQuestion(currentQuestionIndex-1);
	}
</script>

<div id='question'>
</div>

<div data-role='navbar' data-inset='true'>
	<ul>
		<li><a href='javascript:showPreviousQuestion()'>Zurück</a></li>
		<li><a href='javascript:showSolution()'>Lösung</a></li>
		<li><a href='javascript:showNextQuestion()'>Vor</a></li>
	</ul>
</div>

<dl id='statistics'>
</dl>

<div data-role='collapsible' id='exam-legend'>
	<legend><?php echo __('Legend');?></legend>
	<p><div class='sample correct'>Richtige Antwort, aber nicht ausgwählt</div></p>
	<p><div class='sample correct_selected'>Richtige Antwort, ausgewählt</div></p>
	<p><div class='sample wrong'>Falsche Antwort</div></p>
</div>

<div class='actions'>
	<ul data-role='listview' data-theme='b' data-inset='true'>
		<li><?php echo $this->Html->link(
			__('Show All Solutions'),
			"#",
			array('onclick'=>'checkAll(); showComments()'));?>
		</li>
		<li><?php echo $this->Html->link(
			__('Back'),
			array('controller'=>'exams','action'=>'view',$exam['Exam']['id']));?>
		</li>
	</ul>
</div>

<script language='javascript'>
	$('#exam').bind('swipeleft',function() {
		nextQuestion();	
	});

	$('#exam').bind('swiperight',function() {
		previousQuestion();	
	});
</script>
