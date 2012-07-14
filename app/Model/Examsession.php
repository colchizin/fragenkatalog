<?php
App::uses('AppModel', 'Model');
/**
 * Examsession Model
 *
 * @property User $User
 * @property Exam $Exam
 * @property Question $Question
 */
class Examsession extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'exam_id' => array(
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Exam' => array(
			'className' => 'Exam',
			'foreignKey' => 'exam_id',
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
		'Question' => array(
			'className' => 'Question',
			'joinTable' => 'examsessions_questions',
			'foreignKey' => 'examsession_id',
			'associationForeignKey' => 'question_id',
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

	public $hasMany = array(
		'ExamsessionsQuestion' => array(
		)
	);

	public function calculateResult($id = null) {
		$total = 0;
		$answered = 0;
		$valid = 0;
		$correct_invalid = 0;
		$correct_valid = 0;

		if ($id == null) {
			if ($this->id != null)
				$id = $this->id;
			else
				return false;
		} else {
			$this->id = $id;
		}

		$questions = $this->ExamsessionsQuestion->findAllByExamsessionId($id);

		foreach ($questions as $question) {
			$answered++;

			// nur gültige Fragen werden für die Berechnung des Ergebnisses
			// zugrund gelegt
			if ($question['Question']['valid']) {
				$valid++;
			}

			if ($question['Answer']['correct']) {
				if ($question['Question']['valid'])
					$correct_valid++;
				else
					$correct_invalid++;
			}
		}

		return $this->save(
			array('Examsession'=>array(
				'correct' => $correct_valid,
				'valid' => $valid,
				'id' => $id
			)),
			array('fieldList'=>array(
				// wir speichern nur die Anzahl der korrekt beantworteten
				// die Anzahl der gültigen Fragen
				'correct','valid'
			))
		);
	}

}
