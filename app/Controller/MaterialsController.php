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

		$programme = $this->Material->Subject->Programme->findById($material['Subject']['programme_id']);
		$this->Breadcrumb->addBreadcrumb(array(
			'title' =>$programme['Programme']['name'],
			'link' => array('controller'=>'programmes', 'action'=>'view', $material['Subject']['programme_id'])
		));
		$this->Breadcrumb->addBreadcrumb(array(
			'title' =>$material['Subject']['name'],
			'link' => array('controller'=>'subjects', 'action'=>'view', $material['Subject']['id'])
		));
		$this->Breadcrumb->addBreadcrumb(array(
			'title' =>__('Material') . ": " . $material['Material']['title'],
			'link' => array('controller'=>'materials', 'action'=>'view', $material['Material']['id'])
		));
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

	public function unifyImageTexts() {
		$materials = $this->Material->findAllByType('image');
		$pattern = '/<img.*src="(.*?)".*\/?>/';


//<?php // simply for getting proper syntax highlighting in vim. the above 
		// regular expression messes everything up a bit

		error_reporting(E_ALL);

		foreach ($materials as $material) {
			$strpos = strpos($material['Material']['text'], "<img");
			if ($strpos === 0) {
				// Bild-Material mit <img> im Text	
				$filename = preg_replace($pattern, "$1", $material['Material']['text']);

				$this->Material->id = $material['Material']['id'];
				if ($this->Material->saveField('text', $filename)) {
					echo "updated Material {$material['Material']['title']}<br />";	
				}
			}
		}

		exit();
	}

	protected function copyExternalFiles($materials, $dest_dir) {
		foreach ($materials as $material) {
			$base = getcwd();
			$name = basename($material['Material']['text']);
			$source = $material['Material']['text'];

			$dest = $base . "/" . $dest_dir . "/"  . $name;
			echo 'kopiere ' . $source . ' nach ' . $dest . ' ... ';

			if (file_exists($dest)) {
				echo "Datei existiert bereits. Ändere nur den Datenbankeintrag <br />";	
				$material['Material']['text'] = $name;
				$this->Material->save($material);
				continue;
			}

			if (copy($source, $dest)) {
				echo "Erfolg";
				$material['Material']['text'] = $name;
				$this->Material->save($material);
			}
			else
				echo "Fehlschlag";
			echo "<br>";
		}
	}

	public function copyExternalMindmaps() {
		$materials = $this->Material->find('all', array(
			'conditions' => array(
				'type' => 'mindmap',
				'text LIKE' => 'http://%'
			)
		));
		$this->copyExternalFiles($materials, "flash/mindmaps");
		exit();
	}

	public function copyExternalImages() {
		$materials = $this->Material->find('all', array(
			'conditions' => array(
				'type' => 'image',
				'text LIKE' => 'http://%'
			)
		));
		$this->copyExternalFiles($materials, "img/materials");
		exit();
	}

	public function findImagesInAllTexts() {
		$materials = $this->Material->find('list');	

		foreach ($materials as $id=>$material) {
			$this->findImagesInText($id);
		}

		exit();
	}

	public function findImagesInText($id = 1) {
		$dest_dir = "img/materials";
		$pattern = '/<img.*src="(.*?)".*\/?>/';
		$material = $this->Material->findById($id);	
		$results;
		preg_match_all($pattern, $material['Material']['text'], $results);//, PREG_SPLIT_DELIM_CAPTURE));

		foreach ($results[1] as $img) {
			$base = getcwd();
			$source = $this->getThumblessSrc($img);
			$name = basename($source);

			$dest = $base . "/" . $dest_dir . "/"  . $name;
			$success = false;

			if (file_exists($dest)) {
				echo "Datei $dest existiert bereits. <br />";	
				$success = true;
			} else {
				echo 'kopiere ' . $source . ' nach ' . $dest . ' ... ';
				if (copy($source, $dest)) {
					echo "<span style='color:green'>Erfolg</span><br>";
					$success = true;
				} else {
					echo "<span style='color:red>Fehler</span><br>";
				}
			}

			if ($success) {
				$newsrc = "/fragenkatalog/$dest_dir/$name";
				$material['Material']['text'] = str_replace($img, $newsrc, $material['Material']['text']);
			}
		}

		$this->Material->id = $id;
		if ($this->Material->saveField('text', $material['Material']['text'])) {
			echo "<b>Datenbankeintrag aktualisiert</b> <br />\n";	
		}

		exit();
	}

	protected function getThumblessSrc($source) {
		if (!strpos($source, "/thumb/"))
			return $source;

		$thumbless = str_replace("/thumb", "", $source);
		$lastslash = strrpos($thumbless, "/");
		$thumbless = substr($thumbless, 0, $lastslash);
		return $thumbless;
	}

	public function pick_image() {
		$this->loadModel('Image');
		$this->set('images', $this->Image->findAll());
	}
}
