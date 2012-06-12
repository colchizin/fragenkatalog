<?php
/**
 * ExamsessionsQuestionFixture
 *
 */
class ExamsessionsQuestionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'examsession_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'question_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'answer_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'examsession_id' => 1,
			'question_id' => 1,
			'answer_id' => 1,
			'created' => '2012-06-08 12:27:21'
		),
	);
}
