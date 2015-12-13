<?php
App::uses ( 'AppModel', 'Model' );
/**
 * Notice Model
 */
class Notice extends AppModel {
	public $name = 'Notice';

	public $belongsTo = array (
			'Assignment' => array (
					'className' => 'Assignment',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'Notice.model' => 'Assignment'
					)
			),
			'Post' => array (
					'className' => 'Post',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'Notice.model' => 'Post'
					)
			),
			'Report' => array (
					'className' => 'Report',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'Notice.model' => 'Report'
					)
			)
	);

	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'notice';
}
