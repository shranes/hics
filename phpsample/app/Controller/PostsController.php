<?php
App::uses ( 'AppController', 'Controller' );
App::uses('ReadManagementsController','Controller');
class PostsController extends AppController {
	// 読み込むヘルパーたち
	public $helpers = array (
			'Html',
			'Form',
			'Session'
	);
	// セッションコンポーネントを読み込む
	// setFlashなどSessionコンポーネントを使用してる
	public $components = array (
			'Session'
	);



	/**
	 * 各メソッドの基本メソッド(共通処理)
	*/
	private function __lists($id) {

		// ここの引数はTopics_id
		if (! $id) {
			throw new NotFoundException ( __ ( '不正なアクセス' ) );
		}

		// トピックIDを持たせる（現在のトピックを判別
		// これは記事が0件の場合、判別不能になるため
		$this->set ( 'topic_id', $id );
		// 		$post = $this->Post->find ( 'all', array (
		// 				'conditions' => array (
		// 						'Post.topic_id' => $id
		// 				)
		// 		) );



		// ページネイトを利用
		$post = $this->Paginator->paginate('Post', array('Post.topic_id' => $id));


		if (! $post) {
			// 記事のないトピックも存在する
			// throw new NotFoundException(__('不正なアクセス'));
		}
		$this->set ( 'posts', $post );
	}
	/**
	 * 記事の情報表示
	 *
	 * @param unknown $id
	 * @throws NotFoundException
	 */
	private function __view($id = null) {
		if (! $id) {
			throw new NotFoundException ( __ ( 'Invalid post' ) );
		}

		$post = $this->Post->findById ( $id );
		/*
		 * 前画面へ戻るリンク
		*/
		$this->set ( 'referer', $this->referer () );
		// 2階層分のデータを結合する
		// $this->Post->Behaviors->attach('Containable');
		/*
		 * 重要：モデルをViewへ引っ張ってくる場合は以下な感じにするのだ！
		*/
		$this->Post->contain ( array (
				'Comment.User.username',
				'User.username',
				'File'
		) );

		// 通知を更新
		$updateRM = new ReadManagementsController();
		$updateRM->updateWithRM($id, 'Post', $this->Auth->user('id'));


		if (! $post) {
			throw new NotFoundException ( __ ( '無効なポスト' ) );
		}
		$this->set ( 'post', $post );

		if ($this->request->is ( 'post' )) {
			$data = $this->request->data;
			if ($data ['File'] ['0'] ['remove'] == 1) {
				// remove は1だとTrue
				if (! empty ( $data ['File'] ['0'] ['id'] )) {
					$this->loadModel ( 'Attachment' );
					$this->Attachment->delete ( $data ['File'] ['0'] ['id'] );
					$this->Session->setFlash ( __ ( '削除しました。' ) );
					return $this->redirect ( array (
							'action' => 'view',
							$id
					) );
				} else {
					$this->Session->setFlash ( __ ( '削除できませんでした。' ) );
				}
			} else {
				$this->Session->setFlash ( __ ( 'ファイルを選択してください。' ) );
			}
		}
	}
	/**
	 * 記事の追加
	 *
	 * @param string $id
	 * @throws NotFoundException
	 */
	private function __add($id = null) {
		if (! $id) {
			throw new NotFoundException ( __ ( '不正なアクセス' ) );
		}
		// セレクトボックスを持つため
		$this->loadModel ( 'Topic' );
		// セレクトボックスは配列で1：値、2：画面表示で配列を持つ
		$this->set ( 'seletopics', $this->Topic->find ( 'list', array (
				'fields' => array (
						'id',
						'topicname'
				)
		) ) );
		// Topic_idへ記事を作成するトピックIDを選択
		$this->set ( 'topic_id', $id );

		if ($this->request->is ( 'post' )) {


			// 			debug($this->request->data);
			// 			throw new NotFoundException();


			$this->Post->create ();
			// throw Exceptino;
			// ポストのユーザIDへログイン中のユーザIDを持たせる
			$this->request->data ['Post'] ['user_id'] = $this->Auth->user ( 'id' );

			// POSTされたデータは$this->request->dataに入ってる
			try {
				if ($this->Post->createWithAttachments ( $this->request->data )) {


					//debug($this->Post->getLastInsertID());
					// 通知処理
					$RM = new ReadManagementsController();
					$RM->createWithTeacherRM($this->Post->getLastInsertID(), 'Post', $this->Auth->user('id'));

					$this->Session->setFlash ( __ ( '投稿が保存されました。' ) );
					return $this->redirect ( array (
							'action' => 'lists',
							$id
					) );
				}
				$this->Session->setFlash ( __ ( '投稿を追加できません。' ) );
			} catch ( Exception $e ) {
				$this->Session->setFlash ( $e->getMessage () );
			}
		}
	}
	/**
	 * 記事の編集
	 *
	 * @param unknown $id
	 * @throws NotFoundException
	 */
	private function __edit($id) {
		// セレクトボックスのため
		$this->loadModel ( 'Topic' );
		$this->set ( 'seletopics', $this->Topic->find ( 'list', array (
				'fields' => array (
						'id',
						'topicname'
				)
		) ) );

		if (! $id) {
			throw new NotFoundException ( __ ( '無効なアクセス' ) );
		}

		// IDを検索して$postモデルへ代入する
		$post = $this->Post->findById ( $id );
		$this->set ( 'post', $post );
		// Viewへセット
		// もし検索結果がない場合はエラー通知
		if (! $post) {
			throw new NotFoundException ( __ ( '無効なアクセス' ) );
		}

		// リソースの更新はputかpostメソッドのみ
		if ($this->request->is ( array (
				'post',
				'put'
		) )) {

			/*
			 * まぁ1つしかファイルの削除ができんし 遷移先も記事になってるがここはAjax使うので問題ないかと。 だから今は気にしない！
			*/
			$data = $this->request->data;
			// リムーブフラグが無ければなにもしないよ
			if (! empty ( $data ['File'] ['0'] ['remove'] )) {
				if ($data ['File'] ['0'] ['remove'] == 1) {
					// remove は1だとTrue
					if (! empty ( $data ['File'] ['0'] ['id'] )) {
						$this->loadModel ( 'Attachment' );
						$this->Attachment->delete ( $data ['File'] ['0'] ['id'] );
						$this->Session->setFlash ( __ ( '削除しました。' ) );
					} else {
						$this->Session->setFlash ( __ ( '削除できませんでした。' ) );
					}
					// 仕方なし、Viewへ
					return $this->redirect ( array (
							'action' => 'view',
							$id
					) );
				} else {
					$this->Session->setFlash ( __ ( 'ファイルを選択してください。' ) );
					// 仕方なし、Viewへ
					return $this->redirect ( array (
							'action' => 'view',
							$id
					) );
				}
			}

			// ここから記事の更新
			$this->Post->id = $id;
			$this->request->data ['Post'] ['user_id'] = $this->Auth->user ( 'id' );
			if ($this->Post->createWithAttachments ( $this->request->data )) {
				$this->Session->setFlash ( __ ( '記事が更新されました。' ) );
				return $this->redirect ( array (
						'action' => 'view',
						$id
				) );
			}
			$this->Session->setFlash ( __ ( '記事を更新できませんでした。' ) );
		}
		if (! $this->request->data) {
			$this->request->data = $post;
		}
	}
	/**
	 * 記事の削除
	 *
	 * @param string $id
	 * @throws MethodNotAllowedException
	 */
	private function __delete($id = null) {
		if ($this->request->is ( 'get' )) {
			throw new MethodNotAllowedException ();
		}

		// $topic_id = $this->request->data['topic_id'];
		if ($this->Post->delete ( $id  ,$cascade = true)) {
			$this->Session->setFlash ( __ ( '投稿されたID: %s は削除されました。', h ( $id ) ) );
		} else {
			$this->Session->setFlash ( __ ( '投稿されたID: %s は削除できませんでした。', h ( $id ) ) );
		}

		return $this->redirect ( $this->referer () );
	}
	/**
	 * 先生のトップページ
	 */
	public function teacher_index() {

		// 先生はレポートの新着を受け取る

		$this->loadModel('ReadManagement');
		$this->set('n_reports',$this->ReadManagement->find('all', array(
				// 最新20件
				'recursive' => 2,
				'limit' => '10',
				'conditions' => array(
						'ReadManagement.user_id' => $this->Auth->user('id'),
						'ReadManagement.model' => 'Report',
						'ReadManagement.flag' => 0
				),
				'order' => array(
						'ReadManagement.id' => 'desc'
				)
		)
		));

		$this->index ();
	}
	/**
	 * リストの場合は引数はトピックID
	 *
	 * @param unknown $id
	 */
	public function teacher_lists($id = null) {
		$this->isTeacherRangeRole ( $id );
		$this->__lists ( $id );
	}

	/**
	 * 引数は記事ID
	 *
	 * @param string $id
	 */
	public function teacher_view($id = null) {
		// トピックスのIDから権限判断
		$post = $this->Post->findById ( $id );
		$this->isTeacherRangeRole ( $post ['Post'] ['topic_id'] );
		$this->__view ( $id );
		// Viewは生徒と共用
		$this->render ( 'view' );
	}

	/**
	 * Addの場合は引数はトピックスID
	 *
	 * @param string $id
	 */
	public function teacher_add($id = null) {
		$this->isTeacherRangeRole ( $id );
		$this->__add ( $id );
	}

	/**
	 * 引数は記事ID
	 *
	 * @param string $id
	 */
	public function teacher_edit($id = null) {
		// トピックスのIDから権限判断
		$post = $this->Post->findById ( $id );
		$this->isTeacherRangeRole ( $post ['Post'] ['topic_id'] );
		$this->__edit ( $id );
	}
	public function teacher_delete($id = null) {
		// トピックスのIDから権限判断
		$post = $this->Post->findById ( $id );
		$this->isTeacherRangeRole ( $post ['Post'] ['topic_id'] );
		$this->__delete ( $id );

	}

	/*
	 * 以下生徒
	*/
	public function index() {
		// $thiss->Post->Behaviors->attach('Containable');
		// $this->Post->contain();
		// ポストモデルをセットし、findで全件のデータを取得する
		$this->loadModel ( 'Topic' );
		$this->Post->contain ( array (
				'User'
		) );

		$this->loadModel('ReadManagement');
		$this->set('n_posts',$this->ReadManagement->find('all', array(
				// 最新20件
				'limit' => '10',
				'conditions' => array(
						'ReadManagement.user_id' => $this->Auth->user('id'),
						'ReadManagement.model' => 'Post',
						'ReadManagement.flag' => 0
						),
						'order' => array(
								'ReadManagement.id' => 'desc'
						)
				)
		));

		//$this->set ( 'posts', $this->Post->find ( 'all' ) );
	}

	// TopicsのIDからPOSTデータを検索してデータセット
	public function lists($id = null) {
		$this->isRangeRole ( $id );
		$this->__lists ( $id );
	}
	public function view($id = null) {
		// トピックスのIDから権限判断
		$post = $this->Post->findById ( $id );
		$this->isRangeRole ( $post ['Post'] ['topic_id'] );
		$this->__view ( $id );
	}

	/**
	 * 記事の追加：上位のトピックIDを識別するためにIDを渡す
	 *
	 * @param unknown $id
	 */
	public function add($id) {
		$this->isRangeRole ( $id );
		$this->__add ( $id );
	}
	public function edit($id = null) {
		// トピックスのIDから権限判断
		$post = $this->Post->findById ( $id );
		$this->isRangeRole ( $post ['Post'] ['topic_id'] );
		$this->__edit ( $id );
	}
	public function delete($id) {
		// トピックスのIDから権限判断
		$post = $this->Post->findById ( $id );
		$this->isRangeRole ( $post ['Post'] ['topic_id'] );
		$this->__delete ( $id );
	}

	/**
	 * 認証されている場合のみ投稿でき、自分の投稿した記事しか削除と編集できない
	 * 権限判定アダプタを使用する。アダプタがtrueを返すと権限ありとみなす。
	 *
	 * @see AppController::isAuthorized()
	 */
	public function isAuthorized($user) {
		// 登録済みユーザは投稿できる
		if ($this->action === 'add') {
			return true;
		}

		if ($this->action === 'lists') {
			return true;
		}

		if ($this->action === 'view') {
			return true;
		}

		// 編集と削除は作成者のみ
		if (in_array ( $this->action, array (
				'edit',
				'delete'
		) )) {
			$postId = ( int ) $this->request->params ['pass'] [0];
			$this->Session->setFlash ( __ ( $postId ) );
			if ($this->Post->isOwnedBy ( $postId, $user ['id'] )) {
				return true;
			}
		}

		//
		return parent::isAuthorized ( $user );
	}
}