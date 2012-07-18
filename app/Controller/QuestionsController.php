<?php
App::uses('AppController', 'Controller');
/**
 * Questions Controller
 *
 * @property Question $Question
 */
class QuestionsController extends AppController {

	var $helpers = array('Js');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Question->recursive = 0;
		$this->set('questions', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Question->id = $id;
		$this->Question->contain(array(
			'Answer' => array(
				'answer','id','correct','Comment'
			),
			'Comment',
			'Exam',
			'Material',
			'Subject'
		));
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}
		$this->set('question', $this->Question->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Question->create();
			if ($this->Question->save($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		}
		$subjects = $this->Question->Subject->find('list');
		$comments = $this->Question->Comment->find('list');
		$materials = $this->Question->Material->find('list');
		$this->set(compact('subjects', 'comments', 'materials'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Question->save($this->request->data)) {
				$this->Question->saveField('valid', $this->Question->isValid());
				$this->Session->setFlash(__('The question has been saved'));
				$this->redirect(array('action' => 'view',$this->Question->id));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		} else {
			$this->Question->contain(array(
				'Answer'=>array(
					'answer','id','correct',
					'Comment'=>array(
						'comment','id'
					)
				)
			));
			$this->request->data = $this->Question->findById($id);
		}

		$subjects = $this->Question->Subject->find('list');
		$comments = $this->Question->Comment->find('list');
		$materials = $this->Question->Material->find('list');
		$this->set(compact('subjects', 'comments', 'materials'));
		$this->set('title_for_layout',__('Edit Question'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}
		$question = $this->Question->read(null, $id);
		if ($this->Question->delete()) {
			$this->Session->setFlash(__('Question deleted'));
			$this->redirect(array(
				'controller'=>'subjects',
				'action' => 'view',
				$question['Question']['subject_id']
			));
		}
		$this->Session->setFlash(__('Question was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function duplicates() {
		if (isset($this->request->named['subject_id'])) {
			$params['conditions']['Question.subject_id'] = $this->request->named['subject_id'];
		}

		if (isset($this->request->named['filter'])) {
			$params['conditions']['Question.question LIKE '] = "%" . $this->request->named['filter'] . "%";
		}

		$params['order'] = array(
			'count' => 'DESC',
			'Question.question' => 'ASC'
		);
		$params['group'] = array('Question.question HAVING `count` > 1');
		$params['fields'] = array(
			'Question.question',
			'Question.id',
			'COUNT(Question.question) AS `count`'
		);
		$this->Question->contain(array());
		$this->set('questions', $this->Question->find('all',$params));
		
	}

	public function merge($id = null) {
		if ($this->request->is('post')) {
			if (isset($this->request->data['confirm'])) {
				if ($this->Question->merge($this->request->data['Question']['id']))	{
					$this->Session->setFlash(__('Questions successfully merged'));
					$this->redirect(array(
						'action'=>'view',
						$this->request->data['Question']['id'][0]
					));
				} else {
					$this->Session->setFlash(__('Questions could not be merged'));
				}
			} else {
				$this->request->data['confirm'] = true;
				$this->Session->setFlash(__('Please Confirm.'));
				$params['conditions']['Question.id'] = $this->request->data['Question']['id'];
			}
		}

		if (isset($this->request->named['subject_id'])) {
			$params['conditions']['Question.subject_id'] = $this->request->named['subject_id'];
		}

		if (isset($this->request->named['filter'])) {
			$params['conditions']['Question.question LIKE '] = "%" . $this->request->named['filter'] . "%";
		}

		if ($id != null) {
			$this->Question->id = $id;
			if ($this->Question->exists()) {
				$question = $this->Question->read();
				$params['conditions']['Question.question'] = $question['Question']['question'];

				// Wenn schon direkt eine Fragen-Id angegeben ist, dann gehen
				// wir davon aus, dass der Benutzer direkt bestätigen kann
				$this->request->data['confirm'] = false;
			}
		}

		$params['order']['Question.question'] = 'ASC';
		$this->Question->contain(array(
			'Answer'=>array(
				'answer',
				'Comment'=>array(
					'comment'
				)
			),
			'Comment'=>array('comment')
		));
		$this->set('questions', $this->Question->find('all',$params));
	}

	public function check_validity($id = null) {
		if ($id != null) {
			$this->Question->id = $id;
			$valid = $this->Question->isValid();
			$this->Question->saveField('valid', $valid);
			echo "{$this->Question->id} updated to $valid<br>";
			exit;
		}

		$this->Question->contain(array(
			'Answer' => 'correct'
		));
		$questions = $this->Question->query('SELECT Question.id FROM questions as Question');

		echo "Alle Fragen geladen<br>";

		foreach ($questions as $question) {
			$this->Question->id = $question['Question']['id'];
			$valid = $this->Question->isValid();
			$this->Question->saveField('valid', $valid);
			echo "{$this->Question->id} updated to $valid<br>";
		}

		exit();
	}
}
