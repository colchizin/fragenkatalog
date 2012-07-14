<?php
	$this->Html->script('exam', array('inline'=>false));
	$this->Html->script('exam_default', array('inline'=>false));
	$this->Html->script('shortcuts', array('inline'=>false));
	$this->Html->script('timer', array('inline'=>false));
	$this->Html->script('jquery.wysiwyg', array('inline'=>false));
	$this->Js->buffer('$("textarea[data-role=richtext]").wysiwyg();');
	echo $this->Html->link(
		__('Printversion'),
		array(
			'controller'=>'exams',
			'action'=>'exam',
			'layout_once'=>'print',
			$exam['Exam']['id']
		),
		array(
			'data-role'=>'button',
			'class'=>'button',
			'rel'=>'external',
			'target'=>'blank',
			'id'=>'btn-printversion'
		)
	);
	echo $this->Html->link(
		__('Keyboard shortcuts'),
		array(
			'controller'=>'pages',
			'action'=>'display',
			'shortcuts'
		),
		array(
			'data-role'=>'button',
			'class'=>'button',
			'rel'=>'dialog',
			'id'=>'btn-shortcuts'
		)
	);
?>
<script language='javascript'>
	$(document).ready(function() {
		exam = <?php echo json_encode($exam);?>;
		initializeExam();
		showNextUnansweredQuestion();
	});
</script>

<div class='questions exam' id='questions'>

</div>

<dl id='statistics'>
</dl>

<div id='comment-field' style='display:none'>
	<textarea id='textarea-comment'></textarea>
	<button onclick="submitComment();return false;"><?php echo __('comment');?></button>
	<button onclick='hideCommentField(); return false;'><?php echo __('Cancel');?></button>
</div>

<div data-role='collapsible' id='exam-legend'>
	<legend><?php echo __('Legend');?></legend>
	<p><div class='sample correct'>Richtige Antwort, aber nicht ausgwählt</div></p>
	<p><div class='sample correct_selected'>Richtige Antwort, ausgewählt</div></p>
	<p><div class='sample wrong'>Falsche Antwort</div></p>
</div>

<div class='actions'>
	<ul data-role='listview' data-theme='b' data-inset='true'>
		<li><?php echo $this->Html->link(
			__('Show Solutions'),
			"#",
			array('onclick'=>'showAllSolutions(); showStatistics()'));?>
		</li>
		<li><?php echo $this->Html->link(
			__('Cancel'),
			array('controller'=>'exams','action'=>'view',$exam['Exam']['id']));?>
		</li>
	</ul>
</div>
