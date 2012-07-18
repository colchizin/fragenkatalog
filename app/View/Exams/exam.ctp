<?php
	$this->Html->script('exam', array('inline'=>false));
	$this->Html->script('exam_default', array('inline'=>false));
	$this->Html->script('shortcuts', array('inline'=>false));
	$this->Html->script('timer', array('inline'=>false));
	$this->Html->script('jquery.wysiwyg', array('inline'=>false));
?>
	<ul class='menu info-area-element' id='second-menu'>
		<li>
			<?php echo $this->Html->link(
				__('Printversion'),
				array(
					'controller'=>'exams',
					'action'=>'exam',
					'layout_once'=>'print',
					$exam['Exam']['id']
				),
				array(
					'rel'=>'external',
					'target'=>'blank',
					'id'=>'btn-printversion'
				)
			);?>
		</li>
		<li>
			<?php echo $this->Html->link(
				__('Keyboard shortcuts'),
				array(
					'controller'=>'pages',
					'action'=>'display',
					'shortcuts'
				),
				array(
					'rel'=>'dialog',
					'id'=>'btn-shortcuts'
				)
			);?>
		</li>
		<li>
			<input
				type='checkbox'
				id='quick-solution-mode'
				onchange="quickSolutionMode = this.checked;"
			/>
			<label
				for='quick-solution-mode'
				title='<?php echo __('quick solution mode description');?>'
			>
				<?php echo __('immediatly show solution');?>
			</label>

		</li>
	</ul>
<?php	
?>
<script language='javascript'>
	$(document).ready(function() {
		$('#second-menu').appendTo($('#info-area'));
		exam = <?php echo json_encode($exam);?>;
		initializeExam();
		showNextUnansweredQuestion();
		addTimer(document.getElementById('info-area'), 'info-area-element');
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
