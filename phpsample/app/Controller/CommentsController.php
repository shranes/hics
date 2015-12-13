<?php


class CommentsController extends AppController {

	// ヘルパーなど
	public $helpers = array('Html', 'Form', 'Session');

	// コンポーネントなど
	public $conponents = array('Session');

	public function index() {
		//$this->Comment->behaviors->attach('containable');
		$this->set('comments', $this->Comment->find('all'));
	}

	public function teacher_add() {
		$this->add();
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Comment->create();
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('コメントしました。'));
				// 元のページヘリダイレクト（動くか不明
				return $this->redirect(array('controller' => 'posts', 'action' => 'view',
				$this->data['Comment']['post_id']));
			}
			$this->Session->setFlash(__('コメント失敗'));
		}
	}

	public function isAuthorized($user) {
		// Addのみ許可
		if ($this->action === 'add') {
			return true;
		}

		return parent::isAuthorized($user);
	}

}