<div class="questionsComments index">
	<h2><?php echo __('Questions Comments');?></h2>
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('question_id');?></th>
			<th><?php echo $this->Paginator->sort('comment_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($questionsComments as $questionsComment): ?>
	<tr>
		<td><?php echo h($questionsComment['QuestionsComment']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($questionsComment['Question']['id'], array('controller' => 'questions', 'action' => 'view', $questionsComment['Question']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($questionsComment['Comment']['id'], array('controller' => 'comments', 'action' => 'view', $questionsComment['Comment']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $questionsComment['QuestionsComment']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $questionsComment['QuestionsComment']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $questionsComment['QuestionsComment']['id']), null, __('Are you sure you want to delete # %s?', $questionsComment['QuestionsComment']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Questions Comment'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
	</ul>
</div>
