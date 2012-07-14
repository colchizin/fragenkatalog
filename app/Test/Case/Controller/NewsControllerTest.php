<?php
App::uses('NewsController', 'Controller');

/**
 * TestNewsController *
 */
class TestNewsController extends NewsController {
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
 * NewsController Test Case
 *
 */
class NewsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.news', 'app.user', 'app.group', 'app.programme', 'app.university', 'app.subject', 'app.exam', 'app.examsession', 'app.examsessions_question', 'app.question', 'app.answer', 'app.comment', 'app.answers_comment', 'app.questions_comment', 'app.material', 'app.questions_material', 'app.questions_exam', 'app.invitation', 'app.login');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->News = new TestNewsController();
		$this->News->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->News);

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
