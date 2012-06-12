<div class="tickets form">
<?php echo $this->Form->create('Ticket');?>
	<fieldset>
		<legend><?php echo __('Edit Ticket'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('url');
		echo $this->Form->input('tickettype_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('Ticketstatus');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Ticket.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Ticket.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Tickettypes'), array('controller' => 'tickettypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tickettype'), array('controller' => 'tickettypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ticketstatuses'), array('controller' => 'ticketstatuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticketstatus'), array('controller' => 'ticketstatuses', 'action' => 'add')); ?> </li>
	</ul>
</div>
