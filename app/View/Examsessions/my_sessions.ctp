<?php
	$this->Html->css('exam', null, array('inline'=>false));
	$this->Html->script('examsession', array('inline'=>false));
?>

<div class="examsessions index">
<h2><?php echo __('Unfinished Exams');?></h2>
<table>
	<tr>
		<th><?php echo __('Subject');?></th>
		<th><?php echo __('Exam');?></th>
		<th><?php echo __('Sem.');?></th>
		<th><?php echo __('Started');?></th>
		<th><?php echo __('Answered');?></th>
		<th><?php echo __('Actions');?></th>
	</tr>
	<?php foreach ($sessions_unfinished as $session):?>
		
		<tr>
			<td>
			<?php echo $this->Html->link($session['Exam']['Subject']['name'], array(
				'controller'=>'subjects',
				'action'=>'view',
				$session['Exam']['Subject']['id']
			));?>
			</td>
			<td><?php echo $this->Html->link($session['Exam']['fullname'], array(
				'controller'=>'exams',
				'action'=>'view',
				$session['Exam']['id']
			));;?></td>
			<td><?php echo $session['Exam']['semester'];?></td>
			<td><?php echo $session['Examsession']['created'];?></td>
			<td>
				<?php echo $session['Examsession']['examsessions_question_count'];?>
				/
				<?php echo $session['Exam']['question_count'];?>
			</td>
			<td>
				<?php echo $this->Html->link(
					__('Continue exam'),
					array(
						'controller'=>'examsessions',
						'action' => 'continue_session',
						$session['Examsession']['id']
					),
					array(
						'data-role'=>'button'
					)
				);?>

				<?php echo $this->Form->postLink(
					__('Delete'),
					array(
						'controller'=>'examsessions',
						'action' => 'delete',
						$session['Examsession']['id']
					),
					array(
						'data-role'=>'button'
					),
					__("Are you sure you want to remove this exam from your list of unfinished exams?")
				);?>
			</td>
		</tr>

	<?php endforeach;?>
</table>
</div>

<div class="examsessions index" id='exams'>
<h2><?php echo __('Finished Exams');?></h2>
<p>
	<span id='slider-percentage-lower-value'>0%</span>
	<input type='range' id='slider-percentage-lower' min='0' max='100' value='0' />

	bis

	<input type='range' id='slider-percentage-upper' min='0' max='100' value='100' />
	<span id='slider-percentage-upper-value'>100%</span>,

	<?php echo $this->Form->input('subject_id', array(
		'type'=>'select',
		'label' => false,
		'div'=>false,
		'options' => $subjects,
		'empty' => __('All Subjects')
	));?>
</p>
<table>
	<tr>
		<th><?php echo __('Subject');?></th>
		<th><?php echo __('Exam');?></th>
		<th><?php echo __('Sem.');?></th>
		<th><?php echo __('Result');?></th>
		<th><?php echo __('Started');?></th>
		<th><?php echo __('Finished');?></th>
		<th><?php echo __('Details');?></th>
	</tr>
	<?php foreach ($sessions_finished as $session):
		$percent = round(($session['Examsession']['correct']/$session['Examsession']['valid'])*100,0);
	?>
		<tr
			data-role="exams-finished"
			data-value="<?php echo $percent;?>"
			data-subject="<?php echo $session['Exam']['Subject']['id'];?>"
		>
			<td>
			<?php echo $this->Html->link($session['Exam']['Subject']['name'], array(
				'controller'=>'subjects',
				'action'=>'view',
				$session['Exam']['Subject']['id']
			));?>
			</td>
			<td><?php echo $this->Html->link($session['Exam']['fullname'], array(
				'controller'=>'exams',
				'action'=>'view',
				$session['Exam']['id']
			));;?></td>
			<td><?php echo $session['Exam']['semester'];?></td>
			<td class="<?php echo $this->Exam->classByPercentage($percent);?>"><?php echo $percent?> %</td>
			<td><?php echo $session['Examsession']['created'];?></td>
			<td><?php echo $session['Examsession']['finished'];?></td>
			<td class='actions'>
				<?php echo $this->Html->link(__('Result'),
					array(
						'controller'=>'examsessions',
						'action'=>'result',
						$session['Examsession']['id']
					),
					array(
						'data-role'=>'button'
					)
				);?>
			</td>
		</tr>

	<?php endforeach;?>
</table>
</div>
