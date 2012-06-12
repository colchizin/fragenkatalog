<?php
App::uses('Question', 'Model');

/**
 * Question Test Case
 *
 */
class QuestionTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.question', 'app.subject', 'app.answer', 'app.comment', 'app.user', 'app.answers_comment', 'app.questions_comment', 'app.material', 'app.questions_material');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Question = ClassRegistry::init('Question');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Question);

		parent::tearDown();
	}

}
