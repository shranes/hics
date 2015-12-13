<?php
App::uses ( 'AppController', 'Controller' );

class FilesController extends AppController {
	public $uses = array (
			'Attachment'
	);
	// ヘルパーなど
	public $helpers = array (
			'Html',
			'Form',
			'Session'
	);

	// コンポーネントなど
	public $conponents = array (
			'Session'
	);


	public function teacher_filelist() {
		$this->filelist();
	}

	public function teacher_view() {
		$this->view();
	}

	public function filelist() {
		// $this->Comment->behaviors->attach('containable');
		$id = $this->Auth->user('id');

		if (! $id) {
			throw new NotFoundException(__('不正なアクセス'));
		}

		// ログイン情報から投稿したファイル一覧を取得

		$this->set( 'files', $this->Paginator->paginate('Attachment', array('Attachment.user_id' => $id)));


// 		$this->set ( 'files', $this->Attachment->find ( 'all',
// 					array('conditions' => array('Attachment.user_id' => $id)) ) );
	}

	/**
	 * ダウンロードID（Attachmentテーブル主キー）からダウンロード
	 * これIDがわかるとダウンロードできるくね？
	 * なので後ほど考えて修正
	 * @param unknown $id
	 * @return CakeResponse|void
	 */
	public function download($id = null) {
		// View は使わない
		$this->autoRender = false;

		// ファイルのアクセスが適切かを判断するんだが、
		// 生徒の場合は何個有るんだろうか・・・
		// 記事の場合は、公開は気にすること無く、クラス内はIDがクラス内の場合、プライベートは記事がプライベートのとき
		// 課題の場合は、作成したクラスIDが同じクラス内、もしくは作成者が自分
		// 記事の場合はisRangeRole($id)を使いまわせる。
		// 課題は新しく関数を作るしか無い。

		// 権限判定

		// まずデータベースからそのIDの情報取ってきて
		$file_pre = $this->Attachment->findById ( $id );
		// ファイルパス作って
		$file_path = 'webroot' . DS . 'file' . DS . $file_pre ['Attachment'] ['dir'] . DS . $file_pre ['Attachment'] ['attachment'];
		$this->response->file ( $file_path );
		// レスポンスオブジェクトを返すとコントローラがビューの描画を中止します
		return $this->response->download ( $file_pre ['Attachment'] ['attachment'] );
	}

	/**
	 * ダウンロードID（Attachmentテーブル主キー）からダウンロード
	 * これIDがわかるとダウンロードできるくね？
	 * なので後ほど考えて修正
	 * @param unknown $id
	 * @return CakeResponse|void
	 */
	public function teacher_download($id = null) {
		// View は使わない
		$this->autoRender = false;

		// ファイルのアクセスが適切かを判断するんだが、
		// 先生の場合は無条件ダウンロード


		// まずデータベースからそのIDの情報取ってきて
		$file_pre = $this->Attachment->findById ( $id );
		// ファイルパス作って
		$file_path = 'webroot' . DS . 'file' . DS . $file_pre ['Attachment'] ['dir'] . DS . $file_pre ['Attachment'] ['attachment'];
		$this->response->file ( $file_path );
		// レスポンスオブジェクトを返すとコントローラがビューの描画を中止します
		return $this->response->download ( $file_pre ['Attachment'] ['attachment'] );
	}

// 	/**
// 	 *
// 	 * @param unknown $data
// 	 * @return boolean
// 	 */
// 	public function deleteFile() {
// 		// 画像削除のためのポスト
// 		$data = $this->request->data;
// 		debug($data);
// 		if ($this->request->is ( 'post' )) {

// 			// POSTされたデータは$this->request->dataに入ってる
// 			if (! empty ( $data ['File'] ['0'] ['id'] )) {
// 				if ($this->Attachment->deleteFile ( $data )) {
// 					$this->Session->setFlash ( 'ファイルを削除しました。' );
// 					return $this->redirect ( array (
// 							'controller' => 'post',
// 							'action' => 'view',
// 							$id
// 					) );
// 				} else {
// 					$this->Session->setFlash ( '削除できませんでした。' );
// 				}
// 			}
// 		} else {
// 			$this->Session->setFlash ( '画像が選択されていません。' );
// 		}
// 	}
// 	private function __delete($data) {
// 		// POSTされたデータは$this->request->dataに入ってる
// 		try {
// 			if ($data ['File'] ['0'] ['remove']) {
// 				if ($this->Attachment->delete ( $data ['File'] ['0'] ['id'] )) {
// 					return true;
// 				} else {
// 					return false;
// 				}
// 			}
// 		} catch ( Exception $e ) {
// 			print $e;
// 			return false;
// 		}
// 	}

	public function delete($id = null) {
		if ($this->request->is ( 'get' )) {
			throw new MethodNotAllowedException ();
		}

		// $topic_id = $this->request->data['topic_id'];


		if ($this->Attachment->delete ( $id )) {
			$this->Session->setFlash ( __ ( '投稿されたID: %s は削除されました。', h ( $id ) ) );
		} else {
			$this->Session->setFlash ( __ ( '投稿されたID: %s は削除できませんでした。', h ( $id ) ) );
		}

		return $this->redirect ( $this->referer () );
	}


	/**
	 * 投稿したファイル一覧を表示する
	 */
	public function view() {
		$id = $this->Auth->user('id');

		// ログイン情報から投稿したファイル一覧を取得
		$this->set ( 'files', $this->Attachment->find ( 'all',
					array('conditions' => array('Atachment.user_id' => $id)) ) );

	}

	public function isAuthorized($user) {
		// Addのみ許可
		if ($this->action === 'download') {
			return true;
		}

		return parent::isAuthorized ( $user );
	}
}