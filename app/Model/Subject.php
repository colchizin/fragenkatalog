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
		$userquery = "";

		$query = "SELECT
					Exam.semester,
					Subject.name,
					Subject.id,
					COUNT( semester ) AS exam_count
				FROM subjects AS Subject
				LEFT JOIN exams AS Exam ON Exam.subject_id = Subject.id
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
			//$this->Exam->contain();
			//$this->Exam->recursive = -1;
			$data = $this->Exam->find('all', array(
				'conditions' => array(
					'subject_id' => $subject_id,
				),
				'order' => array(
					'title' => 'ASC',
					'year' => 'ASC',
					'term' => 'ASC'
				)
				// 'joins' => array(
					// array(
						// 'table' => 'examsessions',
						// 'alias' => 'Examsession',
						// 'type' => 'LEFT',
						// 'conditions' => array('Examsession.exam_id = Exam.id')
					// )
				// )
			));
			$result = array();

			foreach ($data as $entry) {
				$result[$entry['Exam']['semester']][] = $entry;
			}

			return $result;
	}

}
