<?php
/**
 * Zip Compression Class
 */
App::uses('Component', 'Controller');

class NoticeComponent extends Component {

	public $components = array (
			'Auth',
			'Session',
			'Zip'
	);


	/**
	 * 新着通知をセットする
	 * @param string $id
	 * @param string $model
	 */
	public function createNotice($id, $model) {

	}

	public function updateNotice($id, $model, $flag) {

	}

	public function deleteNotice($id, $model) {

	}


}