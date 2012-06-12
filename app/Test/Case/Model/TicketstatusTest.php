<?php
App::uses('Ticketstatus', 'Model');

/**
 * Ticketstatus Test Case
 *
 */
class TicketstatusTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.ticketstatus', 'app.ticket', 'app.tickettype', 'app.user', 'app.group', 'app.programme', 'app.university', 'app.subject', 'app.exam', 'app.question', 'app.answer', 'app.comment', 'app.answers_comment', 'app.questions_comment', 'app.material', 'app.questions_material', 'app.questions_exam', 'app.invitation', 'app.tickets_ticketstatus');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ticketstatus = ClassRegistry::init('Ticketstatus');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ticketstatus);

		parent::tearDown();
	}

}
