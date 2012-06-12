<div class="ticketstatuses form">
<?php echo $this->Form->create('Ticketstatus');?>
	<fieldset>
		<legend><?php echo __('Edit Ticketstatus'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('Ticket');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Ticketstatus.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Ticketstatus.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Ticketstatuses'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
	</ul>
</div>
