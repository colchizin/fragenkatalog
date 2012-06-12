<div class="ticketstatuses view">
<h2><?php  echo __('Ticketstatus');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ticketstatus['Ticketstatus']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($ticketstatus['Ticketstatus']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($ticketstatus['Ticketstatus']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ticketstatus'), array('action' => 'edit', $ticketstatus['Ticketstatus']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ticketstatus'), array('action' => 'delete', $ticketstatus['Ticketstatus']['id']), null, __('Are you sure you want to delete # %s?', $ticketstatus['Ticketstatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ticketstatuses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticketstatus'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Tickets');?></h3>
	<?php if (!empty($ticketstatus['Ticket'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Url'); ?></th>
		<th><?php echo __('Tickettype Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($ticketstatus['Ticket'] as $ticket): ?>
		<tr>
			<td><?php echo $ticket['id'];?></td>
			<td><?php echo $ticket['title'];?></td>
			<td><?php echo $ticket['description'];?></td>
			<td><?php echo $ticket['url'];?></td>
			<td><?php echo $ticket['tickettype_id'];?></td>
			<td><?php echo $ticket['user_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'tickets', 'action' => 'view', $ticket['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'tickets', 'action' => 'edit', $ticket['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'tickets', 'action' => 'delete', $ticket['id']), null, __('Are you sure you want to delete # %s?', $ticket['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
