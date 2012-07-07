<div class="related">
	<h3>Exams</h3>
	<ul data-role='listview' data-inset='true'>

	<?php
		foreach($semesters as $semester=>$exams):?>
			<li>
				<?php echo __('%sth semester', $semester);?>

				<ul>
				<?php foreach ($exams as $exam):?>
					<li>
						<span class='ui-li-count'>
							<?php echo $exam['Examsession']['count_finished'];?> /
							<?php echo $exam['Examsession']['count_total']-$exam['Examsession']['count_finished'];?>
						</span>
						<?php echo $this->Html->link($exam['Exam']['fullname'],array(
							'controller'=>'exams',
							'action'=>'view',
							$exam['Exam']['id']
						));?>
					</li>
				<?php endforeach;?>
					<li data-theme='a'>
						<span class='ui-li-count'>
							<?php echo __('finished');?> / <?php echo __('Unfinished Exams');?>
						</span>
						<span>Legende</span>
					</li>
				</ul>
			</li>
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
		</dd>
	</dl>
</div>

