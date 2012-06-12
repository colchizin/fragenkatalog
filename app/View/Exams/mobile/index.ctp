<?php $this->set('title_for_layout', __('Exams'));?>
<ul data-role='listview'>
	<?php foreach ($exams as $exam):?>

		<li>
			<?php echo $this->Html->link('<h3>' . $exam['Exam']['fullname'] . '</h3><p>' . $exam['Subject']['name'] . '</p>', array(
				'controller'=>'exams',
				'action' => 'view',
				$exam['Exam']['id'],
			), array('escape'=>false));?>
		</li>
		
	<?php endforeach; ?>
</ul>
<div data-role='navbar'>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
