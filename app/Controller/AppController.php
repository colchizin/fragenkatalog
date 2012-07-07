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
			'loginRedirect' => array('controller'=>'users','action'=>'home')
		),
		'Breadcrumb',
		'RequestHandler',
		'Session');
	var $helpers = array('Html','Form','Session','Js','Breadcrumb');

	public function beforeFilter() {
		if (isset($this->request->named['layout'])) {
			$layout = $this->request->named['layout'];
			if (is_array($layout))
				$layout = $layout[count($layout)-1];
			
				$this->Session->write('Client.Layout', $layout);
		} else {
			if ($this->Session->read('Client.Layout') != 'default' && $this->request->isMobile()) {
				$this->Session->write('Client.Layout', 'mobile');
			}
		}

		if ($layout = $this->Session->read('Client.Layout')) {
			$this->layout = $layout;
		}

		if (isset($this->request->named['layout_once'])) {
			$this->layout = $this->request->named['layout_once'];
		}

		if (isset($this->request->named['useRH']) && $this->request->named['useRH']) {
			$this->RequestHandler->enabled = true;
		}

		if (Configure::read('Fragenkatalog.maintenance')) {
			echo "<h1>Maintenance</h1><p>This service is currently undergoing some maintenance. Please return in a few minutes</p>";
			exit();
		}


	}

	public function beforeRender() {
		if ($this->layout != 'default') {
			$file = '../View/' . $this->viewPath . '/' . $this->layout . '/' . $this->action . '.ctp';
			if (file_exists($file)) {
				$this->viewPath .= '/' . $this->layout;
			}
		}

		if (is_object($this->Breadcrumb)) {
			$this->set('breadcrumbs', $this->Breadcrumb->getBreadcrumbs());
		}
	}
}
