<?php
App::uses ( 'AppModel', 'Model' );
/**
 * Class Model
 */
class Homeroom extends AppModel {
	public $name = 'Homeroom';
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
			),
			'homeroom_name' => array (
					'notEmpty' => array (
							'rule' => array (
									'notEmpty'
							),
							'message' => 'クラス名を入力してください。'
					)
			)
	);

	/**
	 * ホームルームは複数のUserを持つ
	 *
	 * @var unknown
	 */
	public $hasMany = array (
			'User' => array (
					'className' => 'User',
					'foreignKey' => 'user_id'
			),
			'Topic' => array (
					'className' => 'Topic',
					'foreignKey' => 'homeroom_id'
			)
	);
}
