<?php
App::uses ( 'AppModel', 'Model' );
/**
 * Subject Model
 */
class Subject extends AppModel {
	public $name = 'Subject';
	public $hasMany = array (
			'Assignment' => array (
					'className' => 'Assignment',
					'foreignKey' => 'subject_id',
					'dependent' => true
			)
	);
	public $belongsTo = array (

			// 作成者は特定せず所属するのはあくまでクラス単位。
			'Homeroom' => array (
					'className' => 'Homeroom',
					'foreignKey' => 'homeroom_id'
			)
	);
}
