<?php
App::uses('ReadManagementsController', 'Controller');

/**
 * ReadManagementsController Test Case
 *
*/
class ReadManagementsControllerTest extends ControllerTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
			'app.read_management'
	);


	public function testCreateRM() {
		$result = $this->testAction(
				'/articles/index/short',
				array('return' => 'vars')
		);
		debug($result);
	}


}
