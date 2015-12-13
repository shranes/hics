<?php

// Postsという自前のデータベースと関連付けられる
class Post extends AppModel {
	// Attachmentをロード
	public $uses = array (
			'Attachment'
	);
	// コンティナブルをロード
	var $actsAs = array (
			'Containable'
	);
	public $name = 'Post';
	// validate配列を使ってsaveメソッドが呼ばれた時を定義
	public $validate = array (
			'title' => array (
					// notEmpty = 空ではない
			),
			'body' => array (
					'rule' => 'notEmpty'
			),
			'user_id' => array (
					'rule' => 'notEmpty'
			),
			'topic_id' => array (
					'rule' => 'notEmpty'
			)
	);

	// 一つの記事は投稿者のユーザ情報を持っている
	public $belongsTo = array (
			// UserとしてPostモデルの連想配列に外部キーよりデータを持たせる
			'User' => array (
					'className' => 'User',
					// ここはpost側の外部キーを指定
					'foreignKey' => 'user_id'
			),
			'Topic' => array (
					'className' => 'Topic',
					'foreignKey' => 'topic_id'
			)
	);

	/**
	 * 記事が複数持つモデル
	 *
	 * @var unknown
	 */
	public $hasMany = array (
			'Comment' => array (
					'className' => 'Comment',
					'foreignKey' => 'post_id',
					'dependent' => true
			),
			'File' => array (
					// 関連したレコードも削除する
					'dependent' => true,
					'className' => 'Attachment',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'File.model' => 'Post'
					)
			),
			'Notice' => array (
					'dependent' => true,
					'className' => 'Notice',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							'Notice.model' => 'Notice'
					)
			),
			'ReadManagement' => array (
					'dependent' => true,
					'className' => 'ReadManagement',
					'foreignKey' => 'foreign_key',
					'conditions' => array (
							// モデル名がPostのレコードを抽出
							'ReadManagement.model' => 'Post'
					)
			)
	);

	/**
	 * 拡張子をMimeタイプから
	 *
	 * @param unknown $data
	 */
	public function limitExtentions($type) {
		$mimetype = array (
				'image/jpeg',
				'image/gif',
				'image/png'
		);
	}

// 	/**
// 	 * 記事の投稿と同時にアタッチメントも登録（ファイルも投稿）
// 	 *
// 	 * @param unknown $data
// 	 * @throws Exception
// 	 * @return boolean
// 	 */
// 	public function createWithAttachments($data) {
// 		// Sanitize your images before adding them

// 		$files = array ();
// 		if (! empty ( $data ['File'] [0]['attachment']['name'] )) {
// 			foreach ( $data ['File'] as $i => $file ) {
// 				if (is_array ( $data ['File'] [$i] )) {
// 					// Force setting the `model` field to this model
// 					//$file ['model'] = $model;

// 					// Unset the foreign_key if the user tries to specify it
// 					if (isset ( $file ['foreign_key'] )) {
// 						unset ( $file ['foreign_key'] );
// 					}
// 					$files [] = $file;
// 				}
// 			}
// 			$data ['File'] = $files;
// 		} else {
// 			// もしデータがない場合は連想配列をリジェクトする
// 			unset($data['File']);
// 			debug($data);
// 		}
// 		//$data ['File'] = $files;

// 		// Try to save the data using Model::saveAll()
// 		$this->create ();
// 		if ($this->saveAll ( $data )) {
// 			// ここで主キーへファイル名を変更する
// 			return true;
// 		}

// 		// Throw an exception for the controller
// 		throw new Exception ( __ ( "This post could not be saved. Please try again" ) );
// 	}

	// 自信の投稿かどうかの判断
	public function isOwnedBy($post, $user) {
		return $this->field ( 'id', array (
				'id' => $post,
				'user_id' => $user
		) ) !== false;
	}
}