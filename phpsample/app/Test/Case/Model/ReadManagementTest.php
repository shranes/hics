<?php
App::uses('ReadManagement', 'Model');

/**
 * ReadManagement Test Case
 *
 */
class ReadManagementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.read_management'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ReadManagement = ClassRegistry::init('ReadManagement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ReadManagement);

		parent::tearDown();
	}

}
