<?php
	$this->Html->css('exam', null, array('inline'=>false));
	$this->Html->script('examsession', array('inline'=>false));
?>


<ul data-role="listview" id='exams'>
	<li data-role='list-divider'><?php echo __('Unfinished Exams');?></li>
	<?php foreach ($sessions_unfinished as $session):?>
		
		<li><a href="/fragenkatalog/examsessions/continue_session/<?php echo $session['Examsession']['id'];?>">
			<span class='ui-li-count'>
			<?php echo count($session['ExamsessionsQuestion']);?>
			/
			<?php echo $session['Exam']['question_count'];?>
			</span>
			<h3><?php echo $session['Exam']['Subject']['name'];?></h3>
			<p><?php echo $session['Exam']['shortname'];?></p>
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
		</li>

	<?php endforeach;?>
<li data-role='list-divider'><?php echo __('Finished Exams');?></li>
<li data-role='fieldcontain'>
	<label for='slider-percentage'><?php echo __('Upper Limit');?></label>
	<input
		type='range'
		name='slider-percentage-upper'
		id='slider-percentage-upper'
		value='100'
		max='100'
		min='0'
		step='10'
		data-highlight="true"
	/>
</li>
<li data-role='fieldcontain'>
	<?php echo $this->Form->input('subject_id', array(
		'type'=>'select',
		'label' => __('Subject'),
		'div'=>false,
		'options' => $subjects,
		'empty' => __('All Subjects')
	));?>
</li>

	<?php foreach ($sessions_finished as $session):?>
		<?php
			$percent = round(($session['Examsession']['correct']/$session['Examsession']['valid'])*100,0);
		?>
		
		<li
			data-value='<?php echo $percent;?>'
			data-role='exams-finished'
			data-subject='<?php echo $session['Exam']['subject_id'];?>'
		>
			<span
				class='ui-li-count <?php echo $this->Exam->classByPercentage($percent);?>'
			><?php echo $percent;?> %</span>
			<a href="/fragenkatalog/examsessions/result/<?php echo $session['Examsession']['id'];?>">
			<h3>
				<?php echo $session['Exam']['Subject']['name'];?>
			</h3>
			<p><?php echo $session['Exam']['fullname'];?></p>
			</a>
		</li>

	<?php endforeach;?>
</ul>
