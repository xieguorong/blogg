<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

class LoginController extends CommonController{
    public function login()
    {
        if ($input=Input::all()) {
            $user = User::first();
       if ($user->user_name != $input['user_name'] ||Crypt::decrypt($user->user_password) != $input['user_pass']) {
               return back()->with('msg', '用户名或者密码错误');
           }

            session(['user'=>$user]);
         return redirect("/admin/main");

        }else {

            return view("/admin/login");
        }
    }

    public function quite()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }
// 加密解密
//    public function crypt()
//    {
////        $str=123456;
////        $str1=Crypt::encrypt($str);
////        echo($str1);
//        $str2='eyJpdiI6InBPdUV4a0pDRkk3cWdFRkRLb29Ecmc9PSIsInZhbHVlIjoiTnoyUzZ3b1VmZ3dtbkZCVmhiV1Q3QT09IiwibWFjIjoiZTNmZDBlNjNlMmYxNmI3MzIzYWYyMzU4YmJhZTJkZDcyNDJhYmQwMzg1NmU0MzU5NzFhZWU3OTI5MDJiNzU0ZiJ9';
//        $str3=Crypt::decrypt($str2);
//        echo($str3);
//    }
//


}
