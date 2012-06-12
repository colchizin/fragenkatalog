<div class="tickettypes form">
<?php echo $this->Form->create('Tickettype');?>
	<fieldset>
		<legend><?php echo __('Edit Tickettype'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Tickettype.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Tickettype.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Tickettypes'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
	</ul>
</div>
