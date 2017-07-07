<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Http\Utils;

class UploadService {

	/**上传图片
	 * @param
	 * @return
	 */
	public function uploadProductImage(){

		$FileData   = $_FILES['file'];
		$upload_path = "/upload/image/";
		$return_path = '';
		$target_path = Utils::CreateDir( PROJECT_ROOT."/public".$upload_path,"{y}{m}/{d}",$return_path );

		$filename   = $FileData['name'];
		$extension  = pathinfo($filename,PATHINFO_EXTENSION);

		$file_array = array();
		$file_array['pic_name'] = $filename;
		$file_array['filename'] = str_replace(".".$extension, '', $filename);
		$file_array['type']     = $FileData['type'];
		$file_array['size']     = $FileData['size'];
		$file_array['ext']      = $extension;

		srand((double)microtime()*1000000);
		$rnd       = rand(100,999);
		$name      = date("YmdHis",time()).$rnd.'.'.$extension;
		$save_name = $upload_path.$return_path.$name;
		$file_array['pic_url'] = $save_name;

		$bret = move_uploaded_file($FileData['tmp_name'],$target_path.$name );

		return $file_array;
		//echo json_encode($file_array);
	}

}
