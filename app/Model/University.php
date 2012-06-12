<?php
App::uses('AppModel', 'Model');
/**
 * University Model
 *
 * @property Programme $Programme
 */
class University extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'A University cannot have an empty name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Programme' => array(
			'className' => 'Programme',
			'foreignKey' => 'university_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function __construct($id=false, $table=null, $ds=null) {
		parent::__construct($id,$table,$ds);
		$this->validate['name']['notempty']['message'] = __('This Field must not be empty');
	}

}
