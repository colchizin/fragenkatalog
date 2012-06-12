<div class="examsessionsQuestions form">
<?php echo $this->Form->create('ExamsessionsQuestion');?>
	<fieldset>
		<legend><?php echo __('Edit Examsessions Question'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('examsession_id');
		echo $this->Form->input('question_id');
		echo $this->Form->input('answer_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ExamsessionsQuestion.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ExamsessionsQuestion.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Examsessions Questions'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Examsessions'), array('controller' => 'examsessions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Examsession'), array('controller' => 'examsessions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
	</ul>
</div>
