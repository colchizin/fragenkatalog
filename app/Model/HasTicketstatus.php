<?php

class HasTicketstatus extends Model {
	public $useTable = 'tickets_ticketstatuses';

	public $belongsTo = array(
		'Ticket'=>array(
			'foreign_key'=>'ticket_id'
		),
		'Ticketstatus'=>array(
			'foreign_key'=>'ticketstatus_id'
		)
	);
}
