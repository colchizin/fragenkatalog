<?php $this->Html->css('exam', null, array('inline'=>false));?>
	<ul data-role='listview' data-inset='true' data-theme='b'>
		<li><?php echo $this->Html->link(__('Start Exam'), array('action'=>'exam', $exam['Exam']['id']));?></li>
	</ul>
<div class="related" data-role='collapsible'>
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

<div class='related'>
	<h3><?php echo __('Examsessions');?></h3>
	<ul data-role='listview' data-inset='true'>
		<?php foreach ($examsessions as $session):?>
			<li>
				<?php if ($session['Examsession']['finished']):
					$percent = round(($session['Examsession']['correct'] / $session['Examsession']['valid']) * 100, 0);
				?>
						<span class='ui-li-count <?php echo $this->Exam->classByPercentage($percent);?>'>
							<?php echo $percent;?> %
						</span>
						<h3><?php echo __('Finished Exam');?></h3>
						<p><?php echo $session['Examsession']['finished'];?></p>

				<?php else: ?>
					<a href='<?php echo Router::url(array(
						'controller'=>'examsessions',
						'action' => 'continue_session',
						$session['Examsession']['id']
					));?>'
					>
						<span class='ui-li-count'>
							<?php echo $session['Examsession']['examsessions_question_count'];?> /
							<?php echo $exam['Exam']['question_count'];?>
						</span>
						<h3><?php echo __('Unfinished Exam');?></h3>
						<p><?php echo $session['Examsession']['created'];?></p>
					</a>
					
					<?php echo $this->Form->postLink(
						__('Delete'),
						array(
							'controller'=>'examsessions',
							'action' => 'delete',
							$session['Examsession']['id']
						),
						array(
							'data-icon' => 'delete'
						),
						__("Are you sure you want to remove this exam from your list of unfinished exams?")
					);?>
				<?php endif;?>
			</li>
		<?php endforeach;?>
	</ul>
</div>

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

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul data-role='listview' data-inset='true' data-theme='b' class='listview'>
		<li><?php echo $this->Html->link(__('Start Exam'), array('action'=>'exam', $exam['Exam']['id']));?></li>
	</ul>
</div>
