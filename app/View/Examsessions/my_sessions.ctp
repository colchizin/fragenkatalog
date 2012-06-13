<div class="examsessions index">
<h2><?php echo __('Unfinished Exams');?></h2>
<table>
	<tr>
		<th><?php echo __('Subject');?></th>
		<th><?php echo __('Exam');?></th>
		<th><?php echo __('Started');?></th>
		<th><?php echo __('Continue');?></th>
	</tr>
	<?php foreach ($sessions_unfinished as $session):?>
		
		<tr>
			<td><?php echo $session['Exam']['Subject']['name'];?></td>
			<td><?php echo $session['Exam']['fullname'];?></td>
			<td><?php echo $session['Examsession']['created'];?></td>
			<td>
				<?php echo $this->Html->link(
					__('Continue exam'),
					array(
						'controller'=>'examsessions',
						'action' => 'continue_session',
						$session['Examsession']['id']
					)
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
