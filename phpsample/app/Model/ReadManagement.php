<?php
App::uses('AppModel', 'Model');
/**
 * ReadManagement Model
 *
 */
class ReadManagement extends AppModel {

	public $belongsTo = array (
			'Assignment' => array (
					'className' => 'Assignment',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'ReadManagement.model' => 'Assignment'
					)
			),
			'Post' => array (
					'className' => 'Post',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'ReadManagement.model' => 'Post'
					)
			),
			'Report' => array (
					'className' => 'Report',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'ReadManagement.model' => 'Report'
					)
			)
	);

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'read_management';

}
