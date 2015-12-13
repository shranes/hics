<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

	/**
	 * 課題提出と同時にアタッチメントも登録（ファイルも投稿）
	 *
	 * @param unknown $data
	 * @throws Exception
	 * @return boolean
	 */
	public function createWithAttachments($data) {
		// Sanitize your images before adding them
		$files = array ();
		/*
		 * 処理を変更
		* ファイルは複数ファイルを想定する
		*/

		foreach ( $data ['File'] as $i => $file ) {
			if (! empty ( $data ['File'] [$i] ['attachment'] ['name'] )) {
				// 名前がある＝ファイルが選択されている
				if (is_array ( $data ['File'] [$i] )) {
					// Force setting the `model` field to this model
					//$file ['model'] = 'Report';
					// Unset the foreign_key if the user tries to specify it
					if (isset ( $file ['foreign_key'] )) {
						unset ( $file ['foreign_key'] );
					}
					$files [] = $file;
				}

				//$data ['File'] = $files;
			} else {
				// もしデータがない場合は連想配列をリジェクトする
				//unset ( $data ['File'] );
				//debug ( $data );
			}
		}
		// リクエストデータへ整形したファイル情報を戻す
		$data ['File'] = $files;

		// Try to save the data using Model::saveAll()
		$this->create ();

		if ($this->saveAll ( $data )) {
			// ここで主キーへファイル名を変更する
			return true;
		}

		// Throw an exception for the controller
		throw new Exception ( __ ( "投稿できませんでした。再試行してください。" ) );
	}
}
