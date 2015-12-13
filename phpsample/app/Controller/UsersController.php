<?php
// app/Controller/UsersController.php
App::uses ( 'AppController', 'Controller' );
App::uses ( 'BlowfishPasswordHasher', 'Controller/Component/Auth' );
class UsersController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter ();
		// ユーザ自身による登録とログアウトを許可
		// $this->Auth->allow('logout');
		// CakePHP 2.1以上
		// $this->Auth->allow();
	}
	public function teacher_index() {
		// 生徒管理のためのページインデックス
		$this->User->recusive = 0;
		$condition = array (
				/*
				 * ここはモデル名から選択しないとWhereのカラムがどっちのテーブルなのか
				 * 判別することができない（自己参照のため重複名のカラムがあるため）
				 */
				'User.teacher_id' => $this->Auth->user ( 'id' )
		);
		$data = $this->paginate ( $condition );
		// 必要なのはグループが学生で自分の担当である生徒
		$this->set ( 'users', $data );
	}
	public function index() {
		$this->User->recusive = 0;
		$this->set ( 'users', $this->paginate () );
	}
	public function teacher_info($id = null) {

		/*
		 * 正しいアクセスかを判断
		 */
		$this->isSameHomeroom ( $id );

		$this->User->recusive = 0;

		// IDがセットされて無ければエラー
		if (is_null ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}

		$this->User->id = $id;
		if (! $this->User->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}
		$this->set ( 'user', $this->User->read ( null, $id ) );
	}

	/**
	 * プレフィックスルーティングを使うのだ
	 * これは先生による生徒の追加
	 */
	public function teacher_add() {
		$groups = $this->User->Group->find ( 'list' );
		$this->set ( compact ( 'groups' ) );

		if ($this->request->is ( 'post' )) {

			/*
			 * グループIDと先生IDはフォームから入力させない
			 */
			$this->User->create ();
			// ログイン中の先生のユーザIDを生徒の先生IDとして登録
			// $this->User->set ( 'teacher_id', $this->Auth->user ( 'id' ) );
			// $this->User->set ('homeroom_id', $this->Auth->user ('homeroom_id'));

			if (! $this->request->data ['Topic'] ['homeroom_id']) {
				throw new NotFoundException ();
			}

			// studentsとなってるグループIDを取得
			$this->loadModel ( 'Group' );
			$group = $this->Group->find ( 'first', array (
					'conditions' => array (
							'Group.name' => 'students'
					)
			) );
			$this->request->data ['User'] ['group_id'] = $group ['Group'] ['id'];

			if (! $this->request->data ['User'] ['group_id']) {
				throw new NotFoundException ( __ ( 'グループIDエラー' ) );
			}

			if ($this->User->createWithTopics ( $this->request->data )) {
				$this->Session->setFlash ( __ ( '生徒が登録されました。' ) );
				return $this->redirect ( array (
						'action' => 'index'
				) );
			} else {
				$this->Session->setFlash ( __ ( '生徒は登録できませんでした。再試行してください。' ) );
			}
		}
	}

	/**
	 * 先生によるユーザの削除
	 */
	public function teacher_delete($id = null) {
		$this->request->onlyAllow ( 'post' );

		$this->User->id = $id;
		if (! $this->User->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}
		if ($this->User->delete ()) {
			$this->Session->setFlash ( __ ( 'ユーザを削除しました。' ) );
			$this->redirect ( array (
					'action' => 'index'
			) );
		}
		$this->Session->setFlash ( __ ( 'ユーザを削除できませんでした。' ) );
		$this->redirect ( array (
				'action' => 'index'
		) );
	}

	/**
	 * これは単なるユーザ追加
	 */
	public function add() {
		if ($this->request->is ( 'post' )) {
			$this->User->create ();
			if ($this->User->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'ユーザが登録されました。' ) );
			} else {
				$this->Session->setFlash ( __ ( 'ユーザは登録できませんでした。再試行してください。' ) );
			}
		}
		$groups = $this->User->Group->find ( 'list' );
		$this->set ( compact ( 'groups' ) );
	}

	/**
	 * 先生のパスワード変更
	 */
	public function teacher_password() {
		// 自分のログイン中AuthからIDを選択
		$id = null;
		$id = $this->Auth->user ( 'id' );
		// IDがセットされて無ければエラー
		if (is_null ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}

		$this->User->id = $id;
		if (! $this->User->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}

		/*
		 * プットとポストのみ
		 */
		if ($this->request->is ( array (
				'put',
				'post'
		) )) {

			// ここでパスワードの確認
			if ($this->checkPassword ()) {
				// ユーザ情報のみ保存
				if ($this->User->save ( $this->request->data )) {
					$this->Session->setFlash ( __ ( 'パスワードを変更しました。' ) );
					$this->redirect ( array (
							'action' => 'view'
					) );
				} else {
					$this->Session->setFlash ( __ ( '変更できませんでした。再試行してください。' ) );
				}
			} else {
				$this->Session->setFlash ( __ ( '現在のパスワードが一致しません。再試行してください。' ) );
			}
		} else {
			$this->request->data = $this->User->read ( null, $id );
			unset ( $this->request->data ['User'] ['password'] );
		}
		// これが無いとグループリストが取れない
		$groups = $this->User->Group->find ( 'list' );
		$this->set ( compact ( 'groups' ) );
	}

	/**
	 * 先生の基本情報変更
	 */
	public function teacher_edit() {
		unset ( $this->User->validate ['username'] ['naturalNumber'] );
		$this->edit ();
	}

	/**
	 * 先生による生徒情報の変更
	 */
	public function teacher_editstudent($id = null) {
		if (! $id) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}

		// 直リンクでのアクセス制限
		$this->isSameHomeroom ( $id );

		$this->User->id = $id;
		if (! $this->User->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}

		/*
		 * プットとポストのみ
		 */
		if ($this->request->is ( array (
				'put',
				'post'
		) )) {

			// アソシエーションしてるモデルも含めて全部保存
			if ($this->User->saveall ( $this->request->data, array (
					'deep' => true
			) )) {
				$this->Session->setFlash ( __ ( '保存されました。' ) );
				$this->redirect ( array (
						'action' => 'index'
				) );
			} else {
				$this->Session->setFlash ( __ ( '保存できませんでした。再試行してください。' ) );
			}
		} else {
			$this->request->data = $this->User->read ( null, $id );
			unset ( $this->request->data ['User'] ['password'] );
		}
		// これが無いとグループリストが取れない
		$groups = $this->User->Group->find ( 'list' );
		$this->set ( compact ( 'groups' ) );
		$this->set ( 'user', $this->User->findById ( $id ) );
		$this->render ( 'edit' );
	}
	public function teacher_view() {
		$this->view ();
	}
	public function view() {
		// 自分のログイン中AuthからIDを選択
		$this->User->recusive = 0;
		$id = null;
		$id = $this->Auth->user ( 'id' );
		// IDがセットされて無ければエラー
		if (is_null ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}

		$this->User->id = $id;
		if (! $this->User->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}
		$this->set ( 'user', $this->User->read ( null, $id ) );
	}

	/**
	 * 生徒の情報変更
	 *
	 * @throws NotFoundException
	 */
	public function edit() {

		// 自分のログイン中AuthからIDを選択
		$id = null;
		$id = $this->Auth->user ( 'id' );
		// IDがセットされて無ければエラー
		if (is_null ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}

		$this->User->id = $id;
		if (! $this->User->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}

		/*
		 * プットとポストのみ
		 */
		if ($this->request->is ( array (
				'put',
				'post'
		) )) {

			// アソシエーションしてるモデルも含めて全部保存
			if ($this->User->saveall ( $this->request->data, array (
					'deep' => true
			) )) {
				$this->Session->setFlash ( __ ( '保存されました。' ) );
				$this->redirect ( array (
						'action' => 'view'
				) );
			} else {
				$this->Session->setFlash ( __ ( '保存できませんでした。再試行してください。' ) );
			}
		} else {
			$this->request->data = $this->User->read ( null, $id );
			unset ( $this->request->data ['User'] ['password'] );
		}
		// これが無いとグループリストが取れない
		$groups = $this->User->Group->find ( 'list' );
		$this->set ( compact ( 'groups' ) );
		$user = $this->User->findById ( $id );
		$this->set ( 'user', $user );
	}

	/**
	 * ユーザの削除
	 *
	 * @param string $id
	 * @throws NotFoundException
	 */
	public function delete($id = null) {
		$this->request->onlyAllow ( 'post' );

		$this->User->id = $id;
		if (! $this->User->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}
		if ($this->User->delete ()) {
			$this->Session->setFlash ( __ ( 'ユーザを削除しました。' ) );
			$this->redirect ( array (
					'action' => 'index'
			) );
		}
		$this->Session->setFlash ( __ ( 'ユーザを削除できませんでした。' ) );
		$this->redirect ( array (
				'action' => 'index'
		) );
	}

	/**
	 * ログイン処理
	 */
	public function login() {
		if ($this->request->is ( 'post' )) {
			if ($this->Auth->login ()) {
				// ここで先生ならリダイレクトの際変更する
				$this->loadModel ( 'Group' );
				$group = $this->Group->find ( 'first', array (
						'conditions' => array (
								'Group.name' => 'teachers'
						)
				) );
				

				// ログイン情報のグループIDと'teacher'名のグループIDが同一なら
				if ($this->Auth->user ( 'group_id' ) === $group ['Group'] ['id']) {
					$this->Auth->loginRedirect = array (
							'teacher' => true,
							'controller' => 'posts',
							'action' => 'teacher_index'
					);
					$this->redirect ( $this->Auth->redirect () );
				}
				// 生徒の場合は通常ログイン
				$this->redirect ( $this->Auth->redirect () );
			} else {
				$this->Session->setFlash ( __ ( 'ユーザ名かパスワードが異なります。再試行してください。' ), 'default', array('class'=> 'alert alert-danger'));
			}
		}
	}
	public function logout() {
		$this->redirect ( $this->Auth->logout () );
	}

	/**
	 * 現在のパスワードと確認パスワードが一致するかを判定する
	 *
	 * @return boolean
	 */
	public function checkPassword() {
		$passwordHasher = new BlowfishPasswordHasher ();
		$current_pass = $this->User->getPasswordById ( $this->Auth->user ( 'id' ) );
		// パスワードの正誤判定
		if ($passwordHasher->check ( $this->request->data ['User'] ['old_password'], $current_pass )) {
			return true;
		} else {
			return false;
		}
	}

	// public function beforeFilter() {
	// parent::beforeFilter();

	// $homeroom_id = $this->Auth->user('homeroom_id');
	// }
}






