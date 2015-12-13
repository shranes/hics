<?php
App::uses('TeacherTag', 'Model');

/**
 * TeacherTag Test Case
 *
 */
class TeacherTagTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.teacher_tag',
		'app.user',
		'app.group',
		'app.comment',
		'app.post',
		'app.topic',
		'app.attachment',
		'app.class'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TeacherTag = ClassRegistry::init('TeacherTag');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TeacherTag);

		parent::tearDown();
	}

}
