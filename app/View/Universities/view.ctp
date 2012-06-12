<div class="related">
	<?php if (!empty($university['Programme'])):?>
	<h3><?php echo __('Related Programmes');?></h3>
	<ul data-role='listview' data-inset='true'>
	<?php
		foreach ($university['Programme'] as $programme): ?>
		<li>
				<?php echo $this->Html->link($programme['name'], array('controller' => 'programmes', 'action' => 'view', $programme['id'])); ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul data-role='listview'data-inset='true' data-theme='b'>
		<li><?php echo $this->Html->link(__('Edit University'), array('action' => 'edit', $university['University']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Programme'), array('controller' => 'programmes', 'action' => 'add')); ?> </li>
	</ul>
</div>
