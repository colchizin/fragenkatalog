<?php
App::uses('AppModel', 'Model');
/**
 * Answer Model
 *
 * @property Question $Question
 * @property Comment $Comment
 */
class Answer extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'answer' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'correct' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'question_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'joinTable' => 'answers_comments',
			'foreignKey' => 'answer_id',
			'associationForeignKey' => 'comment_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	public function save($data) {
		
		$comments = array();
		if (isset($data['Comment'])) {
			foreach ($data['Comment'] as $comment) {
				// when saving a single entry, CakePHP expexts Data in the Form
				// array('Model'=>data, 'Model2'=>data);
				$comment = array('Comment'=>$comment);
				if (trim($comment['Comment']['comment']) == "") {
					continue;
				}
				if (!isset($comment['Comment']['id']) || $comment['Comment']['id']==0)
					$this->Comment->create($comment);

				if ($this->Comment->save($comment))	{
					$comments[] = $this->Comment->id;
				} else {
					return false;
				}
			}
		}

		$data['Comment']['Comment'] = $comments;

		return parent::save($data);
	}

}
