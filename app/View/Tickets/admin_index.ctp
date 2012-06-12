<div class="tickets index">
	<?php echo $this->Form->create('Ticket', array(
		'method'=>'post',
		'action'=>'delete_all',
		'onsubmit'=>'return confirm("Sicher, dass alle ausgwählten Tickets gelöscht werden soll?");'
	));?>
	<h2><?php echo __('Tickets');?></h2>
	<table>
	<tr>
			<th><?php echo __('Status');?></th>
			<th>
				<input
					type='checkbox'
					onchange='$("#TicketDeleteAllForm input[type=checkbox]").attr("checked",this.checked);'
				/>
			</th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('url');?></th>
			<th><?php echo $this->Paginator->sort('tickettype_id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($tickets as $ticket): ?>
	<tr class='ticket <?php echo Inflector::slug(Inflector::underscore($ticket['HasTicketstatus'][0]['Ticketstatus']['title']));?>'>
		<td><?php echo $ticket['HasTicketstatus'][0]['Ticketstatus']['title'];?></td>
		<td>
			<input type='checkbox' name='data[Ticket][]' value='<?php echo $ticket['Ticket']['id'];?>'/>
		</td>
		<td><?php echo h($ticket['Ticket']['title']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link(__('Link'),$ticket['Ticket']['url']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ticket['Tickettype']['title'], array('controller' => 'tickettypes', 'action' => 'view', $ticket['Tickettype']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($ticket['User']['username'], array('controller' => 'users', 'action' => 'view', $ticket['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $ticket['Ticket']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ticket['Ticket']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Form->end('Delete');?>
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
