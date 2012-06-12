<div class="exams form">
<?php echo $this->Form->create('Exam');?>
	<fieldset>
		<legend><?php echo __('Add Exam'); ?></legend>
	<?php
		echo $this->Form->input('title',array('value'=>__('Exam')));
		echo $this->Form->input('year', array(
			'min'=>'2000',
			'max'=>'2030',
			'value'=>'2000'
		));
		echo $this->Form->input(
			'term',
			array(
				'type'=>'select',
				'options'=>array(
					'0'=>__('Summer'),
					'1'=>__('Winter')
				),
				'empty'=>__('No Specific Semester')
			)
		);
		echo $this->Form->input('semester');
		echo $this->Form->input('subject_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Exams'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Subjects'), array('controller' => 'subjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subject'), array('controller' => 'subjects', 'action' => 'add')); ?> </li>
	</ul>
</div>
