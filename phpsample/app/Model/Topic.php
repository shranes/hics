<?php
class Topic extends AppModel {
	// コンティナブルをロード
	var $actsAs = array (
			'Containable'
	);
	public $name = 'Topic';
	public $validate = array (
			'topicname' => array (
					'notEmpty' => array (
							'rule' => 'notEmpty',
							'message' => '必須項目です。'
					)
			),
			'range_role_id' => array (
					'notEmpty' => array (
							'rule' => 'notEmpty',
							'message' => '必須項目です。'
					)
			)
	);
	public $hasMany = array (
			'Post' => array (
					'className' => 'Post',
					'foreignKey' => 'topic_id',
					'dependent' => true
			)
	);
	public $belongsTo = array (
			'User' => array (
					'className' => 'User',
					'foreignKey' => 'user_id'
			),
			'RangeRole' => array (
					'className' => 'RangeRole',
					'foreignKey' => 'range_role_id'
			),
			'Homeroom' => array (
					'className' => 'Homeroom',
					'foreignKey' => 'homeroom_id'
			)
	);
}