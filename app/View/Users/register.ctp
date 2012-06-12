<?php

echo $this->Html->script('user');

echo $this->Form->create('User');
echo $this->Form->input('username', array('type'=>'text'));
echo $this->Form->input('password', array('onchange'=>'confirmPassword();'));
echo $this->Form->input('password', array(
	'label' => __('Password (confirm)'),
	'id'=>'UserPasswordConfirm',
	'onchange'=>'confirmPassword();'
));
?>
	<span id='PasswordWrong' style='display:none'><?php echo __('Passwords are not the same');?></span>
<?
echo $this->Form->input('email', array('type'=>'text'));
echo $this->Form->input('Invitation.token',array('type'=>'text','label'=>__('Invitation code')));
		echo $this->Html->link(
			__('Privacy'),
			array(
				'controller'=>'pages',
				'action'=>'display',
				'datenschutz'
			),
			array(
				'data-role'=>'button',
				'data-rel'=>'dialog'
			)
		);
echo $this->Form->end(__('Register'));

?>

