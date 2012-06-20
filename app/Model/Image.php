<?php

App::uses('Folder','Utility');
App::uses('File','Utility');

class Image extends AppModel {
	public $useTable = false;
	
	public function findAll() {
		$dir = new Folder(WWW_ROOT . "img/materials");
		$files = $dir->find();
		$result = array();

		foreach ($files as $file) {
			$f = new File($file);
			$result[] = array(
				'name' => $f->name,
				'file' => "materials/" . $file
			);
		}

		return $result;
	}
}

?>
