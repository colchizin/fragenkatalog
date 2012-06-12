<?php
App::uses('AppController', 'Controller');
/**
 * Tickettypes Controller
 *
 * @property Tickettype $Tickettype
 */
class TickettypesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Tickettype->recursive = 0;
		$this->set('tickettypes', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Tickettype->id = $id;
		if (!$this->Tickettype->exists()) {
			throw new NotFoundException(__('Invalid tickettype'));
		}
		$this->set('tickettype', $this->Tickettype->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tickettype->create();
			if ($this->Tickettype->save($this->request->data)) {
				$this->Session->setFlash(__('The tickettype has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tickettype could not be saved. Please, try again.'));
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
		$this->Tickettype->id = $id;
		if (!$this->Tickettype->exists()) {
			throw new NotFoundException(__('Invalid tickettype'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tickettype->save($this->request->data)) {
				$this->Session->setFlash(__('The tickettype has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tickettype could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Tickettype->read(null, $id);
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
		$this->Tickettype->id = $id;
		if (!$this->Tickettype->exists()) {
			throw new NotFoundException(__('Invalid tickettype'));
		}
		if ($this->Tickettype->delete()) {
			$this->Session->setFlash(__('Tickettype deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tickettype was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
