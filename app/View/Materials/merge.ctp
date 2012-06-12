<?php
	echo $this->Form->create('Material',array('method'=>'post'));
?>
	<fieldset data-role='controlgroup'>
<?php	foreach ($materials as $material) :?>
		<div>
			<input
				type='Checkbox'
				name="data[Material][id][]"
				id="material_<?php echo $material['Material']['id'];?>"
				value="<?php echo $material['Material']['id'];?>"
			>
			<label
				for="material_<?php echo $material['Material']['id'];?>"
			>
				<?php echo $material['Material']['title'];?> (<?
				echo $this->Html->link($material['Material']['id'],array(
					'controller'=>'materials',
					'action'=>'view',
					$material['Material']['id']
				));
				?>)
				<?php echo __('Length');?>: 
				<?php echo strlen($material['Material']['text']);?>

			</label>

		</div>
<?php 	endforeach;?>
	</fieldset>
<?php
	echo $this->Form->end(__('Merge'));
?>
