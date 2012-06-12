<?php
	$this->Html->script('jquery.wysiwyg', array('inline'=>false));
	echo $this->Html->script('ticket');
	$this->Js->buffer('$("textarea[data-role=richtext]").wysiwyg();');
?>
<div class="tickets view">
<h2><?php  echo __('Ticket');?></h2>
	<dl>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tickettype'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ticket['Tickettype']['title'], array('controller' => 'tickettypes', 'action' => 'view', $ticket['Tickettype']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ticket['User']['username'], array('controller' => 'users', 'action' => 'view', $ticket['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>


<div class="related ticket-comments">
	<h3><?php echo __('Related Comments');?></h3>
	<?php if (!empty($ticket['Ticketcomment'])):?>
	<script language='javascript'>
		$(document).ready(function() {
			<?php foreach($ticket['Ticketcomment'] as $comment):?>
			insertTicketcomment(<?php echo json_encode($comment);?>,<?php echo AuthComponent::user('id');?>);
			<?php endforeach;?>
		});
	</script> 
	<?php endif;?>
	<form id='TicketcommentAddForm'>
		<textarea data-role='richtext' id="TicketcommentComment"></textarea>
		<button onclick='addTicketcomment(<?php echo $ticket['Ticket']['id'];?>,<?php echo AuthComponent::user('id');?>); return false;'><?php echo __('comment');?></button>
	</form>
</div>

<div class="related">
	<h3><?php echo __('Related Ticketstatuses');?></h3>
	<?php if (!empty($ticket['HasTicketstatus'])):?>
	<table>
	<tr>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Title'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($ticket['HasTicketstatus'] as $ticketstatus): ?>
		<tr>
			<td><?php echo $ticketstatus['Ticketstatus']['title'];?></td>
			<td><?php echo $ticketstatus['created'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul data-role='listview' data-inset='true'>
		<li><?php echo $this->Html->link(__('Alter Status'), array('action' => 'alter_status', $ticket['Ticket']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Ticket'), array('action' => 'edit', $ticket['Ticket']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ticket'), array('action' => 'delete', $ticket['Ticket']['id']), null, __('Are you sure you want to delete # %s?', $ticket['Ticket']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('action' => 'add')); ?> </li>
	</ul>
</div>
