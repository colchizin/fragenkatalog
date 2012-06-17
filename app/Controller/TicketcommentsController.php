<?php
App::uses('AppController', 'Controller');
/**
 * Ticketcomments Controller
 *
 * @property Ticketcomment $Ticketcomment
 */
class TicketcommentsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Ticketcomment->recursive = 0;
		$this->set('ticketcomments', $this->paginate());
		$this->set('_serialize', 'ticketcomments');
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Ticketcomment->id = $id;
		if (!$this->Ticketcomment->exists()) {
			throw new NotFoundException(__('Invalid ticketcomment'));
		}
		$this->set('ticketcomment', $this->Ticketcomment->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$ticketcomment = null;
		if ($this->request->is('post')) {
			$this->request->data['Ticketcomment']['user_id'] = $this->Auth->user('id');
			$this->Ticketcomment->create();
			if ($this->Ticketcomment->save($this->request->data)) {
				$ticketcomment = $this->Ticketcomment->read();
				$this->Session->setFlash(__('The ticketcomment has been saved'));
			} else {
				$this->Session->setFlash(__('The ticketcomment could not be saved. Please, try again.'));
			}
		}
		$tickets = $this->Ticketcomment->Ticket->find('list');
		$users = $this->Ticketcomment->User->find('list');
		$this->set(compact('tickets', 'users', 'ticketcomment'));
		$this->set('_serialize','ticketcomment');
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit_mine($id) {
		// Gehört dieser Kommentar zum angemeldeten Nutzer?
		if ($comment = $this->Ticketcomment->findByIdAndUserId($id, $this->Auth->user('id'))) {
			// dann darf er ihn auch löschen
			$this->edit($id);
		} else {
			if ($this->request->is('ajax')) {
				$this->redirect(null,403);
			} else {
				$this->Auth->flash($this->Auth->authError);
				$this->redirect(array('action' => 'index'));
			}
		}
	}

	public function edit($id = null) {
		$this->Ticketcomment->id = $id;
		if (!$this->Ticketcomment->exists()) {
			throw new NotFoundException(__('Invalid ticketcomment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ticketcomment->save($this->request->data)) {
				$this->Session->setFlash(__('The ticketcomment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticketcomment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Ticketcomment->read(null, $id);
		}
		$tickets = $this->Ticketcomment->Ticket->find('list');
		$users = $this->Ticketcomment->User->find('list');
		$this->set(compact('tickets', 'users'));
		$this->set('data',$this->request->data);
		$this->set('_serialize','data');
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete_mine($id) {
		// Gehört dieser Kommentar zum angemeldeten Nutzer?
		if ($comment = $this->Ticketcomment->findByIdAndUserId($id, $this->Auth->user('id'))) {
			// dann darf er ihn auch löschen
			$this->delete($id);
		} else {
			if ($this->request->is('ajax')) {
				$this->redirect(null,403);
			} else {
				$this->Auth->flash($this->Auth->authError);
				$this->redirect(array('action' => 'index'));
			}
		}
	}
 	
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Ticketcomment->id = $id;
		if (!$this->Ticketcomment->exists()) {
			throw new NotFoundException(__('Invalid ticketcomment'));
		}
		if ($this->Ticketcomment->delete()) {
			if ($this->request->is('ajax')) {
				$this->redirect(null,200);
			} else {
				$this->Session->setFlash(__('Ticketcomment deleted'));
				$this->redirect(array('action' => 'index'));
			}
		}
		$this->Session->setFlash(__('Ticketcomment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Ticketcomment->recursive = 0;
		$this->set('ticketcomments', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Ticketcomment->id = $id;
		if (!$this->Ticketcomment->exists()) {
			throw new NotFoundException(__('Invalid ticketcomment'));
		}
		$this->set('ticketcomment', $this->Ticketcomment->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Ticketcomment->create();
			if ($this->Ticketcomment->save($this->request->data)) {
				$this->Session->setFlash(__('The ticketcomment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticketcomment could not be saved. Please, try again.'));
			}
		}
		$tickets = $this->Ticketcomment->Ticket->find('list');
		$users = $this->Ticketcomment->User->find('list');
		$this->set(compact('tickets', 'users'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Ticketcomment->id = $id;
		if (!$this->Ticketcomment->exists()) {
			throw new NotFoundException(__('Invalid ticketcomment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ticketcomment->save($this->request->data)) {
				$this->Session->setFlash(__('The ticketcomment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticketcomment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Ticketcomment->read(null, $id);
		}
		$tickets = $this->Ticketcomment->Ticket->find('list');
		$users = $this->Ticketcomment->User->find('list');
		$this->set(compact('tickets', 'users'));
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Ticketcomment->id = $id;
		if (!$this->Ticketcomment->exists()) {
			throw new NotFoundException(__('Invalid ticketcomment'));
		}
		if ($this->Ticketcomment->delete()) {
			$this->Session->setFlash(__('Ticketcomment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ticketcomment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
