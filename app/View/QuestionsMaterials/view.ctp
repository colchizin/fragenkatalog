<div class="questionsMaterials view">
<h2><?php  echo __('Questions Material');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($questionsMaterial['QuestionsMaterial']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($questionsMaterial['Question']['id'], array('controller' => 'questions', 'action' => 'view', $questionsMaterial['Question']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Material'); ?></dt>
		<dd>
			<?php echo $this->Html->link($questionsMaterial['Material']['title'], array('controller' => 'materials', 'action' => 'view', $questionsMaterial['Material']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Questions Material'), array('action' => 'edit', $questionsMaterial['QuestionsMaterial']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Questions Material'), array('action' => 'delete', $questionsMaterial['QuestionsMaterial']['id']), null, __('Are you sure you want to delete # %s?', $questionsMaterial['QuestionsMaterial']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions Materials'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Questions Material'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Materials'), array('controller' => 'materials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Material'), array('controller' => 'materials', 'action' => 'add')); ?> </li>
	</ul>
</div>
