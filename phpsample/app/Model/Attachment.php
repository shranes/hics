<?php
class Attachment extends AppModel {
	public $name = 'Attachment';
	public $validate = array (
			'attachment' => array (
					'allowEmpty' => true,
					'rule' => array (
							'isValidExtension',
							array (
									'docx',
									'jpg',
									'pdf',
									'doc',
									'txt',
									'cvs'
							),
							false
					),
					'message' => '無効な拡張子のファイルです。'
			)
	);
	public $actsAs = array (
			'Upload.Upload' => array (
					'attachment' => array (
							'rootDir' => WWW_ROOT,
							'path' => 'file{DS}'
					)
			)
	);
	public $belongsTo = array (
			'Post' => array (
					'className' => 'Post',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'Attachment.model' => 'Post'
					)
			),
			'User' => array (
					'className' => 'User',
					'foreignKey' => 'user_id'
			),
			'Report' => array (
					'className' => 'Report',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'Attachment.model' => 'Report'
					)
			),
			'Assignment' => array (
					'className' => 'Assignment',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'Attachment.model' => 'Assignment'
					)
			)
	);
}
?>