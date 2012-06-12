<?php
App::uses('AppController', 'Controller');
/**
 * Universities Controller
 *
 * @property University $University
 */
class UniversitiesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->University->recursive = 0;
		$this->set('universities', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->University->id = $id;
		if (!$this->University->exists()) {
			throw new NotFoundException(__('Invalid university'));
		}
		$this->set('university', $this->University->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->University->create();
			if ($this->University->save($this->request->data)) {
				$this->Session->setFlash(__('The university has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The university could not be saved. Please, try again.'));
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
		$this->University->id = $id;
		if (!$this->University->exists()) {
			throw new NotFoundException(__('Invalid university'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->University->save($this->request->data)) {
				$this->Session->setFlash(__('The university has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The university could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->University->read(null, $id);
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
		$this->University->id = $id;
		if (!$this->University->exists()) {
			throw new NotFoundException(__('Invalid university'));
		}
		if ($this->University->delete()) {
			$this->Session->setFlash(__('University deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('University was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
