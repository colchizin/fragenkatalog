<div class="questionsComments view">
<h2><?php  echo __('Questions Comment');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($questionsComment['QuestionsComment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($questionsComment['Question']['id'], array('controller' => 'questions', 'action' => 'view', $questionsComment['Question']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo $this->Html->link($questionsComment['Comment']['id'], array('controller' => 'comments', 'action' => 'view', $questionsComment['Comment']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Questions Comment'), array('action' => 'edit', $questionsComment['QuestionsComment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Questions Comment'), array('action' => 'delete', $questionsComment['QuestionsComment']['id']), null, __('Are you sure you want to delete # %s?', $questionsComment['QuestionsComment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions Comments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Questions Comment'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
	</ul>
</div>
