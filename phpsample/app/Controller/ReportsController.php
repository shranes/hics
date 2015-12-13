<?php
App::uses ( 'AppController', 'Controller' );
App::uses('ReadManagementsController', 'Controller');
/**
 * Reports Controller
 *
 * @property Report $Report
 * @property PaginatorComponent $Paginator
*/
class ReportsController extends AppController {

	// 基本設定
	public $paginate = array (
			'Reports' => array (
					'limit' => 10, // 1ページ表示できるデータ数の設定
					'order' => array (
							'user_id' => 'asc'
					)  // データを降順に並べる
			)
	);
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
			'Session'
	);

	/**
	 * 提出済み課題一覧（基本UserIDでソートさせよう）
	 *
	 * @return void
	*/
	public function teacher_index($id = null) {
		if (! $id) {
			throw new NotFoundException ( __ ( '不正なアクセス' ) );
		}

		/*
		 * 使い方は以下な感じ
		* 同一の課題IDのものを取得
		*/
		$data = $this->Paginator->paginate('Report', array('Report.assignment_id' => $id));

		$this->Report->recursive = 0;
		$this->set ( 'reports', $data );
	}


	public function index($id = null) {
		if (! $id) {
			throw new NotFoundException ( __ ( '不正なアクセス' ) );
		}

		/*
		 * 使い方は以下な感じ
		* 同一の課題IDのもの、かつ自身が投稿したもの
		*/
		$data = $this->Paginator->paginate('Report', array('Report.assignment_id' => $id,
				'Report.user_id' => $this->Auth->user('id')));

		$this->Report->recursive = 0;
		$this->set ( 'reports', $data );

	}
	/**
	 * 課題詳細を確認（ここではViewでダウンロードリンクを発行できるように）
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function teacher_view($id = null) {
		if (! $this->Report->exists ( $id )) {
			throw new NotFoundException ( __ ( '不正なアクセス' ) );
		}


		// 通知を更新
		$updateRM = new ReadManagementsController();
		$updateRM->updateWithRM($id, 'Report', $this->Auth->user('id'));

		$options = array (
				'conditions' => array (
						'Report.' . $this->Report->primaryKey => $id
				)
		);
		$this->set ( 'report', $this->Report->find ( 'first', $options ) );
	}

	/**
	 * 生徒用のView
	 * @param string $id
	 * @throws NotFoundException
	 */
	public function view ($id = null) {
		if (! $this->Report->exists ( $id )) {
			throw new NotFoundException ( __ ( '不正なアクセス' ) );
		}
		$options = array (
				'conditions' => array (
						'Report.' . $this->Report->primaryKey => $id
				)
		);
		$this->set ( 'report', $this->Report->find ( 'first', $options ) );

	}

	/**
	 * レポートの追加は生徒のみ行えるよ
	 *
	 * @return void
	 * @param id これは所属する課題ID
	 */
	public function add($id = null) {

		if (! $id ) {
			throw new NotFoundException ( __ ( '課題エラー' ) );
		}

		// 課題の引数が間違えてる場合はダメ
		$this->loadModel('Assignment');
		if (! $this->Assignment->exists($id)) {
			throw new NotFoundException ( __ ( '課題エラー' ) );
		}

		if ($this->request->is ( 'post' )) {

			//  			debug($this->request->data);
			//  			throw new NotFoundException();

			//$this->Report->create ();
			if ($this->Report->createWithAttachments( $this->request->data )) {

				// 通知処理
				$RM = new ReadManagementsController();
				$RM->createWithStudentRM($this->Report->getLastInsertID(), 'Report', $this->Auth->user('id'));

				$this->Session->setFlash ( __ ( '課題の提出を行いました。' ) );
				return $this->redirect ( array (
						'action' => 'index',
						$id
				) );
			} else {
				$this->Session->setFlash ( __ ( '提出ができませんでした。再試行してください。' ) );
			}
		}


		$this->Assignment->recursive = 0;
		$this->set('assignment',$this->Assignment->find('first', array(
				'conditions' => array('Assignment.id' => $id)
			)
		)
		);
	}

	/**
	 * 提出済みのレポートを編集できる
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (! $this->Report->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid report' ) );
		}
		if ($this->request->is ( array (
				'post',
				'put'
		) )) {
			if ($this->Report->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( '提出課題を更新しました。' ) );
				return $this->redirect ( array (
						'action' => 'index'
				) );
			} else {
				$this->Session->setFlash ( __ ( '更新できませんでした。再試行してください。' ) );
			}
		} else {
			$options = array (
					'conditions' => array (
							'Report.' . $this->Report->primaryKey => $id
					)
			);
			$this->request->data = $this->Report->find ( 'first', $options );
		}
	}

	/**
	 * 提出済みのレポートを削除するけど、ここらへんは削除できないようにするかも？
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->Report->id = $id;
		if (! $this->Report->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid report' ) );
		}
		$this->request->allowMethod ( 'post', 'delete' );
		if ($this->Report->delete ()) {
			$this->Session->setFlash ( __ ( '提出物を削除しました。' ) );
		} else {
			$this->Session->setFlash ( __ ( '提出物を削除できませんでした。再試行してください。' ) );
		}
		return $this->redirect ( array (
				'action' => 'index'
		) );
	}
}
