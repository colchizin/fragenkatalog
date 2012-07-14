<?php $this->Html->css('exam', null, array('inline'=>false));?>
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
	<h3>Prüfungssitzungen</h3>
	<table>
		<thead>
			<tr>
				<th><?php echo __('Status');?></th>
				<th><?php echo __('Timestamp');?></th>
				<th><?php echo __('Result');?></th>
				<th><?php echo __('Actions');?></th>
			</tr>
		</thead>
		<tbody>
<?php

		foreach ($examsessions as $session): ?>
			<tr>
				<?php if ($session['Examsession']['finished']):
					$percent = round(($session['Examsession']['correct'] / $session['Examsession']['valid']) * 100, 0);
				?>
					<td><?php echo __('Finished Exam');?></td>
					<td><?php echo $session['Examsession']['finished'];?></td>
					<td class="<?php echo $this->Exam->classByPercentage($percent);?>"><?php echo $percent;?>%</td>
					<td class='actions'>
						<?php echo $this->Html->link(__('Result'), array(
							'controller' => 'examsessions',
							'action' => 'result',
							$session['Examsession']['id']
						));?>
					</td>
				<?php else: ?>
					<td><?php echo __('Unfinished Exam');?></td>
					<td><?php echo $session['Examsession']['created'];?></td>
					<td>
						<?php echo $session['Examsession']['examsessions_question_count'];?> /
						<?php echo $exam['Exam']['question_count'];?>
					</td>
					<td class='actions'>
					<?php
					echo $this->Html->link(__("Continue exam"), array(
						'controller' => 'examsessions',
						'action' => 'continue_session',
						$session['Examsession']['id']
					));
					echo $this->Form->postLink(
						__('Delete'),
						array(
							'controller'=>'examsessions',
							'action' => 'delete',
							$session['Examsession']['id']
						),
						null,
						__("Are you sure you want to remove this exam from your list of unfinished exams?")
					);?>
					</td>
				<?php endif;?>
			</tr>
<?php
		endforeach;
?>
		</tbody>
	</table>

</div>

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
