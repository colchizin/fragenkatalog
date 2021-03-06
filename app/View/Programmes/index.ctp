<div class="programmes index">
	<h2><?php echo __('Programmes');?></h2>
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('university_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($programmes as $programme): ?>
	<tr>
		<td><?php echo h($programme['Programme']['id']); ?>&nbsp;</td>
		<td><?php echo h($programme['Programme']['name']); ?>&nbsp;</td>
		<td><?php echo h($programme['Programme']['description']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($programme['University']['name'], array('controller' => 'universities', 'action' => 'view', $programme['University']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $programme['Programme']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $programme['Programme']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $programme['Programme']['id']), null, __('Are you sure you want to delete # %s?', $programme['Programme']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Programme'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Universities'), array('controller' => 'universities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New University'), array('controller' => 'universities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Subjects'), array('controller' => 'subjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subject'), array('controller' => 'subjects', 'action' => 'add')); ?> </li>
	</ul>
</div>
