<div class="examsessions index">
	<h2><?php echo __('Examsessions');?></h2>
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('exam_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('finished');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($examsessions as $examsession): ?>
	<tr>
		<td><?php echo h($examsession['Examsession']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($examsession['User']['username'], array('controller' => 'users', 'action' => 'view', $examsession['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($examsession['Exam']['fullname'] . " " . $examsession['Exam']['Subject']['name'], array('controller' => 'exams', 'action' => 'view', $examsession['Exam']['id'])); ?>
		</td>
		<td><?php echo h($examsession['Examsession']['created']); ?>&nbsp;</td>
		<td><?php echo h($examsession['Examsession']['finished']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $examsession['Examsession']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $examsession['Examsession']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $examsession['Examsession']['id']), null, __('Are you sure you want to delete # %s?', $examsession['Examsession']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Examsession'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exams'), array('controller' => 'exams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam'), array('controller' => 'exams', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
