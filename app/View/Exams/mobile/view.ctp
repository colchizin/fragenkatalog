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
