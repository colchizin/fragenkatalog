<?php
	echo $this->Html->script('edit_exam');
?>
<div class="exams form">
<?php echo $this->Form->create('Exam');?>
	<fieldset>
		<legend><?php echo __('Edit Exam'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('year');
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
		<fieldset data-role='controlgroup'>
<?php	echo $this->Form->Input('Question', array(
			'multiple'=>'checkbox'
		));
?>
		</fieldset>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Exam.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Exam.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Exams'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Subjects'), array('controller' => 'subjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subject'), array('controller' => 'subjects', 'action' => 'add')); ?> </li>
	</ul>
</div>
