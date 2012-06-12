<div class="questions view">
<h2>
	<?php echo h($question['Question']['question']); ?>
</h2>
<div class='attachment'>
	<?php echo $question['Question']['attachment'];?>
</div>
</div>

<div class="related">
	<h3><?php echo __('Related Answers');?></h3>
	<?php if (!empty($question['Answer'])):?>
	<ul data-role='listview' data-inset='true' class='answers'>
	<?php
		foreach ($question['Answer'] as $answer):
				$correct = ($answer['correct']==1)?'true':'false';?>

			<li data-correct='<?php echo $correct;?>' class='answer'>
				<label><?php echo $answer['answer']; ?>
<?php 			if (isset($answer['Comment']) && count($answer['Comment'])> 0) : ?>
				<div class='comments' >
<?php				foreach ($answer['Comment'] as $comment): ?>
						<div class='comment'>
							<?php echo $comment['comment'];?>
<?php				endforeach;?>
				</div>
<?php			endif; ?>
				</label>
				
			</li>
		</tr>
	<?php endforeach; ?>
	</ul>
	<a
		data-role='button'
		onclick="$('li[data-correct=true]').addClass('correct');$('li div.comments').show();"
	>
		<?php	echo __('Show Solution');?>
	</a>
<?php endif; ?>

</div>

<h3><?php echo __('Subject');?>:
	<?php echo $this->Html->link(
		$question['Subject']['name'],
		array(
			'controller' => 'subjects',
			'action' => 'view',
			$question['Subject']['id']
		),
		array('data-role'=>'button','data-inline'=>'true'));
	?>
</h3>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul data-role='listview' data-inset='true' data-theme='b'>
		<li><?php echo $this->Html->link(__('Edit Question'), array('action' => 'edit', $question['Question']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Question'), array('action' => 'delete', $question['Question']['id']), null, __('Are you sure you want to delete # %s?', $question['Question']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Material'), array('controller' => 'materials', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="related">
	<h3><?php echo __('Related Exams');?></h3>
	<ul data-role='listview' data-inset='true'>
		<?php foreach ($question['Exam'] as $exam):?>
			<li>
				<?php echo $this->Html->link(
					$exam['fullname'],
					array(
						'controller'=>'exams',
						'action'=>'view',
						$exam['id']
					)
				);?>
			</li>
		<?php endforeach; ?>
	</ul>
</div> <!-- End Related Exams -->

<div class="related">
	<h3><?php echo __('Related Comments');?></h3>
	<?php if (!empty($question['Comment'])):?>
	<ul data-role='listview' data-inset='true'>
	<?php
		$i = 0;
		foreach ($question['Comment'] as $comment): ?>
		<li>
				<?php echo $this->Html->link($comment['comment'], array('controller' => 'comments', 'action' => 'view', $comment['id'])); ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>

<div class="related">
	<h3><?php echo __('Related Materials');?></h3>
	<?php if (!empty($question['Material'])):?>
	<ul data-role='listview' data-inset='true'>
	<?php
		foreach ($question['Material'] as $material): ?>
		<li>
				<?php echo $this->Html->link($material['title'], array('controller' => 'materials', 'action' => 'view', $material['id'])); ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>
