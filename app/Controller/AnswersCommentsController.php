<?php
App::uses('AppController', 'Controller');
/**
 * AnswersComments Controller
 *
 * @property AnswersComment $AnswersComment
 */
class AnswersCommentsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AnswersComment->recursive = 0;
		$this->set('answersComments', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->AnswersComment->id = $id;
		if (!$this->AnswersComment->exists()) {
			throw new NotFoundException(__('Invalid answers comment'));
		}
		$this->set('answersComment', $this->AnswersComment->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AnswersComment->create();
			if ($this->AnswersComment->save($this->request->data)) {
				$this->Session->setFlash(__('The answers comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The answers comment could not be saved. Please, try again.'));
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
		$this->AnswersComment->id = $id;
		if (!$this->AnswersComment->exists()) {
			throw new NotFoundException(__('Invalid answers comment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->AnswersComment->save($this->request->data)) {
				$this->Session->setFlash(__('The answers comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The answers comment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->AnswersComment->read(null, $id);
		}
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
		$this->AnswersComment->id = $id;
		if (!$this->AnswersComment->exists()) {
			throw new NotFoundException(__('Invalid answers comment'));
		}
		if ($this->AnswersComment->delete()) {
			$this->Session->setFlash(__('Answers comment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Answers comment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
