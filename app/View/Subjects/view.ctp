<div class="related">
	<h3>Exams</h3>
	<?php foreach($semesters as $semester=>$exams):?>
	<h4><?php echo __('%sth semester', $semester);?></h4>
		<ul data-role='listview'>
		<?php foreach ($exams as $exam):?>
			<li><?php echo $this->Html->link($exam['Exam']['fullname'],array(
				'controller'=>'exams',
				'action'=>'view',
				$exam['Exam']['id']));?></li>
		<?php endforeach;?>
		</ul>
	<?php endforeach;?>
	</ul>
</div>

<div class="related" data-role='collapsible'>
	<h3><?php echo __('Related Materials');?></h3>
	<?php if (!empty($subject['Material'])):?>
	<ul data-role='listview' data-inset='true' data-filter='true'>
	<?php
		foreach ($subject['Material'] as $material): ?>
		<li>
			<?php echo $this->Html->link($material['title'], array('controller' => 'materials', 'action' => 'view', $material['id'])); ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>

<div class="related" data-role='collapsible' data-content-theme='c'>
	<h3><?php echo __('Related Questions');?></h3>
	<?php if (!empty($subject['Question'])):?>
	<ul data-role='listview' data-inset='true' data-filter='true'>
	<?php
		foreach ($subject['Question'] as $question): ?>
		<li>
			<?php echo $this->Html->link($question['question'], array('controller' => 'questions', 'action' => 'view', $question['id'])); ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

</div>

<div class="subjects view">
	<dl>
		<dt><?php echo __('Programme'); ?></dt>
		<dd>
			<?php echo $this->Html->link(
				$subject['Programme']['name'],
				array(
					'controller' => 'programmes',
					'action' => 'view',
					$subject['Programme']['id']
				),
				array(
					'data-role'=>'button'
				)
			); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul data-role='listview' data-inset='true' data-theme='b'>
		<li><?php echo $this->Html->link(__('Edit Subject'), array('action' => 'edit', $subject['Subject']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam'), array('controller' => 'exams', 'action' => 'create', $subject['Subject']['id'])); ?> </li>
		<li>
			<?php echo $this->Html->link(
				__('Import Exam'),
				array(
					'controller' => 'exams',
					'action' => 'parse',
					$subject['Subject']['id']
				)
			); ?>
		</li>
		<li><?php echo $this->Html->link(__('New Material'), array('controller' => 'materials', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Merge Duplicate Questions'), array(
			'controller' => 'questions',
			'action' => 'duplicates',
			'subject_id'=>$subject['Subject']['id']
		)); ?> </li>
	</ul>
</div>
