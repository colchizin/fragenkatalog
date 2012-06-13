<?php
App::uses('AppModel', 'Model');
/**
 * Exam Model
 *
 * @property Subject $Subject
 */
class Exam extends AppModel {
	public $actsAs = array('Containable');
	public $virtualFields = array(
		'fullname' => "
			CONCAT(
				Exam.title,
				' ',
				IF(
					Exam.year IS NULL,
					'',
					CONCAT(
						IF(
							Exam.term=0,
							'Sommersemester',
							'Wintersemester'
						),
						' ',
						Exam.year
					)
				)
			)",
		'shortname' => "
			CONCAT(
				Exam.title,
				' ',
				IF(
					Exam.year IS NULL,
					'',
					CONCAT(
						IF(
							Exam.term=0,
							'SS',
							'WS'
						),
						' ',
						Exam.year
					)
				)
			)",
	);
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'year' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'term' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
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
		'semester' => array(
			'numeric' => array(
				'rule'=>array('numeric')
			)
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $hasMany = array(
		'Examsession'
	);

	public $belongsTo = array(
		'Subject' => array(
			'className' => 'Subject',
			'foreignKey' => 'subject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasAndBelongsToMany = array(
		'Question' => array(
			'className' => 'Question',
			'joinTable' => 'questions_exams'
		)
	);

	public function saveEntirelyNew($data) {
		$questions = array();
		if (isset($data['Question']) && count($data['Question']>0))	{
			foreach ($data['Question'] as $question) {
				// when saving a single entry, CakePHP expexts Data in the Form
				// array('Model'=>data, 'Model2'=>data);
				$question = array(
					'Question'=>$question,
					'Answer'=>(isset($question['Answer'])) ? $question['Answer'] : null,
					'Comment'=>(isset($question['Comment'])) ? $question['Comment'] : null,
					'Material'=>(isset($question['Material'])) ? $question['Material'] : null
				);
				$question['Question']['subject_id'] = $data['Exam']['subject_id'];

				$this->Question->create($question);
				if (!$this->Question->save($question)) {
					echo "Frage konnt nicht gespeichert werden<br>";
					return false;
				}
				$questions[] = $this->Question->getInsertID();
			}
			$data['Question']['Question'] = $questions;
		}

		if ($data['Exam']['year'] == "") {
			unset($data['Exam']['year']);
			unset($data['Exam']['term']);
		} else if ($data['Exam']['term'] == "") {
			unset($data['Exam']['term']);
		}

		$this->create($data);
		if (!$this->save()) {
			var_dump("Speichern des Exams fehlgeschlagen");
			var_dump($data['Exam']);
			return false;
		}
		return $this->read();
	}

	public function findByIdMergeExamsession($id, $session_id) {
		$this->contain(array(
			'Question'=>array(
				'id','question','attachment',
				'Answer'=>array(
					'answer',
					'id',
					'correct',
					'Comment'=>array('comment', 'User'=>array('username','id'))
				),
				'Comment'=>array('comment', 'User'=>array('username','id')),
				'Material'
			),
			'Subject'
		));
		$this->Examsession->contain(array(
			'ExamsessionsQuestion'
		));

		$exam = $this->findById($id);
		$session = $this->Examsession->findById($session_id);
		if (!empty($session['ExamsessionsQuestion'])) {
			foreach ($exam['Question'] as &$question) {
				foreach ($question['Answer'] as &$answer) {
					foreach ($session['ExamsessionsQuestion']as &$esquestion) {
						if ($esquestion['answer_id'] == $answer['id']) {
							$answer['checked'] = true;
						}
					}
				}
			}
		}
		return $exam;
	}
}
