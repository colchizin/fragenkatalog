<?php
App::uses('Programme', 'Model');

/**
 * Programme Test Case
 *
 */
class ProgrammeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.programme', 'app.university', 'app.subject');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Programme = ClassRegistry::init('Programme');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Programme);

		parent::tearDown();
	}

}
