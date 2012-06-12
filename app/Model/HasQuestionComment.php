<?php

class HasQuestionComment extends Model {
	public $useTable = 'questions_comments';

	public $belongsTo = array(
		'Question'=>array(
			'foreignKey' => 'question_id'
		),
		'Comment' => array(
			'foreignKey' => 'comment_id'
		)
	);
}

?>
