<?php
App::uses('AppController', 'Controller');
/**
 * Materials Controller
 *
 * @property Material $Material
 */
class MaterialsController extends AppController {
	public $helpers = array('Material');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Material->recursive = 0;
		$this->set('materials', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Material->id = $id;
		if (!$this->Material->exists()) {
			throw new NotFoundException(__('Invalid material'));
		}
		$material = $this->Material->read(null,$id);
		$this->set('material', $material);
		$this->set('materials', $this->Material->find('all',array(
			'conditions'=>array(
				'Material.subject_id'=>$material['Material']['subject_id'],
				'Material.id <> ' => $material['Material']['id']
			),
			'recursive'=>'-1'
		)));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Material->create();
			if ($this->Material->save($this->request->data)) {
				$this->Session->setFlash(__('The material has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The material could not be saved. Please, try again.'));
			}
		}
		$subjects = $this->Material->Subject->find('list');
		$questions = $this->Material->Question->find('list');
		$this->set(compact('subjects', 'questions'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Material->id = $id;
		if (!$this->Material->exists()) {
			throw new NotFoundException(__('Invalid material'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Material->save($this->request->data)) {
				$this->Session->setFlash(__('The material has been saved'));
				$this->redirect(array('action' => 'view',$this->Material->id));
			} else {
				$this->Session->setFlash(__('The material could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Material->read(null, $id);
		}
		$subjects = $this->Material->Subject->find('list');
		$questions = $this->Material->Question->find('list');
		$this->set(compact('subjects', 'questions'));
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
		$this->Material->id = $id;
		if (!$this->Material->exists()) {
			throw new NotFoundException(__('Invalid material'));
		}
		if ($this->Material->delete()) {
			$this->Session->setFlash(__('Material deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Material was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function merge() {
		if ($this->request->is('post')) {
			$materials  = $this->request->data['Material']['id'];
			$this->loadModel('HasMaterial');
			$this->HasMaterial->recursive = -1;
			$this->HasMaterial->updateAll(
				array('HasMaterial.material_id'=>$materials[0]),
				array('HasMaterial.material_id'=>$materials)
			);

			$firstMaterial = $materials[0];
			unset($materials[0]);

			$this->Material->deleteAll(array('Material.id'=>$materials));
			$params['conditions']['Material.id'] = $firstMaterial;

		} else {

			if (isset($this->request->named['subject_id'])) {
				$params['conditions']['Material.subject_id'] = $this->request->named['subject_id'];
			}

			if (isset($this->request->named['filter'])) {
				$params['conditions']['Material.title LIKE '] = "%" . $this->request->named['filter'] . "%";
			}

		}
		$params['order'] = 'Material.title ASC';
		$this->set('materials', $this->Material->find('all', $params));
	}

	public function copyExternalMindmaps() {
		$materials = $this->Material->find('all', array(
			'conditions' => array(
				'type' => 'mindmap',
				'text LIKE' => 'http://%'
			)
		));
		var_dump(getcwd());
		foreach ($materials as $material) {
			$base = getcwd();
			$name = basename($material['Material']['text']);
			$source = $material['Material']['text'];

			$dest = $base . "/flash/mindmaps/"  . $name;
			echo 'kopiere ' . $source . ' nach ' . $dest . ' ... ';
			if (copy($source, $dest)) {
				echo "Erfolg";
				$material['Material']['text'] = $name;
				$this->Material->save($material);
			}
			else
				echo "Fehlschlag";
			echo "<br>";
		}
		exit();
	}
}
