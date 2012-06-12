<div class="examsessionsQuestions view">
<h2><?php  echo __('Examsessions Question');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($examsessionsQuestion['ExamsessionsQuestion']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Examsession'); ?></dt>
		<dd>
			<?php echo $this->Html->link($examsessionsQuestion['Examsession']['id'], array('controller' => 'examsessions', 'action' => 'view', $examsessionsQuestion['Examsession']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($examsessionsQuestion['Question']['question'], array('controller' => 'questions', 'action' => 'view', $examsessionsQuestion['Question']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Answer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($examsessionsQuestion['Answer']['id'], array('controller' => 'answers', 'action' => 'view', $examsessionsQuestion['Answer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($examsessionsQuestion['ExamsessionsQuestion']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Examsessions Question'), array('action' => 'edit', $examsessionsQuestion['ExamsessionsQuestion']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Examsessions Question'), array('action' => 'delete', $examsessionsQuestion['ExamsessionsQuestion']['id']), null, __('Are you sure you want to delete # %s?', $examsessionsQuestion['ExamsessionsQuestion']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Examsessions Questions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Examsessions Question'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Examsessions'), array('controller' => 'examsessions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Examsession'), array('controller' => 'examsessions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
	</ul>
</div>
