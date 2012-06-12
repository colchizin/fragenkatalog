<?php	echo $this->Form->create('Exam');?>
<fieldset data-role='controlgroup' data-filter='true'>
<?php
	echo $this->Form->input(
		'Question',
		array(
			'multiple'=>'checkbox'
		));
	
?>
</fieldset>
	<fieldset data-role='controlgroup'>
<?
	echo $this->Form->submit(__('Save'),array('data-theme'=>'b'));
	echo $this->Html->link(__('Cancel'),array('action'=>'view',$exam['Exam']['id']), array('data-role'=>'button','data-theme'=>'b','class'=>'button'));
?>
	</fieldset>
<?php	echo $this->Form->end();?>
