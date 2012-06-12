<div class="examsessionsQuestions index">
	<h2><?php echo __('Examsessions Questions');?></h2>
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('examsession_id');?></th>
			<th><?php echo $this->Paginator->sort('question_id');?></th>
			<th><?php echo $this->Paginator->sort('answer_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($examsessionsQuestions as $examsessionsQuestion): ?>
	<tr>
		<td><?php echo h($examsessionsQuestion['ExamsessionsQuestion']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($examsessionsQuestion['Examsession']['id'], array('controller' => 'examsessions', 'action' => 'view', $examsessionsQuestion['Examsession']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($examsessionsQuestion['Question']['question'], array('controller' => 'questions', 'action' => 'view', $examsessionsQuestion['Question']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($examsessionsQuestion['Answer']['id'], array('controller' => 'answers', 'action' => 'view', $examsessionsQuestion['Answer']['id'])); ?>
		</td>
		<td><?php echo h($examsessionsQuestion['ExamsessionsQuestion']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $examsessionsQuestion['ExamsessionsQuestion']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $examsessionsQuestion['ExamsessionsQuestion']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $examsessionsQuestion['ExamsessionsQuestion']['id']), null, __('Are you sure you want to delete # %s?', $examsessionsQuestion['ExamsessionsQuestion']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Examsessions Question'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Examsessions'), array('controller' => 'examsessions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Examsession'), array('controller' => 'examsessions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
	</ul>
</div>
