<div class="questions form">
<?php echo $this->Html->script('question');?>
<?php echo $this->Form->create('Question');?>
	<fieldset>
		<legend><?php echo __('Add Question'); ?></legend>
	<?php
		echo $this->Form->input('question');
		echo $this->Form->input('attachment');
		echo $this->Form->input('subject_id');
	?>
		<fieldset id='answers'>
			<legend><?php echo __('Answers');?></legend>
<?php
			if (isset($this->request->data['Answer'])):
				foreach ($this->request->data['Answer'] as $answer):
					$correct = ($answer['correct'] == true)?'true':'false';
					$this->Js->buffer("addAnswer('{$answer['id']}','{$answer['answer']}', $correct)");
					$this->Html->script("question", array('inline'=>false));
				endforeach;
			endif;?>
	
			<a id='add_answer' href="javascript:addAnswer(0,'',false)" data-role='button'>Antwort
			hinzufügen</a>
		</fieldset> <!-- End Answers !-->
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Questions'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Subjects'), array('controller' => 'subjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subject'), array('controller' => 'subjects', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Materials'), array('controller' => 'materials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Material'), array('controller' => 'materials', 'action' => 'add')); ?> </li>
	</ul>
</div>
