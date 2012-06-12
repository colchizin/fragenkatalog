<?php
App::uses('AppModel', 'Model');
/**
 * Invitation Model
 *
 * @property User $User
 */
class Invitation extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'email';

	public $validate = array(
		'email'=>array(
			'email'=>array(
				'rule'=>'email',
				'message'=>'Please provide a valid e-mail address'
			)
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	
	public function beforeSave() {
		if (empty($this->data['Invitation']['token'])) {
			$date = date('Y-m-d H:i:s');
			$this->data['Invitation']['token'] = Security::hash($date . $this->data['Invitation']['email']);
			$this->data['Invitation']['created'] = $date;
		}
		return true;
	}
}
