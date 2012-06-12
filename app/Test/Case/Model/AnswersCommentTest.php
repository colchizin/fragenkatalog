<?php
App::uses('AnswersComment', 'Model');

/**
 * AnswersComment Test Case
 *
 */
class AnswersCommentTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.answers_comment', 'app.answer', 'app.question', 'app.comment');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnswersComment = ClassRegistry::init('AnswersComment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnswersComment);

		parent::tearDown();
	}

}
