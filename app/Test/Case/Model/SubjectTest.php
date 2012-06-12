<?php
App::uses('Subject', 'Model');

/**
 * Subject Test Case
 *
 */
class SubjectTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.subject', 'app.programme', 'app.university', 'app.exam', 'app.material', 'app.question', 'app.answer', 'app.comment', 'app.user', 'app.answers_comment', 'app.questions_comment', 'app.questions_material');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Subject = ClassRegistry::init('Subject');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Subject);

		parent::tearDown();
	}

}
