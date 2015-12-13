<?php
App::uses ( 'AppController', 'Controller' );
/**
 * Subjects Controller
 *
 * @property Subject $Subject
 * @property PaginatorComponent $Paginator
 */
class SubjectsController extends AppController {

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
			'Session',
			'Download'
	);
	public function teacher_index() {
		$this->index ();
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		// ページネイトの使い方
		$data = $this->Paginator->paginate('Subject', array('Subject.homeroom_id' => $this->Auth->user('homeroom_id')));
		$this->Subject->recursive = 0;
		$this->set ( 'subjects', $data );
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (! $this->Subject->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid subject' ) );
		}
		$options = array (
				'conditions' => array (
						'Subject.' . $this->Subject->primaryKey => $id
				)
		);
		$this->set ( 'subject', $this->Subject->find ( 'first', $options ) );
	}

	/**
	 *
	 * これは見直し
	 *
	 * @param string $id
	 * @throws NotFoundException
	 */
	public function teacher_download($id = null) {
		// レイアウトは使いません
		$this->autoRender = false;
		if (! $this->Subject->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid subject' ) );
		}

		$this->loadModel ( 'Assignment' );

		$data = $this->Assignment->find ( 'all', array (
				'conditions' => array (
						'Assignment.subject_id' => $id
				)
		) );

		debug ( $data );

		$this->Download->assignment_zip ( $data );

		// throw new NotFoundException();
		// $this->File->find('all', array('conditions' => array('Subject'))
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function teacher_add() {
		if ($this->request->is ( 'post' )) {
			$this->Subject->create ();
			if ($this->Subject->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'The subject has been saved.' ) );
				return $this->redirect ( array (
						'action' => 'index'
				) );
			} else {
				$this->Session->setFlash ( __ ( 'The subject could not be saved. Please, try again.' ) );
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
	public function edit($id = null) {
		if (! $this->Subject->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid subject' ) );
		}
		if ($this->request->is ( array (
				'post',
				'put'
		) )) {
			if ($this->Subject->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'The subject has been saved.' ) );
				return $this->redirect ( array (
						'action' => 'index'
				) );
			} else {
				$this->Session->setFlash ( __ ( 'The subject could not be saved. Please, try again.' ) );
			}
		} else {
			$options = array (
					'conditions' => array (
							'Subject.' . $this->Subject->primaryKey => $id
					)
			);
			$this->request->data = $this->Subject->find ( 'first', $options );
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->Subject->id = $id;
		if (! $this->Subject->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid subject' ) );
		}
		$this->request->allowMethod ( 'post', 'delete' );
		if ($this->Subject->delete ()) {
			$this->Session->setFlash ( __ ( 'The subject has been deleted.' ) );
		} else {
			$this->Session->setFlash ( __ ( 'The subject could not be deleted. Please, try again.' ) );
		}
		return $this->redirect ( array (
				'action' => 'index'
		) );
	}
}
