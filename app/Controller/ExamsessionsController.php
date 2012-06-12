<?php
App::uses('AppController', 'Controller');
/**
 * Examsessions Controller
 *
 * @property Examsession $Examsession
 */
class ExamsessionsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Examsession->recursive = 0;
		$this->set('examsessions', $this->paginate());
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
		$this->set('examsession', $this->Examsession->read(null, $id));
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
		if ($this->Examsession->delete()) {
			$this->Session->setFlash(__('Examsession deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Examsession was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
