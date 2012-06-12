<div class="examsessions view">
<h2><?php  echo __('Examsession');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($examsession['Examsession']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($examsession['User']['id'], array('controller' => 'users', 'action' => 'view', $examsession['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Exam'); ?></dt>
		<dd>
			<?php echo $this->Html->link($examsession['Exam']['title'], array('controller' => 'exams', 'action' => 'view', $examsession['Exam']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($examsession['Examsession']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Finished'); ?></dt>
		<dd>
			<?php echo h($examsession['Examsession']['finished']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Examsession'), array('action' => 'edit', $examsession['Examsession']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Examsession'), array('action' => 'delete', $examsession['Examsession']['id']), null, __('Are you sure you want to delete # %s?', $examsession['Examsession']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Examsessions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Examsession'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exams'), array('controller' => 'exams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam'), array('controller' => 'exams', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Questions');?></h3>
	<?php if (!empty($examsession['Question'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Question'); ?></th>
		<th><?php echo __('Attachment'); ?></th>
		<th><?php echo __('Questiontype Id'); ?></th>
		<th><?php echo __('Subject Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($examsession['Question'] as $question): ?>
		<tr>
			<td><?php echo $question['id'];?></td>
			<td><?php echo $question['question'];?></td>
			<td><?php echo $question['attachment'];?></td>
			<td><?php echo $question['questiontype_id'];?></td>
			<td><?php echo $question['subject_id'];?></td>
			<td><?php echo $question['parent_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'questions', 'action' => 'view', $question['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'questions', 'action' => 'edit', $question['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'questions', 'action' => 'delete', $question['id']), null, __('Are you sure you want to delete # %s?', $question['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
