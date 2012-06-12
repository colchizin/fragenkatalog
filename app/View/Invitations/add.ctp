<div class="invitations form">
<?php echo $this->Form->create('Invitation');?>
	<?php
		echo $this->Form->input('email', array('type'=>'text'));
		echo $this->Html->link(
			__('Privacy'),
			array(
				'controller'=>'pages',
				'action'=>'display',
				'datenschutz'
			),
			array(
				'data-role'=>'button',
				'data-rel'=>'dialog',
				'target'=>'blank'
			)
		);
	?>
<?php echo $this->Form->end(__('Submit'));?>
</div>
