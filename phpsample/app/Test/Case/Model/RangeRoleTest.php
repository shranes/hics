<?php
App::uses('RangeRole', 'Model');

/**
 * RangeRole Test Case
 *
 */
class RangeRoleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.range_role'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RangeRole = ClassRegistry::init('RangeRole');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RangeRole);

		parent::tearDown();
	}

}
