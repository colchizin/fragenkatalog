<div class="invitations view">
<h2><?php  echo __('Invitation');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($invitation['Invitation']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Token'); ?></dt>
		<dd>
			<?php echo h($invitation['Invitation']['token']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($invitation['Invitation']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Used'); ?></dt>
		<dd>
			<?php echo h($invitation['Invitation']['used']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($invitation['User']['id'], array('controller' => 'users', 'action' => 'view', $invitation['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($invitation['Invitation']['email']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Invitation'), array('action' => 'edit', $invitation['Invitation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Invitation'), array('action' => 'delete', $invitation['Invitation']['id']), null, __('Are you sure you want to delete # %s?', $invitation['Invitation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Invitations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invitation'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
