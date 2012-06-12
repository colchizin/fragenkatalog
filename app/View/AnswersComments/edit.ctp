<div class="answersComments form">
<?php echo $this->Form->create('AnswersComment');?>
	<fieldset>
		<legend><?php echo __('Edit Answers Comment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('answer_id');
		echo $this->Form->input('comment_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('AnswersComment.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('AnswersComment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Answers Comments'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
	</ul>
</div>
