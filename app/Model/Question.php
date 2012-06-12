<?php
App::uses('AppModel', 'Model');
/**
 * Question Model
 *
 * @property Subject $Subject
 * @property Answer $Answer
 * @property Comment $Comment
 * @property Material $Material
 */
class Question extends AppModel {
	public $actsAs = array('Containable');
	public $displayField = 'question';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'question' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'subject_id' => array(
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
		'Subject' => array(
			'className' => 'Subject',
			'foreignKey' => 'subject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Answer' => array(
			'className' => 'Answer',
			'foreignKey' => 'question_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Answer.id ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
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
			'joinTable' => 'questions_comments',
			'foreignKey' => 'question_id',
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
		),
		'Material' => array(
			'className' => 'Material',
			'joinTable' => 'questions_materials',
			'foreignKey' => 'question_id',
			'associationForeignKey' => 'material_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Exam' => array(
			'className' => 'Exam',
			'joinTable' => 'questions_exams'
		)
	);

	/**
	 * Speicher eine Frage mitsamt der dazugehörigen Antworten 
	 * 
	 * @param mixed $data 
	 * @access public
	 * @return boolean Im Erfolgsfall true, sonst false
	 */
	public function save($data=null) {
		
		$comments = array();
		if (isset($data['Comment'])) {
			foreach ($data['Comment'] as $comment) {
				// when saving a single entry, CakePHP expexts Data in the Form
				// array('Model'=>data, 'Model2'=>data);
				$comment = array(
					'Comment'=>$comment
				);
				if (!isset($comment['Comment']['id']) || $comment['Comment']['id']==0)
					$this->Comment->create($comment);

				if ($this->Comment->save($comment))	{
					$comments[] = $this->Comment->getInsertID();
				} else {
					return false;
				}
			}
		}
		$data['Comment']['Comment'] = $comments;

		$materials = array();
		if (isset($data['Material'])) {
			foreach ($data['Material'] as $material) {
				// when saving a single entry, CakePHP expexts Data in the Form
				// array('Model'=>data, 'Model2'=>data);
				$material = array('Material'=>$material);
				$material['Material']['subject_id'] = $data['Question']['subject_id'];
				if (!isset($material['Material']['id']) || $material['Material']['id']==0)
					$this->Material->create($material);

				if ($this->Material->save($material))	{
					$materials[] = $this->Material->getInsertID();
				} else {
					echo "Material konnt nicht gespeichert werden<br>";
					var_dump($material);
					return false;
				}
			}
		}
		$data['Material']['Material'] = $materials;

		if (!parent::save($data)) {
			return false;
		}

		if (isset($data['Answer'])) {
			foreach ($data['Answer'] as $answer) {
				// when saving a single entry, CakePHP expexts Data in the Form
				// array('Model'=>data, 'Model2'=>data);
				$answer = array(
					'Answer'=>$answer,
					'Comment'=>(isset($answer['Comment']))?$answer['Comment']:null
				);
				$answer['Answer']['question_id'] = $this->id;
				$answer['Answer']['correct'] = (isset($answer['Answer']['correct']) && $answer['Answer']['correct']=='on')?1:0;
				if (
					!isset($answer['Answer']['id']) || 
					$answer['Answer']['id'] == 0
				)	{ // neue Frage, also erstmal erstellen
					$this->Answer->create($answer);
				}
				if (!$this->Answer->save($answer)) {
					echo "Antwort konnte nicht gespeichert werden<br>";
					return false;
				}
			}
		}

		
		return true;
	}

	/**
	 * Merges multiple Questions into one. Recursively merges Ansers and
	 * Comments. Updates Materials and Exams 
	 * 
	 * @param mixed $questions List of Question-IDs
	 * @access public
	 * @return void
	 */
	public function merge($questions) {
		$hasQuestion = ClassRegistry::init('HasQuestion');
		$hasMaterial = ClassRegistry::init('HasMaterial');
		$hasQuestionComment = ClassRegistry::init('HasQuestionComment');

		// Materialien wird neue Frage zugewiesen
		$hasMaterial->updateAll(
			array('HasMaterial.question_id'=>$questions[0]),
			array('HasMaterial.question_id'=>$questions)
		);

		$hasQuestionComment->updateAll(
			array('HasQuestionComment.question_id'=>$questions[0]),
			array('HasQuestionComment.question_id'=>$questions)
		);

		$hasQuestion->updateAll(
			array('HasQuestion.question_id'=>$questions[0]),
			array('HasQuestion.question_id'=>$questions)
		);

		$firstQuestion = $questions[0];
		unset($questions[0]);

		if (!$this->deleteAll(array('Question.id'=>$questions))) {
			return false;
		}

		return true;
	}

}
