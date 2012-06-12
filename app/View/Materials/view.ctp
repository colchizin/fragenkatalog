<div class="materials view">
<h2><?php  echo h($material['Material']['title']);?></h2>
	<div><?php echo $this->Material->write($material); ?></div>
	<p>
		<?php echo __('Subject');?>:
		<?php echo $this->Html->link(
			$material['Subject']['name'],
			array(
				'controller' => 'subjects',
				'action' => 'view',
				$material['Subject']['id']
			),
			array(
				'data-role'=>'button',
				'data-inline'=>'true'
			));
		?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	 <ul data-role='listview' data-inset='true' data-theme='b'>
		<li><?php echo $this->Html->link(__('Edit Material'), array('action' => 'edit', $material['Material']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Material'), array('action' => 'delete', $material['Material']['id']), null, __('Are you sure you want to delete # %s?', $material['Material']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Material'), array('action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Questions');?></h3>
	<?php if (!empty($material['Question'])):?>
	<ul data-role='listview' data-inset='true'>
	<?php
		$i = 0;
		foreach ($material['Question'] as $question): ?>
		<li>
				<?php echo $this->Html->link($question['question'], array('controller' => 'questions', 'action' => 'view', $question['id'])); ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

</div>

<?php if (count($materials)>0): ?>
<div class="related">
	<h3><?php echo __('Other Materials on this Subject');?></h3>
	<ul data-role='listview' data-inset='true'>
	<?php
		foreach($materials as $material):
?>
		<li>
			<?php echo $this->Html->link(
				$material['Material']['title'],
				array('action'=>'view',$material['Material']['id'])
			);?>
		</li>
<?php
		endforeach;
	?>
	</ul>
</div>
<?php endif;?>
