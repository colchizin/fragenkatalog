<?php
App::uses('ExamsessionsQuestion', 'Model');

/**
 * ExamsessionsQuestion Test Case
 *
 */
class ExamsessionsQuestionTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.examsessions_question', 'app.examsession', 'app.user', 'app.group', 'app.programme', 'app.university', 'app.subject', 'app.exam', 'app.question', 'app.answer', 'app.comment', 'app.answers_comment', 'app.questions_comment', 'app.material', 'app.questions_material', 'app.questions_exam', 'app.invitation', 'app.session');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ExamsessionsQuestion = ClassRegistry::init('ExamsessionsQuestion');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ExamsessionsQuestion);

		parent::tearDown();
	}

}
