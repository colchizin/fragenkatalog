<?php
App::uses('AppController', 'Controller');
/**
 * News Controller
 *
 * @property News $News
 */
class NewsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Breadcrumb->addBreadcrumb(array(
			'title' => __('News'),
			'link' => array('controller' => 'news', 'action' => 'index')
		));
		$this->News->recursive = 0;
		$this->paginate  = array(
			'order' => 'News.created DESC',
			'contain' => array(
				'HasComment' => array('Comment'=>array('comment', 'User')),
				'User'
			)
		);
		$this->set('news', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->News->id = $id;
		if (!$this->News->exists()) {
			throw new NotFoundException(__('Invalid news'));
		}
		$this->set('news', $this->News->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->News->create();
			$this->request->data['News']['user_id'] = $this->Auth->user('id');
			if ($this->News->save($this->request->data)) {
				$this->Session->setFlash(__('The news has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.'));
			}
		}
		$users = $this->News->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->News->id = $id;
		if (!$this->News->exists()) {
			throw new NotFoundException(__('Invalid news'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->News->save($this->request->data)) {
				$this->Session->setFlash(__('The news has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->News->read(null, $id);
		}
		$users = $this->News->User->find('list');
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
		$this->News->id = $id;
		if (!$this->News->exists()) {
			throw new NotFoundException(__('Invalid news'));
		}
		if ($this->News->delete()) {
			$this->Session->setFlash(__('News deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('News was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function addComment() {
		if ($this->request->is('post')) {

			$this->request->data['Comment']['user_id'] = $this->Auth->user('id');
			$this->News->Comment->create($this->request->data);

			if ($this->News->Comment->save()) {
				$this->request->data['HasComment']['comment_id'] = $this->News->Comment->getInsertId();
				$this->News->HasComment->create($this->request->data);

				if (!$this->News->HasComment->save()) {
					if ($this->request->is('ajax')) {
						$this->redirect(null,200);
					} else {
						$this->Session->setFlash(__('Error saving comment'));
						$this->redirect($this->referer());
					}
				} else {
					$this->News->Comment->contain(array(
						'User', 'News'
					));

					$this->set('comment', $this->News->Comment->findById(
						$this->News->Comment->getInsertId()
					));

					if ($this->request->is('ajax')) {
						$this->set('_serialize', 'comment');
					} else {
						$this->Session->setFlash(__('Comment created'));
						$this->redirect($this->referer());
					}
				}
			}	
		}
	}
}
