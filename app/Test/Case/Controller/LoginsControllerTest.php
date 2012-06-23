<?php
App::uses('LoginsController', 'Controller');

/**
 * TestLoginsController *
 */
class TestLoginsController extends LoginsController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * LoginsController Test Case
 *
 */
class LoginsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.login', 'app.user', 'app.group', 'app.programme', 'app.university', 'app.subject', 'app.exam', 'app.examsession', 'app.examsessions_question', 'app.question', 'app.answer', 'app.comment', 'app.answers_comment', 'app.questions_comment', 'app.material', 'app.questions_material', 'app.questions_exam', 'app.invitation');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Logins = new TestLoginsController();
		$this->Logins->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Logins);

		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {

	}
/**
 * testView method
 *
 * @return void
 */
	public function testView() {

	}
/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}
/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {

	}
/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {

	}
}
