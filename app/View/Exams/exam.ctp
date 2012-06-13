<?php
	echo $this->Html->script('exam');
	echo $this->Html->script('shortcuts');
	echo $this->Html->script('timer');
	$this->Html->script('jquery.wysiwyg', array('inline'=>false));
	$this->Js->buffer('$("textarea[data-role=richtext]").wysiwyg();');
	echo $this->Html->link(
		__('Printversion'),
		array(
			'controller'=>'exams',
			'action'=>'exam',
			'layout'=>'print',
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
		<?php if (isset($session_finished) && $session_finished):?>
			finished = true;
		<?php endif;?>

		<?php if (!empty($current_question)):?>
			setCurrentQuestion($('#question<?php echo $current_question;?>'));
			scrollToQuestion($('#question<?php echo $current_question;?>'));
		<?php else:?>
			nextQuestion();
		<?php endif;?>
		addQuestionCounter(document.getElementById('info-area'), 'info-area-element');
		addTimer(document.getElementById('info-area'), 'info-area-element');
		updateQuestionCounter();
	});
</script>

	<form id='exam' name='examform'>
<?php
	$i = 1;	
	foreach ($exam['Question'] as $question):
?>
		<div
			class='question'
			id='question<?php echo $question['id'];?>'
			data-id='<?php echo $question['id'];?>'
			onclick="if (true) {
				setCurrentQuestion($(document.getElementById('question<?php echo $question['id'];?>')));
			}"
		>
			<p class='question-text'>
				<span class='counter'><?php echo $i++;?>.</span>
				<?php echo $question['question'];?>
			</p>
			
			<div class='attachment'>
				<?php echo $question['attachment'];?>
			</div>

			<fieldset class='answers' data-role='controlgroup'>
				<?php foreach ($question['Answer'] as $answer):?>
					<div class='answer'
<?php
						if ($answer['correct']) {
							echo 'data-correct="true"';
						}
?>
						data-id="<?php echo $answer['id'];?>"
					>
						<input
							type='radio'
							id='answer_<?php echo $answer['id']?>'
							name='question_<?php echo $question['id']?>'
							<?php if (isset($answer['checked']) && $answer['checked']):?>
								checked="checked"
							<?php endif;?>
							onclick="submitAnswer(<?php echo $question['id'];?>,<?php echo $answer['id'];?>);"
						/>
						<label
							for='answer_<?php echo $answer['id'];?>'
						>
							<span class='answer-text'><?php echo $answer['answer'];?></span>

						<div class='comments' >
		<?php 			if (isset($answer['Comment']) && count($answer['Comment'])> 0) : ?>
		<?php				foreach ($answer['Comment'] as $comment): ?>
								<p class='comment'>
									<?php echo $comment['comment'];?>
									<span class='comment-author'>
										<?php echo (isset($comment['User']['username'])) ? $comment['User']['username'] : "unbekannt";?>
									</span>
								</p>
		<?php				endforeach;?>
		<?php			endif; ?>
						<button onclick='showCommentField($("#answer_<?php echo $answer['id'];?>").next());return false;'><?php echo __('comment');?></button>
						</div> <!-- End Comments !-->
						</label> <!-- End Label Answer !-->
					</div> <!-- End Answer !-->
				<?php endforeach;?>
				<a
					href='javascript:showQuestionDetails($(document.getElementById("question<?php echo $question['id'];?>")));'
					class='button btn-show-solution'
					data-role='button'
					data-mini='true'
					title='<?php echo __('Show Solution');?>'
				>
					<?php echo __('Solution');?>
				</a>
				<?php
					echo $this->Html->link(
						$this->Html->image('editor.gif'),
						array(
							'controller'=>'questions',
							'action'=>'edit',
							$question['id']
						),
						array(
							'data-role'=>'button',
							'class'=>'btn-edit-question',
							'title'=>__('Edit Question'),
							'escape'=>false
						)
					);
				?>
			</fieldset> <!-- End Answers !-->

			<div class='comments'>
				<?php foreach ($question['Comment'] as $comment):?>
					<p class='comment'>
						<?php echo h($comment['comment']);?>
						<span class='comment-author'>
							<?php echo (isset($comment['User']['username'])) ? $comment['User']['username'] : "unbekannt";?>
						</span>
					</p>
				<?php endforeach;?>
				<a
					href='javascript:showCommentField($("#question<?php echo $question['id'];?>"));'
					data-role='button'
					data-mini='true'
					title='<?php __('comment');?>'
				>
					<?php echo __('comment');?>
				</a>
			</div>

			<ul data-role='listview' data-inset='true' class='materials'>
		<?php	foreach ($question['Material'] as $material): ?>
				<li><?php echo $this->Html->link(
					$material['title'],
					array(
						'controller'=>'materials',
						'action'=>'view',
						$material['id']
					),
					array(
						'target'=>'blank'
					)
				);?></li>
		<?php	endforeach; ?>
			</ul>
		</div>
<?php
	endforeach;

?>
	</form>

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
			array('onclick'=>'checkAll(); showComments()'));?>
		</li>
		<li><?php echo $this->Html->link(
			__('Cancel'),
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
