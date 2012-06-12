<div class="answersComments view">
<h2><?php  echo __('Answers Comment');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($answersComment['AnswersComment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Answer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($answersComment['Answer']['id'], array('controller' => 'answers', 'action' => 'view', $answersComment['Answer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo $this->Html->link($answersComment['Comment']['id'], array('controller' => 'comments', 'action' => 'view', $answersComment['Comment']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Answers Comment'), array('action' => 'edit', $answersComment['AnswersComment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Answers Comment'), array('action' => 'delete', $answersComment['AnswersComment']['id']), null, __('Are you sure you want to delete # %s?', $answersComment['AnswersComment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers Comments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answers Comment'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
	</ul>
</div>
