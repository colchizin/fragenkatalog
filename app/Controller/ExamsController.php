<?php
App::uses('AppController', 'Controller');
/**
 * Exams Controller
 *
 * @property Exam $Exam
 */
class ExamsController extends AppController {
	var $helpers = array('Js');
	/**
	 * Starte eine Klausur 
	 * ruft intern ExamsController::view auf
	 * 
	 * @param mixed $id ID der Klausur
	 * @access public
	 * @return void
	 */
	public function exam($id = null) {
		$this->Exam->contain(array(
			'Question' => array(
				'question',
				'attachment',
				'Answer' => array('answer','id','correct','Comment'),
				'Comment',
				'Material'
			)
		));

		$sessionid = $this->Session->read("Examsession");
		$question = false;

		// Prüfen, ob eine Examsession schon geöffnet ist
		if ($sessionid) {
			// ja, eine Examsession ist schon geöffnet
			if ($id != null)	// es wurde aber auch eine Klausur übergeben, was nun?
				$this->redirect(array('controller'=>'exams', 'action' => 'confirm_session', $id));
			else { // keine Klausur übergeben, also Session fortführen
				$id = $sessionid;
				$session = $this->Exam->Examsession->findById($sessionid);
				$id = $session['Examsession']['exam_id'];

				// Wenn mindestens eine Frage beantwortet wurde, dann zu dieser Frage springen
				if (!empty($session['Question']))
					$question = $session['Question'][count($session['Question'])-1]['id'];
				if (!empty($session['Examsession']['finished']))
					$this->set('session_finished', true);

			}
		} else if ($id != null) {
			// noch keine Examsession geöffnet
			$this->Exam->Examsession->create(array(
				'Examsession'=>array(
					'user_id'=>$this->Auth->user('id'),
					'exam_id'=>$id
				)
			));
			$this->Exam->Examsession->save();
			$sessionid = $this->Exam->Examsession->getInsertId();
			$this->Session->write('Examsession', $sessionid);
		}

		$this->set('current_question',$question);

		$this->view($id);
	}


/**
 * index methsession*
 * @return void
 */
	public function index() {
		$this->Exam->recursive = 0;
		$this->set('exams', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Exam->id = $id;
		if (!$this->Exam->exists()) {
			throw new NotFoundException(__('Invalid exam'));
		}

		$exam = $this->Exam->findByIdMergeExamsession($id, $this->Session->read('Examsession'));
		$this->set('title_for_layout',$exam['Exam']['shortname']);
		$this->set('exam', $exam);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Exam->create();
			if ($this->Exam->save($this->request->data)) {
				$this->Session->setFlash(__('The exam has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The exam could not be saved. Please, try again.'));
			}
		}
		$subjects = $this->Exam->Subject->find('list');
		$this->set(compact('subjects'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Exam->id = $id;
		if (!$this->Exam->exists()) {
			throw new NotFoundException(__('Invalid exam'));
		}
		$this->Exam->contain(array(
			'Question'=>array(
				'id','question','attachment',
				'Answer'=>array(
					'answer','id','correct'
				)
			),
			'Subject'=>array('id')
		));
		$exam = $this->Exam->read(null, $id);
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Exam->save($this->request->data)) {
				$this->Session->setFlash(__('The exam has been saved'));
				$this->redirect(array('action' => 'view',$this->Exam->id));
			} else {
				$this->Session->setFlash(__('The exam could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $exam;
		}
		$subjects = $this->Exam->Subject->find('list');
		$questions = $this->Exam->Question->find(
			'list',
			array(
				'conditions'=>array(
					'subject_id'=>$exam['Subject']['id']
				)
			)
		);
		$this->set(compact('subjects','questions'));
//		$this->render('create');
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
		$this->Exam->id = $id;
		if (!$this->Exam->exists()) {
			throw new NotFoundException(__('Invalid exam'));
		}

		$exam = $this->Exam->read();
		if ($this->Exam->delete()) {
			$this->Session->setFlash(__('Exam deleted'));
			$this->redirect(array(
				'controller'=>'subjects',
				'action' => 'view',
				$exam['Exam']['subject_id']
			));
		}
		$this->Session->setFlash(__('Exam was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function addExistingQuestions($id = null) {
		$this->Exam->id = $id;
		if (!$this->Exam->exists()) {
			throw new NotFoundException(__('Invalid exam'));
		}
		$exam = $this->Exam->read(null,$id);
		if ($this->request->is('put')) {
			echo "POST-Request";
			if ($this->Exam->save($this->request->data)) {
				var_dump($this->request->data);
				$this->Session->setFlash(__('Questions added'));
			//	$this->redirect(array('action'=>'view',$id));
			} else {
				$this->Sessions->setFlash(__('Quesitons could not be added'));
			}
		} else {
			echo "Muhaha";
			$this->request->data = $exam;
		}
		$this->Exam->Question->contain(array());
		$questions = $this->Exam->Question->find(
			'list',
			array(
				'conditions'=>array(
					'subject_id'=>$exam['Subject']['id']
				)
			)
		);
		$this->set('questions',$questions);
		$this->set('exam',$exam);
	}

	
	/**
	 * Gibt ein Interface zum Parsen einer Medi-Wiki-Seite aus 
	 * @param string subject 	Das Fach, zu dem eine Klausur hinzugefügt wird 
	 * @access public
	 * @return void
	 */
	public function parse($subject) {
		$this->set('title_for_layout', __('Import Exam'));
		$this->Exam->Subject->id = $subject;
		if (!$this->Exam->Subject->exists()) {
			$this->Session->setFlash(__('Invalid Subject'));
			$this->redirect($this->referer());
		}
		if ($this->request->is('post')) {
			// var_dump($this->request->data['Question'][0]);
			if ($exam = $this->Exam->saveEntirelyNew($this->request->data)) {
				$this->Session->setFlash(__('Exam has been saved'));
				$this->redirect(array(
					'action'=>'view',
					$exam['Exam']['id']
				));
			} else {
				$this->Session->setFlash(__('Exam could not be saved. Please try again'));
			}
		}

		$this->request->data['Exam']['subject_id'] = $subject;
		$this->set('subjects', $this->Exam->Subject->find('list'));
	}

	public function create($subject = null) {
		$this->Exam->Subject->id = $subject;
		if (!$this->Exam->Subject->exists()) {
			$this->Session->setFlash(__('Invalid Subject'));
			$this->redirect($this->referer());
		}

		if ($this->request->is('post')) {
			if ($this->Exam->saveEntirelyNew($this->request->data)) {
				$this->Session->setFlash(__('Exam has been saved'));
				$this->redirect(array(
					'controller'=>'exams',
					'action'=>'view',
					$this->Exam->id
				));
			} else {
				$this->Session->setFlash(__('Exam could not be saved. Please try again'));
			}
		}

		$this->request->data['Exam']['subject_id'] = $subject;
		$this->set('subjects', $this->Exam->Subject->find('list'));
	}
}
