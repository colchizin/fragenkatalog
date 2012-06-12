<div class="materials form">
<?php
	$this->Html->script('jquery.wysiwyg', array('inline'=>false));

	$this->Js->buffer("$('#MaterialText').wysiwyg({
		'height':'500px'
	});");
?>
<?php echo $this->Form->create('Material');?>
	<fieldset>
		<legend><?php echo __('Edit Material'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('type'=>'text'));
		echo $this->Form->input('text');
		echo $this->Form->input('subject_id');
		echo $this->Form->input('Question', array('multiple'=>'checkbox'));
	?>
	<fieldset data-role='controlgroup'>
<?php
		echo $this->Form->submit(__('Save'),array('data-theme'=>'b'));
		echo $this->Html->link(
			__('Cancel'),
			array('action'=>'view',$this->request->data['Material']['id']),
			array('data-role'=>'button','class'=>'button','data-theme'=>'b')
		);
?>
	</fieldset>
	</fieldset>
<?php echo $this->Form->end();?>
</div>
