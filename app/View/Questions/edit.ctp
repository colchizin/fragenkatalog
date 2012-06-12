<div class="questions form">
<?php echo $this->Html->script('question');?>
<?php echo $this->Form->create('Question');?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('question', array('rows'=>2));
		echo $this->Form->input('attachment', array('rows'=>4));
		echo $this->Form->input('subject_id', array('type'=>'hidden'));
?>
		<div class='answers' id='answers'>
			<h3>Antwortmöglichkeiten</h3>
<?php
			foreach ($this->request->data['Answer'] as $answer):
				if (isset($answer['Answer']))
					$answer = $answer['Answer'];

				$correct = (isset($answer['correct']) && $answer['correct'] == true)?'true':'false';
?><script language='javascript'>
	$(document).ready(function() {
		addAnswer(
			<?php echo json_encode($answer);?>
		);
	});
</script>
<?php		endforeach;?>
	
			<a id='add_answer' href="javascript:addAnswer(0,'',false)" data-role='button'>Antwort
			hinzufügen</a>
		</div> <!-- End Answers !-->
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div>
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="actions" data-role='listview' data-inset='true' data-theme='b'>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Question.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Question.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Cancel'), array('controller' => 'questions', 'action' => 'view',	$this->request->data['Question']['id'])); ?> </li>
	</ul>
</div>
