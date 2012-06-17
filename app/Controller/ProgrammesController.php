<?php
App::uses('AppController', 'Controller');
/**
 * Programmes Controller
 *
 * @property Programme $Programme
 */
class ProgrammesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Programme->recursive = 0;
		$this->set('programmes', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Programme->id = $id;
		if (!$this->Programme->exists()) {
			throw new NotFoundException(__('Invalid programme'));
		}
		$this->Programme->contain(array(
			'Subject'=>array('name', 'id', 'Exam' => array()),
			'University'
		));
		$programme = $this->Programme->read(null, $id);
		$semesters = $this->Programme->Subject->getExamCountGroupedBySemesterAndSubject($this->Auth->user('id'));
		$this->set('programme',$programme);
		$this->set('semesters', $semesters);
		$this->set('title_for_layout', $programme['Programme']['name']);
		if ($programme['Programme']['id'] != $this->Auth->user('programme_id'))
		{
			$this->set('ask_programme',true);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Programme->create();
			if ($this->Programme->save($this->request->data)) {
				$this->Session->setFlash(__('The programme has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The programme could not be saved. Please, try again.'));
			}
		}
		$universities = $this->Programme->University->find('list');
		$this->set(compact('universities'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Programme->id = $id;
		if (!$this->Programme->exists()) {
			throw new NotFoundException(__('Invalid programme'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Programme->save($this->request->data)) {
				$this->Session->setFlash(__('The programme has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The programme could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Programme->read(null, $id);
		}
		$universities = $this->Programme->University->find('list');
		$this->set(compact('universities'));
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
		$this->Programme->id = $id;
		if (!$this->Programme->exists()) {
			throw new NotFoundException(__('Invalid programme'));
		}
		if ($this->Programme->delete()) {
			$this->Session->setFlash(__('Programme deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Programme was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
