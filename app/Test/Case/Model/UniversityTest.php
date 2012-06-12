<?php
App::uses('University', 'Model');

/**
 * University Test Case
 *
 */
class UniversityTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.university', 'app.programme', 'app.subject', 'app.exam', 'app.material', 'app.question', 'app.answer', 'app.comment', 'app.user', 'app.answers_comment', 'app.questions_comment', 'app.questions_material');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->University = ClassRegistry::init('University');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->University);

		parent::tearDown();
	}

}
