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
			<td><?php echo count($session['ExamsessionsQuestion']);?></td>
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
		<th><?php echo __('Started');?></th>
		<th><?php echo __('Finished');?></th>
		<th><?php echo __('Results');?></th>
	</tr>
	<?php foreach ($sessions_finished as $session):?>
		
		<tr>
			<td><?php echo $session['Exam']['Subject']['name'];?></td>
			<td><?php echo $session['Exam']['fullname'];?></td>
			<td><?php echo $session['Examsession']['created'];?></td>
			<td><?php echo $session['Examsession']['finished'];?></td>
			<td>
				<?php echo $this->Html->link(__('Results'), array(
					'controller'=>'examsessions',
					'action'=>'result',
					$session['Examsession']['id']
				));?>
			</td>
		</tr>

	<?php endforeach;?>
</table>
</div>
