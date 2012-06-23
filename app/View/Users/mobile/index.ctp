	<ul data-role='listview'>
	<?php
	foreach ($users as $user): ?>
	<li>
		<a href='/fragenkatalog/users/view/<?php echo $user['User']['id'];?>'>
			<h3><?php echo h($user['User']['username']); ?>&nbsp;</h3>
			<p><?php echo h($user['User']['email']); ?></p>
			<p><?php echo h($user['Group']['name']);?></p>
		</a>
	</li>
<?php endforeach; ?>
	<li data-role='navbar'>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>

	<p class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</p>
	</li>
	</ul>

	<ul data-role='listview' data-theme='b'>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
	</ul>
