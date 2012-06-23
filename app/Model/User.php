<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Group $Group
 * @property Comment $Comment
 */
class User extends AppModel {
	public $actsAs = array(
		'Acl' => array(
			'type'=>'requester'
		)
	);
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'passwort' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Programme' => array(
			'className'=>'Programme',
			'foreignKey'=> 'programme_id'
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Invitation',
		'Examsession',
		'Login'
	);

	/**
	 * Wird aufgerufen, bevor der Benutzer in die Datenbank gespeichert wird. 
	 * 
	 * @access public
	 * @return void
	 */
	public function beforeSave() {
		if (isset($this->data['User']['password'])) {
			if (isset($this->data['User']['id'])) {
				// Bei einem bestehenden Benutzer gibt es zwei Mögichkeiten:
				// 1. Das Passwort wird geändert, dann muss neu gehasht werden
				// 2. Das Passwort ist unverändert, dann wird nicht gehasht.
				if($user = $this->findById($this->data['User']['id'])) {
					if ($user['User']['password'] != $this->data['User']['password']) {
						// neues Passwort, also auch neu hashen
						$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
					}
				}
			} else {
				// Bei einem neuen Benutzer wird stets gehasht
				$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			}
		}
		return true;
	}

	public function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}

		if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
	
		if (empty($groupId)) {
			return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
	}

	// ACL nur auf Basis der Gruppen
	public function bindNode($user) {
		return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
	}

}
