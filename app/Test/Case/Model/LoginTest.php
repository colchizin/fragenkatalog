<?php
App::uses('Login', 'Model');

/**
 * Login Test Case
 *
 */
class LoginTestCase extends CakeTestCase {
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
		$this->Login = ClassRegistry::init('Login');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Login);

		parent::tearDown();
	}

}
