<div class="answersComments index">
	<h2><?php echo __('Answers Comments');?></h2>
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('answer_id');?></th>
			<th><?php echo $this->Paginator->sort('comment_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($answersComments as $answersComment): ?>
	<tr>
		<td><?php echo h($answersComment['AnswersComment']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($answersComment['Answer']['id'], array('controller' => 'answers', 'action' => 'view', $answersComment['Answer']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($answersComment['Comment']['id'], array('controller' => 'comments', 'action' => 'view', $answersComment['Comment']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $answersComment['AnswersComment']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $answersComment['AnswersComment']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $answersComment['AnswersComment']['id']), null, __('Are you sure you want to delete # %s?', $answersComment['AnswersComment']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Answers Comment'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
	</ul>
</div>
