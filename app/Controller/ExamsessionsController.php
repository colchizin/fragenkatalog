<?php
App::uses('AppController', 'Controller');
/**
 * Examsessions Controller
 *
 * @property Examsession $Examsession
 */
class ExamsessionsController extends AppController {

	public $paginate = array(
		'limit' => 25,
		'order' => array(
			'Examsession.finished' => 'ASC',
			'Examsession.created' => 'DESC'
		)
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Examsession->contain(array(
			'Exam'=>array('id','fullname','Subject'),
			'User'
		));
		$this->set('examsessions', $this->paginate());
	}

	public function my_sessions() {
		$this->set('title_for_layout', __('My Exams'));
		$userid = $this->Auth->user('id');
		$contain = array(
			'Exam'=>array('id','fullname','shortname','Subject'),
			'User',
			'ExamsessionsQuestion'
		);
		
		$this->Examsession->contain($contain);
		$sessions_unfinished = $this->Examsession->find('all', array(
			'conditions' => array(
				'user_id' => $userid,
				'finished' => null
			)
		));
		$this->Examsession->contain($contain);
		$sessions_finished = $this->Examsession->find('all', array(
			'conditions' => array(
				'user_id' => $userid,
				'NOT' => array('finished' => null)
			),
			'joins'=>array(
				array(
					'table'=>'exams',
					'alias'=>'MyExam',
					'conditions'=>'MyExam.id = Examsession.exam_id'
				)
			),
			'order' => array('MyExam.subject_id')
		));

		$this->set(compact('sessions_unfinished','sessions_finished'));
		$this->set('_serialize', compact('sessions_unfinished','sessions_finished'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Examsession->id = $id;
		if (!$this->Examsession->exists()) {
			throw new NotFoundException(__('Invalid examsession'));
		}
		$this->set('examsession', $this->Examsession->findById($id));
	}

	public function result($id = null) {
		$this->Examsession->contain(array(
			'ExamsessionsQuestion' => array('answer_id', 'Question' => array('question','Answer'))
		));
		
		$this->view($id);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Examsession->create();
			if ($this->Examsession->save($this->request->data)) {
				$this->Session->setFlash(__('The examsession has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The examsession could not be saved. Please, try again.'));
			}
		}
		$users = $this->Examsession->User->find('list');
		$exams = $this->Examsession->Exam->find('list');
		$questions = $this->Examsession->Question->find('list');
		$this->set(compact('users', 'exams', 'questions'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Examsession->id = $id;
		if (!$this->Examsession->exists()) {
			throw new NotFoundException(__('Invalid examsession'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Examsession->save($this->request->data)) {
				$this->Session->setFlash(__('The examsession has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The examsession could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Examsession->read(null, $id);
		}
		$users = $this->Examsession->User->find('list');
		$exams = $this->Examsession->Exam->find('list');
		$questions = $this->Examsession->Question->find('list');
		$this->set(compact('users', 'exams', 'questions'));
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

		$this->Examsession->id = $id;
		if (!$this->Examsession->exists()) {
			throw new NotFoundException(__('Invalid examsession'));
		}

		$exam = $this->Examsession->read(null,$id);
		if ($exam['Examsession']['user_id'] != $this->Auth->user('id')) {
			throw new ForbiddenException();
		}
		if ($this->Examsession->delete()) {
			$this->Session->setFlash(__('Examsession deleted'));
			$this->redirect(array('action' => 'my_sessions'));
		}
		$this->Session->setFlash(__('Examsession was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function continue_current_session() {
		$this->redirect(array('controller' => 'exams', 'action'=>'exam'));
	}

	public function continue_session($id = null) {
		if ($id != null) {
			$session = $this->Examsession->findById($id);
			if ($session['Examsession']['user_id'] != $this->Auth->user('id')) {
				$this->Session->flash(__('This session does not belong to you'));
				$this->redirect($this->referer());
			}

			$this->Session->write('Examsession', $id);
		}

		$this->continue_current_session();
	}

	public function confirm_session($id = null) {
		$sessionid = $this->Session->read('Examsession');
		if (!$sessionid)
			$this->redirect(array('controller'=>'exams', 'action'=>'exam',$id));

		$session = $this->Examsession->findById($sessionid);

		$this->Examsession->Exam->id = $id;
		if (!$this->Examsession->Exam->exists()) {
			throw new NotFoundException(__('Invalid exam'));
		}
		$exam = $this->Examsession->Exam->findById($id);
		$this->set(compact('exam','session'));
	}

	public function new_session($id = null) {
		$this->Session->write('Examsession',null);
		$this->redirect(array('controller'=>'exams','action'=>'exam', $id));
	}

	
	public function finish() {
		$this->Examsession->id = $this->Session->read('Examsession');

		if (!$this->Examsession->field('finished'))
			$this->Examsession->saveField('finished',date("y:m:d H:i:s"));

		$this->set('_serialize', true);
	}
}
