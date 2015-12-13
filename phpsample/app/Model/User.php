<?php
// app/Model/User.php
App::uses ( 'AppModel', 'Model' );
App::uses ( 'Topic', 'Model' );
App::uses ( 'BlowfishPasswordHasher', 'Controller/Component/Auth' );
App::uses ( 'AuthComponent', 'Controller/Component' );
class User extends AppModel {
	// 名前は一意識別
	public $name = 'User';
	public $actsAs = array (
			'Acl' => array (
					'type' => 'requester'
			),
			'Containable'
	);
	public $validate = array (
			'username' => array (
					'naturalNumber' => array (
							'rule' => 'naturalNumber',
							'message' => '半角数字の自然数が必要です。'
					),
					'maxLength' => array (
							'rule' => array (
									'maxLength',
									'6'
							),
							'message' => '6桁以内です。'
					),
					'minLength' => array (
							'rule' => array (
									'minLength',
									'6'
							),
							'message' => '6桁必要です。'
					),
					'required' => array (
							'rule' => array (
									'notEmpty'
							),
							'message' => 'ユーザー名が必要です。'
					)
			),
			'password' => array (
					'required' => array (
							'rule' => array (
									'notEmpty'
							),
							'message' => 'パスワードが必要です。'
					),
					'minLength' => array (
							'rule' => array (
									'minLength',
									'6'
							),
							'message' => '6文字以上必要です。'
					)
			)
	);
	public $belongsTo = array (
			'Teacher' => array (
					'className' => 'User',
					'foreignKey' => 'teacher_id',
					'fields' => array (
							'userfname',
							'userlname'
					)
			),
			'Group',
			'Homeroom',
	);

	// 一人のユーザは複数のコメントを持つ
	public $hasMany = array (
			'Comment' => array (
					'className' => 'Comment',
					'foreignKey' => 'user_id'
			),
			'File' => array (
					'className' => 'Attachment',
					'foreignKey' => 'user_id',
					'conditions' => array (
							'File.model' => 'Post'
					)
			),
			'Student' => array (
					'className' => 'User',
					'foreignKey' => 'teacher_id'
			),
			'Topic' => array (
					'className' => 'Topic',
					'foreignKey' => 'user_id'
			),
			// 			'Post' => array(
					// 					'className' => 'ReadManagement',
					// 					'foreignKey' => 'foreign_key',
					// 					'conditions' => array (
							// 							// モデル名がPostのレコードを抽出
							// 							'ReadManagement.model' => 'Post'
							// 					)
					// 			),
	// 			'Assign' => array(
			// 					'className' => 'ReadManagement',
			// 					'foreignKey' => 'foreign_key',
			// 					'conditions' => array (
					// 							// モデル名がPostのレコードを抽出
					// 							'ReadManagement.model' => 'Assignment'
	// 					)
	// 			)
	);

	/**
	 * ACL関連
	 *
	 * @return NULL|multitype:multitype:Ambigous <string, boolean, mixed>
	*/
	public function parentNode() {
		if (! $this->id && empty ( $this->data )) {
			return null;
		}
		if (isset ( $this->data ['User'] ['group_id'] )) {
			$groupId = $this->data ['User'] ['group_id'];
		} else {
			$groupId = $this->field ( 'group_id' );
		}
		if (! $groupId) {
			return null;
		} else {
			return array (
					'Group' => array (
							'id' => $groupId
					)
			);
		}
	}

	/**
	 * 記事の投稿と同時に個人トピックスも登録（ファイルも投稿）
	 *
	 * @param unknown $data
	 * @throws Exception
	 * @return boolean
	 */
	public function createWithTopics($data) {
		// Sanitize your images before adding them
		$dataSource = $this->getDataSource ();
		$this->Topic = new Topic ();

		$dataSource->begin ();
		// トピックスの名前を自身の学籍番号へ設定する
		$data ['Topic'] ['topicname'] = $data ['User'] ['username'];
		// debug($data);
		// throw new NotFoundException();
		$this->create ();
		if ($this->save ( $data )) {
			// 最後に登録したユーザIDを外部キーにトピックスを作成
			$data ['Topic'] ['user_id'] = $this->getInsertId ();
			$this->Topic->create ();
			if ($this->Topic->save ( $data )) {
				$dataSource->commit ();
				return true;
			}
			$dataSource->rollback ();
		}

		// Throw an exception for the controller
		throw new Exception ( __ ( "生徒を登録できませんでした。再施行してください。" ) );
	}

	// 該当ユーザのハッシュ化されたパスワードを返す
	public function getPasswordById($id) {
		$user = $this->find ( 'first', array (
				'conditions' => array (
						'User.id' => $id
				),
				'fields' => 'password'
		) );
		return $user ['User'] ['password'];
	}
	public function beforeSave($options = array()) {
		if (isset ( $this->data [$this->alias] ['password'] )) {
			$passwordHasher = new BlowfishPasswordHasher ();
			$this->data [$this->alias] ['password'] = $passwordHasher->hash ( $this->data [$this->alias] ['password'] );
		}
		return true;
	}

	/**
	 * ユーザ情報が変更されると自動でAuthを更新
	 *
	 * @see Model::afterSave()
	 */
	// public function afterSave($created, $options = array()){
	// parent::afterSave($created,$options);

	// //updating authentication session
	// App::uses('CakeSession', 'Model/Datasource');
	// CakeSession::write('Auth',$this->findById(AuthComponent::user('id')));

	// return true;
	// }
}