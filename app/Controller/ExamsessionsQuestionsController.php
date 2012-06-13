<?php
App::uses('AppController', 'Controller');
/**
 * ExamsessionsQuestions Controller
 *
 * @property ExamsessionsQuestion $ExamsessionsQuestion
 */
class ExamsessionsQuestionsController extends AppController {
	public $components = array('RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ExamsessionsQuestion->recursive = 0;
		$this->set('examsessionsQuestions', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ExamsessionsQuestion->id = $id;
		if (!$this->ExamsessionsQuestion->exists()) {
			throw new NotFoundException(__('Invalid examsessions question'));
		}
		$this->set('examsessionsQuestion', $this->ExamsessionsQuestion->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ExamsessionsQuestion->create();
			if ($this->ExamsessionsQuestion->save($this->request->data)) {
				$this->Session->setFlash(__('The examsessions question has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The examsessions question could not be saved. Please, try again.'));
			}
		}
		$examsessions = $this->ExamsessionsQuestion->Examsession->find('list');
		$questions = $this->ExamsessionsQuestion->Question->find('list');
		$answers = $this->ExamsessionsQuestion->Answer->find('list');
		$this->set(compact('examsessions', 'questions', 'answers'));
	}

	/*
	 * This is only for ajax use
	 */
	public function add_or_save() {
		if ($this->request->is('post')) {
			if ($session_id = $this->Session->read('Examsession')) {
				$data = $this->request->data['ExamsessionsQuestion'];
				$eq = $this->ExamsessionsQuestion->findByExamsessionIdAndQuestionId(
					$session_id,
					$data['question_id']
				);
				if ($eq) {
					$eq['ExamsessionsQuestion']['answer_id'] = $this->request->data['ExamsessionsQuestion']['answer_id'];
				} else {
					$eq = array('ExamsessionsQuestion' => array(
						'question_id' => $data['question_id'],
						'answer_id' => $data['answer_id'],
						'examsession_id' => $session_id
					));
					$this->ExamsessionsQuestion->create();
				}
				$eq = $this->ExamsessionsQuestion->save($eq);
				$this->set('examsessionsQuestion', $eq);
				$this->set('_serialize','examsessionsQuestion');
			}	
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ExamsessionsQuestion->id = $id;
		if (!$this->ExamsessionsQuestion->exists()) {
			throw new NotFoundException(__('Invalid examsessions question'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ExamsessionsQuestion->save($this->request->data)) {
				$this->Session->setFlash(__('The examsessions question has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The examsessions question could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ExamsessionsQuestion->read(null, $id);
		}
		$examsessions = $this->ExamsessionsQuestion->Examsession->find('list');
		$questions = $this->ExamsessionsQuestion->Question->find('list');
		$answers = $this->ExamsessionsQuestion->Answer->find('list');
		$this->set(compact('examsessions', 'questions', 'answers'));
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
		$this->ExamsessionsQuestion->id = $id;
		if (!$this->ExamsessionsQuestion->exists()) {
			throw new NotFoundException(__('Invalid examsessions question'));
		}
		if ($this->ExamsessionsQuestion->delete()) {
			$this->Session->setFlash(__('Examsessions question deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Examsessions question was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
