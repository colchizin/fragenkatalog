<?php
	echo $this->Form->create('User', array(
		'class'=>'login'
	));
	echo $this->Form->input('username',
		array('type'=>'text','label'=>false,'placeholder'=>__('Username'))
	);
	echo $this->Form->input('password', array('label'=>false,'placeholder'=>__('Password')));
	echo $this->Form->end(__('Log in'));

	echo $this->Html->link(__('Register'),
		array(
			'controller'=>'users',
			'action'=>'register',
		),
		array(
			'data-role'=>'button'
		)
	);
?>
