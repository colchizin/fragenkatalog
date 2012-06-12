<?php
	$this->Js->buffer("
		$('#naviation').hide();
		$('#content').addClass('full_width');
		$('#show_navigation').hide();
	");
	echo $this->Form->create('User', array(
		'class'=>'login'
	));
	echo $this->Form->input('username',array('type'=>'text','label'=>false));
	echo $this->Form->input('password', array('label'=>false));
	echo $this->Form->end('submit');

	echo $this->Html->link(__('Register'),array(
		'controller'=>'users',
		'action'=>'register'
	));
?>
