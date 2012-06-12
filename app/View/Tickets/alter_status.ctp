<?php

	$this->Html->script('jquery.wysiwyg', array('inline'=>false));
	$this->Js->buffer('$("#TicketcommentComment").wysiwyg();');

	echo $this->Form->create('HasTicketstatus');
	echo $this->Form->input('ticketstatus_id');
	echo $this->Form->input('Ticketcomment.comment', array('style'=>'width:70% !important;'));
	echo $this->Form->end(__('Save'));

?>
