<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('login','register'));
		$this->Auth->allow('init_db');
		// $this->Auth->allow(array('add','index','edit','login','logout'));
	}

	public function home() {
		$this->set('title_for_layout', __('Home'));
		$userid = $this->Auth->user('id');
		$this->User->contain(array(
			'Examsession'=>array('id','finished','Exam')
		));
		$user = $this->User->findById($userid);
		$this->set('user', $user);
	}

	public function init_db() {
		$group = $this->User->Group;

		// Administrator-Gruppe
		$group->id = Configure::read('User.admin_group');
		$this->Acl->allow($group,'controllers');

		// Benutzer-Gruppe
		$group->id = Configure::read('User.users_group');
		$this->Acl->deny($group, 'controllers');
		$this->Acl->allow($group, 'controllers/Pages');
		$this->Acl->allow($group, 'controllers/Universities/index');
		$this->Acl->allow($group, 'controllers/Universities/view');
		$this->Acl->allow($group, 'controllers/Programmes/view');
		$this->Acl->allow($group, 'controllers/Subjects/view');
		$this->Acl->allow($group, 'controllers/Subjects/add');
		$this->Acl->allow($group, 'controllers/Subjects/edit');
		$this->Acl->allow($group, 'controllers/Exams');
		$this->Acl->deny($group, 'controllers/Exams/delete');
		$this->Acl->allow($group, 'controllers/Questions');
		$this->Acl->allow($group, 'controllers/Materials');
		$this->Acl->allow($group, 'controllers/Answers');
		$this->Acl->allow($group, 'controllers/Comments');
		$this->Acl->allow($group, 'controllers/Users/view_myprofile');
		$this->Acl->allow($group, 'controllers/Users/edit_myprofile');
		$this->Acl->allow($group, 'controllers/Users/logout');
		$this->Acl->allow($group, 'controllers/Users/setProgramme');
		$this->Acl->allow($group, 'controllers/Invitations/add');
		$this->Acl->allow($group, 'controllers/Tickets/add');
		$this->Acl->allow($group, 'controllers/Tickets/view');
		$this->Acl->allow($group, 'controllers/Tickets/index');
		$this->Acl->allow($group, 'controllers/Ticketcomments/add');
		$this->Acl->allow($group, 'controllers/Ticketcomments/delete_mine');
		$this->Acl->allow($group, 'controllers/Ticketcomments/edit_mine');
		$this->Acl->allow($group, 'controllers/Examsessions/my_sessions');
		$this->Acl->allow($group, 'controllers/Examsessions/result');
		$this->Acl->allow($group, 'controllers/Examsessions/finish');
		$this->Acl->allow($group, 'controllers/Examsessions/new_session');
		$this->Acl->allow($group, 'controllers/Examsessions/confirm_session');
		$this->Acl->allow($group, 'controllers/Examsessions/continue_session');
		$this->Acl->allow($group, 'controllers/Examsessions/continue_current_session');
		$this->Acl->allow($group, 'controllers/Examsessions/delete');
		$this->Acl->allow($group, 'controllers/ExamsessionsQuestions/add_or_save');
		echo "all done";
		exit;
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function view_myprofile() {
		$this->User->id = $this->Auth->user('id');
		$this->_view();
	}

	public function edit_myprofile() {
		$this->User->id = $this->Auth->user('id');
		$this->_edit('view_myprofile');
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->id = $id;
		$this->_view();
	}

	public function _view() {
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}

		$this->set('user', $this->User->read(null, $this->User->id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		$this->_edit();
	}

	public function _edit($redirectAction = "view") {
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => $redirectAction,$this->User->id));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $this->User->id);
		}
		$groups = $this->User->Group->find('list');
		$programmes = $this->User->Programme->find('list');
		$this->set(compact('groups','programmes'));
		$this->render('edit');
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}


	public function login() {
		$this->set('title_for_layout','Anmelden');
		if ($this->request->is('post')) {
			echo $this->request->data['User']['username'];
			echo $this->request->data['User']['password'];
			if ($this->Auth->login()) {
				// $group = $this->User->Group->findById($this->Auth->user('group_id'));
				$this->User->Login->create(array('Login'=>array('user_id'=>$this->Auth->user('id'))));
				$this->User->Login->save();

				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Invalid Login-Data'));
			}
		}
	}

	public function logout() {
		$this->Session->setFlash(__("Good Bye!"));
		$this->Session->write('Module',null);
		$this->redirect($this->Auth->logout()); 
	}

	public function setProgramme($programme = null) {
		if (isset($programme) && $programme != null) {
			$this->User->Programme->id = $programme;
			if (!$this->User->Programme->exists()) {
				$this->Session->setFlash(__('Invalud Programme'));
				return;
			}

			$p = $this->User->Programme->read(null, $programme);

			$this->request->data['User']['id'] = $this->Auth->user('id');
			$this->request->data['User']['programme_id'] = $programme;

			if (!$this->User->save(
				$this->request->data,
				array('fieldlist'=>array('programme_id'))
			)) {
				$this->Session->setFlash(__('Default Programme could not be	saved. Please, try again'));
			} else {
				$this->Session->setFlash(__('Default Programme changed to %s',$p['Programme']['name']));
				$this->Session->write('Auth.User.programme_id',$programme);
			}
		}
		$this->redirect(array('controller'=>'programmes','action'=>'view',$programme));
	}

	public function invite() {
		if ($this->request->is('post')) {
			
		}
	}

	/**
	 * Registrierung eines Benutzers anhand eines zuvor erstellten
	 * Einlade-Codes (Invitation-Token). 
	 * 
	 * @access public
	 * @return void
	 */
	public function register() {
		if ($this->request->is('post'))	{
			$invitation = $this->User->Invitation->findByToken($this->request->data['Invitation']['token']);

			if ($invitation == null) {
				$this->Session->setFlash(__('Invalid Invitation code'));
				return;
			}

			// Passt die E-Mail-Adresse zum Einladungs-Code?
			if ($this->request->data['User']['email'] != $invitation['Invitation']['email']) {
				$this->Session->setFlash(__('Invitation code does not match your email-address'));
				return;
			}

			// Existiert schon ein Nutzer mit dieser E-Mail-Adresse?
			if ($this->User->findByEmail($this->request->data['User']['email'])) {
				$this->Session->setFlash(__('A user with that e-mail address already exists'));
				return;
			}

			// Existiert schon ein Nutzer mit diesem Benutzernamen?
			if ($this->User->findByUsername($this->request->data['User']['username'])) {
				$this->Session->setFlash(__('A user with that name already exists'));
				return;
			}

			$this->request->data['User']['group_id'] = Configure::read('User.users_group');
			var_dump($this->request->data);
			$this->User->create();
			if (!$this->User->save($this->request->data)) {
				$this->Session->setFlash('Your Account could not be created. Please, try again.');
				return;
			} else {
				$this->Session->setFlash('Your Account has been created. You can login now');

				$invitation['Invitation']['used'] = true;
				if (!$this->User->Invitation->save($invitation)) {
					echo "Invitation not changed";
				}
				$this->redirect(array('controller'=>'users','action'=>'login'));
			}
		}

		// Wenn in der URL ein Einladungscode übergeben wurde, dann den direkt eintragen
		if (isset($this->request->named['token'])) {
			$this->request->data['Invitation']['token'] = $this->request->named['token'];
		}
	}
}
