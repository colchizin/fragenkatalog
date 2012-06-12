<?php
App::uses('Ticketcomment', 'Model');

/**
 * Ticketcomment Test Case
 *
 */
class TicketcommentTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.ticketcomment', 'app.ticket', 'app.tickettype', 'app.user', 'app.group', 'app.programme', 'app.university', 'app.subject', 'app.exam', 'app.question', 'app.answer', 'app.comment', 'app.answers_comment', 'app.questions_comment', 'app.material', 'app.questions_material', 'app.questions_exam', 'app.invitation', 'app.has_ticketstatus', 'app.ticketstatus', 'app.tickets_ticketstatus');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ticketcomment = ClassRegistry::init('Ticketcomment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ticketcomment);

		parent::tearDown();
	}

}
