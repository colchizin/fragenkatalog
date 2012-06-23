<?php
/**
 * 
 */
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Tickets Controller
 *
 * @property Ticket $Ticket
 */
class TicketsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Breadcrumb->addBreadcrumb(array(
			'title' => __('Tickets'),
			'link' => array('controller'=>'tickets','action'=>'index')
		));
		$this->Ticket->recursive = 0;
		$this->Ticket->contain(array(
			'Tickettype',
			'User',
			'HasTicketstatus'=>array('Ticketstatus')
		));
		$this->set('tickets', $this->paginate(array(), array(
			'joins' => array(
				array(
					'table' => 'tickets_ticketstatuses',
					'alias' => 'HasTicketstatus',
					'conditions' => array("HasTicketstatus.ticket_id = Ticket.id")
				)
			),
		)));
		$this->set('_serialize', 'tickets');
	}

	public function admin_index() {
		$this->index();
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Ticket->id = $id;
		if (!$this->Ticket->exists()) {
			throw new NotFoundException(__('Invalid ticket'));
		}
		
		$this->Ticket->contain(array(
			'User',
			'HasTicketstatus'=>array('Ticketstatus'),
			'Ticketcomment'=>array('comment','id', 'created','User'),
			'Tickettype'
		));
		$this->set('ticket', $this->Ticket->read(null, $id));

		$this->Breadcrumb->addBreadcrumb(array(
			'title' => __('Tickets'),
			'link' => array('controller'=>'tickets','action'=>'index')
		));
		$this->Breadcrumb->addBreadcrumb(array(
			'title' => __('Ticket details'),
			'link' => array('controller'=>'tickets','action'=>'view', $id)
		));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		$this->add();
	}

	public function add() {
		if (empty($this->request->data['Ticket']['url'])) {
			if (empty($this->request->named['url'])) {
				$this->request->data['Ticket']['url'] = $this->referer();
			} else {
				$this->request->data['Ticjet']['url'] = $this->request->named['url'];
			}
		}
		if ($this->request->is('post')) {
			$this->request->data['Ticket']['user_id'] = $this->Auth->user('id');
			$this->request->data['HasTicketstatus'] = array(
				'ticketstatus_id'=>1
			);
			$this->Ticket->create();
			if ($this->Ticket->save($this->request->data)) {
				$this->request->data['HasTicketstatus']['ticket_id'] = $this->Ticket->getInsertId();
				$this->Ticket->HasTicketstatus->create();
				if ($this->Ticket->HasTicketstatus->save($this->request->data)) {
					$this->Session->setFlash(__('The ticket has been saved'));

					$this->Ticket->contain(array(
						'User'=>array('username'),
						'HasTicketstatus'=>array('created')
					));
					$ticket = $this->Ticket->findById($this->Ticket->getInsertId());
					$email = new CakeEmail();
					$email
						->template('ticket_new','default')
						->emailFormat('text')
						->to(Configure::read('Fragenkatalog.Admin.email'))
						->from(Configure::read('Fragenkatalog.email'))
						->subject(__('New Ticket'))
						->viewVars(array('ticket'=>$ticket))
						->send()
					;

					$this->redirect($this->request->data['Ticket']['url']);
				} else {
					$this->Session->setFlash(__('The ticketstatus could not be saved. Please, try again.'));
				}
			} else {
				$this->Session->setFlash(__('The ticket could not be saved. Please, try again.'));
			}
		}
		$tickettypes = $this->Ticket->Tickettype->find('list');
		$this->set(compact('tickettypes'));

		$this->Breadcrumb->addBreadcrumb(array(
			'title' => __('Tickets'),
			'link' => array('controller'=>'tickets','action'=>'index')
		));
		$this->Breadcrumb->addBreadcrumb(array(
			'title' => __('Report an error'),
			'link' => array('controller'=>'tickets','action'=>'add')
		));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Ticket->id = $id;
		if (!$this->Ticket->exists()) {
			throw new NotFoundException(__('Invalid ticket'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ticket->save($this->request->data)) {
				$this->Session->setFlash(__('The ticket has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticket could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Ticket->read(null, $id);
		}
		$tickettypes = $this->Ticket->Tickettype->find('list');
		$users = $this->Ticket->User->find('list');
		$ticketstatuses = $this->Ticket->Ticketstatus->find('list');
		$this->set(compact('tickettypes', 'users', 'ticketstatuses'));
	}

	public function admin_edit($id = null) {
		$this->edit($id);
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete_all() {
		if ($this->request->is('post') && !empty($this->request->data['Ticket'])) {
			if ($this->Ticket->deleteAll(array('Ticket.id' => $this->request->data['Ticket']))) {
				$this->Session->setFlash(__('Tickets deleted'));
			} else {
				$this->Session->setFlash(__('Error deleting tickets'));
			}
			$this->redirect(array('action'=>'index'));
		}
	}

	public function admin_delete_all() {
		$this->delete_all();
	}

	public function admin_delete($id = null) {
		$this->delete($id);
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		$this->Ticket->id = $id;
		if (!$this->Ticket->exists()) {
			throw new NotFoundException(__('Invalid ticket'));
		}
		if ($this->Ticket->delete()) {
			$this->Session->setFlash(__('Ticket deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ticket was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * Status eines Tickets setzen
	 * 
	 * @param mixed $id 
	 * @access public
	 * @return void
	 */
	public function alter_status($id = null) {
		$this->admin_alter_status($id);
	}

	/**
	 * Status eines Tickets setzen (Admin)
	 * 
	 * @param mixed $id 
	 * @access public
	 * @return void
	 */
	public function admin_alter_status($id = null) {
		$this->set('title_for_layout',__('Alter Ticket-Status'));

		$this->Ticket->id = $id;
		if (!$this->Ticket->exists()) {
			throw new NotFoundException(__('Invalid ticket'));
		}

		if ($this->request->is('post')) {
			$this->request->data['HasTicketstatus']['ticket_id'] = $id;
			$this->Ticket->HasTicketstatus->create();
			if ($this->Ticket->HasTicketstatus->save($this->request->data)) {
				$this->Session->setFlash(__('Ticket-Status altered'));

				// Kommentar erstellen
				$this->Ticket->HasTicketstatus->Ticketstatus->id = $this->request->data['HasTicketstatus']['ticketstatus_id'];
				$this->request->data['Ticketcomment']['ticket_id'] = $id;
				$this->request->data['Ticketcomment']['comment'] =
					"<p><em>" . 
					__('[Status changed: %s]', $this->Ticket->HasTicketstatus->Ticketstatus->field('title')) .
					"</em></p>\n" . 
					$this->request->data['Ticketcomment']['comment']
				;
				$this->request->data['Ticketcomment']['user_id'] = $this->Auth->user('id');
				$this->Ticket->Ticketcomment->create();
				$this->Ticket->Ticketcomment->save($this->request->data);

				// umleiten auf Index
				$this->redirect(array('action'=>'view',$id));
			} else {
				$this->Session->setFlash(__('Ticket-Status could not be altered. Please, try again'));
			}

		}

		$this->set('ticketstatuses', $this->Ticket->Ticketstatus->find('list'));
	}

	/**
	 * Den Status für mehere Tickets gleichzeitig setzen
	 * 
	 * @access public
	 * @return void
	 */
	public function admin_alter_status_all() {
		if ($this->request->is('post'))	{
			$data = array();
			foreach ($this->request->data['Ticket'] as $ticket_id) {
				$data[]['HasTicketstatus'] = array(
					'ticket_id' => $ticket,
					'ticketstatus_id' => $this->request->data['HasTicketstatus']['ticketstatus_id']
				);
			}
		}
	}
}
