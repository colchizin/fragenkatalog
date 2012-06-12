<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Invitations Controller
 *
 * @property Invitation $Invitation
 */
class InvitationsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Invitation->recursive = 0;
		$this->set('invitations', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Invitation->id = $id;
		if (!$this->Invitation->exists()) {
			throw new NotFoundException(__('Invalid invitation'));
		}
		$this->set('invitation', $this->Invitation->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Invitation']['user_id'] = $this->Auth->user('id');
			$this->Invitation->create();
			if ($this->Invitation->save($this->request->data)) {
				$invitation = $this->Invitation->findById($this->Invitation->id);
				$this->Session->setFlash(__('The invitation has been submitted'));
				$email = new CakeEmail();
				$email
					->template('invitation','default')
					->emailFormat('text')
					->to($this->request->data['Invitation']['email'])
					->from(Configure::read('Fragenkatalog.email'))
					->subject(__('You habe been invited to %s', "Fragenkatalog"))
					->viewVars(array('invitation'=>$invitation))
					->send()
				;


//				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invitation could not be saved. Please, try again.'));
			}
		}
		$users = $this->Invitation->User->find('list');
		$this->set(compact('users'));
		$this->set('title_for_layout', __('Invite someone'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Invitation->id = $id;
		if (!$this->Invitation->exists()) {
			throw new NotFoundException(__('Invalid invitation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Invitation->save($this->request->data)) {
				$this->Session->setFlash(__('The invitation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invitation could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Invitation->read(null, $id);
		}
		$users = $this->Invitation->User->find('list');
		$this->set(compact('users'));
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
		$this->Invitation->id = $id;
		if (!$this->Invitation->exists()) {
			throw new NotFoundException(__('Invalid invitation'));
		}
		if ($this->Invitation->delete()) {
			$this->Session->setFlash(__('Invitation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Invitation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
