<?php
App::uses('AppController', 'Controller');
/**
 * QuestionsMaterials Controller
 *
 * @property QuestionsMaterial $QuestionsMaterial
 */
class QuestionsMaterialsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->QuestionsMaterial->recursive = 0;
		$this->set('questionsMaterials', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->QuestionsMaterial->id = $id;
		if (!$this->QuestionsMaterial->exists()) {
			throw new NotFoundException(__('Invalid questions material'));
		}
		$this->set('questionsMaterial', $this->QuestionsMaterial->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->QuestionsMaterial->create();
			if ($this->QuestionsMaterial->save($this->request->data)) {
				$this->Session->setFlash(__('The questions material has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The questions material could not be saved. Please, try again.'));
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
		$this->QuestionsMaterial->id = $id;
		if (!$this->QuestionsMaterial->exists()) {
			throw new NotFoundException(__('Invalid questions material'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->QuestionsMaterial->save($this->request->data)) {
				$this->Session->setFlash(__('The questions material has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The questions material could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->QuestionsMaterial->read(null, $id);
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
		$this->QuestionsMaterial->id = $id;
		if (!$this->QuestionsMaterial->exists()) {
			throw new NotFoundException(__('Invalid questions material'));
		}
		if ($this->QuestionsMaterial->delete()) {
			$this->Session->setFlash(__('Questions material deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Questions material was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
