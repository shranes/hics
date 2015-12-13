<?php
App::uses ( 'Component', 'Controller' );
class ZipComponent extends Component {




	/*
	 * 本番環境ではコマンドを使う
	 */
	/**
	 *
	 * @param unknown $dir	圧縮元
	 * @param unknown $file	圧縮先
	 * @param unknown $filename	ZIPファイル名
	 */
	function comandZip($dir, $file, $filename) {
		// zipファイル名
		$fileName = $filename;
		// 圧縮対象フォルダ
		$compressDir = $dir;
		// zipファイル保存先
		$zipFileSavePath = $file;

		// コマンド
		// cd：ディレクトリの移動
		// zip:zipファイルの作成
		$command = "cd " . $compressDir . ";" . "zip -r " . $zipFileSavePath . $fileName . ".zip .";

		// Linuxコマンドの実行
		exec ( $command );
	}



	/**
	 * 方法その1
	 * @param unknown $dir
	 * @param unknown $file
	 * @param string $root
	 * @return boolean
	 */
	function zipDirectory($dir, $file, $root = "") {
		$zip = new ZipArchive ();
		$res = $zip->open ( $file, ZipArchive::CREATE );

		if ($res) {
			// $rootが指定されていればその名前のフォルダにファイルをまとめる
			if ($root != "") {
				$zip->addEmptyDir ( $root );
				$root .= DIRECTORY_SEPARATOR;
			}

			$baseLen = mb_strlen ( $dir );

			$iterator = new RecursiveIteratorIterator ( new RecursiveDirectoryIterator ( $dir, FilesystemIterator::SKIP_DOTS | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO ), RecursiveIteratorIterator::SELF_FIRST );

			$list = array ();
			foreach ( $iterator as $pathname => $info ) {
				$localpath = $root . mb_substr ( $pathname, $baseLen );
				// debug($localpath);

				if ($info->isFile ()) {
					// $zip->addFile($pathname,$filenameonly );
					$zip->addFile ( $pathname, $localpath );
				} else {
					$res = $zip->addEmptyDir ( $localpath );
				}
			}

			$zip->close ();
		} else {
			return false;
		}
	}

	// --------------------------------------------------------------------------
	// ディレクトリZIP圧縮
	// --------------------------------------------------------------------------
	public static function all_zip($dir_path, $new_dir) {
		$zip = new ZipArchive ();
		if ($zip->open ( $new_dir, ZipArchive::OVERWRITE ) === true) {
			self::add_zip ( $zip, $dir_path, "" );
			$zip->close ();
			return true;
		} else {
			throw new Exception ( 'It does not make a zip file' );
		}
	}

	// --------------------------------------------------------------------------
	// 再起的にディレクトリかファイルを判断し、ストリームに追加する
	// --------------------------------------------------------------------------
	private static function add_zip($zip, $dir_path, $new_dir) {
		if (! is_dir ( $new_dir )) {
			$zip->addEmptyDir ( $new_dir );
		}

		foreach ( self::get_inner_path_of_directory ( $dir_path ) as $file ) {
			if (is_dir ( $dir_path . DS . $file )) {
				self::add_zip ( $zip, $dir_path . DS . $file, $new_dir . DS . $file );
			} else {
				// $zip->addFile( $dir_path . DS . $file, $new_dir . DS . $file );
				$zip->addFile ( $dir_path . DS . $file, $new_dir . DS . $file );
			}
		}
	}

	// --------------------------------------------------------------------------
	// ディレクトリ内の一覧を取得する
	// --------------------------------------------------------------------------
	public static function get_inner_path_of_directory($dir_path) {
		$file_array = array ();
		if (is_dir ( $dir_path )) {
			if ($dh = opendir ( $dir_path )) {
				while ( ($file = readdir ( $dh )) !== false ) {
					if ($file == "." || $file == "..") {
						continue;
					}
					$file_array [] = $file;
				}
				closedir ( $dh );
			}
		}
		sort ( $file_array );
		return $file_array;
	}
}