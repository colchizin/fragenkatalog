<div class="invitations form">
<?php echo $this->Form->create('Invitation');?>
	<fieldset>
		<legend><?php echo __('Edit Invitation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('token');
		echo $this->Form->input('used');
		echo $this->Form->input('user_id');
		echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Invitation.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Invitation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Invitations'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
