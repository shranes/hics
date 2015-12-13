<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses ( 'Controller', 'Controller' );

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
*/
class AppController extends Controller {
	public $helpers = array (
			'Html',
			'Form',
			'Session'
	);

	// ページネイト基本設定
	public $paginate = array (
			'Reports' => array (
					'limit' => 20, // 1ページ表示できるデータ数の設定
			)
	);

	public $components = array (
			'Zip',
			'Paginator',
			'DebugKit.Toolbar',
			'Session',
			'Acl',
			'Auth' => array (
					// ログイン後のリダイレクト先
					'loginRedirect' => array (
							'controller' => 'posts',
							'action' => 'index'
					),
					// ログアウト後のリダイレクト先
					'logoutRedirect' => array (
							'controller' => 'posts',
							'action' => 'index'
					),
					'authenticate' => array (
							'Form' => array (
									'passwordHasher' => 'Blowfish'
							)
					),

					'authorize' => array (
							'Actions' => array (
									'actionPath' => 'controllers'
							)
					)
			)
	);
	public function beforeFilter() {
		// すべてのコントローラのindex, viewについてはログインを必要としない
		$this->Auth->allow ();

		// 多分ロールでリダイレクト先を変更するならここしかない
		// ハードコーディングになるだろうが仕方ない（studentsなど）

		// authとして認証情報の連想配列を渡す。 user(null)だとユーザデータすべてをフェッチする
		$this->Auth->loginAction = array (
				'controller' => 'users',
				'action' => 'login'
		);
		$this->Auth->logoutRedirect = array (
				'controller' => 'users',
				'action' => 'login'
		);
		$this->Auth->loginRedirect = array (
				'controller' => 'posts',
				'action' => 'index'
		);

		// エラー時のリダイレクトをしない
		$this->Auth->unauthorizedRedirect = false;

		// グループIDからTeacherならteacher_indexへリダイレクト
		$this->set ( 'user', $this->Auth->user () );
	}
	public function isAuthorized($user) {
		// ロールがAdminであれあすべての操作を許可
		if (isset ( $user ['role'] ) && $user ['role'] === 'admin') {
			return true;
		}
		// デフォルト無効
		return false;
	}

	/**
	 * 対象のトピックスのIDが正当な権限かどうかの判定
	 * 引数$idは上位トピックID
	 *
	 * @param string $topic_id
	 * @throws FatalErrorException
	 */
	public function isRangeRole($topic_id = null) {
		if (! $topic_id) {
			throw new FatalErrorException ();
		}

		// 各モデルをロード
		$this->loadModel ( 'Topic' );
		$this->loadModel ( 'RangeRole' );

		// まずは自身のホームルームID取得
		$user_homeroom_id = $this->Auth->user ( 'homeroom_id' );
		$user_id = $this->Auth->user ( 'id' );
		// トピックの権限IDを取得
		$topic = $this->Topic->findById ( $topic_id );
		$range_role_id = $topic ['Topic'] ['range_role_id'];
		// トピックスのホームルームIDを取得
		$topic_homeroom_id = $topic ['Topic'] ['homeroom_id'];
		$topic_user_id = $topic ['Topic'] ['user_id'];

		// 全体の場合
		if ($range_role_id === '1') {
			return true;
		} else if ($range_role_id === '2' && $topic_homeroom_id === $user_homeroom_id) {
			// トピックスのロールがクラス内かつ、自身のクラスである場合
			return true;
		} else if ($range_role_id === '3' && $topic_user_id === $user_id) {
			// トピックスのロールが個人、かつトピックスの作成者が自身の場合
			// 先生の場合は作成者でなくともアクセス可能
			return true;
		} else {
			throw new ForbiddenException ();
		}
	}

	/**
	 * 対象のトピックスのIDが正当な権限かどうかの判定
	 * 引数$idは上位トピックID
	 *
	 * @param string $topic_id
	 * @throws FatalErrorException
	 */
	public function isTeacherRangeRole($topic_id = null) {
		if (! $topic_id) {
			throw new FatalErrorException ();
		}

		// 各モデルをロード
		$this->loadModel ( 'Topic' );
		$this->loadModel ( 'RangeRole' );

		// まずは自身のホームルームID取得
		$user_homeroom_id = $this->Auth->user ( 'homeroom_id' );
		$user_id = $this->Auth->user ( 'id' );
		// トピックの権限IDを取得
		$topic = $this->Topic->findById ( $topic_id );
		$range_role_id = $topic ['Topic'] ['range_role_id'];
		// トピックスのホームルームIDを取得
		$topic_homeroom_id = $topic ['Topic'] ['homeroom_id'];
		$topic_user_id = $topic ['Topic'] ['user_id'];

		// 全体の場合
		if ($range_role_id === '1') {
			return true;
		} else if ($range_role_id === '2' && $topic_homeroom_id === $user_homeroom_id) {
			// トピックスのロールがクラス内かつ、自身のクラスである場合
			return true;
		} else if ($range_role_id === '3' && $this->isTeacherRole ( $user_id ) && $topic_homeroom_id === $user_homeroom_id) {
			// トピックスのロールが個人、かつトピックスの作成者が自身の場合
			// 先生の場合は作成者でなくともアクセス可能
			return true;
		} else {
			throw new ForbiddenException ();
		}
	}

	/**
	 * 先生のロールなのかを確認する
	 *
	 * @param unknown $id
	 */
	public function isTeacherRole($id) {
		if (! $id) {
			throw new NotFoundException ();
		}
		$this->loadModel ( 'User' );
		$user = $this->User->findById ( $id );
		$this->loadModel ( 'Group' );
		$group = $this->Group->findById ( $user ['User'] ['group_id'] );
		$group_name = $group ['Group'] ['name'];

		if ($group_name === 'administrators') {
			return true;
		} else if ($group_name === 'teachers') {
			return true;
		} else if ($group_name === 'students') {
			return false;
		} else {
			throw new FatalErrorException ( __ ( '権限ロールエラー' ) );
		}
	}

	/**
	 * 自身のホームルームIDと引数に渡したユーザIDのホームルームIDが一致するか
	 *
	 * @param unknown $id
	 * @throws NotFoundException
	 * @return boolean
	 */
	public function isSameHomeroom($id) {
		if (! $id) {
			throw new NotFoundException ();
		}

		$student = $this->User->findById ( $id );
		if (! $student) {
			throw new NotFoundException ();
		}

		// debug($student);
		// throw new NotFoundException();
		$teacher_homeroom_id = $this->Auth->user ( 'homeroom_id' );

		if ($student ['User'] ['homeroom_id'] === $teacher_homeroom_id) {
			return true;
		} else {
			throw new ForbiddenException ();
		}
	}

	// 	/**
	// 	 * 新着通知をセットする
	// 	 *
	// 	 * @param string $id
	// 	 *        	対象の主キー
	// 	 * @param string $model
	// 	 */
	// 	public function createPostNotice($id) {
	// 		if (! $id) {
	// 			throw new FatalErrorException ( 'id error' );
	// 		}

	// 		$model = 'Post';
	// 		$notice_users = null;

	// 		$this->loadModel ( 'Notice' );
	// 		$this->loadModel ( 'User' );
	// 		$this->loadModel ( 'Post' );

	// 		$this->User->recusive = - 1;

	// 		$post = $this->Post->findById ( $id );

	// 		$range_role = $post ['Topic'] ['range_role_id'];

	// 		if ($range_role === '1') {
	// 			// 全体へ公開
	// 			$notice_users = $this->User->find ( 'all', array (
	// 					'conditions' => array (
	// 							// 自身のIDは含めない
	// 							'User.id !=' => $this->Auth->user ( 'id' )
	// 					)
	// 			) );
	// 		} else if ($range_role === '2') {
	// 			// クラス内公開
	// 			$notice_users = $this->User->find ( 'all', array (
	// 					'conditions' => array (
	// 							'User.homeroom_id' => $this->Auth->user ( 'homeroom_id' ),
	// 							// 自身のIDは含めない
	// 							'User.id !=' => $this->Auth->user ( 'id' )
	// 					)
	// 			) );
	// 		} else if ($range_role === '3') {
	// 			// 個人
	// 			if ($this->isTeacherRole ( $this->Auth->user ( 'id' ) )) {
	// 				$notice_users = $this->User->findById ( $post ['User'] ['id'] );
	// 			} else {
	// 				$notice_users = $this->User->findById ( $post ['User'] ['teacher_id'] );
	// 			}
	// 		}
	// 		// throw new NotFoundException ();

	// 		// 通知ユーザがあるだけループ

	// 		foreach ( $notice_users as $user ) {

	// 			$this->Notice->create ();
	// 			$this->Notice->set ( array (
	// 					'foreign_key' => $id,
	// 					'model' => $model,
	// 					'user_id' => $user ['User'] ['id']
	// 			) );
	// 			if ($this->Notice->save ()) {
	// 				print_r ( 'saved' );
	// 			} else {
	// 				throw new FatalErrorException ( '通知を設定できませんでした。' );
	// 			}
	// 		}
	// 	}


}
