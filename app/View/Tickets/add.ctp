<div class="tickets form">
<?php echo $this->Form->create('Ticket');?>
	<fieldset>
		<legend><?php echo __('Add Ticket'); ?></legend>
	<?php
		echo $this->Form->input('title', array('type'=>'text'));
		echo $this->Form->input('description');
		echo $this->Form->input('url', array('type'=>'text'));
		echo $this->Form->input('tickettype_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
