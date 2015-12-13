<?php
App::uses ( 'AppModel', 'Model' );
/**
 * Assignment Model
 * 課題モデル
 * 科目→課題→提出
 */
class Assignment extends AppModel {
	public $name = 'Assignment';
	public $belongsTo = array (
			'Subject' => array (
					'className' => 'Subject',
					'foreignKey' => 'subject_id'
			)
	);

	/**
	 * 課題は複数の提出物を持つモデル
	 *
	 * @var unknown
	 */
	public $hasMany = array (
			'Report' => array (
					'className' => 'Report',
					'foreignKey' => 'assignment_id',
					'dependent' => true
			),

			// なにか参考資料を付加する可能性
			'File' => array (
					// 関連したレコードも削除する
					'dependent' => true,
					'className' => 'Attachment',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'File.model' => 'Assignment'
					)
			),
			'Notice' => array (
					'dependent' => true,
					'className' => 'Notice',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'Notice.model' => 'Assignment'
					)
			),
			'ReadManagement' => array (
					'dependent' => true,
					'className' => 'ReadManagement',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'ReadManagement.model' => 'Assignment'
					)
			)
	);
}
