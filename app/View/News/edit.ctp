<div class="news form">
<?php
	echo $this->Form->create('News');
	$this->Html->script('jquery.wysiwyg', array('inline'=>false));
	$this->Js->buffer("$('textarea[data-role=wysiwyg]').wysiwyg();");
?>
	<fieldset>
		<legend><?php echo __('Edit News'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description'); //, array('data-role'=>'wysiwyg'));
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('News.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('News.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List News'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
