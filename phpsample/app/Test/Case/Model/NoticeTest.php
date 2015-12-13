<?php
App::uses('Notice', 'Model');

/**
 * Notice Test Case
 *
 */
class NoticeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.notice'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Notice = ClassRegistry::init('Notice');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Notice);

		parent::tearDown();
	}

}
