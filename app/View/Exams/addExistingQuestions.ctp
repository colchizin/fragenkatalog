<fieldset data-role='controlgroup'>
<?php
	$this->Form->create('Exam');
	foreach ($questions as $question):
		echo $this->Form->input(
			'question',
			array(
				'type'=>'checkbox',
				'multiple'=>true,
				'value'=>$question['Question']['id'],
				'label'=>$question['Question']['question']
			)
		);
	endforeach;
?>
	<fieldset data-role='controlgroup' data-theme='b'>
<?
	echo $this->Html->link(__('Cancel'),array('action'=>'view'));
	echo $this->Form->submit(__('Save'));
?>
	</fieldset>
<?php	echo $this->Form->end();?>
</fieldset>
