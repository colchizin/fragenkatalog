<?php $this->Html->css('exam', null, array('inline'=>false));?>
<div class="examsessions index">
<h2><?php echo __('Unfinished Exams');?></h2>
<table>
	<tr>
		<th><?php echo __('Subject');?></th>
		<th><?php echo __('Exam');?></th>
		<th><?php echo __('Started');?></th>
		<th><?php echo __('Answered');?></th>
		<th><?php echo __('Actions');?></th>
	</tr>
	<?php foreach ($sessions_unfinished as $session):?>
		
		<tr>
			<td><?php echo $session['Exam']['Subject']['name'];?></td>
			<td><?php echo $this->Html->link($session['Exam']['fullname'], array(
				'controller'=>'exams',
				'action'=>'view',
				$session['Exam']['id']
			));;?></td>
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

<div class="examsessions index">
<h2><?php echo __('Finished Exams');?></h2>
<table>
	<tr>
		<th><?php echo __('Subject');?></th>
		<th><?php echo __('Exam');?></th>
		<th><?php echo __('Result');?></th>
		<th><?php echo __('Started');?></th>
		<th><?php echo __('Finished');?></th>
		<th><?php echo __('Details');?></th>
	</tr>
	<?php foreach ($sessions_finished as $session):
		$percent = round(($session['Examsession']['correct']/$session['Exam']['question_count'])*100,0);
	?>
		<tr>
			<td><?php echo $session['Exam']['Subject']['name'];?></td>
			<td><?php echo $session['Exam']['fullname'];?></td>
			<td class="<?php echo $this->Exam->classByPercentage($percent);?>"><?php echo $percent?> %</td>
			<td><?php echo $session['Examsession']['created'];?></td>
			<td><?php echo $session['Examsession']['finished'];?></td>
			<td>
				<?php echo $this->Html->link(__('Details'),
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
