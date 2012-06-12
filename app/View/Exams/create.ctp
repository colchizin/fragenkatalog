<?php
	echo $this->Html->script('exam');
	echo $this->Form->create('Exam');

	echo $this->Form->input('id');
	echo $this->Form->input('subject_id',array('type'=>'hidden'));
	echo $this->Form->input('title', array('value'=>__('Exam')));
	echo $this->Form->input('term',	array(
		'type'=>'select',
		'options'=>array(
			'0'=>__('Summer'),
			'1'=>__('Winter')
		),
		'empty'=>__('No Specific Term'),
	));
	echo $this->Form->input('year',array('min'=>2000,'value'=>'2000'));
	echo $this->Form->input('semester', array('value'=>1));
?>
	<div class='questions'>
		<script langauge='javascript'>
		$(document).ready(function() {
<?php	if (isset($this->data['Question'])):
			foreach ($this->data['Question'] as $question):?>
				addQuestion(<?php echo json_encode($question);?>);	
<?php		endforeach;
		endif;?>
		});
		</script>
	</div>

	<button onclick='addQuestion();return false;';><?php echo __('Add Question');?></button>

<?php echo $this->Form->end(__('save')); ?>

<div class='actions'>
	<ul data-role='listview' data-theme='b'>
		<li><?php echo $this->Html->link(
			__('Cancel'),
			array(
				'controller'=>'subjects',
				'action'=>'view',
				$this->data['Exam']['subject_id']
			)
		); ?>
	</ul>
</div>
