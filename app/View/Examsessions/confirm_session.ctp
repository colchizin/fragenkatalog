<div class='info'>

<p><strong>Du hast bereits eine Klausur geöffnet:</strong></p>

<p><?php echo $this->Html->link($session['Exam']['fullname'],array('action'=>'continue_last_session'));?></p>

<p>Möchtest du die alte Sitzung fortsetzen oder mit der neuen Klausur
(<?php echo $this->Html->link(
	$exam['Exam']['fullname'],
	array('action'=>'new_session', $exam['Exam']['id'])
);?>)
beginnen?</p>

<p>
	<?php echo $this->Html->link(
		__('Continue previous session'),
		array('action'=>'continue_current_session'),
		array('data-role'=>'button')
	);?>

	<?php echo $this->Html->link(
		__('Start new exam'),
		array('action'=>'new_session', $exam['Exam']['id']),
		array('data-role'=>'button')
	);?>
</p>

</div>
