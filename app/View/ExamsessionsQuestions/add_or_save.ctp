<?php
	echo $this->Form->create("ExamsessionsQuestion");
	echo $this->Form->inputs(array(
		'question_id',
		'answer_id'
	));
	echo $this->Form->end('Submit');
?>
