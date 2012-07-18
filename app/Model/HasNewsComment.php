<?php

class HasNewsComment extends Model {
	public $useTable = 'news_comments';

	public $belongsTo = array(
		'News'=>array(
			'foreignKey' => 'news_id'
		),
		'Comment' => array(
			'foreignKey' => 'comment_id'
		)
	);
}

?>
