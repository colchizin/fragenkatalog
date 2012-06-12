<?php
App::uses('AppModel', 'Model');
/**
 * Subject Model
 *
 * @property Programme $Programme
 * @property Exam $Exam
 * @property Material $Material
 * @property Question $Question
 */
class Subject extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'programme_id' => array(
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
		'Programme' => array(
			'className' => 'Programme',
			'foreignKey' => 'programme_id',
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
		'Exam' => array(
			'className' => 'Exam',
			'foreignKey' => 'subject_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => array(
				'Exam.year'=>'ASC',
				'Exam.term'=>'ASC',
				'Exam.title'=>'ASC'
			),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Material' => array(
			'className' => 'Material',
			'foreignKey' => 'subject_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Material.title',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'subject_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Question.question ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function getExamCountGroupedBySemesterAndSubject() {
		$db = $this->getDataSource();
		$query = "SELECT
					Exam.semester,
					Subject.name,
					Subject.id,
					COUNT( semester ) AS exam_count
				FROM exams as Exam
				JOIN subjects AS Subject ON Exam.subject_id = Subject.id
				GROUP BY Exam.semester, Subject.id";

		$data = $db->query($query);
		$result = array();

		foreach($data as $entry) {
			$entry['Subject']['exam_count'] = $entry[0]['exam_count'];
			$result[$entry['Exam']['semester']][] = $entry;
		}

		return $result;
	}

	public function getExamsGroupedBySemester($subject_id) {
			$this->Exam->contain();
			$data = $this->Exam->findAllBySubjectId($subject_id);
			$result = array();

			foreach ($data as $entry) {
				$result[$entry['Exam']['semester']][] = $entry;
			}

			return $result;
	}

}
