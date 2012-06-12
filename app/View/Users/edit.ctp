<div class="users form">
<?php echo $this->Html->script('user');?>
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username',array('type'=>'text'));
		echo $this->Form->input('email',array('type'=>'text'));
		echo $this->Form->input('password');
		echo $this->Form->input('password', array(
			'label' => __('Password (confirm)'),
			'id'=>'UserPasswordConfirm',
		));
		echo $this->Form->input('programme_id', array('empty'=>__('No Default Programme')));
		?>
			<span id='PasswordWrong' class='error-message' style='display:none'><?php echo __('Passwords are not the same');?></span>
		<?
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
