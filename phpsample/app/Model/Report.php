<?php
App::uses ( 'AppModel', 'Model' );
/**
 * Report Model
 * 提出モデル
 * 科目→課題→提出
*/
class Report extends AppModel {
	public $name = 'Report';
	public $belongsTo = array (
			// UserとしてPostモデルの連想配列に外部キーよりデータを持たせる
			'User' => array (
					'className' => 'User',
					// ここはpost側の外部キーを指定
					'foreignKey' => 'user_id'
			),
			// 複数の課題に所属する
			'Assignment' => array (
					'className' => 'Assignment',
					'foreignKey' => 'assignment_id'
			)
	);

	/**
	 * 提出課題が複数持つモデル
	 *
	 * @var unknown
	*/
	public $hasMany = array (

			'File' => array (
					// 関連したレコードも削除する
					'dependent' => true,
					'className' => 'Attachment',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'File.model' => 'Report'
					)
			),
			'Notice' => array (
					'dependent' => true,
					'className' => 'Notice',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'Notice.model' => 'Report'
					)
			),
			'ReadManagement' => array (
					'dependent' => true,
					'className' => 'ReadManagement',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'ReadManagement.model' => 'Report'
					)
			)
	);

// 	public $hasOne = array(
// 			'User' => array(
// 					'className' => 'User',
// 					'foreignKey' => 'id',
// 			)
// 	);


}
