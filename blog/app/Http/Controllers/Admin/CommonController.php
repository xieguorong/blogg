<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
//    上传图片
    public function upload()
    {
        $file=Input::file("Filedata");
        if($file->isValid()){//如果文件有效
//            $realPath=$file->getRealPath();//文件临时绝对路径
            $entension=$file->getClientOriginalExtension();//上传文件的后缀
            $newName=date('Ymdhmf').mt_rand(100,999).'.'.$entension;//文件的新命名
            $path=$file->move(base_path().'/public/uploads',$newName);//存放在uploads文件夹并重命名
            $filePath='/uploads/'.$newName;
            return $filePath;
        }

   }
}

?>