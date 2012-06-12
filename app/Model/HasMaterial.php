<?php

class HasMaterial extends Model {
	public $useTable = 'questions_materials';

	public $belongsTo = array(
		'Question'=>array(
			'foreignKey' => 'question_id'
		),
		'Material' => array(
			'foreignKey' => 'material_id'
		)
	);
}

?>
