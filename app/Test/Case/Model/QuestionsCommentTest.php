<?php
App::uses('QuestionsComment', 'Model');

/**
 * QuestionsComment Test Case
 *
 */
class QuestionsCommentTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.questions_comment', 'app.question', 'app.subject', 'app.answer', 'app.comment', 'app.user', 'app.answers_comment', 'app.material', 'app.questions_material');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->QuestionsComment = ClassRegistry::init('QuestionsComment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->QuestionsComment);

		parent::tearDown();
	}

}
