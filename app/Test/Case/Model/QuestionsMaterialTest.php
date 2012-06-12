<?php
App::uses('QuestionsMaterial', 'Model');

/**
 * QuestionsMaterial Test Case
 *
 */
class QuestionsMaterialTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.questions_material', 'app.question', 'app.subject', 'app.answer', 'app.comment', 'app.user', 'app.answers_comment', 'app.questions_comment', 'app.material');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->QuestionsMaterial = ClassRegistry::init('QuestionsMaterial');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->QuestionsMaterial);

		parent::tearDown();
	}

}
