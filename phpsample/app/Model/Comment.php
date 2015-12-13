<?php

class Comment extends AppModel {
	public $name = "Comment";
	// アソシエーションを設定
	// 同じアソシエーションを分割できない（名前の競合）
	public $belongsTo = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'Post_id'
	),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	//
	public $hasOne = array (
		'User' => array(
			'className' => 'User',
				//ここの外部キーは表先の参照元のキー
			'foreignKey' => 'id'
		)
	);

	public $validate = array (
			'comment' => array (
					'rule' => 'notEmpty'
			)
	);

}