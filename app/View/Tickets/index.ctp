<div class="tickets index">
	<h2><?php echo __('Tickets');?></h2>
	<table>
	<tr>
			<th><?php echo __('Status');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('url');?></th>
			<th><?php echo $this->Paginator->sort('tickettype_id');?></th>
			<th><?php echo $this->Paginator->sort('User.username');?></th>
			<th><?php echo __('Last Edit');?></th>
	</tr>
	<?php
	foreach ($tickets as $ticket): ?>
	<tr class='ticket <?php echo Inflector::slug(Inflector::underscore($ticket['HasTicketstatus'][0]['Ticketstatus']['title']));?>'>
		<td><?php echo $ticket['HasTicketstatus'][0]['Ticketstatus']['title'];?></td>
		<td>
			<?php echo $this->Html->link($ticket['Ticket']['title'], array('action' => 'view', $ticket['Ticket']['id'])); ?>
		</td>
		<td><?php echo $this->Html->link(__('Link'),$ticket['Ticket']['url']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ticket['Tickettype']['title'], array('controller' => 'tickettypes', 'action' => 'view', $ticket['Tickettype']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($ticket['User']['username'], array('controller' => 'users', 'action' => 'view', $ticket['User']['id'])); ?>
		</td>
		<td><?php echo h($ticket['HasTicketstatus'][0]['created']);?></td>
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
	<ul data-role='listview'>
		<li><?php echo $this->Html->link(__('New Ticket'), array('action' => 'add')); ?></li>
	</ul>
</div>
