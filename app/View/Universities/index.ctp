<div class="universities index">
	<ul data-role='listview' data-inset='true' data-filter='true'>
	<?php
	foreach ($universities as $university): ?>
	<li>
		<?php echo $this->Html->link(
			$university['University']['name'],
			array(
				'controller'=>'universities',
				'action'=>'view',
				$university['University']['id'])); ?>
	</li>
<?php endforeach; ?>
	</ul>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging" data-role="controlgroup">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul data-role='listview' data-inset='true' data-theme='b'>
		<li><?php echo $this->Html->link(__('New University'), array('action' => 'add')); ?></li>
	</ul>
</div>
