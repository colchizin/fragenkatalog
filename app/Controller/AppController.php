<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('Auth','Controller/Component');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	var $components = array(
		'Acl',
		'Auth' => array(
			'authenticate' => array('Form'),
			'authorize' => array(
				'Actions'=>array('actionPath'=>'controllers')
			),
			'loginRedirect' => array('controller'=>'pages','action'=>'display','home'),

		),
		// 'RequestHandler',
		'Session');
	var $helpers = array('Html','Form','Session','Js');

	public function beforeFilter() {
		if (isset($this->request->named['mobile'])) {
			$mobile = $this->request->named['mobile'];
			if (is_array($mobile))
				$this->Session->write('Client.Mobile', $mobile[count($mobile)-1]);
			else
				$this->Session->write('Client.Mobile', $mobile);
		}

		if (
			(
				$this->request->is('mobile') &&
				$this->Session->read('Client.Mobile') !== "false"
			) ||
				$this->Session->read('Client.Mobile') === "true"
		) {
			$this->layout = "mobile";
		}

		if (isset($this->request->named['print']) && $this->request->named['print']==true)
		{
			$this->layout = 'print';
		}
	}

	public function beforeRender() {
		if ($this->layout != 'default') {
			$file = '../View/' . $this->viewPath . '/' . $this->layout . '/' . $this->action . '.ctp';
			if (file_exists($file)) {
				$this->viewPath .= '/' . $this->layout;
			}
		}
	}
}
