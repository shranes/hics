<?php
App::uses('AppController', 'Controller');
/**
 * ReadManagements Controller
 *
 * @property ReadManagement $ReadManagement
 * @property PaginatorComponent $Paginator
*/
class ReadManagementsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');



	/**
	 *
	 * 先生からのみ
	 * @param unknown $insert_id	登録する
	 * @param unknown $model
	 * @param $type common, homeroom, personal
	*/
	public function createWithTeacherRM($insert_id, $model, $user_id) {

		/*
		 * Insert_idはそのまま使える
		* Modelも読み込む必要無し
		* user_idで生徒のIDが必要
		*/
		if (! $insert_id) {
			throw new FatalErrorException ( 'id error' );
		}

		$this->loadModel ( 'User' );
		$this->loadModel('ReadManagement');
		$this->loadModel('Post');
		$post = $this->Post->findById($insert_id);

		$range_role_id = $post['Topic']['range_role_id'];
		$teacher = $this->User->findById($user_id);


		if ($range_role_id == 1) {

			// 全員の連絡をセットする
			// ユーザデータ全件取得
			$students = $this->User->find('all');
		} else if ($range_role_id == 2) {
			// クラス内のみ(homeroomID判定）
			$students = $this->User->find('all', array(
					'conditions' => array(
							'User.homeroom_id' => $teacher['User']['homeroom_id'],
							// teacher_idが自身は含めない
							'User.id !=' => $user_id
					)
			));
		} else if ($range_role_id == 3) {
			// TopicのユーザIDから対象のユーザを取得する
			$students = $this->User->find('all', array(
					'conditions' => array(
							'User.id' => $post['Topic']['user_id'])
			));

		} else {
			throw new FatalErrorException('invalid range_role');
		}
		foreach ($students as $student) {
			$this->ReadManagement->create ();
			$this->ReadManagement->set ( array (
					'foreign_key' => $insert_id,
					'model' => $model,
					'user_id' => $student ['User'] ['id']
			) );
			if ($this->ReadManagement->save ()) {
				print_r ( 'saved' );
			} else {
				throw new FatalErrorException ( '通知を設定できませんでした。' );
			}
		}


	}

	/**
	 *
	 * 生徒からのみ（課題の提出
	 * @param unknown $insert_id	登録する
	 * @param unknown $model
	 * @param $type common, homeroom, personal
	 */
	public function createWithStudentRM($insert_id, $model, $user_id) {

		/*
		 * Insert_idはそのまま使える
		* Modelも読み込む必要無し
		* user_idで生徒のIDが必要
		*/
		if (! $insert_id) {
			throw new FatalErrorException ( 'id error' );
		}
		if (! $user_id) {
			throw new FatalErrorException(' user_id error');
		}

		$this->loadModel ( 'User' );
		$this->loadModel('ReadManagement');

		// 生徒の情報
		$student = $this->User->findById($user_id);

		$this->ReadManagement->create ();
		$this->ReadManagement->set ( array (
				'foreign_key' => $insert_id,
				'model' => $model,
				'user_id' => $student['User']['teacher_id']
		) );
		if ($this->ReadManagement->save ()) {
			print_r ( 'saved' );
		} else {
			throw new FatalErrorException ( '通知を設定できませんでした。' );
		}

	}

	/**
	 *
	 * 先生の連絡作成、課題設定をターゲット
	 * @param unknown $insert_id	登録する
	 * @param unknown $model
	 */
	public function updateWithRM($insert_id, $model, $user_id) {

		/*
		 * Insert_idはそのまま使える
		* Modelも読み込む必要無し
		* user_idで生徒のIDが必要
		*/
		if (! $insert_id) {
			throw new FatalErrorException ( 'id error' );
		}

		$this->loadModel ( 'User' );

		// 先生の情報を取得してTeacheIDで生徒の一覧を取得する

		// 更新する1件を見つける
		$rm_data = $this->ReadManagement->find('first', array(
				'conditions' => array(
						'ReadManagement.model' => $model,
						'ReadManagement.user_id' => $user_id,
						'ReadManagement.flag' => 0),
				'order' =>  array(
						// 新しい順
						'ReadManagement.id' => 'desc'
				)
		));

		if (!empty($rm_data) ) {
			$rm_id = $rm_data['ReadManagement']['id'];
			if ($rm_id) {
				$this->ReadManagement->id = $rm_id;
				$this->ReadManagement->saveField('flag', '1');
			} else {
				throw new FatalErrorExeption('NoticeUpdate Error');
			}
		}


	}





}
