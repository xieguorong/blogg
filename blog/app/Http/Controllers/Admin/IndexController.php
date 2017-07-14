<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\Category;
use App\Http\Requests;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController{
    public function index()
    {
        return view("admin/index");
    }

    public function pass()
    {
       if($input=Input::all()){
           $rules=[
             'password'=>'required|between:6,20|confirmed'
           ];
           $message=[
              'password.required' =>'新密码不能为空',
               'password.between' =>'新密码必须是6-20位',
               'password.confirmed' =>'确认密码与新密码不一致',
           ];
           $validate = Validator::make($input,$rules,$message);
           if($validate->passes()){
            $user=User::first();
               $_password=Crypt::decrypt($user->user_password);

               if($input['password_o']==$_password){

                 $user->user_password=Crypt::encrypt($input['password']);
                  $user->update();
                   $errors['error'] = '修改密码成功！';
                   return back()->withErrors($errors);
               }else{
                   $errors['error'] = '原密码错误！';
                   return back()->withErrors($errors);
               }

           }else{
//               echo 122;
               return back()->withErrors( $validate);
           }
       }else{
       return view("admin/pass");
       }
    }


}
?>