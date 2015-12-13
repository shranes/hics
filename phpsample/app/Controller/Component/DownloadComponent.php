<?php
App::uses ( 'Component', 'Controller' );
App::uses ( 'Folder', 'Utility' );
App::uses ( 'File', 'Utility' );
class DownloadComponent extends Component {
	public $components = array (
			'Auth',
			'Session',
			'Zip'
	);

	public function assignment_zip($data = null) {

		// 手順一覧
		// 一時ディレクトリを作成する。
		// 科目名→学籍番号（名前）：ループ→番号＋ファイル名：ループ
		// となるように一時ファイルを作成。

		// このディレクトリをZipコンポーネントに渡してファイル構造ごとZIPへ圧縮
		// 圧縮完了と同時に先のディレクトリを削除

		// ZIPファイルをレスポンスとして返す。

		// 作成場所：Assignmentコントローラー内
		// 一時作業ファイルDir：/tmp/ランダムな値/科目名...

		// Cakeのファイルユーティリティを利用。
		// 一時ファイルを含めてすべて作成手順は同様。

		// 一時ディレクトリ用に時間をいれたディレクトリ
		// www.root\tmp\copy\時間\
		$time = time ();
		$dir = new Folder ( TMP . DS . 'copy' . DS . $time, true, 0777 );
		$zip_dir = new Folder ( TMP . DS . 'zip' . DS . $time, true, 0777 );

		// 作業用のルートディレクトリとなる
		$workingDirRootPath = $dir->pwd ();
		$makingDirRootPath = $zip_dir->pwd ();

		// レポートファイルのあるディレクトリの元
		$reportDirRootPath = WWW_ROOT . DS . 'file';

		// 一時フォルダを作成
		try {
			if ($dir->create ( $workingDirRootPath )) {

				$assigment_title = $data [0] ['Assignment'] ['title'];

				if (! $assigment_title) {
					// ファイルがない場合は偽
					return;
				}


				// 課題名のフォルダを作成
				$kadai_dir = $workingDirRootPath . DS . $assigment_title;
				$dir->create ( $kadai_dir );


				// まず学籍番号フォルダを作成
				foreach ( $data as $i => $kadai ) {

// 					debug($kadai);
// 					throw new NotFoundException();
					// 学籍番号フォルダ作成
					$gakusei_dir = $kadai_dir . DS . $kadai ['User'] ['username'];
					$dir->create ( $gakusei_dir );
					$count = 0;
					$report_id = $kadai['Report']['id'];
					foreach ( $kadai ['File'] as $i => $file ) {
						// ここでコピー処理
						// debug($file);
						// throw new NotFoundException();
						$copy_file = new File ( $reportDirRootPath . DS . $file ['dir'] . DS . $file ['attachment'] );
						// 数値プラスファイル名でコピーする
						//$copy_file->copy ( $gakusei_dir . DS . sprintf ( "%02d", self::$count++ ) .'_'. $file['attachment'] );
						$copy_file->copy ( $gakusei_dir . DS .$report_id . '-' .sprintf ( "%02d", $count ) .'_'. $file['attachment'] );
						$count++;
					}
				}

				if ($zip_dir->create ( $makingDirRootPath )) {
					// ZIPに圧縮
					// 想定ディレクトリ www.ROOT\tmp\zip\時間\課題名.zip
					$zip_file_dir = $makingDirRootPath . DS . $assigment_title . '.zip';
					// 圧縮 fromdir, todir
					$this->Zip->all_zip ( $kadai_dir, $zip_file_dir );

					// 一時ファイルを削除する
					$dir->delete();
					// 保存されたディレクトリを返す
					return $zip_file_dir;
				} else {
					throw new FatalErrorException ( 'zipディレクトリが作成できない' );
				}
			} else {
				throw new FatalErrorException ( '一時ディレクトリを作成できない' );
			}
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	}
}