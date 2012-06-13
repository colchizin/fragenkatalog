<?php
App::uses('AppController', 'Controller');
/**
 * QuestionsComments Controller
 *
 * @property QuestionsComment $QuestionsComment
 */
class QuestionsCommentsController extends AppController {

	public $components = array('RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->QuestionsComment->recursive = 0;
		$this->set('questionsComments', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->QuestionsComment->id = $id;
		if (!$this->QuestionsComment->exists()) {
			throw new NotFoundException(__('Invalid questions comment'));
		}
		$this->set('questionsComment', $this->QuestionsComment->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$questionscomment = null;
		if ($this->request->is('post')) {
			if (empty($this->request->data['Comment']['user_id'])) {
				$this->request->data['Comment']['user_id'] = $this->Auth->user('id');
			}
			$this->QuestionsComment->create();
			if ($this->QuestionsComment->saveAssociated($this->request->data, array('validate'=>'true'))) {
				$this->QuestionsComment->contain(array(
					'Comment'=> array('comment', 'User'=>array('username','id'))
				));
				$questionscomment = $this->QuestionsComment->findById($this->QuestionsComment->getInsertId());
			} else {
				$this->Session->setFlash(__('The questions comment could not be saved. Please, try again.'));
			}
		}

		$this->set('questionscomment', $questionscomment);
		$this->set('_serialize','questionscomment');
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->QuestionsComment->id = $id;
		if (!$this->QuestionsComment->exists()) {
			throw new NotFoundException(__('Invalid questions comment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->QuestionsComment->save($this->request->data)) {
				$this->Session->setFlash(__('The questions comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The questions comment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->QuestionsComment->read(null, $id);
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
		$this->QuestionsComment->id = $id;
		if (!$this->QuestionsComment->exists()) {
			throw new NotFoundException(__('Invalid questions comment'));
		}
		if ($this->QuestionsComment->delete()) {
			$this->Session->setFlash(__('Questions comment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Questions comment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
