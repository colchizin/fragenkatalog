<div class="exams index">
	<h2><?php echo __('Exams');?></h2>
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('year');?></th>
			<th><?php echo $this->Paginator->sort('term');?></th>
			<th><?php echo $this->Paginator->sort('subject_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($exams as $exam): ?>
	<tr>
		<td><?php echo h($exam['Exam']['id']); ?>&nbsp;</td>
		<td><?php echo h($exam['Exam']['title']); ?>&nbsp;</td>
		<td><?php echo h($exam['Exam']['year']); ?>&nbsp;</td>
		<td><?php echo h($exam['Exam']['term']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($exam['Subject']['name'], array('controller' => 'subjects', 'action' => 'view', $exam['Subject']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $exam['Exam']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $exam['Exam']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $exam['Exam']['id']), null, __('Are you sure you want to delete # %s?', $exam['Exam']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Exam'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Subjects'), array('controller' => 'subjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subject'), array('controller' => 'subjects', 'action' => 'add')); ?> </li>
	</ul>
</div>
