	<ul data-role='listview' data-inset='true' data-theme='b'>
		<li><?php echo $this->Html->link(__('Start Exam'), array('action'=>'exam', $exam['Exam']['id']));?></li>
	</ul>
<dl>
	<dt><?php echo __('Subject');?></dt>
	<dd><?php echo $this->Html->link($exam['Subject']['name'],
		array(
			'controller'=>'subjects',
			'action'=>'view',
			$exam['Subject']['id']
		),
		array(
			'data-role'=>'button'
		)
	);?></dd>
</dl>
<div class="related">
	<h3><?php echo __('Questions');?></h3>
	<ol data-role='listview' data-inset='true' class='listview'>
		<?php foreach($exam['Question'] as $question):?>
			<li>
				<?php echo $this->Html->link(
					$question['question'],
					array(
						'controller'=>'questions',
						'action'=>'view',
						$question['id']
					)
				);?>
			</li>
		<?php endforeach; ?>
	</ol>
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul data-role='listview' data-inset='true' data-theme='b' class='listview'>
		<li><?php echo $this->Html->link(__('Start Exam'), array('action'=>'exam', $exam['Exam']['id']));?></li>
		<li><?php echo $this->Html->link(__('Edit Exam'), array('action' => 'edit', $exam['Exam']['id'])); ?> </li>
		<li><?php echo $this->Html->link(
			__('Add New Question'),
			array(
				'controller'=>'questions',
				'action' => 'add'
			)
		); ?> </li>
		<li><?php echo $this->Html->link(
			__('Add Existing Question'),
			array(
				'controller'=>'exams',
				'action' => 'addExistingQuestions',
				$exam['Exam']['id']
			)
		); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Exam'), array('action' => 'delete', $exam['Exam']['id']), null, __('Are you sure you want to delete # %s?', $exam['Exam']['id'])); ?> </li>
	</ul>
</div>
