<div class="questionsMaterials index">
	<h2><?php echo __('Questions Materials');?></h2>
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('question_id');?></th>
			<th><?php echo $this->Paginator->sort('material_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($questionsMaterials as $questionsMaterial): ?>
	<tr>
		<td><?php echo h($questionsMaterial['QuestionsMaterial']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($questionsMaterial['Question']['id'], array('controller' => 'questions', 'action' => 'view', $questionsMaterial['Question']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($questionsMaterial['Material']['title'], array('controller' => 'materials', 'action' => 'view', $questionsMaterial['Material']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $questionsMaterial['QuestionsMaterial']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $questionsMaterial['QuestionsMaterial']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $questionsMaterial['QuestionsMaterial']['id']), null, __('Are you sure you want to delete # %s?', $questionsMaterial['QuestionsMaterial']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Questions Material'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Materials'), array('controller' => 'materials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Material'), array('controller' => 'materials', 'action' => 'add')); ?> </li>
	</ul>
</div>
