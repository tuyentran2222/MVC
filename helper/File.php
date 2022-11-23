<?php
	namespace helper;

	class File{
		/**
		 * @desc upload file to directory
		 * @param File $file
		 * @param string $upload_file_dir
		 * @param string $new_file_name
		 * @return string|boolean destination path if success otherwise return false
		 */
		public static function uploadFile($file, $upload_file_dir, $new_file_name){
			$file_tmp_path = $file["tmp_name"];
			$file_name = $file["name"];
			$file_name_cmps = explode(".", $file_name);
			$file_extension = strtolower(end($file_name_cmps));
			$new_file_name = $new_file_name.".". $file_extension;
			$dest_path = $upload_file_dir . $new_file_name;

			if(!move_uploaded_file($file_tmp_path, $dest_path)) return false;
			return $dest_path;
		}

		/**
		 * @desc delete file by file directory
		 * @param string $file_dir  Path to the file.
		 * @return void
		 */
		public static function deleteFile($file_dir){
			return unlink($file_dir);
		}
	}