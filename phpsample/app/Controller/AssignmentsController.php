<?php
App::uses ( 'AppController', 'Controller' );
/**
 * Assignments Controller
 *
 * @property Assignment $Assignment
 * @property PaginatorComponent $Paginator
 */
class AssignmentsController extends AppController {

	// 読み込むヘルパーたち
	public $helpers = array (
			'Html',
			'Form',
			'Session'
	);

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array (
			'Paginator',
			'Session',
			'Download'
	);

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Assignment->recursive = 0;
		$this->set ( 'assignments', $this->Paginator->paginate () );
	}

	/**
	 * 各メソッドの基本メソッド(共通処理)
	 */
	public function teacher_lists($id) {

		// ここの引数はTopics_id
		if (! $id) {
			throw new NotFoundException ( __ ( '不正なアクセス' ) );
		}

		if (! $this->_auth_role ( $id )) {
			throw new NotFoundException ( __ ( 'ファイルが見つかりません' ) );
		}

		// トピックIDを持たせる（現在のトピックを判別
		// これは記事が0件の場合、判別不能になるため
		$this->_setAssignment ( $id );
	}
	public function lists($id = null) {
		// ここの引数はTopics_id
		if (! $id) {
			throw new NotFoundException ( __ ( '不正なアクセス' ) );
		}

		if (! $this->_auth_role ( $id )) {
			throw new NotFoundException ( __ ( 'ファイルが見つかりません' ) );
		}
		// トピックIDを持たせる（現在のトピックを判別
		// これは記事が0件の場合、判別不能になるため
		$this->_setAssignment ( $id );
	}
	private function _setAssignment($id) {
		$this->set ( 'subject_id', $id );

		// $assignment = $this->Assignment->find ( 'all', array (
		// 'conditions' => array (
		// 'Assignment.subject_id' => $id
		// )
		// ) );

		$assignment = $this->Paginator->paginate ( 'Assignment', array (
				'Assignment.subject_id' => $id
		) );

		if (! $assignment) {
			// 記事のないトピックも存在する
			// throw new NotFoundException(__('不正なアクセス'));
		}
		$this->set ( 'assignments', $assignment );
	}

	/**
	 * 課題ごとに一括ダウンロード（提出者のみ）
	 *
	 * @param string $id
	 * @throws NotFoundException
	 */
	public function teacher_download($id = null) {
		// レイアウトは使いません
		$this->autoRender = false;
		if (! $this->Assignment->exists ( $id )) {
			throw new NotFoundException ( __ ( '課題IDが無効です' ) );
		}

		// $this->loadModel ( 'Report' );
		$data = $this->Assignment->Report->find ( 'all', array (
				'conditions' => array (
						'Report.assignment_id' => $id
				)
		) );

		if (! $data) {
			throw new NotFoundException ( __ ( '提出者はいません。' ) );
		}

		$zip_dir = $this->Download->assignment_zip ( $data );
		// debug($zip_dir);
		// throw new NotFoundException();

		if (! is_null ( $zip_dir )) {
			$this->response->type ( 'application/zip' );
			$this->response->file ( $zip_dir, array (
					'download' => true
			) );
			// 課題名のファイル名を指定
			$this->response->download ( $data [0] ['Assignment'] ['title'] . '.zip' );
		}
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function teacher_view($id = null) {
		if (! $this->Assignment->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid assignment' ) );
		}
		$options = array (
				'conditions' => array (
						'Assignment.' . $this->Assignment->primaryKey => $id
				)
		);
		$this->set ( 'assignment', $this->Assignment->find ( 'first', $options ) );
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (! $this->Assignment->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid assignment' ) );
		}
		$options = array (
				'conditions' => array (
						'Assignment.' . $this->Assignment->primaryKey => $id
				)
		);
		$this->set ( 'assignment', $this->Assignment->find ( 'first', $options ) );
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function teacher_add($id = null) {


		$this->_setAssignment ( $id );

		if ($this->request->is ( 'post' )) {



			if ($this->Assignment->createWithAttachments ( $this->request->data )) {
				$this->Session->setFlash ( __ ( '課題を設定しました。' ) );
				return $this->redirect ( array (
						'action' => 'lists',
						$id
				) );
			} else {
				$this->Session->setFlash ( __ ( '課題を設定できませんでした。再試行してください。' ) );
			}
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function teacher_edit($id = null) {
		if (! $this->Assignment->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid assignment' ) );
		}

		if ($this->request->is ( array (
				'post',
				'put'
		) )) {
			if ($this->Assignment->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'The assignment has been saved.' ) );
				return $this->redirect ( array (
						'action' => 'view',
						$id
				)
				 );
			} else {
				$this->Session->setFlash ( __ ( 'The assignment could not be saved. Please, try again.' ) );
			}
		} else {
			$options = array (
					'conditions' => array (
							'Assignment.' . $this->Assignment->primaryKey => $id
					)
			);
			$this->request->data = $this->Assignment->find ( 'first', $options );
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function teacher_delete($id = null) {
		$this->Assignment->id = $id;
		if (! $this->Assignment->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid assignment' ) );
		}

		// リダイレクトでリストへ戻るための科目ID
		$assignment = $this->Assignment->findById ( $id );
		$subject_id = $assignment ['Assignment'] ['subject_id'];

		$this->request->allowMethod ( 'post', 'delete' );
		if ($this->Assignment->delete ()) {
			$this->Session->setFlash ( __ ( 'The assignment has been deleted.' ) );
		} else {
			$this->Session->setFlash ( __ ( 'The assignment could not be deleted. Please, try again.' ) );
		}
		return $this->redirect ( array (
				'action' => 'lists',
				$subject_id
		) );
	}

	/**
	 * 課題IDを渡して自身のホームルームIDと同一かを判定
	 * 0件の場合は検索できないので上位のSubjectをロードして判定する
	 *
	 * @param string $id
	 * @return boolean
	 */
	private function _auth_role($id = null) {
		$this->loadModel ( 'Subject' );
		// 存在するかしないか
		if (! $this->Subject->exists ( $id )) {
			throw new NotFoundException ( '存在しない課題' );
		}

		$data = $this->Subject->find ( 'first', array (
				'conditions' => array (
						'Subject.id' => $id
				)
		) );

		if ($data ['Subject'] ['homeroom_id'] === $this->Auth->user ( 'homeroom_id' )) {
			return true;
		}

		return false;
	}
}
