<?php
App::uses('AppController', 'Controller');
/**
 * Ticketstatuses Controller
 *
 * @property Ticketstatus $Ticketstatus
 */
class TicketstatusesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Ticketstatus->recursive = 0;
		$this->set('ticketstatuses', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Ticketstatus->id = $id;
		if (!$this->Ticketstatus->exists()) {
			throw new NotFoundException(__('Invalid ticketstatus'));
		}
		$this->set('ticketstatus', $this->Ticketstatus->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ticketstatus->create();
			if ($this->Ticketstatus->save($this->request->data)) {
				$this->Session->setFlash(__('The ticketstatus has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticketstatus could not be saved. Please, try again.'));
			}
		}
		$tickets = $this->Ticketstatus->Ticket->find('list');
		$this->set(compact('tickets'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Ticketstatus->id = $id;
		if (!$this->Ticketstatus->exists()) {
			throw new NotFoundException(__('Invalid ticketstatus'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ticketstatus->save($this->request->data)) {
				$this->Session->setFlash(__('The ticketstatus has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticketstatus could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Ticketstatus->read(null, $id);
		}
		$tickets = $this->Ticketstatus->Ticket->find('list');
		$this->set(compact('tickets'));
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
		$this->Ticketstatus->id = $id;
		if (!$this->Ticketstatus->exists()) {
			throw new NotFoundException(__('Invalid ticketstatus'));
		}
		if ($this->Ticketstatus->delete()) {
			$this->Session->setFlash(__('Ticketstatus deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ticketstatus was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
