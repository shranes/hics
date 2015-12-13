<?php
App::uses ( 'AppModel', 'Model' );
/**
 * RangeRole Model
 */
class RangeRole extends AppModel {
	public $name = 'RangeRole';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'range_name';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array (
			'id' => array (
					'notEmpty' => array (
							'rule' => array (
									'notEmpty'
							)
					// 'message' => 'Your custom message here',
					// 'allowEmpty' => false,
					// 'required' => false,
					// 'last' => false, // Stop validation after this rule
					// 'on' => 'create', // Limit validation to 'create' or 'update' operations
										)
			)
	);
	public $hasMany = array (
			'Topic' => array (
					'className' => 'Topic',
					'foreignKey' => 'range_role_id'
			)

	);
}
