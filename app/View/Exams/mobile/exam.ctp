<?php
	echo $this->Html->script('exam_test');
	echo $this->Html->script('shortcuts');
	echo $this->Html->script('timer');
	echo $this->Js->buffer("
		exam = " . json_encode($exam) . ";
		buildIndex();

		finished = " . ((isset($session_finished) && $session_finished) ? 'true' : 'false') . ";
		if (finished) {
			showAllSolutions();
		} else {
			showNextUnansweredQuestion();
		}

		updateQuestionCounter();
	");
?>

<a
	href='javascript:showIndex()'
	data-role='button'
	id='question-counter'
	data-icon='grid'
	data-mini='true'
>
	<span id='questions-answers-count'>0</span> 
	von <span id='questions-total-count'>0</span>
	Fragen beantwortet
</a>

<div id='question'>
</div>

<div data-role='navbar' data-inset='true'>
	<ul>
		<li><a id='button-previous-question' href='javascript:showPreviousQuestion()'>Zurück</a></li>
		<li><a id='button-show-solution' href='javascript:showSolution(currentQuestionIndex)'>Lösung</a></li>
		<li><a id='button-next-question' href='javascript:showNextQuestion()'>Vor</a></li>
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
		<li>
			<a href="javascript:showAllSolutions();"><?php echo __('Score');?></a>
		</li>
		<li><?php echo $this->Html->link(
			__('Back'),
			array('controller'=>'exams','action'=>'view',$exam['Exam']['id']));?>
		</li>
	</ul>
</div>

<script language='javascript'>
	$('#question').bind('swipeleft',function() {
		showNextQuestion();	
	});

	$('#question').bind('swiperight',function() {
		showPreviousQuestion();	
	});
</script>
