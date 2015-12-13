<?php
class TopicsController extends AppController {
	public $helpers = array (
			'Html',
			'Form',
			'Session'
	);
	public $components = array (
			'Session'
	);

	/**
	 * 公開範囲を'rangerole'で登録
	 *
	 * @param string $id
	 * @throws NotFoundException
	 */
	private function __setRangeRole($id = null) {
		if (! $id) {
			throw new NotFoundException ();
		}
		$this->loadModel ( 'RangeRole' );
		$this->RangeRole->recusive = - 1;
		$this->set ( 'rangerole', $this->RangeRole->findById ( $id, array (
				'contain' => false
		) ) );
	}
	/*
	 * 以下は先生部分がかなり冗長だけども致し方なし。
	 */
	private function __common() {
		// トピックスの移動はいまのところ考察中
		$this->Topic->contain ( array (
				'User.username'
		) );
		$this->set ( 'seletopics', $this->Topic->find ( 'list', array (
				'fields' => array (
						'id',
						'topicname'
				)
		) ) );
		// $this->set ( 'topics', $this->Topic->find ( 'all', array (
		// 'conditions' => array (
		// 'Topic.range_role_id' => '1'
		// )
		// ) ) );
		// ページネイト
		$this->set ( 'topics', $this->Paginator->paginate ( 'Topic', array (
				'Topic.range_role_id' => '1'
		) ) );

		$this->__setRangeRole ( '1' );
	}
	private function __homeroom() {
		/*
		 * 公開範囲がクラス内（２）であるかつログイン中ユーザのホームルームID
		 */
// 		$this->set ( 'topics', $this->Topic->find ( 'all', array (
// 				'conditions' => array (
// 						// And条件を明示
// 						'and' => array (
// 								'Topic.range_role_id' => '2',
// 								'Topic.homeroom_id' => $this->Auth->user ( 'homeroom_id' )
// 						)
// 				)
// 		) ) );

		$this->set ( 'topics', $this->Paginator->paginate ( 'Topic', array (
				'Topic.range_role_id' => '2',
				'Topic.homeroom_id' => $this->Auth->user ( 'homeroom_id' )
		) ) ) ;

		$this->loadModel ( 'RangeRole' );
		$this->RangeRole->recusive = - 1;
		$this->set ( 'rangerole', $this->RangeRole->findById ( '1', array (
				'contain' => false
		) ) );
		$this->__setRangeRole ( '2' );
	}
	/**
	 * リダイレクト処理
	 *
	 * @param string $id
	 * @throws ForbiddenException
	 */
	private function __redirect($id = null) {
		if (! $id) {
			throw new ForbiddenException ();
		}
		if ($id === '1') {
			return $this->redirect ( array (
					'action' => 'common'
			) );
		} else if ($id === '2') {
			return $this->redirect ( array (
					'action' => 'homeroom'
			) );
		} else {
			return false;
		}
	}

	/**
	 * 全体へ公開
	 */
	public function common() {
		$this->__common ();
		$this->render ( 'view' );
	}
	/**
	 * クラス内のみ
	 */
	public function homeroom() {
		$this->__homeroom ();
		$this->render ( 'view' );
	}
	/**
	 * 個人的
	 */
	public function personal() {

		/*
		 * 公開範囲が個人（３）であるかつログイン中ユーザが作成者
		 */
// 		$this->set ( 'topics', $this->Topic->find ( 'all', array (
// 				'conditions' => array (
// 						// And条件を明示
// 						'and' => array (
// 								'Topic.range_role_id' => '3',
// 								'Topic.user_id' => $this->Auth->user ( 'id' )
// 						)
// 				)
// 		) ) );


		$this->set ( 'topics', $this->Paginator->paginate ( 'Topic', array (
				'Topic.range_role_id' => '3',
				'Topic.user_id' => $this->Auth->user ( 'id' )
		) ) ) ;

		$this->__setRangeRole ( '3' );
		$this->render ( 'view' );
	}
	public function teacher_common() {
		$this->__common ();
		$this->render ( 'teacher_view' );
	}
	/**
	 * ここは同じく自分のクラスのトピック
	 */
	public function teacher_homeroom() {
		$this->__homeroom ();
		$this->render ( 'teacher_view' );
	}
	/**
	 * パーソナルだけは生徒一覧のトピックを見れるように
	 */
	public function teacher_personal() {
		// 個人区別の自身と同じホームルームIDの生徒
		$this->set ( 'topics', $this->Topic->find ( 'all', array (
				'conditions' => array (
						// And条件を明示
						'and' => array (
								'Topic.range_role_id' => '3',
								'Topic.homeroom_id' => $this->Auth->user ( 'homeroom_id' )
						)
				)
		) ) );

		$this->set ( 'topics', $this->Paginator->paginate ( 'Topic', array (
				'Topic.range_role_id' => '3',
				'Topic.homeroom_id' => $this->Auth->user ( 'homeroom_id' )
		) ) ) ;

		$this->__setRangeRole ( '3' );
		$this->render ( 'teacher_view' );
	}

	/**
	 * トピックスの作成
	 *
	 * @param string $id
	 */
	public function teacher_add($id = null) {
		$this->__setRangeRole ( $id );

		if ($this->request->is ( 'post' )) {
			$this->Topic->create ();
			// 作成者のユーザIDを認証情報から設定
			$this->request->data ['Topic'] ['user_id'] = $this->Auth->user ( 'id' );
			$this->request->data ['Topic'] ['homeroom_id'] = $this->Auth->user ( 'homeroom_id' );

			if ($this->Topic->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'トピックが作成されました' ) );
				// ポストのリストへ登録したIDを渡してリダイレクト

				// 投稿したトピックスのRange_role_idでリダイレクトをかける
				$range_role_id = $this->Topic->findById ( $this->Topic->getInsertId () )['Topic']['id'];
				$this->__redirect ( $range_role_id );
			} else {
				$this->Session->setFlash ( __ ( 'トピックを作成できませんでした' ) );
			}
		}
	}
	public function teacher_edit($id) {
		if (! $id) {
			throw new NotFoundException ( __ ( '無効なPOST' ) );
		}

		$topic = $this->Topic->findById ( $id );

		if (! $topic) {
			throw new NotFoundException ( __ ( 'Not FoundTopis' ) );
		}

		if ($this->request->is ( array (
				'post',
				'put'
		) )) {
			$this->Topic->id = $id;
			if ($this->Topic->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'トピックが更新されました' ) );
				return $this->redirect ( array (
						'action' => 'view'
				) );
			}
			$this->Session->setFlash ( __ ( 'トピックを更新できませんでした' ) );
		}
		if (! $this->request->data) {
			$this->request->data = $topic;
		}
	}
	public function teacher_delete($id) {
		if (! $id) {
			throw new NotFoundException ();
		}

		$topic = $this->Topic->findById ( $id );
		$range_role_id = $topic ['Topic'] ['range_role_id'];

		if ($this->request->is ( 'get' )) {
			throw new MethodNotAllowedException ();
		}

		if ($this->Topic->delete ( $id )) {
			$this->Session->setFlash ( __ ( 'トピック： %s は削除されました', h ( $id ) ) );
		} else {
			$this->Session->setFlash ( __ ( 'トピック： %s は削除できませんでした。', h ( $id ) ) );
		}

		// 削除されたトピックスへリダイレクト
		$this->__redirect ( $range_role_id );
	}
	public function isAuthorized($user) {
		// トピック一覧も認証必須範囲
		if ($this->action === 'view') {
			return true;
		}

		if ($this->action === 'add') {
			return true;
		}

		if ($this->action === 'edit') {
			return true;
		}

		if ($this->action === 'delete') {
			return true;
		}

		return parent::isAuthorized ( $user );
	}
}