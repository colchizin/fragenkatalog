<?php
App::uses('AppController', 'Controller');
/**
 * Universities Controller
 *
 * @property University $University
 */
class UniversitiesController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->University->recursive = 0;
		$this->set('universities', $this->paginate());
		$this->Breadcrumb->addBreadcrumb(array(
			'title' =>__('Universities'),
			'link' => array('controller'=>'universities', 'action'=>'index')
		));
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
		$university = $this->University->read(null, $id);
		$this->set('university', $university);

		$this->Breadcrumb->addBreadcrumb(array(
			'title' =>__('Universities'),
			'link' => array('controller'=>'universities', 'action'=>'index')
		));
		$this->Breadcrumb->addBreadcrumb(array(
			'title' =>$university['University']['name'],
			'link' => array('controller'=>'universities', 'action'=>'view', $id)
		));
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
		$this->Breadcrumb->addBreadcrumb(__('Universities'), array('controller'=>'universities', 'action'=>'index'));
		$this->Breadcrumb->addBreadcrumb(__('Add University'), array('controller'=>'universities', 'action'=>'add'));
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

		$this->Breadcrumb->addBreadcrumb(__('Universities'), array('controller'=>'universities', 'action'=>'index'));
		$this->Breadcrumb->addBreadcrumb(__('Edit University'), array('controller'=>'universities', 'action'=>'edit'));
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
