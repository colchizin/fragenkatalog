<div class="logins view">
<h2><?php  echo __('Login');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($login['Login']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($login['User']['id'], array('controller' => 'users', 'action' => 'view', $login['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($login['Login']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Login'), array('action' => 'edit', $login['Login']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Login'), array('action' => 'delete', $login['Login']['id']), null, __('Are you sure you want to delete # %s?', $login['Login']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Logins'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Login'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
