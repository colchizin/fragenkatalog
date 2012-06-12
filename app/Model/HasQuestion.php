<?php

class HasQuestion extends Model {
	public $useTable = 'questions_exams';

	public $belongsTo = array(
		'Question'=>array(
			'foreignKey' => 'question_id'
		),
		'Exam' => array(
			'foreignKey' => 'exam_id'
		)
	);
}

?>
